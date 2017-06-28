<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use spec\Http\Message\Decorator\MessageDecoratorSpec;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;

class Dialog extends ActiveRecord
{
    public $id;
    public $receiver_id;
    public $author_id;
    public $messages = [];
    public $isDeleted = 0;
    public $isBlocked;
    public $token;

    public $last_message;

    public $link;

    public function rules()
    {
        return [
            [['id', 'messages', 'isDeleted', 'isBlocked', 'token'], 'safe'],
            [['receiver_id', 'author_id'],  'required'],
            [['receiver_id', 'author_id'], 'integer']


        ];
    }

    public function insert($runValidation = true, $attributes = null)
    {

        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        if ($attributes == null) {
            $attributes = $this->getAttributesStr($this->attributes());
        }

        $time = (int) time();
        $token =md5(rand().rand().time().md5($this->author_id));

        $attributes .=", isDeleted:0, token:'".$token."'";

        $receiver_id = (int) $this->receiver_id;

        return $this->match("(a:Account{user_id:$this->author_id}) OPTIONAL MATCH (b:Account{user_id:$receiver_id}) CREATE (a)-[hd1:has_dialog]->(d1:Dialog{{$attributes}})-[:link]->(d2:Dialog{{$attributes}})<-[hd2:has_dialog]-(b)")
            ->get('d1, ID(d1) as id')
            ->one();


    }

    public function isExist()
    {
        $receiver_id = (int) $this->receiver_id;
        return !is_null($this::find()->match("(a:Account{user_id:$this->author_id})-[hd1:has_dialog]->(d1:Dialog)-[l:link]-(d2:Dialog)<-[hd2:has_dialog]-(b:Account{user_id:$receiver_id})")
            ->get('l IS NOT NULL as link')
            ->one());
    }

    public function getToken()
    {
        $receiver_id = (int) $this->receiver_id;
        try {
          return  ($this::find()->match("(d:Dialog) WHERE (d.author_id = $this->author_id AND d.receiver_id = $receiver_id) OR (d.author_id = $receiver_id AND d.receiver_id = $this->author_id)")
                ->get("head(collect(d)).token as token")
                ->one())->token;
        } catch (UnknownPropertyException $e){
            return null;
        }
    }

