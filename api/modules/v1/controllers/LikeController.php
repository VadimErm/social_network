<?php


namespace api\modules\v1\controllers;


use api\filters\auth\HttpBearerAuth;
use common\models\Like;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\web\Response;

class LikeController extends Controller
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
                    'actions' => ['create'],
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


            ],
        ];

        return $behaviors;
    }

    /**
     * Add like to node
     * @return array
     * @method POST
     * @path /api/v1/likes
     * @fields:
     * id - id of node, like a car or something else
     */
    public function actionCreate()
    {
       $nodeId =  Yii::$app->request->post('id');

       if(Like::add($nodeId)){
            return [
               'status' => 'success',
               'access_token' =>\Yii::$app->user->identity->getAuthKey(),

           ];
       } else {
           return [
               'status' => 'fail',
               'error' => 'Like created already',
               'access_token' =>\Yii::$app->user->identity->getAuthKey(),
           ];
       }


    }

}