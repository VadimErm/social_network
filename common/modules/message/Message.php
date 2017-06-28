<?php

namespace common\modules\message;

use yii\base\Module;

class Message extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}