    public static function blockDialogWithUser($userId)
    {
        $currentUserId = Yii::$app->user->identity->getId();

        try{
         return (bool) (self::find()->match("(a:Account{user_id:$currentUserId}) OPTIONAL MATCH (a)-[:has_dialog]->(d:Dialog) WHERE (d.author_id = $currentUserId AND d.receiver_id = $userId) OR (d.author_id = $userId  AND d.receiver_id = $currentUserId)
            SET d.isBlocked = 1")
                ->get("d.isBlocked as isBlocked")
                ->one())->isBlocked;

        } catch (UnknownPropertyException $e){

            return false;
        }
    }

    public function wasDeleted()
    {
        $receiver_id = (int) $this->receiver_id;
        return (bool) ($this::find()->match("(a:Account{user_id:$this->author_id})-[hd1:has_dialog]->(d1:Dialog)-[l:link]-(d2:Dialog)<-[hd2:has_dialog]-(b:Account{user_id:$receiver_id}) WHERE d1.isDeleted = 1 OR d2.isDeleted = 1")
            ->get('d1.isDeleted as isDeleted')
            ->one())->isDeleted;
    }

    public function resurrect()
    {
        if($token = $this->getToken()){
            $this::find()->match("(d:Dialog) WHERE d.token ='".$token."' SET d.isDeleted = 0")
                ->execute();
        }

    }

    public function getMessages()
    {

        //TODO: изменить запрос с учетом удалленых сообщений

        return Message::find()->match("(d:Dialog) WHERE ID(d) = $this->id OPTIONAL MATCH (d)-[:has_message]->(m:Message) WITH m
        OPTIONAL MATCH (m)-[:has_image]->(i:Image) WITH m, collect(i) as images 
        OPTIONAL MATCH (m)-[:has_video]->(v:Video) WITH m, images, collect(v) as videos 
        OPTIONAL MATCH (m)-[:has_file]->(f:File) WITH m, images, videos, collect(f) as files")
            ->get("m, ID(m) as id, images, videos, files ORDER BY ID(m) DESC")
            ->all();
    }


    public function asArray($expand = [])
    {
        $identity = $this;

        if(empty($expand)){
            $expand = [
                'id',
                'receiver_id',
                'author_id',
                'isDeleted',
                'isBlocked',
                'messages',
                'last_message',
                'token'
            ];
        }

        return  ArrayHelper::toArray($identity , [
            'common\models\Dialog' => $expand
        ]);
    }

    public static function getAll($asArray = false)
    {


        $userId = Yii::$app->user->identity->getId();
        $dialogs= [];
        try{
            $dialogs = Dialog::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_dialog]->(d) WITH d 
            OPTIONAL MATCH (d)-[:has_message]->(m) WITH d, m ORDER BY toInteger(m.created_at) DESC")
                ->get("d, ID(d) as id, collect(m)  as messages ORDER BY  toInteger(head(messages).created_at) DESC")
                ->all();
            foreach ($dialogs as $dialog){
                $dialog->last_message = $dialog->getLastMessage($asArray);
            }


        } catch (UnknownPropertyException $e){
            $dialogs = [];
        }



        if($asArray) {
            if(!empty($dialogs)){
                foreach ($dialogs as $key => $dialog){
                    $dialogs[$key] = $dialog->asArray(['id', 'receiver_id', 'author_id', 'isDeleted','token','last_message']);
                }
            }
        }


        return $dialogs;
    }

    public static function deleteAll($userId)
    {

        return (bool) self::find()->match("d = (dialogs), (a:Account)-[:has_dialog]->(dialogs) WHERE a.user_id = $userId FOREACH (n IN nodes(d)| SET n.isDeleted = 1 )")
            ->get("dialogs")
            ->all();

    }

    public static function deleteOne($dialogId)
    {
        try{
            $deletedDialog = self::find()->match("(d:Dialog) WHERE ID(d) = $dialogId SET d.isDeleted = 1")
                ->get("d, ID(d) as id")
                ->one();
        } catch (UnknownPropertyException $e){
            $deletedDialog = null;
        }

        if($deletedDialog){
            return (bool) $deletedDialog->isDeleted;
        } else {
            return false;
        }
    }




    public function getLastMessage($asArray = false)
    {
        try{
            $messages = Message::find()->match("(d:Dialog) WHERE ID(d) = $this->id OPTIONAL MATCH (d)-[:has_message]->(m)")
                ->get("m, ID(m) as id  ORDER BY toInteger(m.created_at) DESC")
                ->all();
        } catch (UnknownPropertyException $e){
            $messages = [];
        }

        if(!empty($messages)){

            if($asArray){
                $messages[0]->author = $messages[0]->getAuthor()->asArray();
            } else {
                $messages[0]->author = $messages[0]->getAuthor();
            }

            return ($asArray) ? $messages[0]->asArray() : $messages[0];
        }

       return $messages;


    }

    public function copyTo($userId)
    {

       $atributesStr = $this->getAttributesStr($this->attributes());
       $messages = $this->getMessages();

       $dialogCopy = $this->match("(a:Account{user_id:$userId}) CREATE
        (a)-[:has_dialog]->(d:Dialog{".$atributesStr."})")
           ->get("d, ID(d) as id")
           ->one();

       $dialogId = $dialogCopy->id;

       foreach ($messages as $message){

            $atributesStr =  $this->getAttributesStr($message->attributes());
            $images = $message->getImages();
            $videos = $message->getVideos();
            $files = $message->getFiles();
           try{ $message = Message::find()->match("(d:Dialog) WHERE ID(d) = $dialogId
            CREATE (d)-[:has_message]->(m:Message{".$atributesStr."})")
                ->get("m, ID(m) as id")
                ->one();
           } catch (UnknownPropertyException $e) {

               return false;
           }

           $messageId = $message->id;

           if(!empty($images)){
               foreach ($images as $image){
                   $atributesStr =  $this->getAttributesStr($image->attributes());
                   try{
                       Image::find()->match("(m:Message) WHERE ID(m) = $messageId 
                   CREATE (m)-[:has_image]->(i:Image{".$atributesStr ."})")
                           ->get("i")
                           ->one();
                   } catch (UnknownPropertyException $e) {

                       return false;
                   }

               }

           }

           if(!empty($videos)){
               foreach ($videos as $video){
                   $atributesStr =  $this->getAttributesStr($video->attributes());
                   try{
                       Video::find()->match("(m:Message) WHERE ID(m) = $messageId 
                   CREATE (m)-[:has_video]->(v:Video{".$atributesStr ."})")
                           ->get("v")
                           ->one();
                   } catch (UnknownPropertyException $e) {

                       return false;
                   }
               }
           }


           if(!empty($files)){
               foreach ($files as $file){
                   $atributesStr =  $this->getAttributesStr($file->attributes());
                   try{
                       File::find()->match("(m:Message) WHERE ID(m) = $messageId 
                   CREATE (m)-[:has_file]->(f:File{".$atributesStr ."})")
                           ->get("f")
                           ->one();
                   } catch (UnknownPropertyException $e) {

                       return false;
                   }
               }
           }


       }


       return true;

    }

}