<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Faker\Provider\DateTime;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\UnknownPropertyException;

class Bookmark extends ActiveRecord
{
    CONST JOURNAL_ENTRY_BOOKMARK = 1;
    CONST USER_BOOKMARK = 2;
    CONST JOURNAL_BOOKMARK = 3;
    CONST BLOG_POST_BOOKMARK = 4;
    CONST COMMUNITY_BOOKMARK = 5;
    CONST COMPANY_BOOKMARK = 6;
    CONST PROMO_ACTIONS = 7;

    public $isCreated;
    public static $users = [];
    public static $journalEntries = [];
    public static $journals = [];
    public static $blogPosts = [];
    public static $communities = [];
    public static $companies = [];
    public static $promoActions = [];

    public $count;

    public function add($type, $id)
    {
        $userId = Yii::$app->user->identity->getId();

        $node = '';

        $time = DateTime::unixTime();

        switch ($type){
            case self::JOURNAL_ENTRY_BOOKMARK:
                $node = 'JournalEntry';
                break;
            case self::USER_BOOKMARK:
                $node = 'Account';
                break;
            case self::JOURNAL_BOOKMARK:
                $node = 'Journal';
                break;
            case self::BLOG_POST_BOOKMARK:
                $node = 'Post';
                break;
            case self::COMMUNITY_BOOKMARK:
                $node = 'Community';
                break;
            case  self::COMPANY_BOOKMARK:
                $node = 'Company';
                break;
            case self::PROMO_ACTIONS:
                $node = 'PromoAction';
                break;
        }

        try {
            $this::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (n:$node) WHERE ID(n) = $id
            AND NOT (a)-[:bookmarked]->(n) WITH a, n
           CREATE (a)-[b:bookmarked{created_at:$time}]->(n)")
                ->get("SIGN(COUNT(b)) as isCreated")
                ->one();

            return true;
        } catch (Neo4jException $e){
            return false;
        }

    }

    public static function getAll($asArray = false)
    {
        $userId = Yii::$app->user->identity->getId();

        try{
            self::$users = Account::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[b:bookmarked]->(n:Account)")
                ->get('n, ID(n) as id ORDER BY b.created_at DESC')
                ->all();
        } catch (UnknownPropertyException $e){
            self::$users = [];
        }


        try{
            self::$blogPosts = Post::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:bookmarked]->(n:Post)<-[:has_post]-(b)<-[:has_blog]-(c:Account)")
                ->get('n, ID(n) as id, c as account')
                ->all();

        } catch (UnknownPropertyException $e){

            self::$blogPosts  = [];
        }

        try{
            self::$journals = Journal::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:bookmarked]->(n:Journal)")
                ->get('n, ID(n) as id')
                ->all();
        } catch (UnknownPropertyException $e){

            self::$journals = [];
        }

        try{
            self::$journalEntries =JournalEntry::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:bookmarked]->(n:JournalEntry)")
                ->get('n, ID(n) as id')
                ->all();
        } catch (UnknownPropertyException $e){

            self::$journalEntries = [];

        }

        try{
            self::$communities = Community::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:bookmarked]->(n:Community)")
                ->get('n, ID(n) as id')
                ->all();
        } catch (UnknownPropertyException $e) {

            self::$communities = [];
        }

        try{
            self::$companies = Company::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:bookmarked]->(n:Company)")
                ->get('n, ID(n) as id')
                ->all();
        } catch (UnknownPropertyException $e){

            self::$communities = [];

        }

        try{
            self::$promoActions = PromoAction::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:bookmarked]->(n:PromoAction)")
                ->get('n, ID(n) as id')
                ->all();
        } catch (UnknownPropertyException $e) {

            self::$promoActions = [];
        }

        if($asArray) {
            return self::convertToArray();
        }


        return [
            'users' => self::$users,
            'blogPosts' => self::$blogPosts,
            'journals' => self::$journals,
            'journalEntries' => self::$journalEntries,
            'communities' => self::$communities,
            'companies' => self::$companies,
            'promoActions' =>  self::$promoActions
        ];
    }

    protected static function convertToArray()
    {
        $users = [];
        $blogPosts = [];
        $journals = [];
        $journalEntries = [];
        $communities = [];
        $companies = [];
        $promoActions = [];



        if(!empty(self::$users)){
            foreach (self::$users as $user){
                $users[] = $user->asArray();
            }
        }

        if(!empty(self::$blogPosts)){
            foreach (self::$blogPosts as $blogPost){
                $blogPosts[] = $blogPost->asArray();
            }
        }

        if(!empty(self::$journals)){
            foreach (self::$journals as $journal){
                $journals[] = $journal->asArray();
            }
        }

        if(!empty(self::$journalEntries)){
            foreach (self::$journalEntries as $journalEntry){
                $journalEntries[] = $journalEntry->asArray();
            }
        }

        if(!empty(self::$communities)){
            foreach (self::$communities as $community){
                $communities[] = $community->asArray();
            }
        }

        if(!empty(self::$companies)){
            foreach (self::$companies as $company){
                $companies[] = $company->asArray();
            }
        }

        if(!empty(self::$promoActions)){
            foreach (self::$promoActions as $promoAction){
                $promoActions[] = $promoAction->asArray();
            }
        }



        return [
            'users' => $users,
            'blogPosts' => $blogPosts,
            'journals' => $journals,
            'journalEntries' => $journalEntries,
            'communities' => $communities,
            'companies' => $companies,
            'promoActions' =>  $promoActions
        ];

    }

    public static function deleteBookmark($id)
    {
        $userId = Yii::$app->user->identity->getId();

        try{
            Bookmark::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[r:bookmarked]->(n) WHERE ID(n) = $id DELETE r")
                ->execute(true);
        }  catch (Neo4jException $e){

            return false;
        }

        return true;
    }

    public static function  getCount()
    {
        $user_id = Yii::$app->user->identity->getId();

        return Bookmark::find()->match("(a:Account{user_id: $user_id}) OPTIONAL MATCH (a)-[b:bookmarked]->(n)")
            ->get("count(n) as count")
            ->one()->count;
    }

}