<?php

namespace common\modules\feed;

use yii\base\Module;

class Feed extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}