<?php

namespace backend\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@bower';
    public $css = [
        'bootstrap/dist/css/bootstrap.min.css',
        'font-awesome/css/font-awesome.min.css',

    ];
}