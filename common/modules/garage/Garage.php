<?php

namespace common\modules\garage;

use yii\base\Module;

class Garage extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}