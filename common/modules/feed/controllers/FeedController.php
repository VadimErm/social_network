<?php

namespace common\modules\feed\controllers;

use yii\web\Controller;

class FeedController extends Controller
{
    public function actionIndex()
    {
        return $this->render('newsfeed');
    }
}