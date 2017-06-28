<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\UnknownPropertyException;

class Favorite extends ActiveRecord
{
    public $count;

    public $isCreated;


    public static function add($nodeId)
    {
        $userId = Yii::$app->user->identity->getId();

        $created_at = time();

        try{
            self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (n) WHERE ID(n) = $nodeId AND  NOT (a)-[:favorite]->(n) 
        WITH a,n
        CREATE (a)-[r:favorite{created_at: $created_at}]->(n)")
                ->get("SIGN(COUNT(r)) as isCreated")
                ->one()->isCreated;

            return true;
        } catch (Neo4jException $e) {
            return false;
        }

    }



    public static function getCount($nodeId)
    {
        try{
            $favorites = self::find()->match("(n) WHERE ID(n) = $nodeId OPTIONAL MATCH (n)<-[:favorite]-(a)")
                ->get("COUNT(a) as count")
                ->one();
        } catch (UnknownPropertyException $e){
            return 0;
        }

        return $favorites->count;
    }


}