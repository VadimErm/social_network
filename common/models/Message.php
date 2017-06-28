<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;


class Message extends  ActiveRecord
{
    CONST UNREADED = 0;
    CONST READED = 1;

    public $id;

    public $title;
    public $text;
    public $images = [];
    public $videos = [];
    public $isDeleted = 0;
    public $created_at;
    public $receiver_id;
    public $author_id;
    public $author;
    public $receiver;
    public $readed = 0;
    public $token;
    public $files = [];

    public $count;
    public $blocked;


    public function rules()
    {
        return [
            [['id', 'created_at', 'images', 'videos', 'isDeleted', 'receiver_id', 'author_id', 'author', 'readed', 'token', 'files'], 'safe'],
            [['title', 'text'],  'required'],


        ];
    }

    public function insert($runValidation = true, $attributes = null)
    {
        //TODO: закончить метод для веб приложения
    }

    public static function removeByIds(array $messagesId)
    {
        $messageIdsStr = implode(',', $messagesId);
        return (bool) self::find()->match("m = (message) WHERE ID(message) IN [$messageIdsStr] FOREACH (n IN nodes(m)| SET n.isDeleted = 1 )")
            ->get("message")
            ->all();
    }

    public static function deleteAll($dialogId)
    {
        return (bool) self::find()->match("m = (message),  (message)<-[:has_message]-(d) WHERE ID(d) = $dialogId FOREACH (n IN nodes(m)| SET n.isDeleted = 1 )")
            ->get("message")
            ->all();

    }

    public function getAuthor()
    {
        return Account::find()->match("(a:Account{user_id:$this->author_id})")
            ->get("a, ID(a) as id")
            ->one();
    }

    public function getReceiver()
    {
        $account = new Account();

        return  $account->findByUserId($this->receiver_id);
    }

    public  function read()
    {
        $model = new Message();
        $messages = $model->findByToken($this->token);

        foreach ($messages as $message){
            $message->readed = 1;
            $message->update();
        }

      return $messages;
    }

    public function findByToken($token)
    {
        return Message::find()->match("(m:Message) WHERE m.token = '$token'")
            ->get("m, ID(m) as id")
            ->all();
    }

    public static function getUnreadedMessagesCount(){

        $userId = Yii::$app->user->identity->getId();
        if($message = Message::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_dialog]->(d) WITH d 
        OPTIONAL MATCH (d)-[:has_message]->(m) WHERE m.readed = 0 AND m.author_id <> $userId")
            ->get("count(m) as count")
            ->one()){

            return  $message->count;

        }

        return null;

    }



    public function asArray()
    {
        $identity = $this;
        return ArrayHelper::toArray($identity, [
            'common\models\Message' =>[
                'id',
                'title',
                'text',
                'created_at',
                'readed',
                'isDeleted',
                'author_id',
                'receiver_id',
                'blocked',
                'receiver' => function($identity){


                    return $identity->getReceiver()->asArray();
                },
                'author' => function($identity){
                    return $identity->getAuthor()->asArray();
                },
                'images' => function($identity){
                    return ArrayHelper::toArray($identity->images, [
                        'common\models\Image' => [
                            'src',
                            'description'

                        ]
                    ]);
                },
                'files' => function($identity){
                    return ArrayHelper::toArray($identity->files, [
                        'common\models\File' => [
                            'path',

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
                'token' => function($identity){
                    return ($identity->token) ? $identity->token : null;
                }
            ]
        ]);
    }

    public function getImages($asArray = false)
    {
        try {
            $images = Image::find()->match("(m:Message) WHERE ID(m) = $this->id OPTIONAL MATCH
        (m)-[:has_image]->(i:Image)")
                ->get("i")
                ->all();
        } catch (UnknownPropertyException $e) {
            $images = [];
        }


        $imagesArr  = [];
        if($asArray && !empty($images)){
            foreach ($images as $image){
                $imagesArr[] = $image->asArray();
            }

            return $imagesArr;

        }

        return $images;

    }

    public function getVideos($asArray = false)
    {
        try{
            $videos = Video::find()->match("(m:Message) WHERE ID(m) = $this->id OPTIONAL MATCH
            (m)-[:has_video]->(v:Video)")
                ->get("v")
                ->all();
        } catch (UnknownPropertyException $e) {
            $videos = [];
        }

        $videosArr  = [];
        if($asArray && !empty($videos)){
            foreach ($videos as $video){
                $videosArr[] = $video->asArray();
            }

            return $videosArr;
        }

        return $videos;
    }

    public function getFiles($asArray = false)
    {
        try{
            $files = File::find()->match("(m:Message) WHERE ID(m) = $this->id OPTIONAL MATCH
            (m)-[:has_file]->(f:File)")
                ->get("f")
                ->all();
        } catch (UnknownPropertyException $e) {
            $files = [];
        }

        $filesArr  = [];
        if($asArray && !empty($files)){
            foreach ($files as $file){
                $filesArr[] = $file->asArray();
            }

            return $filesArr;
        }

        return $files;

    }

}