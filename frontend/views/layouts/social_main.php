<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Html;
use \frontend\assets\SocialAsset;
use yii\helpers\Url;
use \frontend\assets\ConfirmAlertAsset;

if (!Yii::$app->user->isGuest &&
    Yii::$app->user->identity->status == \common\models\User::STATUS_DELETED) {
    ConfirmAlertAsset::register($this);
}
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
        <?php if (!Yii::$app->user->isGuest) : ?>
            <meta name="access-token" content="<?= Yii::$app->user->identity->access_token ?>">
        <?php endif; ?>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <!-- Favicons -->
        <link rel="shortcut icon" href="/images/favicon.ico">
        <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
        <style>
            .garage-car-wrap:hover {
                cursor: pointer;
            }
        </style>

        <?php $this->head() ?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-94012702-1', 'auto');
            ga('send', 'pageview');

        </script>
        
        <style type="text/css">
	    	/* PROFILE SHOW */
	    	#profile-header-menu, #non-profile-header-menu{
		    	transform: translateY(-100%) !important;
		    	transition: all .5s ease-in-out !important;
	    	}    
	    	#profile-header-menu.wake-up, #non-profile-header-menu.wake-up{
		    	transform: translateY(0%) !important;
		    	transition: all .5s ease-in-out !important;
	    	}  
        </style>
        
    </head>
    <body ng-app="arbaLiveApp">
    <?php $this->beginBody() ?>
    <!-- Header -->
    
    
	<div ng-controller="HomeCtrl">
		<ng-include src="'../../live/arba-app/views/default/header.html'"></ng-include>
	</div>
    <?php /*<div class="nav-wrap">
        <nav class="z-depth-0">
            <div class="nav-wrapper container">
                <div class="row">
                    <div class="col s2 m4 l3">
                        <!-- Logo wrap -->
                        <a id="logo" href="<?= Yii::$app->getHomeUrl() ?>">
                            Arba<span>.ae</span>
                        </a>
                        <!-- /Logo wrap -->
                        <span class="slogan">Where cars become friends</span>
                    </div>

                    <!-- Top icons -->
                    <?php if ($isGuest = Yii::$app->user->isGuest) : ?>
                        <div class="col s10 m8 l9 pos-rel">
                            <ul class="top-list clearfix">
                                <li>
                                    <div id="top-search"><span class="ico-magnifier"></span></div>
                                </li>
                                <li>
                                    <a href="#signin" class="popup-form">Login</a>
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
                                            <?php
                                                $avatar = Yii::$app->user->identity->avatar;

                                                if (empty($avatar)) {
                                                    $avatar = '/images/u-avatar1.jpg';
                                                }
                                            ?>
                                            <img src="<?= $avatar ?>" alt="profile avatar">
                                        </div>
                                        <p>Hi, <a href="#" data-activates="slide-out" class="profile-name"><?= Yii::$app->user->identity->username ?></a>
                                        </p>
                                    </div>
                                </li>
                                <li>
                                    <a href="#" class="pos-rel notify">
                                        <span class="ico-new-email-interface-symbol-of-closed-envelope-back"></span>
                                        <div style="display: none" class="notify-badge">10</div>
                                    </a>
                                    <a href="#" class="pos-rel notify">
                                        <span class="ico-bell-alarm-symbol"></span>
                                        <div style="display: none" class="notify-badge">10</div>
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
    <?php if (!$isGuest) : ?>
        <div id="slide-out" class="side-nav">
            <div class="nav-user-top center">
                <div class="nav-user-avatar round">
                    <img src="<?= $avatar ?>" alt="profile avatar">
                </div>
                <ul class="top-user-info">
                    <li><span class="ico-maps-placeholder-outlined-tool"></span>Dubai</li>
                    <li><img src="/images/arba2.png" alt="rating">0</li>
                </ul>
            </div>
            <div class="user-nav-menu">
                <ul>
                    <li><a href="<?= Url::to(['/feed'])?>">My news feed</a></li>
                    <li><a href="<?= Url::to(['/user/account/profile']) ?>">My profile</a></li>
                    <li class="garage-menu"><a class="garage-menu-with-sep" href="<?= Url::to(['/garage'])?>">My garage</a><ul class="cars-list"><li class="clearfix"><a href="#"><span class="truncate">My favorite car Mercedes-Benz</span></a><div style="display: none" class="user-badge">23</div></li><li class="clearfix"><a href="#"><span class="truncate">Muscle car</span></a></li></ul></li>
                    <li><a href="/live/#/messages/all">My messages</a><div style="display: none" class="user-badge">1</div></li>
                    <li><a href="#">My journals</a><div style="display: none" class="user-badge">1</div><div style="display: none" class="user-badge"><span class="ico-heart-outline"></span>23</div></li>
                    <li><a href="<?= Url::to(['/user/album']) ?>">My photos</a><div style="display: none" class="user-badge">1</div><div style="display: none" class="user-badge"><span class="ico-heart-outline"></span>23</div></li>
                    <li><a href="<?= Url::to(['/achievements'])?>">My achievements</a><div style="display: none" class="user-badge">1</div><div style="display: none" class="user-badge"><span class="ico-heart-outline"></span>23</div></li>
                    <li><a href="<?= Url::to(['/user/subscriptions']) ?>">My subscriptions</a><div style="display: none" class="user-badge">1</div></li>
                    <li><a href="<?= Url::to(['/user/bookmark']) ?>">My bookmarks</a><div style="display: none" class="user-badge">1</div></li>
                    <li><a href="#">My notifications</a><div style="display: none" class="user-badge">1</div></li>
                    <li><a href="<?= Url::to(['/site/logout']) ?>">Logout</a></li>
                </ul>

            </div>
        </div>
        <!-- /User navigation -->
    <?php endif; ?>*/ ?>
    <!-- /Header -->

    <?= $content ?>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l5">
                    <div class="footer-about">
                        <img class="logo" src="/images/logo.svg" alt="logo">
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
						<div ng-controller="HomeCtrl">
							<ng-include src="'../../live/arba-app/views/default/footer.html'"></ng-include>
						</div>
                        <?/*= \common\widgets\footer_menu\FooterMenu::widget([
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
                        ]) */?>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="row">
                        <div class="col s12">
                            <h6>Instagram</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="inst-widget">
                            <script src="http://lightwidget.com/widgets/lightwidget.js"></script>
                            <iframe src="http://lightwidget.com/widgets/4ba4aacc2411580ab6009846053d5e78.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width: 100%; border: 0px; overflow: hidden; height: 213px;"></iframe>
                        </div>
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

    <?php if (Yii::$app->user->isGuest) : ?>
        <!-- Signin popup -->
        <form id="signin" action="<?= Url::to(['/site/login']) ?>" class="white-popup-block mfp-hide" method="post">
            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <div class="row">
                <div class="col s12">
                    <div class="heading center">
                        <h4>Authorization</h4>
                        <div class="heading-separator">
                            <img src="/images/arba.png" alt="separator">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="login" name="name" type="text" class="validate">
                    <label for="login" data-error="Empty login" data-success="right">Login</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password" data-error="Empty password" data-success="right">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button class="waves-effect btn-large" id="login-btn" type="submit" name="action">login</button>
                    <a href="#" class="fgt-pw">Forgot your password?</a>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="oauth-wrap">
                        <h6>Or sign in with:</h6>
                        <ul class="clearfix">
                            <li><a href="#" class="fb"><span class="ico-facebook"></span></a></li>
                            <li><a href="#" class="tw"><span class="ico-twitter"></span></a></li>
                            <li><a href="#" class="in"><span class="ico-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <?php $this->registerJsFile('/js/login-compiled.js', [
            'depends' => \frontend\assets\SocialAsset::className(),
            'position' => \yii\web\View::POS_END
        ]) ?>
        <!-- /Signin popup -->
    <?php endif; ?>

    <!-- Dialog popup -->
    <form id="remove-item" class="white-popup-block dialog-pop mfp-hide">
        <div class="heading">
            <button type="button" id="confirmBtn"><span class="ico-close-cross-circular-interface-button"></span></button>
        </div>
        <div class="dialog-popup">
            <h6>Delete car</h6>
            <p>Are you sure? All car's entries will be removed too.</p>
            <a href="javascript:void(0)" onclick="CarActions.confirmRemove()" class="btn-large waves-effect">Yes</a>
            <a href="#"  id ="delete-car-cancel-btn" class="btn-large btn-gray modal-close waves-effect" >cancel</a>
        </div>
    </form>
    <!-- /Dialog popup -->

    <!-- add car popup -->
    <form id="addcar" class="white-popup-block mfp-hide full-btn"  enctype="multipart/form-data">
	    <input type="hidden" name="Car[engine_type]" value="gasoline" />
        <input type="hidden" name="Car[drive_type]" value="Full wheel drive" />
        <input type="hidden" name="Car[build_date]" value="2016" />
        <div class="row">
            <div class="col s12 marg">
                <div class="heading center">
                    <h4>Add car</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div id="cropContainerModal" style="height: 440px; width: 617px; position: absolute; left: -9999px;"></div>
                <div class="btn-large btn-gray waves-effect upload-btn"><span>upload photos</span><div id="progress-bar"></div> <input id="add-car-images" type="file" class="car-images" multiple=""></div>
                <div class="cars-preview"></div>
                <p>File format — JPEG.<br>
                    Size — any (but not less than 640×480 pixels).<br>
                    Dragging the image, you can specify the output order of pictures on the page. The first image is the main.</p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <select id="brand" name="Car[brand]">
                    <option value="" disabled selected>Brand</option>
                    <option value="Audi">Audi</option>
                    <option value="BMW">BMW</option>
                    <option value="Chrysler">Chrysler</option>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="model" name="Car[model]">
                    <option value="" disabled selected>Model</option>
                    <option value="model 1">model 1</option>
                    <option value="model 2">model 2</option>
                    <option value="model 3">model 3</option>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="modification" name="Car[modification]">
                    <option value="" disabled selected>Modification</option>
                    <option value="model 4">model 1</option>
                    <option value="model 5">model 2</option>
                    <option value="model 6">model 3</option>
                </select>
            </div>
            <div class="input-field col s12">
                <select id="modelYear" name="Car[use_since]">
                    <option value="" disabled selected>Use since</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                </select>
            </div>
            <!--<div class="input-field col s12">
                <select id="modelYear" name="Car[build_date]">
                    <option value="" disabled selected>Model year</option>
                    <option value="model 1">model 1</option>
                    <option value="model 2">model 2</option>
                    <option value="model 3">model 3</option>
                </select>
            </div>-->

            <!--<div class="input-field col s12">
                <select id="engine" name="Car[engine_type]">
                    <option value="" disabled selected>Engine type</option>
                    <option value="engine 1">model 1</option>
                    <option value="engine 2">model 2</option>
                    <option value="engine 3">model 3</option>
                </select>
            </div>-->
            <div class="input-field col s12">
                <select id="engine-size" name="Car[engine_size]">
                    <option value="" disabled selected>Engine size</option>
                    <option value="size 1">model 1</option>
                    <option value="size 2">model 2</option>
                    <option value="size 3">model 3</option>
                </select>
            </div>
            <div class="input-field col s12">
                <input id="capacity" name="Car[capacity]" type="text">
                <label for="capacity">Capacity</label>
            </div>
            <div class="input-field col s12">
                <input id="car-name" name="Car[car_name]" type="text">
                <label for="carname">Own car name</label>
            </div>
            <div class="input-field col s12">
                <input id="car-number" name="Car[car_number]" type="text">
                <label for="carnumber">Car number</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="Car[location]" id="location" class="autocomplete">
                <label for="city">Car location</label>
            </div>

            <div class="addishional-field">

            </div>
            <div class="input-field col s12">
                <input type="text" name="Car[about]" id="about" class="autocomplete">
                <label for="about">About my car</label>
            </div>
            <div class="input-field col s12 marg">
                <input type="checkbox" name="Car[main_car]" class="filled-in main-for-hide" id="maincar">
                <label for="maincar">Main car</label>
            </div>
            <div id="hidden-inputs"></div>
        </div>
        <div class="row">
            <div class="col s12">
                <button id="add-car-btn" class="waves-effect btn-large" type="submit" name="action2">add car</button>
            </div>
        </div>
    </form>
    <!-- /add car popup -->

    <!-- add popup -->
    <form id="newalbum" class="white-popup-block mfp-hide full-btn">
        <div class="row">
            <div class="col s12 marg">
                <div class="heading center">
                    <h4>Add photo album</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="btn-large btn-gray waves-effect">
                    <div id="progress-bar"></div>
                    <input id="upload-photos" type="file" multiple="">
                    <span>upload photos</span>
                </div>
                <div id="album-images-preview" style="position: relative; display: inline-block; padding-top: 10px; padding-left: 15px;">
                    <div class="preloader-wrapper small" style="display: block;">
                        <div class="spinner-layer spinner-green-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div><div class="gap-patch">
                                <div class="circle"></div>
                            </div><div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <p>File format — JPEG.<br>
                    Size — any (but not less than 640×480 pixels).<br>
                    Dragging the image, you can specify the output order of pictures on the page. The first image is the main.</p>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="album-title" name="Album[title]" type="text" class="validate" required >
                <label id="album-label" for="album-title" data-error="wrong" data-success="right">Photo album title</label>
            </div>
            <div class="input-field col s12 marg">
                <input type="checkbox" class="filled-in" name="Album[hidden]" value="0" id="halbum">
                <label for="halbum">Hidden album</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <button id="create-album" class="waves-effect btn-large" type="submit" name="action2">add photo album</button>
            </div>
        </div>
    </form>
    <!-- /add popup -->

    <!-- Dialog popup -->
    <form id="delete-post" class="white-popup-block dialog-pop mfp-hide">
        <div class="heading">
            <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
        </div>
        <div class="dialog-popup center">
            <h6>Delete post</h6>
            <p>Are you sure?</p>
            <a href="#" id="remove-post" class="btn-large waves-effect">Yes</a>
            <a href="#" id="cancel-photo-delete" class="btn-large btn-gray waves-effect modal-close">cancel</a>
        </div>
    </form>
    <!-- /Dialog popup -->
    <!-- Dialog popup -->
    <form id="delete" class="white-popup-block dialog-pop mfp-hide">
        <div class="heading">
            <button type="button"><span class="ico-close-cross-circular-interface-button"></span></button>
        </div>
        <div class="dialog-popup center">
            <h6>Delete photo</h6>
            <p>Are you sure?</p>
            <a href="#" id="remove-photo" class="btn-large waves-effect">Yes</a>
            <a href="#" id="cancel-photo-delete" class="btn-large btn-gray waves-effect modal-close">cancel</a>
        </div>
    </form>
    <!-- /Dialog popup -->

    <!-- Search -->
    <div class="overlay overlay-data">
        <div id="close-search">
            <img src="/images/close.svg" alt="Close search">
        </div>
        <form id="nav-search">
            <div class="input-field">
                <i class="prefix ico-magnifier"></i>
                <input id="sinput" type="text">
                <label for="sinput">Enter your request</label>
            </div>
        </form>
    </div>
    <!-- Crop Modal -->
    <div id="crop-modal" class="modal" style="max-height: 100%; width: 60%; overflow: hidden">
        <div class="modal-content">

        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Crop</a>
        </div>
    </div>
    <!-- Search -->
    <?php $this->endBody() ?>

	<!----------------------------------------------------------------------
	  -
	  - AngularJS - CORE SCRIPTS & DEPENDENCIES
	  -
	  --------------------------------------------------------------------->
	  
	<!-- ANGULAR MOMENT -->
	<script src="/live/angular.js/vendor/bower/moment/min/moment.min.js"></script>
	
	<!-- Include Froala Editor Plugins -->
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/froala_editor.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/align.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/char_counter.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/code_beautifier.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/code_view.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/colors.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/emoticons.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/entities.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/file.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/font_family.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/font_size.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/fullscreen.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/image.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/image_manager.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/inline_style.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/line_breaker.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/link.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/lists.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_format.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/paragraph_style.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/quote.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/save.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/table.min.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-froala/bower_components/froala-wysiwyg-editor/js/plugins/video.min.js"></script>
	
	<script src="/live/angular.js/vendor/bower/angular/angular.js"></script>
	
	<script src="/live/angular.js/vendor/bower/angular-aria/angular-aria.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-ui-router/release/angular-ui-router.min.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-animate/angular-animate.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-cookies/angular-cookies.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-messages/angular-messages.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-mocks/angular-mocks.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-resource/angular-resource.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-route/angular-route.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-sanitize/angular-sanitize.js"></script>
    <script src="/live/angular.js/vendor/bower/angular-touch/angular-touch.js"></script>
    
	<!-- ANGULAR FANCYBOX -->
	<script src="/live/angular.js/vendor/bower/fancybox-plus/dist/jquery.fancybox-plus.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-fancybox-plus/js/angular-fancybox-plus.js"></script>
	
	<!-- MATERIAL ANGULAR -->
	<script src="/live/angular.js/vendor/bower/angular-material/angular-material.js"></script>
	
	<!-- ANGULAR MOMENT -->
	<script src="/live/angular.js/vendor/bower/angular-moment/angular-moment.js"></script>
	
	<!-- ANGULAR FILTERS -->
	<script src="/live/angular.js/vendor/bower/angular-filter/dist/angular-filter.js"></script>
	
	<!-- ANGULAR CACHE -->
	<script src="/live/angular.js/vendor/bower/angular-cache/dist/angular-cache.js"></script>
	
	<!-- ANGULAR YOUTUBE -->
	<script src="https://www.youtube.com/iframe_api"></script>
	<script src="/live/angular.js/vendor/bower/angular-youtube-mb/src/angular-youtube-embed.js"></script>
	
	<!-- ANGULAR BASE64 IMAGE -->
	<script src="/live/angular.js/vendor/bower/angular-base64-upload/dist/angular-base64-upload.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-base64/angular-base64.js"></script>
	
	<!-- AngularJS Editor Froala -->
	<script src="/live/angular.js/vendor/bower/angular-froala/src/angular-froala.js"></script>
	
	<!-- AngularJS Scroll -->
	<script src="/live/angular.js/vendor/bower/angular-scroll/angular-scroll.js"></script>
	
	<!-- AngularJS Notify Icons -->
	<script src="/live/angular.js/vendor/bower/angular-notification-icons/dist/angular-notification-icons.js"></script>
	
	<!-- SWEETALERTS -->
	<script src="/live/angular.js/vendor/bower/sweetalert/dist/sweetalert.min.js"></script>
	<script src="/live/angular.js/vendor/bower/ng-sweet-alert/ng-sweet-alert.js"></script>
	
	<!-- SOCKET.IO -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.1/socket.io.js"></script>
	<script src="/live/angular.js/vendor/bower/angular-socket-io/socket.js"></script>
		
	<!-- WEB NOTIFICATIONS -->
	<script type="text/javascript" src="/live/angular.js/vendor/bower/simple-web-notification/web-notification.js"></script>
	<script type="text/javascript" src="/live/angular.js/vendor/bower/angular-web-notification/angular-web-notification.js"></script>
	
	<!----------------------------------------------------------------------
	  -
	  --------- AngularJS - CORE SCRIPTS & DEPENDENCIES
	  -
	  --------------------------------------------------------------------->
	
	<!----------------------------------------------------------------------
	  -
	  - AngularJS - ABRA.AE ENGINE, FACTORYES & SERVICES, CONTROLLERS
	  -
	  --------------------------------------------------------------------->
	  
	<!-- ARBA START ENGINE & ROUTES -->
	<script src="/live/arba-assets/js/base.js"></script>
	<script type="text/javascript">
		'use strict';
		
		window.isNotAngularSystem = true;
		window.promoItems = function(){};
		window.slidersInit = function(){};

		window.homeNonRegSlider = function(){};

		angular.module('arbaLiveApp', [
			'ui.router',
		    'ngAnimate',
		    'ngCookies',
		    'ngMessages',
		    'ngResource',
		    'ngSanitize',
		    'ngTouch',
			'ngMaterial',
			'naif.base64',
			'base64',
			'btford.socket-io',
			'ng-sweet-alert',
			'froala',
			'duScroll',
			'fancyboxplus',
			'angularMoment',
			'angular-notification-icons',
			'youtube-embed',
			'angular.filter',
			'angular-cache',
			'angular-web-notification'
		])
		.config(function($stateProvider, $locationProvider, $urlRouterProvider) {});
	</script>
	
	<!-- ARBA ENGINE SERVICES & DIRECTIVES -->
	<script src="/live/arba-app/engine-services.js"></script>
	<script src="/live/arba-app/directives.js"></script>
	
	<!-- ARBA SERVICES&FACTORIES -->
	<script src="/live/arba-app/scripts/services/arbaprofile.js"></script>
	<script src="/live/arba-app/scripts/services/arbarest.js"></script>
	<script src="/live/arba-app/scripts/services/arbasocial.js"></script>
	<script src="/live/arba-app/scripts/services/fake-arbaprofile.js"></script>
	
	<!-- ARBA PAGES CONTROLLERS -->
	<script src="/live/arba-app/scripts/controllers/home.js"></script>
	
	<!----------------------------------------------------------------------
	  -
	  --------- AngularJS - AngularJS - ABRA.AE ENGINE, FACTORYES & SERVICES, CONTROLLERS
	  -
	  --------------------------------------------------------------------->
    </body>
    </html>
<?php $this->endPage() ?>
