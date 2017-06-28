<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 20.06.17
 * Time: 18:11
 */

namespace api\modules\v1\controllers;

use common\models\Blacklist;
use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class BlacklistController extends Controller
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
                    'actions' => [ 'delete', 'add'],
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


                'delete'   => ['delete'],

                'add'       => ['post']

            ],
        ];

        return $behaviors;
    }

    /**
     * Add node to user's blacklist
     * @return array
     * @param blocked_node - id of blocked node (if it's account, this must be id of account, not user_id)
     * @method POST
     * @link /api/v1/blacklists/add
     */
    public function actionAdd()
    {
        $userId = Yii::$app->user->identity->getId();

        $blockedNodeId = Yii::$app->request->post('blocked_node');


        if(Blacklist::add($userId, $blockedNodeId)){
            return [
                'status' => 'success',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        } else {
            return [
                'status' => 'fail',
                'error' => 'No such node',
                'access_token' => Yii::$app->user->identity->getAuthKey()
            ];
        }


    }

}