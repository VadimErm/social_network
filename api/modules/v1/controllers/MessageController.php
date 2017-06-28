<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\MessageRest;
use common\models\Account;
use common\models\Blacklist;
use common\models\Blocklist;
use common\models\Dialog;
use common\models\Message;
use GraphAware\Neo4j\Client\Exception\Neo4jException;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
//use yii\rest\Controller;
use yii\web\Response;

class MessageController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
            ],

        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [

                [
                    'allow' => true,
                    'actions' =>
                    [
                        'index',
                        'create',
                        'update',
                        'delete',
                        'count',
                        'spam',
                        'readed',
                        'clear-history',
                        'search',
                        'delete-dialog',
                        'delete-messages',
                        'block',
                        'delete-all-dialogs',
                        'view-dialogs-by-type',
                        'blacklist',
                        'unblock',
                        'view-dialog',
                        'unreaded-count',
                        'join-user'
                    ],
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['bootstrap'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]

        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [

                'index'    => ['get'],
                'create'      => ['post'],
                'delete'   => ['delete'],
                'update'    => ['patch'],
                'delete-dialog' => ['delete'],
                'count'     => ['get'],
                'spam'      => ['put'],
                'readed'    => ['put'],
                'clear-history' => ['delete'],
                'search'    => ['get'],
                'delete-messages' => ['delete'],
                'block'         => ['put'],
                'delete-all-dialogs' => ['delete'],
                'view-dialogs-by-type'  => ['get'],
                'blacklist'         => ['get'],
                'unblock'           => ['put'],
                'view-dialog'       => ['get'],
                'unreaded-count'    => ['get'],
                'join-user'         => ['put']



            ],
        ];

        return $behaviors;
    }

    /**
     * Get all user's dialogs
     * @method get
     * /api/v1/messages
     * @return array
     *
     */
    public function actionIndex()
    {

        $dialogs =  Dialog::getAll(true);

        $this->breadcrumbs->addCrumb("My profile", '/user/account/profile');
        $this->breadcrumbs->addCrumb("My messages");


        return [
            'status' =>'success',
            'dialogs' => $dialogs,
            'user_id' => Yii::$app->user->identity->getId(),
            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Get count of unreaded messages
     * @return array
     * @method GET
     * /api/v1/messages/unreaded-count
     */
    public function actionUnreadedCount()
    {
        if($count = Message::getUnreadedMessagesCount()){
            return [
                'status' =>'success',
                'unreaded_count' => $count,
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'success',
            'unreaded_count' => 0,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];


    }

    /**
     * View dialogs by $type (all or unread)
     * @param $type
     * @return array
     * @method get
     * /api/v1/messages/view-dialogs-by-type/$type
     */
    public function actionViewDialogsByType($type)
    {
        return [
            'status' =>'success',
            'dialogs' => [],
            'type' => $type,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }
    /**
     * View dialog by $dialog_id
     * @param $dialog_id
     * @return array
     * @method get
     * /api/v1/messages/view-dialog/$dialog_id
     */
    public function actionViewDialog($dialog_id)
    {

        $userId = Yii::$app->user->identity->getId();
        $this->breadcrumbs->addCrumb("My profile", '/user/account/profile');
        $this->breadcrumbs->addCrumb("My messages");

        if($dialog = Dialog::find()->match("(a:Account{user_id:$userId})-[:has_dialog]->(d:Dialog) WHERE ID(d) = $dialog_id")
            ->get("d, ID(d) as id")
            ->one()){

            $dialog->messages = $dialog->getMessages();

            foreach ($dialog->messages as $key => $message){
                $message->author = $message->getAuthor();
                $dialog->messages[$key] = $message->asArray();
            }

            return [
                'status' =>'success',
                'dialog' => $dialog->asArray(),
                'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' => 'fail',
                'error' => 'Dialog not found',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

    }

    /**
     * Add new message
     * @method post
     * /api/v1/messages
     * Fields:
     * MessageRest[title]
     * MessageRest[text]
     * MessageRest[images][] - in base64
     * MessageRest[videos][]
     * MessageRest[files][] - in base64
     * MessageRest[receiver_id] - id of user, to which was sent message
     */
    public function actionCreate()
    {

        $message = new MessageRest();
        $message->author_id = Yii::$app->user->identity->getId();


        if ($message->load(Yii::$app->request->post()) && $savedMessage = $message->insert()) {


            return [
                'status' =>'success',
                'message' => $savedMessage->asArray(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return ['status' => 'fail', 'access_token' => Yii::$app->user->identity->getAuthKey()];


    }

    /**
     * Delete dialog by dialog_id
     *
     * @return array
     * @method DELETE
     * /api/v1/messages/delete-dialog
     * Fields:
     * dialog_id
     */
    public function actionDeleteDialog()
    {
        $dialogId = Yii::$app->getRequest()->getBodyParam('dialog_id');

        if(Dialog::deleteOne($dialogId)){
            return [
                'status' =>'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' =>'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

    }

    /**
     * Delete all user's dialogs
     * @return array
     * @method DELETE
     *  /api/v1/messages/delete-all-dialogs
     *
     */
    public function actionDeleteAllDialogs()
    {
        $userId = Yii::$app->user->identity->getId();

        if(Dialog::deleteAll($userId))
        {
            return [
                'status' =>'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {

            return [
                'status' =>'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }



    }

    /**
     * Delete messages by id
     * @return array
     * @method DELETE
     * /api/v1/messages/delete-messages
     * @param id[]: array of message's id
     *
     *
     */
    public function actionDeleteMessages()
    {
        $messagesId = Yii::$app->getRequest()->getBodyParam('id');

        if(Message::removeByIds($messagesId)){
            return [
                'status' => 'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' => 'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

    }

    /**
     * Update message by id
     * @param $id
     * @return array
     * @method patch
     * /api/v1/messages/$id
     */
    public function actionUpdate($id)
    {
        return [
            'status' =>'success',
            'message' => [],
            'id' => $id,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**Get count of user's messages
     * @return array
     * @method get
     * /api/v1/messages/count
     */
    public function actionCount()
    {
        $userId = Yii::$app->user->identity->getId();

        return [
            'status' =>'success',
            'count' => null,
            'userId' => $userId,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Mark message as spam
     * @return array
     * @method put
     * /api/v1/messages/spam
     * Fields:
     * message_id
     */

    public function actionSpam()
    {
        $userId = Yii::$app->user->identity->getId();

        return [
            'status' =>'success',
            'userId' => $userId,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Block user
     * @return array
     * @method PUT
     * @link /api/v1/messages/block
     * @param :
     * user_id - id of user that is blocked
     */
    public function actionBlock()
    {

        $blockedUserId = Yii::$app->getRequest()->getBodyParam('user_id');

        $userId = Yii::$app->user->identity->getId();

        if($userId !== $blockedUserId){

            if(Blacklist::add($userId, $blockedUserId)){
                return [
                    'status' =>'success',
                    'access_token' => Yii::$app->user->identity->getAuthKey()
                ];
            } else {
                return [
                    'status' =>'fail',
                    'access_token' => Yii::$app->user->identity->getAuthKey()
                ];
            }

        } else {
            return [
                'status' =>'fail',
                'error' => 'You cannot add to blacklist yourself',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }




    }

    /**
     * Unblock user
     * @return array
     * @method put
     * /api/v1/messages/unblock
     * Fields:
     * user_id - id of user that is unblocked
     */
    public function actionUnblock()
    {
        return [
            'status' =>'success',
            'user_id' => Yii::$app->getRequest()->getBodyParams('user_id'),
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Mark message as readed
     * @return array
     * @method put
     * /api/v1/messages/readed
     * Fields:
     * message_id
     */
    public function actionReaded()
    {
        $messageId = Yii::$app->getRequest()->getBodyParam('message_id');
        $userId = Yii::$app->user->identity->getId();

        $model = new Message();

        if($message = $model->findById($messageId)){

            if($message->author_id !== $userId){
                $message->read();
            } else {
                return [
                    'status' =>'fail',
                    'error' => "You can't set status 'Read' for own message",
                    'access_token' => Yii::$app->user->identity->getAuthKey()
                ];

            }


            return [
                'status' =>'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' =>'fail',
                'error' => "The message does't exist",
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }


    }

    /**
     * Clear message's history between message's owner and user
     *
     * @return array
     * @method DELETE
     * /api/v1/messages/clear-history
     * Fields:
     * dialog_id
     */

    public function actionClearHistory()
    {

        $dialogId = Yii::$app->getRequest()->getBodyParam('dialog_id');

        if(Message::deleteAll($dialogId) && Dialog::deleteOne($dialogId)){
            return [
                'status' =>'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {

            return [
                'status' =>'fail',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

    }

    public function actionJoinUser()
    {
        $userId = Yii::$app->getRequest()->getBodyParam('user_id');
        $dialogId = Yii::$app->getRequest()->getBodyParam('dialog_id');

       $modelAccount = new Account();
       $modelDialog = new Dialog();
       $account = $modelAccount->findByUserId($userId);
       $dialog = $modelDialog->findById($dialogId);


       var_dump($dialog->copyTo($userId));
       exit;


    }



    /**
     * Get all users, who in blacklist
     * @return array
     * @method get
     * /api/v1/messages/blacklist
     */
    public function actionBlacklist()
    {
        return [
            'status' =>'success',
            'accounts' => [],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Filtering messages by $_GET query
     * @return array
     * @method get
     * /api/v1/messages/search?query=xxx
     */

    public function actionSearch()
    {
        if(!empty($_GET)){
            $query = $_GET;

            return [
                'status' => 'success',
                'query' => $query,
                'messages' => [],
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'query' => null,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }



}