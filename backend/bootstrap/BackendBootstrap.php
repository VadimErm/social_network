<?php

namespace backend\bootstrap;
use yii\base\BootstrapInterface;
use yii\web\User;

class BackendBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
//        $app->user->on(User::EVENT_AFTER_LOGIN, ['common\models\User', 'afterLogin']);
//        $app->user->on(User::EVENT_BEFORE_LOGOUT, ['common\models\User', 'beforeLogout']);
    }
}