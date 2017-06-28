<?php

namespace frontend\bootstrap;

use yii\web\User;
use yii\base\BootstrapInterface;

class UserBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->user->on(User::EVENT_AFTER_LOGIN, ['common\models\User', 'afterLogin']);
        $app->user->on(User::EVENT_BEFORE_LOGOUT, ['common\models\User', 'beforeLogout']);
    }
}