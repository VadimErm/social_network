<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 03.06.17
 * Time: 16:33
 */

namespace common\modules\user\controllers;

use yii\web\Controller;

class SubscriptionsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('my-subscriptions');
    }

}