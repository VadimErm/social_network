<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $js =[
            'moment/moment.js'
    ];



}