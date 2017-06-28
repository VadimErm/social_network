<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SocialAsset extends AssetBundle
{
    public $css = [
        '/css/fonts.css',
        '/css/icons.css',
        '/css/materialize.min.css',
        '/css/jquery.bxslider.css',
        '/css/owl.carousel.css',
        '/css/style.css',
        '/css/custom.css',
        '/css/magnific-popup.min.css',
        '/css/cropper.css',
        'https://fonts.googleapis.com/icon?family=Material+Icons'

    ];

    public $js = [
        '/js/materialize.min.js',
        '/js/jquery.bxslider.min.js',
        '/js/owl.carousel.min.js',
        '/js/init.js',
        '/js/core-compiled.js',
        '/js/journal/journal-compiled.js',
        '/js/garage/car-compiled.js',
        '/js/garage/carForm-compiled.js',
        '/js/cropperjs/dist/cropper.js',
        '/js/progress-bar.js',
        '/js/album/album.js',
        '/js/profile/profile.js',
        '/js/bookmark/bookmark.js'

    ];

    public $depends = [
        'frontend\assets\HandlebarsAsset',
        'yii\web\YiiAsset'
    ];
}