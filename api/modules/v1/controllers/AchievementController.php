<?php


namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use api\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\Response;

class AchievementController extends Controller
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
                    'actions' => ['index', ],
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

            ],
        ];

        return $behaviors;
    }

    /**
     * Get list of entities such as Car of the day, Most popular blogs and others, exp: /api/v1/achievements?type=1
     * @return array
     * @method get
     * /api/v1/achievements?type=xxx
     */
    public function actionIndex()
    {
        return [
            'status' =>'success',

            'entities' => [],
            'access_token' => Yii::$app->user->identity->getAuthKey()
        ];

    }

}