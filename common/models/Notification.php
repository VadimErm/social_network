<?php


namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Yii;
use yii\base\UnknownPropertyException;
use yii\helpers\ArrayHelper;


class Notification  extends ActiveRecord
{
    //Event's types
    CONST LIKE_TYPE = 1;
    CONST FOLLOW_TYPE = 2;
    CONST SUBSCRIBE_TYPE = 3;
    CONST BOOKMARK_TYPE = 4;
    CONST FAVORITE_TYPE = 5;
    CONST NEW_COMMENT_TYPE = 6;

    protected static $events_text = [
        self::LIKE_TYPE => 'like',
        self::FOLLOW_TYPE => 'follow up',
        self::SUBSCRIBE_TYPE => 'subscribe to',
        self::BOOKMARK_TYPE => 'bookmarked',
        self::FAVORITE_TYPE => 'add to favorite',
        self::NEW_COMMENT_TYPE => 'leave comment on'
    ];

    //Object's types
    CONST CAR  = 1;
    CONST JOURNAL_ENTRY = 2;
    CONST USER = 3;
    CONST BLOG_POST = 4;
    CONST COMMENT = 5;

    protected static $object_names = [
        self::CAR => 'car',
        self::JOURNAL_ENTRY => 'journal entry',
        self::USER => 'account',
        self::BLOG_POST => 'blog post',
        self::COMMENT => 'comment'
    ];



    public $id;
    public $title;
    public $event_type;
    public $type;
    public $created_at;
    public $avatar;
    public $object_type;
    public $id_object;
    public $readed; //bool
    public $user_id;
    public $url;

    public $unreaded_count;

    public function rules()
    {
       return [
           [['readed', 'title', 'type', 'created_at', 'avatar', 'url'], 'safe'],
           [ ['id_object', 'user_id', 'event_type', 'object_type'], 'required'],
           [['id_object', 'user_id', 'event_type', 'object_type'], 'integer']
       ];
    }

    public function insert($runValidation = true, $attributes = null)
    {
        if ($attributes == null) {
            $attributes = $this->attributes();
        }

        if ($runValidation && !$this->validate()) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        switch ($this->object_type){
            case self::CAR:

                $attributes['type'] = 'my-car';
                break;
            case  self::JOURNAL_ENTRY:

                $attributes['type'] = 'journal-entry';
                break;
            case  self::USER:

                $attributes['type'] = 'my-account';
                break;
            case self::BLOG_POST:

                $attributes['type'] = 'my-blog-post';
                break;
            case self::COMMENT:

                $attributes['type'] = 'my-comment';
                break;

        }

        $authorId = Yii::$app->user->identity->getId();
        $accountModel = new Account();
        $account = $accountModel->findByUserId($authorId);
        $event = self::$events_text[$this->event_type];
        $object_name = self::$object_names[$this->object_type];
        $accountArr = $account->asArray();

        $username = $accountArr['username'];
        $attributes['avatar'] = $accountArr['avatar'];
        $attributes['created_at'] = time();
        $attributes['title'] = "User $username $event your $object_name.";

        unset($attributes['event_type']);
        unset($attributes['object_type']);
        unset($attributes['user_id']);

        $attributesStr = $this->getAttributesStr($attributes);
        $attributesStr .=", readed:0";

        return self::find()->match("(a:Account{user_id:$this->user_id}) CREATE (n:Notification{".$attributesStr."}), (a)-[:has_notification]->(n)")
            ->get("n, ID(n) as id")
            ->one();

    }

    public static function getAll($asArray = false)
    {
        $userId = Yii::$app->user->identity->getId();
        $notificationsArr = [];
        try {
            $notifications = Notification::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_notification]->(n)")
                ->get("n, ID(n) as id")
                ->all();

        } catch (UnknownPropertyException $e){
            $notifications = [];
        }

        if(!empty($notifications)){
            if($asArray){
                foreach ($notifications as $notification){
                    $notificationsArr[] = $notification->asArray();
                }
            } else {
                $notificationsArr = $notifications;
            }

            $object = Notification::find()->match("(a:Account{user_id:$userId}) OPTIONAL MATCH (a)-[:has_notification]->(n) WHERE n.readed = 0")
                ->get("COUNT(n) as unreaded_count")
                ->one();

            $notificationsArr['unreaded_count'] = $object->unreaded_count;

        }

        return $notificationsArr;

    }

   public static function read($id)
    {
        $userId = Yii::$app->user->identity->getId();

        try{
         $notification = self::find()->match("(a:Account{user_id:$userId})-[:has_notification]->(n) WHERE ID(n) = $id SET n.readed = 1" )
                ->get("n.readed as readed")
                ->one();
        } catch (UnknownPropertyException $e)
        {
            $notification =null;
        }

        if($notification){
            return (bool) $notification->readed;
        } else {
            return false;
        }



    }

    public function asArray()
    {
        $identity = $this;

        return ArrayHelper::toArray($identity, [
            get_class($identity) => [
                'id',
                'title',
                'type',
                'created_at',
                'avatar',
                'id_object',
                'readed',
                'url'
            ]
        ]);
    }


}