<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 08.06.17
 * Time: 18:44
 */

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\UnknownPropertyException;

class Node extends ActiveRecord
{
    CONST CAR = 1;
    CONST ACCOUNT = 2;
    CONST JOURNAL_ENTRY = 3;
    CONST BLOG_POST = 4;
    CONST ALBUM = 5;
    CONST NOTIFICATION = 6;


    public function getNode($id, $node_type, $asArray = false,  $skips = null)
    {
        $node= null;
        switch ($node_type){
            case self::CAR:
                $node = Car::find()->match("(n:Car) WHERE ID(n) = $id")
                    ->get("n, ID(n) as id")
                    ->one();
                break;
            case self::ACCOUNT:
                $node = Account::find()->match("(n:Account) WHERE ID(n) = $id")
                    ->get("n, ID(n) as id")
                    ->one();
                break;
            case self::JOURNAL_ENTRY:
                $node = JournalEntry::find()->match("(n:JournalEntry) WHERE ID(n) = $id")
                    ->get("n, ID(n) as id")
                    ->one();
                break;
            case self::BLOG_POST:
                $node = Post::find()->match("(n:Post) WHERE ID(n) = $id")
                    ->get("n, ID(n) as id")
                    ->one();
                break;
            case self::ALBUM:
                $node = Album::find()->match("(n:Album) WHERE ID(n) = $id")
                    ->get("n, ID(n) as id")
                    ->one();
                break;
            case  self::NOTIFICATION:
                $node = Notification::find()->match("(n:Notification) WHERE ID(n) = $id")
                    ->get("n, ID(n) as id")
                    ->one();
                break;

        }

       if($node){
            if($asArray){
                return $node->asArray();
            } else{
                return $node;
            }

       } else {
           return null;
       }

    }

}