<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\UnknownPropertyException;


class Follower extends ActiveRecord
{
    protected static $followers = [];
    public $c;
    public  $count;

    public $isCreated;

    public static function follow($nodeId)
    {
        $userId = Yii::$app->user->identity->getId();

        try{
            self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (n) WHERE ID(n) = $nodeId AND  NOT (a)-[:follow]->(n) 
        WITH a,n
        CREATE (a)-[r:follow]->(n)")
                ->get("SIGN(COUNT(r)) as isCreated")
                ->one()->isCreated;

            return true;
        } catch (Neo4jException $e) {
            return false;
        }

    }

    public static function unfollow($nodeId)
    {
        $userId = Yii::$app->user->identity->getId();

      if(self::find()->match("(a)-[f:follow]->(n) WHERE a.user_id = $userId AND ID(n) = $nodeId DELETE f")
            ->get("a, n")
            ->execute(true)){
          return true;
      } else {
          return false;
      }

    }

    /**
     * Список пользователей за которым следит данный пользователь
     * @param bool $asArray
     * @param null $type
     * @return array
     */
    public static function getAll($asArray = false, $type = null)
    {
        $userId = Yii::$app->user->identity->getId();
        try {
            self::$followers = Account::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:follow]->(b:Account)-[:live_in]->(c:City)-[:locate]->(ct:Country)")
                ->get("b, ID(b) as id, c as city, ct as country")
                ->all();


        } catch (UnknownPropertyException $e) {
            self::$followers = [];
        }


        if ($asArray) {
            return self::convertToArray();
        }


        return self::$followers;
    }



    protected static function convertToArray()
    {
        $followers = [];

        if(!empty(self::$followers)){
            foreach (self::$followers as $follower){
                $followers[] = $follower->asArray();
            }
        }

        return $followers;

    }

    public static function getCount()
    {
        $userId = Yii::$app->user->identity->getId();

        try {
            self::$count = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:follow]->(b:Account)")
                ->get("count(b) as c")
                ->one();
        } catch (UnknownPropertyException $e){

           return 0;
        }

        return self::$count->c;

    }

    public static function getFollowersCount($nodeId)
    {
        try{
            $followers = self::find()->match("(n) WHERE ID(n) = $nodeId OPTIONAL MATCH (n)<-[:follow]-(a)")
                ->get("COUNT(a) as count")
                ->one();
        } catch (UnknownPropertyException $e){
            return 0;
        }

        return $followers->count;

    }

    /**
     * Список пользователей которые следят за нодой
     * @param $nodeId
     * @param bool $asArray
     * @return array
     */
    public static function getFollowers($nodeId, $asArray = false)
    {
       try{
           self::$followers = Account::find()->match("(n) WHERE ID(n) = $nodeId OPTIONAL MATCH (n)<-[:follow]-(a)")
               ->get("a, ID(a) as id")
               ->all();
       } catch (UnknownPropertyException $e) {
           self::$followers = [];
       }

        if ($asArray) {
            return self::convertToArray();
        }


        return self::$followers;

    }

    public static function getMyFolowersCount()
    {
        $userId = Yii::$app->user->identity->getId();

        try {
            $followers = self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)<-[f:follow]-(b)")
                ->get("count(b) as count")
                ->one();
        } catch (UnknownPropertyException $e){

            return 0;
        }

        return $followers->count;
    }
}