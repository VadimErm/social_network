<?php

namespace common\modules\account\controllers;

use yii\web\Controller;

class AccountController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}