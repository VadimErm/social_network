<?php

namespace api\controllers;

use yii\rest\Controller;

class PromoController extends Controller
{
    public function actionCars()
    {
        return [
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
        ];
    }
}