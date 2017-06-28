<?php

namespace common\modules\achievements;

use Yii;

/**
 * achivment module definition class
 */
class Achievements extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::configure($this, require(__DIR__ . '/config/main.php'));
    }
}
