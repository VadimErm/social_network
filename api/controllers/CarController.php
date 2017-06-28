<?php

namespace api\controllers;

use yii\rest\Controller;

class CarController extends Controller
{
    public function actionTop()
    {
        return [
            'top' => [
                'title' => 'Mercedes C200 AMG',
                'rating' => 540,
                'date' => '27.10.2016',
                'location' => 'Dubai',
                'img_src' => '/images/candidat1.jpg',
                'url' => '#'
            ],
            'candidates' => [
                [
                    'title' => 'Mercedes C200 AMG',
                    'rating' => 540,
                    'date' => '27.10.2016',
                    'location' => 'Dubai',
                    'img_src' => '/images/candidat1.jpg',
                    'url' => '/images/candidat1.jpg'
                ],
                [
                    'title' => 'Mercedes C200 AMG',
                    'rating' => 540,
                    'date' => '27.10.2016',
                    'location' => 'Dubai',
                    'img_src' => '/images/candidat1.jpg',
                    'url' => '/images/candidat1.jpg'
                ],
                [
                    'title' => 'Mercedes C200 AMG',
                    'rating' => 540,
                    'date' => '27.10.2016',
                    'location' => 'Dubai',
                    'img_src' => '/images/candidat1.jpg',
                    'url' => '/images/candidat1.jpg'
                ],
                [
                    'title' => 'Mercedes C200 AMG',
                    'rating' => 540,
                    'date' => '27.10.2016',
                    'location' => 'Dubai',
                    'img_src' => '/images/candidat1.jpg',
                    'url' => '/images/candidat1.jpg'
                ]
            ]
        ];
    }
}