<?php


namespace api\modules\v1\controllers;

use Yii;
use yii\filters\AccessControl;
use api\filters\auth\HttpBearerAuth;
use yii\filters\auth\CompositeAuth;
use yii\rest\Controller;
use yii\web\Response;

class SecurityController extends Controller
{
    public function behaviors()
    {
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [

                [
                    'allow' => true,
                    'actions' =>
                        [
                            'get-csrf-token',

                        ],
                    'roles' => ['@', '?'],
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

                'get-csrf-token'    => ['get'],




            ],
        ];

        return $behaviors;
    }

    public function actionGetCsrfToken()
    {
        $request = Yii::$app->getRequest();
        $csrf = $request->getCsrfToken();

        return $csrf;
    }

}