<?php

namespace common\modules\community;

use yii\base\Module;

class Community extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}