<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Comment extends ActiveRecord
{
    public $id;
    public $node_id;
    public $message;
    public $created_at;
    public $user_id;
    public $answer_comment_id;
    public $account;

    public $count;
    public $likes;
    public $spam = 0;





    public function rules()
    {
        return [
            [['node_id'], 'integer'],
            ['message', 'required'],
            ['message', 'string'],
            [['user_id', 'answer_comment_id','created_at', 'id', 'spam'], 'safe']
        ];
    }

    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }
        $this->message = nl2br($this->message);

        if ($attributes == null) {
            $attributes = $this->attributes();
        }
        $node_id = $attributes['node_id'];
        //unset($attributes['node_id']);

        $attributesStr = $this->getAttributesStr($attributes);

        return $this
            ->match("(n) WHERE ID(n) = $node_id CREATE (c:Comment{{$attributesStr}}), (n)-[:has_comment]->(c)")
            ->get('c, ID(c) as id')
            ->one();
    }

    public static function getCount($nodeId)
    {
        try{
            $comments = self::find()->match("(n) WHERE ID(n) = $nodeId OPTIONAL MATCH (n)-[:has_comment]->(c:Comment)")
                ->get("COUNT(c) as count")
                ->one();
        } catch (UnknownPropertyException $e){
            return 0;
        }

        return $comments->count;
    }

    public function getAccount()
    {
        if(!is_null($this->user_id)) {
            return Account::find()->match("(a:Account) WHERE a.user_id = $this->user_id")
                ->get('a')
                ->one()->asArray();
        } else {
            return null;
        }
    }

    public function getLikes()
    {
        return Like::getCount($this->id);
    }

    public function asArray($skips = [])
    {
        $identity = $this;
        $response =   ArrayHelper::toArray($identity, [
            'common\models\Comment' => [
                'id',
                'node_id',
                'message',
                'created_at',
                'spam',
                'account'=> function($identity){
                    return $identity->getAccount();
                },
                'answer_comment_id',
                'user_id',
                'likes' => function($identity){
                    return $identity->getLikes();
                },
            ]
        ]);

        if(!empty($skips)){
            foreach ($skips as $skip){
                unset($response[$skip]);
            }
        }

        return $response;
    }

    public static function getAll($nodeId)
    {
        $commentsArr = [];
        $count = 0;
        try{
            $comments = Comment::find()->match("(n) WHERE ID(n) = $nodeId OPTIONAL MATCH (n)-[:has_comment]->(c)")
                ->get("c, ID(c) as id")
                ->all();

            $count = Comment::getCount($nodeId);

        } catch (UnknownPropertyException $e) {
            $comments = [];
        }

        if(!empty($comments)){
            foreach ($comments as $comment){
                $commentsArr[] = $comment->asArray();
            }

        }

        $commentsArr['count'] = $count;

        return $commentsArr;


    }

    public static function spam($commentId)
    {
        try{
            $comment = self::find()->match("(c:Comment) WHERE ID(c) = $commentId")
                ->set("c.spam = 1")
                ->get("c, ID(c) as id")
                ->one();
        } catch (UnknownPropertyException $e) {
            $comment = null;
        }

        if($comment) {
            return (bool) $comment->spam;
        } else {
            return false;
        }


    }


}