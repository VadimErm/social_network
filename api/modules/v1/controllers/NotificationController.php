<?php


namespace api\modules\v1\controllers;

use api\filters\auth\HttpBearerAuth;

use common\models\Notification;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\Response;

class NotificationController extends Controller
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
                    'actions' => ['create', 'read'],
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

                'create'    => ['post'],
                'read'      => ['put']


            ],
        ];

        return $behaviors;
    }

    /**
     * Create notification
     * @return array
     * @method POST
     * @path /api/v1/notifications
     * @param Notification[id_object] - id of object where notification triggered
     * @param Notification[user_id] - id of user for whom was sent notification
     * @param Notification[event_type] - type of event
     * @param Notification[object_type] - type of object where notification triggered
     */
    public function actionCreate()
    {
        $notification = new Notification();

        if($notification->load(Yii::$app->request->post()) && $savedNotification = $notification->insert()){
            return [
                'status' => 'success',
                'notification' => $savedNotification->asArray(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' => 'fail',
                'errors' => $notification->getErrors(),
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }



    }

    /**
     * Set notification as readed
     * @return array
     * @method PUT
     * @path /api/v1/notifications/read
     * @param id - id of notification
     */
    public function actionRead()
    {
        $id = Yii::$app->getRequest()->getBodyParam('id');


        if(Notification::read($id)){
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

}