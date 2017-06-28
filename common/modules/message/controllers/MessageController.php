<?php

namespace common\modules\message\controllers;

use yii\web\Controller;

class MessageController extends Controller
{
    public function actionIndex()
    {
        return $this->render('my_messages');
    }

    public function actionDialog()
    {
        return $this->render('dialog');
    }
}