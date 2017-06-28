<?php

namespace common\modules\promotion\controllers;

use yii\web\Controller;

class PromotionController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}