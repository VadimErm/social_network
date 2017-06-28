<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Post extends ActiveRecord
{
    public $id;
    public $title;
    public $message;
    public $created_at;
    public $images;
    public $videos;
    public $comments;
    public $user_id;
    public $account;
    public $deleted_images;

    public function rules()
    {
        return [
            [['created_at', 'user_id', 'deleted_images', 'account'], 'safe'],
            [['title', 'message'],  'required'],


        ];
    }

    public function getComments()
    {
        return Comment::find()
            ->match("(n:Post)-[:has_comment]->(c) WHERE ID(n) = $this->id")
            ->get('c, ID(c) as id')
            ->all();
    }

    public function getAccount($asArray = false)
    {
        /**
         * @var Account $account
         */
        $account = Account::find()->match("(a:Account{user_id:$this->user_id})")
            ->get("a, ID(a) as id")
            ->one();
        if($asArray){
            return $account->asArray();
        }
        return $account;
    }

    public static function getAll()
    {

        $postsArr = [];
        try{
            $posts =  self::find()->match("(p:Post) OPTIONAL MATCH (p)-[:has_image]->(i:Image)")
                ->get("p, ID(p) as id, collect(i) as images ORDER BY p.created_at DESC")
                ->all();

        } catch (UnknownPropertyException $e) {

            $posts = [];

        }


        if(!empty($posts)){

            foreach ($posts as $key => $post){

                $postsArr[$key] = $post->asArray();
                $postsArr[$key]['account'] = $post->getAccount(true);
            }
        }

        return $postsArr;
    }

    public function asArray()
    {
        $identity = $this;
        $identity->comments = $this->getComments();
      return  ArrayHelper::toArray($identity, [
            'common\models\Post' => [
                'id',
                'title',
                'message',
                'created_at',
                'account' => function($identity) {

                    return  (!is_null($this->account)) ? $this->account->asArray() : null;

                },
                'images' => function($identity) {

                    return ArrayHelper::toArray($identity ->images, [
                        'common\models\Image' => [
                            'src',
                            'description'

                        ]
                    ]);

                },
                'videos' =>function($identity) {

                    return ArrayHelper::toArray($identity->videos, [
                        '\stdClass' => [
                            'src',


                        ]
                    ]);

                },
                'comments' => function($identity ) {

                    return ArrayHelper::toArray($identity->comments, [
                        'common\models\Comment' => [
                            'id',
                            'node_id',
                            'message',
                            'created_at',
                            'user_id',
                            'answer_comment_id',
                            'account' => function($comment) {
                                return $comment->getAccount();
                            }

                        ]
                    ]);

                },
                'user_id'
            ]
        ]);
    }
}