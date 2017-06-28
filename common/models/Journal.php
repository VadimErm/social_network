<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\ErrorException;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Journal extends ActiveRecord
{


    public $id;
    public $car;
    public $account;
    public $entries;
    public $created_at;

    public $likes;
    public $views = 0;
    public $favorites;


    public  $count;
    public $countOfAllEntries;

    public function rules()
    {
        return [
            [['created_at', 'likes', 'favorites', 'views'], 'safe'],

        ];
    }

    public function getEntries($asArray = false, $skip = null, $limit = null, $sort = null)
    {

        $offset = '';
        $order = '';
        if( !is_null($skip) && !is_null($limit)){
            $offset = " SKIP $skip LIMIT $limit";
        }

        if(!is_null($sort)){
            switch ($sort){
                case JournalEntry::SORT_BY_NAME:
                    $order = ' ORDER BY je.title ASC';
                    break;
                case  JournalEntry::SORT_BY_TAG:
                    $order = ' ORDER BY head(tags).name ASC';
                    break;
                case JournalEntry::SORT_BY_DATE:
                    $order = ' ORDER BY toInteger(je.created_at) DESC';
            }

        }

        try{
            $journalEntries = JournalEntry::find()->match("(j:Journal) WHERE ID(j) = $this->id 
        OPTIONAL MATCH (j)-[:has_journal_entry]->(je) WITH je 
        OPTIONAL MATCH (je)-[:has_image]->(i) WITH je, collect(i) as images 
        OPTIONAL MATCH (je)-[:has_tag]->(t) WITH je, images, t ORDER BY t.name")
                ->get("je, ID(je) as id, images, collect(t) as tags$order$offset")
                ->all();
       } catch (UnknownPropertyException $e){

            $journalEntries = [];

      }

       if(!empty($journalEntries)){
            foreach ($journalEntries as $key => $journalEntry){
                $journalEntry->tags = $journalEntry->getTags();
            }

            if($asArray){
                foreach ($journalEntries as $key => $journalEntry)
                {
                    $journalEntries[$key] = $journalEntry->asArray();
                }

            }
        }

        return $journalEntries;
    }

    public function getCar($asArray = false)
    {
        try {
            $car = Car::find()->match("(j:Journal), (j)<-[:has_journal]-(c:Car) WHERE ID(j) = $this->id  
         OPTIONAL MATCH (c)-[:has_image]-(i)")
                ->get("c, ID(c) as id, collect(i) as images")
                ->one();
        } catch (UnknownPropertyException $e){
            $car = [];
        }


        if($asArray){

            return (!is_null($car)) ? $car->asArray() : [];
        } else {
            return $car;
        }

    }

    public function getAccount($asArray = false)
    {
        /**
         * @var Account $account
         */
        $account = Account::find()->match("(j:Journal),  (j)<-[:has_journal]-(c:Car)<-[r:has_car | :main_car | :ex_car | :wished | :test_drive]-(a) WHERE ID(j) = $this->id")
            ->get("a, ID(a) as id")
            ->one();
        if($asArray){
            return $account->asArray();
        }
        return $account;
    }

    public function asArray($skips = null, $skipEntries = null, $limitEntries = null, $sort = null)
    {
       $identity = $this;
       $response = ArrayHelper::toArray($identity, [
           'common\models\Journal' =>[
               'id',
               'car',
               'entries' => function($identity, $skipEntries = null, $limitEntries = null, $sort = null)  {

                   return $identity->getEntries(true, $skipEntries, $limitEntries, $sort);

               },

               'account' => function($identity) {
                   return  $identity->getAccount(true);
               }
           ]
       ]);

        if($skips){
            foreach ($skips as $skip){
                unset($response[$skip]);
            }
        }
       return $response;
    }

    public static function getCount($userId = null)
    {
        if(is_null($userId)){
            $userId = Yii::$app->user->identity->getId();
        }

        return Journal::find()->match("(a:Account{user_id: $userId}) OPTIONAL MATCH (a)-[r:main_car | :has_car | :ex_car]->(car) WITH car 
         OPTIONAL MATCH (car)-[:has_journal]->(j)")
            ->get("count(j) as count")
            ->one()->count;


    }

    public static function getCountOfAllEntries($userId = null)
    {
        if(is_null($userId)){
            $userId = Yii::$app->user->identity->getId();
        }

        try {
            $journal = Journal::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[r:main_car | :has_car | :ex_car]->(car) WITH car 
         OPTIONAL MATCH (car)-[:has_journal]->(j) WITH car, j OPTIONAL MATCH (j)-[:has_journal_entry]->(je:JournalEntry) ")
                ->get("COUNT(je) as countOfAllEntries")
                ->one();
        } catch (UnknownPropertyException $e) {
            $journal = null;
        }

        if($journal){
            return $journal->countOfAllEntries;
        } else {
            return 0;
        }
    }

    public static function getAll($userId = null)
    {
        if(is_null($userId)){
            $userId = Yii::$app->user->identity->getId();
        }
        $journalsArr = [];
        try{
            $journals = Journal::find()->match("(a:Account{user_id: $userId}) 
            OPTIONAL MATCH (a)-[r:main_car | :has_car | :ex_car | :wished | :test_drive]->(c) WITH c 
            OPTIONAL MATCH (c)-[:has_journal]->(j) WITH j")
                ->get("j, ID(j) as id")
                ->all();
        } catch (UnknownPropertyException $e){
            $journals = [];
        }

        if(!empty($journals)){
            foreach ($journals as $journal){
                $journal->car = $journal->getCar(true);
                $journalsArr[] = $journal->asArray();

            }
        }


        return $journalsArr;
    }

    public function addViews()
    {
        $userId = Yii::$app->user->identity->getId();

        if($model = $this->match("(j:Journal) WHERE ID(j) = $this->id")
            ->get("j.views as views")
            ->one()){
            if($userId !== $this->getAccount()->user_id){
                $views = (int) $model->views;
                $views +=1;
                Journal::find()->match("(j:Journal) WHERE ID(j) = $this->id")
                    ->set("j.views = $views")
                    ->get('j, ID(j) as id')
                    ->one();
                return true;
            } else {
                return false;
            }

        }

        return false;
    }


    public function getLikes()
    {
        return Like::getCount($this->id);
    }

    public function getFavorites()
    {
        return Favorite::getCount($this->id);
    }

    public static function getAllJournals()
    {
        $journalsArr = [];
        $journalArrr = [];
        $journals =  self::find()->match("(j:Journal)")
            ->get("j, ID(j) as id ORDER BY j.created_at DESC")
            ->all();

        foreach ($journals as $journal){
            $journal->car = $journal->getCar(true);
            $journal->likes = $journal->getLikes();
            $journal->favorites = $journal->getFavorites();
        }

        return $journals;
    }


}

