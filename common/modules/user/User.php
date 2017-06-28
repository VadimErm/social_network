<?php

namespace common\modules\user;

use yii\base\Module;

class User extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}