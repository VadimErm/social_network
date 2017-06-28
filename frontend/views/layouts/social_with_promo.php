<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Html;
use \frontend\assets\SocialAsset;
use \common\widgets\menu\Menu;
use \common\modules\garage\widgets\carofday\CarOfDay;
use yii\helpers\Url;
use \frontend\assets\Angular2Asset;

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
                    <?php if (!$isGuest = Yii::$app->user->isGuest) : ?>
                        <div class="col s10 m8 l9 pos-rel">
                            <ul class="top-list clearfix">
                                <li>
                                    <div id="top-search"><span class="ico-magnifier"></span></div>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['site/login']) ?>">Login</a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['site/signup']) ?>">Register</a>
                                </li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <div class="col s10 m8 l9 pos-rel">
                            <ul class="top-list clearfix">
                                <li>
                                    <div id="top-search"><span class="ico-magnifier"></span></div>
                                </li>
                                <li class="hide-on-small-only">
                                    <div class="top-user-profile">
                                        <div class="top-avatar round">
                                            <img src="/images/user.png" alt="profile avatar">
                                        </div>
                                        <p>Hi, <a href="#" data-activates="slide-out" class="profile-name">Aahil</a>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="pos-rel notify">
                                        <span class="ico-new-email-interface-symbol-of-closed-envelope-back"></span>
                                        <div class="notify-badge">10</div>
                                    </a>
                                    <a href="#" class="pos-rel notify">
                                        <span class="ico-bell-alarm-symbol"></span>
                                        <div class="notify-badge">10</div>
                                    </a>
                                    <a href="#" data-activates="slide-out" class="profile-btn"><span
                                            class="ico-bars"></span></a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <!-- /Top icons -->
                </div>
            </div>
        </nav>
    </div>

    <!-- User navigation -->
    <?php if ($isGuest) : ?>
        <div id="slide-out" class="side-nav">
            <div class="nav-user-top center">
                <div class="nav-user-avatar round">
                    <img src="/images/user.png" alt="profile avatar">
                </div>
                <ul class="top-user-info">
                    <li><span class="ico-maps-placeholder-outlined-tool"></span>Dubai</li>
                    <li><img src="/images/arba2.png" alt="rating">777</li>
                </ul>
            </div>
            <div class="user-nav-menu">
                <ul>
                    <li><a href="#">My news feed</a></li>
                    <li><a href="#">User profile</a></li>
                    <li><a href="#">Messages</a>
                        <div class="user-badge">1</div>
                    </li>
                    <li><a href="#">Journals</a>
                        <div class="user-badge">1</div>
                        <div class="user-badge"><span class="ico-heart-outline"></span>23</div>
                    </li>
                    <li><a href="#">Photos</a>
                        <div class="user-badge">1</div>
                        <div class="user-badge"><span class="ico-heart-outline"></span>23</div>
                    </li>
                    <li><a href="#">Achievements</a>
                        <div class="user-badge">1</div>
                        <div class="user-badge"><span class="ico-heart-outline"></span>23</div>
                    </li>
                    <li><a href="#">Subscriptions</a>
                        <div class="user-badge">1</div>
                    </li>
                    <li><a href="#">Bookmarks</a>
                        <div class="user-badge">1</div>
                    </li>
                    <li><a href="#">Notifications</a>
                        <div class="user-badge">1</div>
                    </li>
                    <li><a href="<?= Url::to(['site/logout']) ?>">Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- /User navigation -->
    <?php endif; ?>
    <!-- /Header -->

    <!-- Promo cars block -->
    <div class="section promo-cars gray-section">
        <div class="container">
            <div class="row">
                <div id="promo-cars-carousel">
                    <?= \common\modules\promotion\widgets\promotion\PromotionWidget::widget([
                        'items' => [
                            [
                                'title' => 'Muscle car',
                                'description' => 'Aenean porta ipsum eget tortor tincidunt',
                                'url' => '#',
                                'src' => '/images/promo-car2.jpg'
                            ],
                            [
                                'title' => 'Muscle car',
                                'description' => 'Aenean porta ipsum eget tortor tincidunt',
                                'url' => '#',
                                'src' => '/images/promo-car2.jpg'
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <a class="btn-large btn-liner waves-effect" href="#">promote your car</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Promo cars block -->
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
    <!-- /Main menu block -->
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="col s12">
                <ul class="clearfix">
                    <li class="active">My page</li>
                    <li>&rarr;</li>
                    <li><a href="index.html">main</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Breadcrumbs -->
    <?= $content ?>
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
            <div class="container">s
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