<?php

namespace backend\assets;

use yii\web\AssetBundle;

class LoginCustomAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $css = [
        'css/animate.min.css',
        'css/custom.min.css'
    ];

    public $depends = [
        LoginAsset::class
    ];
}