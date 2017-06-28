<?php

namespace api\controllers;

use yii\rest\Controller;

class CityController extends Controller
{
    public function actionAll()
    {
        return [
            [
                'top_car' => true,
                'url' => '#',
                'title' => 'Dubai',
                'users' => '167 688',
                'src' => '/images/city1.jpg'
            ],
            [
                'url' => '#',
                'title' => 'Dubai',
                'users' => '167 688',
                'src' => '/images/city2.jpg'
            ],
            [
                'url' => '#',
                'title' => 'Dubai',
                'users' => '167 688',
                'src' => '/images/city3.jpg'
            ],
            [
                'url' => '#',
                'title' => 'Dubai',
                'users' => '167 688',
                'src' => '/images/city4.jpg'
            ],
            [
                'url' => '#',
                'title' => 'Dubai',
                'users' => '167 688',
                'src' => '/images/city5.jpg'
            ]
        ];
    }
}