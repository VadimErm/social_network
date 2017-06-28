<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 16.06.17
 * Time: 17:16
 */

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Blacklist extends ActiveRecord
{
    public $id;
    public $nodes = [];

    public $isCreated;


    public static function add($userId,$blockedNodeId)
    {

        try{
           return (bool) self::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (n) WHERE ID(n) = $blockedNodeId CREATE UNIQUE (a)-[:has_blacklist]->(b:Blacklist)-[r:blocked]->(n)")
                ->get("SIGN(COUNT(r)) as isCreated")
                ->one()->isCreated;

        } catch (Neo4jException $e) {
            return false;
        }


    }

    public static function getBlockedNodes($userId)
    {
        $blacklist = [];
        $blockedAccountsArr = [];
        $blockedPostsArr = [];
        $blockedDialogsArr = [];
        $blockedCommentsArr = [];


        try{
            $blockedAccounts = Account::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_blacklist]->(b) 
                WITH b OPTIONAL MATCH (b)-[:blocked]->(n:Account)")
                ->get("n, ID(n) as id")
                ->all();
        } catch (UnknownPropertyException $e) {

            $blockedAccounts = [];
        }

        try{
            $blockedPosts = Post::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_blacklist]->(b) 
                WITH b OPTIONAL MATCH (b)-[:blocked]->(n:Post)")
                ->get("n, ID(n) as id")
                ->all();
        } catch (UnknownPropertyException $e) {

            $blockedPosts = [];
        }

        try{
            $blockedDialogs = Dialog::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_blacklist]->(b)
            WITH b OPTIONAL MATCH (b)-[:blocked]->(n:Dialog)")
                ->get("n, ID(n) as id")
                ->all();
        } catch (UnknownPropertyException $e) {

            $blockedDialogs = [];
        }

        try{
            $blockedComments = Comment::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_blacklist]->(b)
            WITH b OPTIONAL MATCH (b)-[:blocked]->(n:Comment)")
                ->get("n, ID(n) as id")
                ->all();
        } catch (UnknownPropertyException $e) {

            $blockedComments  = [];
        }


       if(!empty($blockedAccounts)){
           foreach ($blockedAccounts as $blockedAccount){
               $blockedAccountsArr[] = $blockedAccount->asArray([], true);
           }

       }

        if(!empty($blockedPosts)){
            foreach ($blockedPosts as $blockedPost){
                $blockedPostsArr[] = $blockedPost->asArray();
            }


        }

        if(!empty($blockedDialogs)){
            foreach ($blockedDialogs as $blockedDialog){
                $blockedDialogsArr[] = $blockedDialog->asArray();
            }

        }

        if(!empty($blockedComments)){
            foreach ($blockedComments as $blockedComment){
                $blockedCommentsArr[] = $blockedComment->asArray(['account']);
            }

        }

        $blacklist['accounts'] = $blockedAccountsArr;
        $blacklist['posts'] = $blockedPostsArr;
        $blacklist['dialogs'] = $blockedDialogsArr;
        $blacklist['comments'] = $blockedCommentsArr;



       return $blacklist;
    }

}