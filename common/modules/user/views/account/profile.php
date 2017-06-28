<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;

?>
<?php $this->title = 'Arba.ae / My page'; ?>
<?php if (Yii::$app->session->hasFlash('profile_change')) : ?>
    <?php $msg = Yii::$app->session->getFlash('profile_change') ?>
    <?php $this->registerJs("Materialize.toast('$msg', 4000)") ?>
<?php endif; ?>
<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<?php \frontend\assets\BowerAsset::register($this)?>
<?php $this->registerJsFile('/js/blog/post.js', [
    'depends' => \frontend\assets\SocialAsset::className(),
    'position' => \yii\web\View::POS_END
]) ?>
<?php $this->registerCssFile('/css/blog.css') ?>


<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My page</li>
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
                            <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>0</div>
                            <div class="pf-location">
                                <?php if (!empty($account->count)) : ?>
                                    <?= $account->country->title ?>
                                    ,
                                <?php endif; ?>
                                <?= $account->city->title ?>
                            </div>
                        </div>
                        <div class="center age-wrap" style="padding-top: 16px;">Birthday: <span class="yo-item"><?= $account->birthday ?></span></div>
                        <div class="center registration-date">
                            Registred on <?= $registered ?>
                        </div>
                        <div class="center profile-buttons">
                            <a href="<?= \yii\helpers\Url::to(['/user/account/change']) ?>" class="btn-large btn-gray waves-effect">change profile</a>
<!--                            <a href="#" class="btn-large waves-effect">-->
<!--                                <span class="ico-medal-on-a-necklace"></span>Top 10-->
<!--                            </a>-->
                        </div>
                        <div class="profile-info-wrap">
                            <div class="profile-info-row clearfix">
                                followers
                                <span class="stat-counter"><a href="<?= Url::to(['/user/account/my-followers']) ?>">0</a></span>
                            </div>
                            <div class="profile-info-row clearfix">
                                users follows
                                <span class="stat-counter"><a href="<?= Url::to(['/user/account/i-follow']) ?>">0</a></span>
                            </div>
                            <div class="profile-info-row clearfix">
                                cars follows
                                <span class="stat-counter"><a href="#">0</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="bordered-box profile-groups">
                        <h5>Achivements</h5>
<!--                        <ul class="achivements-list">-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Most popular blog in <a href="#">December 2017</a></div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a href="#">December 2017</a></div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci</div>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                                <div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>-->
<!--                                <div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>-->
<!--                            </li>-->
<!--                        </ul>-->
                        <h5>Communities</h5>
<!--                        <ul class="communities-list">-->
<!--                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">BMW Lovers Club</a></h6></li>-->
<!--                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">Mercedes-Benz Lovers Club</a></h6></li>-->
<!--                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">Mitsubishi Lovers Club</a></h6></li>-->
<!--                            <li><div class="avatar round" style="background-image:url(/images/community-ava1.jpg);"></div><h6 class="truncate"><a href="#">United Arab Emirates Club</a></h6></li>-->
<!--                        </ul>-->
                    </div>
                </aside>
            </div>
            <div class="col s12 m12 l8 profile-content">
                <div class="about bordered-box">
                    <h6>About myself</h6>
                    <p><?= $account->summary ?></p>
                </div>
                <div class="garage-wrap">
                    <h5>My garage</h5>
                    <?php if(empty($mainCar) && empty($cars)) : ?>
                        <div class="alert-box-none">
                            You don't have any cars in your garage yet.
                        </div>
                    <?php else: ?>
                        <div class="garage-cars">
                        <div class="row">
                            <div class="col s12">
                                <div class="garage-item big-car">
                                    <?php if(!empty($mainCar)): ?>
                                        <div class="garage-car-wrap" style="background-image:url(<?= $mainCar->images->src ?>);">
                                        <div class="preview-info clearfix">
<!--                                            <div class="badge2 award-badge">-->
<!--                                                <a href="#"><span class="ico-sports-or-education-trophy-cup"></span>nominee Car of the day</a>-->
<!--                                            </div>-->
<!--                                            <div class="badge1 award-badge">-->
<!--                                                <a href="#"><span class="ico-sports-or-education-trophy-cup"></span>Car of the day</a>-->
<!--                                            </div>-->
                                            <div class="bookmark">
                                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                            </div>
                                        </div>
                                        </div>
                                        <h6 class="car-name"><a href="#"><?= $mainCar->car_name; ?></a></h6>
                                        <div class="car-modification"><?= $mainCar->brand.' / '.$mainCar->model.' / '.$mainCar->modification .' / '.$mainCar->build_date; ?></div>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <?php if(!empty($cars)): ?>
                                <?php foreach ($cars as $car): ?>
                                    <?php if (isset($car->images[0])) : ?>
                                <div class="col s12 m6 l6">
                                    <div class="garage-item">
                                        <div class="garage-car-wrap" style="background-image:url(<?= $car->images[0]->src; ?>)">
                                        <div class="preview-info clearfix">
<!--                                            <div class="badge3 award-badge">-->
<!--                                                <a href="#"><span class="ico-sports-or-education-trophy-cup"></span>best car’s blog</a>-->
<!--                                            </div>-->
                                            <div class="bookmark">
                                                <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                                            </div>
                                        </div>
                                        </div>
                                        <h6 class="car-name truncate"><a href="#"><?= $car->car_name; ?></a></h6>
                                        <div class="car-modification truncate"><?= $car->brand.' / '.$car->model.' / '.$car->modification.' / '.$car->build_date; ?></div>
                                    </div>
                                </div>
                                        <?php endif; ?>
                                <?php endforeach ?>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php endif; ?>
                    <a href="<?= Url::to(['/garage']) ?>" class="btn-large btn-gray waves">view garage</a>
                </div>
                <?= $this->render('../../../blog/views/blog/blog', ['account' => $account, 'posts' => $posts, 'mainCar' => $mainCar]) ?>
            </div>
        </div>
    </div>
</div>
<!-- /Confirm wrapper -->