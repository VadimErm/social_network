<?php

namespace common\modules\account;

use yii\base\Module;

class Account extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}