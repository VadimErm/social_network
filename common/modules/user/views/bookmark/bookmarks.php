<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;

?>
<?php $this->title = 'Arba.ae / My page'; ?>

<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<?php \frontend\assets\BowerAsset::register($this)?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My bookmarks</li>
                <li>&rarr;</li>
                <li><a href="<?= \yii\helpers\Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->

<!-- wrapper -->
<div class="section bookmarks">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>My bookmarks</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l3">
                <aside class="htabs-wrap">
                    <a class="btn-large waves-effect full" href="profile.html">back to profile</a>
                    <ul class="bordered-box edit-menu htabs">
                        <li class="tab profile-info-row">
                            <a class="active" href="#users">Users (0)</a>
                        </li>
                        <li class="tab profile-info-row">
                            <a href="#cjournals">Car’s journals (0)</a>
                        </li>
                        <li class="tab profile-info-row">
                            <a href="#centries">Car’s entries (0)</a>
                        </li>
                        <li class="tab profile-info-row">
                            <a href="#bentries">Blog’s entries (0)</a>
                        </li>
                        <li class="tab profile-info-row">
                            <a href="#communities">Communities (0)</a>
                        </li>
                    </ul>
                </aside>
            </div>
            <div class="col s12 m12 l9 bookmarks-content">
                <div class="row">
                    <div class="col input-field s12">
                        <input id="susers" type="text" placeholder="Search">
                        <span class="ico-magnifier"></span>
                    </div>
                </div>
                <div id="users">
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar1.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar2.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar3.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar2.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar1.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar2.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar3.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="fuser-row clearfix">-->
<!--                        <div class="u-avatar round small">-->
<!--                            <img src="/images/u-avatar2.jpg" alt="user avatar">-->
<!--                        </div>-->
<!--                        <div class="u-body">-->
<!--                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>-->
<!--                            <a href="#" class="bolder">Aahil Asad</a>-->
<!--                            <div class="city">-->
<!--                                UAE, Dubai-->
<!--                            </div>-->
<!--                            <a class="nmess popup-form" href="#new-message">Send message</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                    <div class="alert-box-none">
                        You don't have any users yet.
                    </div>
                <div id="cjournals">
                    <div class="alert-box-none">
                        You don't have any car's journals yet.
                    </div>
                    <!--
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo2.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo3.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo4.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo5.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo6.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo2.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo3.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo4.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo5.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo6.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    -->
                </div>
                <div id="centries">
                    <div class="alert-box-none">
                        You don't have any car's entries yet.
                    </div>
                    <!--
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo6.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo5.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo4.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo3.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo2.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo6.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo5.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo4.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo3.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo2.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/in-photo.jpg" alt="car avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="marg2">My favorite car Mercedes-Benz</a>
                            <div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    -->
                </div>
                <div id="bentries">
                    <div class="alert-box-none">
                        You don't have any blog's entries yet.
                    </div>
                    <!--
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar1.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar2.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar3.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar1.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar2.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar3.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar1.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar2.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar3.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar1.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar2.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/u-avatar3.jpg" alt="user avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Donec laoreet, tellus scelerisque lobortis tincidunt, diam turpis feugiat turpis, et vestibulum nibh dui eget diam.</a>
                            <a href="#" class="sub-title">Aahil Asad</a>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    -->
                </div>
                <div id="communities">
                    <div class="alert-box-none">
                        You don't have any communities yet.
                    </div>
                    <!--
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">BMW Lovers Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Mercedes-Benz Lovers Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Mitsubishi Lovers Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">United Arab Emirates Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">BMW Lovers Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Mercedes-Benz Lovers Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">Mitsubishi Lovers Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    <div class="bookmark-row clearfix">
                        <div class="preview-img round">
                            <img src="/images/community-ava1.jpg" alt="community avatar">
                        </div>
                        <div class="b-body">
                            <a href="#" class="bolder truncate">United Arab Emirates Club</a>
                            <div class="sub-title">167 700 users</div>
                            <a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-close-cross-circular-interface-button"></span></a>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /wrapper -->