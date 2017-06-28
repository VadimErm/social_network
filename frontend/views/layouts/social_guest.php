<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Html;
use \frontend\assets\SocialAsset;
use \common\widgets\menu\Menu;
use yii\helpers\Url;

?>

<?php SocialAsset::register($this) ?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <!-- Favicons -->
        <link rel="shortcut icon" href="/images/favicon.ico">
        <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">

        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <!-- Header -->
    <div class="nav-wrap">
        <nav class="z-depth-0">
            <div class="nav-wrapper container">
                <div class="row">
                    <div class="col s2 m4 l3">
                        <!-- Logo wrap -->
                        <a id="logo" href="<?= Yii::$app->getHomeUrl() ?>">
                            Arba<span>.ae</span>
                        </a>
                        <!-- /Logo wrap -->
                    </div>


                    <!-- Top icons -->
                    <div class="col s10 m8 l9 pos-rel">
                        <ul class="top-list clearfix">
                            <li><div id="top-search"><span class="ico-magnifier"></span></div></li>
                            <li>
                                <a href="<?= Url::to(['site/login']) ?>">Login</a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['site/singup']) ?>">Register</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /Top icons -->
                </div>
            </div>
        </nav>
    </div>

    <!-- /Header -->

    <!-- Slider -->
    <div class="section main-slider">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="slider">
                        <ul class="slides">
                            <li>
                                <div class="caption-outer">
                                    <div class="caption-inner center">
                                        <h1>Lorem Ipsum Dolor sit amet</h1>
                                        <p>Nulla eu lectus nec magna porttitor varius sit amet eu neque.</p>
                                        <a class="btn-large waves-effect" href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">register now!</a>
                                    </div>
                                </div>
                                <img src="/images/slide1.jpg" alt="slide">
                            </li>
                            <li>
                                <div class="caption-outer">
                                    <div class="caption-inner center">
                                        <h1>Lorem Ipsum Dolor sit amet</h1>
                                        <p>Nulla eu lectus nec magna porttitor varius sit amet eu neque.</p>
                                        <a class="btn-large waves-effect" href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">register now!</a>
                                    </div>
                                </div>
                                <img src="/images/slide2.jpg" alt="slide">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Slider -->

    <!-- /Main menu block -->
    <div class="main-menu">
        <div class="container">
            <div class="row">
                <div class="col s6 m6 l2">
                    <img src="/images/logo.png" alt="logo">
                </div>
                <div class="col s6 m6 l10 right-align">
                    <?= Menu::widget([
                        'ulClass' => 'top-list clearfix hide-on-med-and-down',
                        'items' => [
                            ['label' => 'Top cars', 'url' => '#'],
                            ['label' => 'Car’s journals', 'url' => '#'],
                            ['label' => 'User’s blogs', 'url' => '#'],
                            ['label' => 'Communities', 'url' => '#'],
                            ['label' => 'Achievements', 'url' => '#'],
                            ['label' => 'Companies', 'url' => '#'],
                            ['label' => 'Promo', 'url' => '#'],
                            ['label' => 'News', 'url' => '#'],
                        ]
                    ]) ?>
                    <a href="#" data-activates="slide-out2" class="menu-btn hide-on-large-only"><span
                            class="ico-bars"></span></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu navigation -->
    <div id="slide-out2" class="side-nav">
        <div class="user-nav-menu">
            <?= Menu::widget([
                'items' => [
                    ['label' => 'Top cars', 'url' => '#'],
                    ['label' => 'Car\’s journals', 'url' => '#'],
                    ['label' => 'User’s blogs', 'url' => '#'],
                    ['label' => 'Communities', 'url' => '#'],
                    ['label' => 'Achievements', 'url' => '#'],
                    ['label' => 'Companies', 'url' => '#'],
                    ['label' => 'Promo', 'url' => '#'],
                    ['label' => 'News', 'url' => '#'],
                ]
            ]) ?>
        </div>
    </div>
    <!-- /Menu navigation -->
    <!-- /Main menu block -->

    <!-- City block -->
    <div class="section city gray-section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h5>Select city</h5>
                </div>
            </div>
            <div class="row">
                <div id="city-wrap">
                    <?= \common\widgets\city\City::widget([
                        'items' => [
                            [
                                'of_day' => true,
                                'url' => '#',
                                'title' => 'Dubai',
                                'users' => '167 688',
                                'src' => '/images/city1.jpg'
                            ],
                            [
                                'url' => '#',
                                'title' => 'Dubai',
                                'users' => '167 688',
                                'src' => '/images/city2.jpg'
                            ],
                            [
                                'url' => '#',
                                'title' => 'Dubai',
                                'users' => '167 688',
                                'src' => '/images/city3.jpg'
                            ],
                            [
                                'url' => '#',
                                'title' => 'Dubai',
                                'users' => '167 688',
                                'src' => '/images/city4.jpg'
                            ],
                            [
                                'url' => '#',
                                'title' => 'Dubai',
                                'users' => '167 688',
                                'src' => '/images/city5.jpg'
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /City block -->

    <!-- Car's journals block -->
    <div class="section journals">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="heading center">
                        <h4>Car’s journals</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?= \common\modules\garage\widgets\journals\Journals::widget([
                    'items' => [
                        [
                            'url' => '#',
                            'src' => '/images/journal1.jpg',
                            'title' => '',
                            'cat' => '',
                            'description' => '',
                            'views' => '',
                            'rating' => '',
                            'likes' => ''
                        ]
                    ]
                ]) ?>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a class="btn-large waves-effect" href="#">see all</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Car's journals block -->

    <!-- User's blogs-->
    <div class="section gray-section blogs">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="heading center">
                        <h4>User’s blogs</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?= \common\modules\blog\widgets\blogs\Blogs::widget([
                    'items' => [
                        [
                            'user_url' => '#',
                            'src' => '/images/blog1.jpg',
                            'url' => '#',
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                            'avatar' => '/images/u-avatar1.jpg',
                            'username' => 'Aahil Asad'
                        ]
                    ]
                ]) ?>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a class="btn-large btn-liner waves-effect" href="#">see all</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /User's blogs-->

    <!-- Communities block-->
    <div class="section communities">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="heading center">
                        <h4>Communities</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?= \common\modules\community\widgets\communities\Communities::widget([
                    'items' => [
                        [
                            'avatar' => '/images/community-ava1.jpg',
                            'src' => '/images/community1.jpg',
                            'url' => '#',
                            'title' => 'BMW Lovers Club',
                            'members' => '19889'
                        ]
                    ]
                ]) ?>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a class="btn-large waves-effect" href="#">see all</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Communities block-->

    <!-- Companies block-->
    <div class="section companies gray-section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="heading center">
                        <h4>Companies</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?= \common\modules\company\widgets\companies\Companies::widget([
                    'items' => [
                        [
                            'src' => '/images/company1.jpg',
                            'rating' => '544',
                            'title' => 'Mercedes-Benz Service',
                            'url' => '#',
                            'address' => 'Financial Centre Road,Downtown Dubai',
                            'email' => 'mercedes@uae.ae',
                            'phone' => '+971 800 382246255',
                            'website' => 'www.mercedes.ae',
                            'brands' => ['b1', 'b2', 'b3', 'b4', 'b5', 'b6'],
                            'services' => [
                                'Painting',
                                'Oil changes',
                                'Car engine repair',
                                'Body car service'
                            ]
                        ]
                    ]
                ]) ?>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a class="btn-large btn-liner waves-effect" href="#">see all</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Companies block-->

    <!-- Promo block-->
    <div class="section promo">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <div class="heading center">
                        <h4>Promo</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?= \common\modules\promotion\widgets\promo\Promo::widget([
                    'items' => [
                        [
                            'src' => '/images/promo1.jpg',
                            'url' => '#',
                            'rating' => '544',
                            'title' => '50% Discount on car repair',
                            'location' => 'Dubai',
                            'date' => '01.11.2016-01.12.2016',
                            'service' => 'Oil changes',
                            'brands' => ['b1', 'b2', 'b3', 'b4', 'b5'],
                            'likes' => '144',
                            'uploads' => '144'
                        ]
                    ]
                ]) ?>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a class="btn-large waves-effect" href="#">see all</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Promo block-->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l5">
                    <div class="footer-about">
                        <img src="/images/logo.png" alt="logo">
                        <p>Nulla eu lectus nec magna porttitor varius sit amet eu neque. In pellentesque malesuada
                            venenatis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed molestie,
                            tellus varius volutpat venenatis, leo ipsum aliquet libero, id egestas ipsum lectus in
                            elit.</p>
                    </div>
                </div>
                <div class="col s12 m6 l4">
                    <div class="row">
                        <div class="col s12">
                            <h6>Menu</h6>
                        </div>
                        <?= \common\widgets\footer_menu\FooterMenu::widget([
                            'items' => [
                                'column1' => [
                                    ['url' => '#', 'title' => 'Top cars'],
                                    ['url' => '#', 'title' => 'Car’s journals'],
                                    ['url' => '#', 'title' => 'User’s blogs'],
                                    ['url' => '#', 'title' => 'Communities']
                                ],
                                'column2' => [
                                    ['url' => '#', 'title' => 'Achievements'],
                                    ['url' => '#', 'title' => 'Companies'],
                                    ['url' => '#', 'title' => 'Promo'],
                                    ['url' => '#', 'title' => 'News'],
                                ]
                            ]
                        ]) ?>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="row">
                        <div class="col s12">
                            <h6>Instagram</h6>
                        </div>
                    </div>
                    <div class="row">
                        <?= \common\widgets\instagram\Instagram::widget([
                            'items' => [
                                ['url' => '#', 'src' => '/images/in-photo.jpg'],
                                ['url' => '#', 'src' => '/images/in-photo2.jpg'],
                                ['url' => '#', 'src' => '/images/in-photo3.jpg'],
                                ['url' => '#', 'src' => '/images/in-photo4.jpg'],
                                ['url' => '#', 'src' => '/images/in-photo5.jpg'],
                                ['url' => '#', 'src' => '/images/in-photo6.jpg'],
                            ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy">
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="copy-text">
                            &copy; 2017. All rights reserved. <a href="#">Arba.ae</a>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="social">
                            <a href="#"><span class="ico-facebook"></span></a>
                            <a href="#"><span class="ico-twitter"></span></a>
                            <a href="#"><span class="ico-youtube"></span></a>
                            <a href="#"><span class="ico-instagram"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- /Footer -->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>