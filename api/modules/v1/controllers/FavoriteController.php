<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 07.06.17
 * Time: 17:00
 */

namespace api\modules\v1\controllers;


use api\filters\auth\HttpBearerAuth;
use common\models\Account;
use common\models\Car;
use common\models\Favorite;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\Response;
use yii\rest\Controller;

class FavoriteController extends Controller
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
                        'add',


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

                'add'         => ['put'],



            ],
        ];

        return $behaviors;
    }

    /**
     * Add node to favorites
     * @return array
     * @method PUT
     * /api/v1/favorites/add
     * @fields:
     * id - node id
     */
    public function actionAdd()
    {
        $nodeId = Yii::$app->getRequest()->getBodyParam('id');
        $userId = Yii::$app->user->identity->getId();
        $modelAccount = new Account();
        $account = $modelAccount->findByUserId($userId);
        $modelCar = new Car();
        $car = $modelCar->findById($nodeId);


        if($nodeId == $account->id){
            return [
                'status' => 'fail',
                'error' => 'You cannot add yourself to favorites',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),
            ];
        } elseif (!is_null($car) && $car->getAccount()->id == $account->id) {
            return [
                'status' => 'fail',
                'error' => 'You cannot add your car to favorites',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),
            ];
        }



        if(Favorite::add($nodeId)){
            return [
                'status' => 'success',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),

            ];
        } else {
            return [
                'status' => 'fail',
                'access_token' =>\Yii::$app->user->identity->getAuthKey(),
            ];
        }

    }


}