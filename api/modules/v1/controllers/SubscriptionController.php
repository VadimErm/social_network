<?php


namespace api\modules\v1\controllers;

use common\models\Subscription;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
//use yii\rest\Controller;
use yii\web\Response;

class SubscriptionController extends Controller
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
                    'actions' => ['index', 'view-by-type', 'subscribe', 'unsubscribe', 'search', 'count'],
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
                'view-by-type' => ['get'],
                'subscribe'    => ['put'],
                'unsubscribe' => ['put'],
                'search'    => ['get'],
                'count'     => ['get']


            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of user's subscriptions
     * @return array
     * /api/v1/subscriptions
     */
    public function actionIndex()
    {
        $this->breadcrumbs->addCrumb("My profile", '/user/account/profile');
        $this->breadcrumbs->addCrumb("My subscriptions");

        $subscriptions = Subscription::getAll(true);


        return [
            'status' => 'success',
            'subscriptions' => $subscriptions,
            'breadcrumbs' => $this->breadcrumbs->getBreadcrumbs(),
            'access_token' => Yii::$app->user->identity->getAuthKey()

        ];

    }

    /**
     * Subscribe on blog/car journal/community depending on the $type
     * @param $type integer - type on what user subscribe
     * @param $id - id of blog/car journal/community
     * @return array
     * @method put
     * /api/v1/subscriptions/subscribe/$type/$id
     */
    public function actionSubscribe($type, $id)
    {

         if(Subscription::subscribe($type, $id)){
             return [
                 'status' =>'success',
                 'access_token' => Yii::$app->user->identity->getAuthKey()
             ];
         } else {
             return [
                 'status' =>'fail',
                 'error' => 'You are already subscribed',
                 'access_token' => Yii::$app->user->identity->getAuthKey()
             ];
         }




    }

    /**
     * Unsubscribe from blog/car journal/community
     * @param $id - id of blog/car journal/community
     * @return array
     * @method put
     * /api/v1/subscriptions/unsubscribe/$id
     */
    public function actionUnsubscribe($id)
    {

        if(Subscription::unsubscribe($id)){
            $status = 'success';
        } else {
            $status = 'fail';
        }

        return [
            'status' =>$status,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Search subscriptions  by $_GET query
     * @return array
     * @method get
     * /api/v1/subscriptions/search?query=xxx
     */
    public function actionSearch()
    {
        if(!empty($_GET)){
            $query = $_GET;

            return [
                'status' =>'success',
                'query' => $query,
                'subscriptions' => [],
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'query' => null,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

    /**
     * Get subscription count
     * @return array
     * @method GET
     * /api/v1/subscriptions/count
     */
    public function actionCount()
    {
        if($count = Subscription::getCount()){
            return [
                'status' =>'success',
                'subscription_count' => $count,
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }

        return [
            'status' => 'success',
            'subscription_count' => 0,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

}