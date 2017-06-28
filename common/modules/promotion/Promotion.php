<?php

namespace common\modules\promotion;

use yii\base\Module;

class Promotion extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}