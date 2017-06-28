<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class Angular2Asset extends AssetBundle
{
    public $sourcePath = '@frontend/angular2/dist';
    public $baseUrl = '@web';

    public $js = [
        'inline.bundle.js',
        'styles.bundle.js',
        'main.bundle.js'
    ];

    public $publishOptions = [
        'forceCopy'=> true,
    ];
}