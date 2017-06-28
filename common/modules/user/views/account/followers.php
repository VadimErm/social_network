<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;

?>
<?php if (Yii::$app->session->hasFlash('profile_change')) : ?>
    <?php $msg = Yii::$app->session->getFlash('profile_change') ?>
    <?php $this->registerJs("Materialize.toast('$msg', 4000)") ?>
<?php endif; ?>
<?= $this->render('../../../../../frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('../../../../../frontend/views/site/_blocks/menu') ?>
<?php $this->registerJsFile('/js/blog.js', [
    'depends' => \frontend\assets\SocialAsset::className(),
    'position' => \yii\web\View::POS_END
]) ?>
<?php $this->registerCssFile('/css/blog.css') ?>
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My followers</li>
                <li>→</li>
                <li><a href="<?= Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>→</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l4">
                <aside>
                    <div class="bordered-box main-profile">
                        <div class="preview-info clearfix">
                            <div class="bookmark">
                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                            </div>
                            <?php if ($is_premium) : ?>
                                <div class="premium-badge">
                                    <a href="#"><span class="ico-precious-stone"></span>Premium account</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="big-avatar round">
                            <img src="<?= $avatar ?>" alt="avatar">
                        </div>
                        <div class="center pf-marg">
                            <div class="profile-title">
                                <a href="#"><?= $account->first_name ?>&nbsp;<?= $account->last_name ?></a><span class="badge green online">online</span>
                            </div>
                        </div>
                        <div class="center pf-marg">
                            <div class="u-rating"><img src="/images/arba2.png" alt="rating">777</div>
                            <div class="pf-location"><?= $account->country->title, ', ' ,$account->city->title ?></div>
                        </div>
                        <div class="center registration-date">
                            Registred on <?= $registered ?>
                        </div>
                        <div class="center profile-buttons">
                            <a href="<?= \yii\helpers\Url::to(['/user/account/change']) ?>" class="btn-large btn-gray waves-effect">change profile</a>
                            <a href="#" class="btn-large waves-effect"><span class="ico-medal-on-a-necklace"></span>Top 10</a>
                        </div>
                        <div class="profile-info-wrap">
                            <div class="profile-info-row clearfix">
                                followers
                                <span class="stat-counter"><a href="<?= Url::to(['/user/account/followers']) ?>">100</a></span>
                            </div>
                            <div class="profile-info-row clearfix">
                                users follows
                                <span class="stat-counter"><a href="#">77</a></span>
                            </div>
                            <div class="profile-info-row clearfix">
                                cars follows
                                <span class="stat-counter"><a href="#">211</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="bordered-box profile-groups">
                        <h5>Achivements</h5>
                        <ul class="achivements-list">
                            <li>
                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                <div class="ach-desc">Most popular blog in <a href="#">December 2017</a></div>
                            </li>
                            <li>
                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                <div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a href="#">December 2017</a></div>
                            </li>
                            <li>
                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>
                            </li>
                            <li>
                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci</div>
                            </li>
                            <li>
                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>
                                <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>
                            </li>
                        </ul>
                        <h5>Communities</h5>
                        <ul class="communities-list">
                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">BMW Lovers Club</a></h6></li>
                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">Mercedes-Benz Lovers Club</a></h6></li>
                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">Mitsubishi Lovers Club</a></h6></li>
                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">United Arab Emirates Club</a></h6></li>
                        </ul>
                    </div>
                </aside>
            </div>
            <div class="col s12 m12 l8 followers-content">
                <div class="row">
                    <div class="col s12 m8 l8">
                        <ul class="utabs clearfix">
                            <li class="tab"><a class="active" href="#following">My followers (167)</a></li>
                            <li class="tab"><a href="#follow">I follow (55)</a></li>
                        </ul>
                    </div>
                    <div class="col input-field s12 m4 l4">
                        <input id="susers" type="text" placeholder="Search">
                        <span class="ico-magnifier"></span>
                    </div>
                </div>
                <div id="following">
                    <div class="fuser-row clearfix">
                        <div class="u-avatar round small">
                            <img src="/images/u-avatar1.jpg" alt="user avatar">
                        </div>
                        <div class="u-body">
                            <a href="#" class="btn-large btn-gray waves-effect">follow</a>
                            <a href="#" class="bolder">Aahil Asad</a>
                            <div class="city">
                                UAE, Dubai
                            </div>
                            <a class="nmess popup-form" href="#new-message">Send message</a>
                        </div>
                    </div>
                </div>
                <div id="follow">
                    <div class="fuser-row clearfix">
                        <div class="u-avatar round small">
                            <img src="/images/u-avatar3.jpg" alt="user avatar">
                        </div>
                        <div class="u-body">
                            <a href="#" class="btn-large btn-gray waves-effect">unfollow</a>
                            <a href="#" class="bolder">Aahil Asad</a>
                            <div class="city">
                                UAE, Dubai
                            </div>
                            <a class="nmess popup-form" href="#new-message">Send message</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Confirm wrapper -->