<?php


namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class TopCarController extends Controller
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
                    'actions' => ['index'],
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

            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of top cars filtering cars by country, city, car's brand, show on page.
     * Example /api/v1/top-cars?country=USA&city=Dubai&brand=Mercedes&skip=50&limit=25
     * @return array
     * @method get
     * /api/v1/top-cars?country=xxx&city=xxx&brand=xxx&skip=xxx&limit=xxx
     */
    public function actionIndex()
    {
        return [
            'status' =>'success',
            'query' => $_GET,
            'cars' => [],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }



}