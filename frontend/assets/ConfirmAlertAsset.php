<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ConfirmAlertAsset extends AssetBundle
{
    public $js = [
        '/js/confirm.alert.js'
    ];

    public $depends = [
        'frontend\assets\SocialAsset'
    ];
}