<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\UnknownPropertyException;

class Subscription extends ActiveRecord
{
    CONST BLOG = 1;
    CONST JOURNAL  =2;
    CONST COMMUNITY_BLOG = 3;
    CONST COMPANY_BLOG = 4;

    CONST NODE = [
        self::BLOG => 'Blog',
        self::JOURNAL => 'Journal',
        self::COMMUNITY_BLOG => 'CommunityBlog',
        self::COMPANY_BLOG => 'CompanyBlog'
    ];

    public $isCreated;
    public $count;

    protected static $_blogs = [];
    protected static $_journals = [];
    protected static $_community_blogs = [];
    protected static $_company_blogs = [];

    /**
     * Subscribe on node by type and id
     * @param $type - type of node
     * @param $id - id of node
     * @return bool
     */
    public static function subscribe($type, $id)
    {
        $userId = Yii::$app->user->identity->getId();
        $node = '';

        if(isset($type)) {
            if(self::NODE[$type])  {
                $node = self::NODE[$type];
            } else {
                return false;
            }
        } else {
            return false;
        }

        try{
          $subscription = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (n:$node) WHERE ID(n) = $id AND  NOT (a)-[:subscribe]->(n)
            WITH a, n 
                CREATE (a)-[s:subscribe]->(n)")
                ->get("SIGN(COUNT(s)) as isCreated")
                ->one();
        } catch (Neo4jException $e) {

            return false;
        }

        return (bool) $subscription->isCreated;

    }

    /**
     * Unsubscribe from node by id
     * @param $id - id of node
     * @return bool
     */
    public static function unsubscribe($id)
    {
        $userId = Yii::$app->user->identity->getId();

        try{
            $unsubscribe = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[s:subscribe]->(n) WHERE ID(n) = $id
               DELETE s")
                ->get("SIGN(COUNT(s)) as isCreated")
                ->one();
        } catch (Neo4jException $e) {
            return false;
        }

        return (bool) $unsubscribe->isCreated;


    }

    public static function getAll($asArray = false)
    {
        $userId = Yii::$app->user->identity->getId();

        try {
            self::$_blogs = Account::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(:Blog)<-[:has_blog]-(ac:Account)-[:live_in]->(c:City)-[:locate]->(ct:Country)
        WITH ac, c, ct OPTIONAL MATCH (ac)-[:has_car | :main_car]->(car:Car)  WITH ac, c, ct, car")
                ->get("ac, ID(ac) as id, c as city, ct as country, collect(car) as cars")
                ->all();

            $count = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(:Blog)<-[:has_blog]-(ac:Account)")
                ->get("count(ac) as count")
                ->one();
            self::$_blogs['count'] = (!is_null($count)) ? $count->count : 0;
        } catch (UnknownPropertyException $e) {

            self::$_blogs = [];
        }
        try{
            self::$_journals = Journal::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(j:Journal)<-[:has_journal]-(c:Car)<-[:has_car | :main_car]-(ac:Account)")
                ->get("j, ID(j) as id, c as car, ac as account")
                ->all();
            $count = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(j:Journal)")
                ->get("count(j) as count")
                ->one();
            self::$_journals['count'] = (!is_null($count)) ? $count->count : 0;
        } catch (UnknownPropertyException $e){

            self::$_journals = [];
        }

        try {
            self::$_community_blogs = Community::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(cb:CommunityBlog)<-[:has_blog]-(c:Community)")
                ->get("c, ID(c) as id")
                ->all();
            $count = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(cb:CommunityBlog)")
                ->get("count(cb) as count")
                ->one();
            self::$_community_blogs['count'] = (!is_null($count)) ? $count->count : 0;
        } catch (UnknownPropertyException $e){

            self::$_community_blogs = [];
        }

        try {
            self::$_company_blogs = Company::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(cb:CompanyBlog)<-[:has_blog]-(c:Company)")
                ->get("c, ID(c) as id")
                ->all();
            $count = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:subscribe]->(cb:CompanyBlog)")
                ->get("count(cb) as count")
                ->one();
            self::$_company_blogs['count'] = (!is_null($count)) ? $count->count : 0;
        } catch (UnknownPropertyException $e){

            self::$_company_blogs = [];
        }

        if($asArray){
            return self::convertToArray();
        }



        return [
            'blogs' => self::$_blogs,
            'journals' => self::$_journals,
            'community_blogs' => self::$_community_blogs,
            'company_blogs' => self::$_company_blogs
        ];

    }

    protected static function convertToArray()
    {
        $blogs = [];
        $journals = [];
        $community_blogs = [];
        $company_blogs = [];

        if(!empty(self::$_blogs)){
            foreach (self::$_blogs as $key => $user){
                if($key === 'count'){
                    $blogs[$key] = $user;
                } else {
                    $blogs[$key] = $user->asArray();
                }

            }
        }

        if(!empty(self::$_journals)){
            foreach (self::$_journals as $key => $journal){
                if($key === 'count'){
                    $journals[$key] = $journal;
                } else {
                    $journals[$key] = $journal->asArray();
                }

            }
        }

        if(!empty(self::$_community_blogs)){
            foreach (self::$_community_blogs as $key => $community){
                if($key === 'count'){
                    $community_blogs[$key] = $community;
                } else{
                    $community_blogs[$key] = $community->asArray();
                }

            }
        }

        if(!empty(self::$_company_blogs)){
            foreach (self::$_company_blogs as $key => $company){
                if($key === 'count'){
                    $company_blogs[$key] = $company;
                } else{
                    $company_blogs[$key] = $company->asArray();
                }

            }
        }

        return [
            'blogs' => $blogs,
            'journals' => $journals,
            'community_blogs' => $community_blogs,
            'company_blogs' => $company_blogs
        ];
    }

    public static function getCount()
    {
        $userId = Yii::$app->user->identity->getId();
        if($subscription = Subscription::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[s:subscribe]->(n)")
            ->get("count(s) as count")
            ->one()){

            return  $subscription->count;

        }

        return null;
    }
}