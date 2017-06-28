<?php
/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

\backend\assets\CustomAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->language ?>">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="<?= Yii::$app->language ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="nav-md">
    <?php $this->beginBody() ?>
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?= Yii::$app->getHomeUrl() ?>" class="site_title"><i class="fa fa-car"></i> <span>Arba club</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="/admin/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>Ivan</h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br/>

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section active">
                            <h3>
                                <span class="label">Administrator</span>
                            </h3>
                            <ul class="nav side-menu">
                                <li class="active"><a><i class="fa fa-home"></i> Home <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= Url::to(['user/index']) ?>">Users</a></li>
                                        <li><a href="<?= Url::to(['community/index']) ?>">Communities</a></li>
                                        <li><a href="<?= Url::to(['complaint/index']) ?>">Complaints</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-bar-chart"></i> Statistic <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= Url::to(['user/count']) ?>">Users count</a></li>
                                        <li><a href="<?= Url::to(['user/activity']) ?>">Users activity</a></li>
                                        <li><a href="<?= Url::to(['user/business-activity']) ?>">Users business activity</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-car"></i> Cars <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= Url::to(['car/add']) ?>">Add</a></li>
                                        <li><a href="<?= Url::to(['car/all']) ?>">All</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-book"></i> Journal categories <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= Url::to(['journal-cat/add']) ?>">Add</a></li>
                                        <li><a href="<?= Url::to(['car/all']) ?>">All</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-map-marker"></i> Locations <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?= Url::to(['location/add']) ?>">Add</a></li>
                                        <li><a href="<?= Url::to(['location/all']) ?>">All</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <img src="/admin/images/img.jpg" alt="">Ivan
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                        <a href="javascript:;">
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li><a href="<?= \yii\helpers\Url::to(['site/logout']) ?>"><i
                                                class="fa fa-sign-out pull-right"></i> Logout </a></li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image">
                                                <img src="/admin/images/img.jpg" alt="Profile Image"/>
                                            </span>
                                            <span><span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                        </span>
                                            <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <?= $content ?>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    Arba club &copy; 2016
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>