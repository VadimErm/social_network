<?php

namespace common\modules\blog;

use yii\base\Module;

class Blog extends Module
{
    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}