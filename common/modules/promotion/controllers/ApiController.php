<?php

namespace common\modules\promotion\controllers;

use yii\filters\Cors;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                ]
            ]
        ];
    }

    public function actionMain()
    {
        return json_encode([
            [
                'title' => 'Muscle car',
                'description' => 'Aenean porta ipsum eget tortor tincidunt',
                'url' => '#',
                'src' => '/images/promo-car2.jpg'
            ],
            [
                'title' => 'Muscle car',
                'description' => 'Aenean porta ipsum eget tortor tincidunt',
                'url' => '#',
                'src' => '/images/promo-car2.jpg'
            ]
        ]);
    }
}