<?php


namespace api\modules\v1\controllers;

use common\models\Account;
use common\models\Follower;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class FollowerController extends Controller
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
                    'actions' => [
                        'index',
                        'follow',
                        'unfollow',
                        'search',
                        'follow-car',
                        'unfollow-car',

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

                'index'         => ['get'],
                'follow'        => ['put'],
                'unfollow'      => ['put'],
                'follow-car'    => ['put'],
                'unfollow-car'  => ['put'],
                'search'        => ['get']


            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of followers
     * @return array
     * @method get
     * /api/v1/followers
     */
    public function actionIndex()
    {
        $followers =  Follower::getAll(true);
        $count = Follower::getCount();

        return [
            'status' => 'success',
            'followers' => $followers,
            'count' => $count,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Follow up another user
     * @return array
     * @method put
     * /api/v1/followers/follow
     * Fields:
     * id - id of node that current user follow up
     */
    public function actionFollow()
    {
        $nodeId =  Yii::$app->getRequest()->getBodyParam('id');

        if(Follower::follow($nodeId)){
            return [
                'status' => 'success',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),

            ];
        } else {
            return [
                'status' => 'fail',
                'error' => 'You followed alredy',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),
            ];
        }



    }

    /**
     * Unfollow up another user
     * @return array
     * @method put
     * /api/v1/followers/unfollow
     * Fields:
     * id - id of node that current user unfollow up
     */
    public function actionUnfollow()
    {

        $nodeId = Yii::$app->getRequest()->getBodyParam('id');

        if(Follower::unfollow($nodeId)){
            return [
                'status' => 'success',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),

            ];
        } else {
            return [
                'status' => 'fail',
                'error' => 'You unfollowed alredy',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),
            ];
        }

    }

    /**
     * View users that i follow
     * @return array
     * @method get
     * /api/v1/followers/i-follow
     */
    public function actionIFollow()
    {
        return [
            'status' =>'success',
            'i_follow' => [],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];
    }

    /**
     * Search by first_name and last_name
     * @param $query string
     * @return array
     * @method GET
     * /api/v1/followers/search/<query>
     */
    public function actionSearch($query)
    {

        $accounts = Account::search($query, true);

        return [
            'status' =>'success',
            'accounts' => $accounts,
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];


    }



}