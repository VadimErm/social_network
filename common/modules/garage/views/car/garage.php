<?php
/**
 * @var $this \yii\web\View
 * @var $mainCar object|null
 * @var $myCars array
 */
use yii\helpers\Url;

?>
<?php $this->title = 'Arba.ae / My garage'; ?>
<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<!-- Breadcrumbs -->
<div class="breadcrumbs hide-on-small-only">
    <div class="container">
        <div class="col s12">
            <ul class="clearfix">
                <li class="active">My garage</li>
                <li>&rarr;</li>
                <li><a href="<?= Url::to(['/user/account/profile']) ?>">my profile</a></li>
                <li>&rarr;</li>
                <li><a href="/">main</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumbs -->

<!-- wrapper -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col s12 garage-content">
                <div id="" class="garage-block">
                    <h5>My cars</h5>
                    <?php if (empty($myCars) && empty($mainCar)) : ?>
                        <div class="alert-box-none">
                            You don't have any cars in your garage yet.
                        </div>
                    <?php else: ?>
                    <div id="garage-my-cars">
                        <?= \common\modules\garage\widgets\mycar\MyCar::widget([
                            'cars' => $myCars,
                            'main' => $mainCar
                        ]) ?>
                    </div>
                    <?php endif; ?>
                    <div class="edit-block-section center">
                        <a href="#addcar" data-car-type="1" class="add-car-btn btn-large waves-effect popup-form">add
                            car</a>
                    </div>
                </div>
                <div class="garage-block">
                    <div class="row">
                        <div class="col s12">
                            <h5>My ex-cars</h5>
                            <?php if (empty($exCars)) : ?>
                                <div class="alert-box-none">
                                    You don't have any ex-cars in your garage yet.
                                </div>
                            <?php else: ?>
                                <?= \common\modules\garage\widgets\mycar\MyExCar::widget([
                                    'exCars' => $exCars,
                                ]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="col s12 center">
                            <div class="edit-block-section">
                                <a href="#addcar" data-car-type="2"
                                   class="add-car-btn btn-large waves-effect popup-form">add car</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="garage-block">
                    <div class="row">
                        <div class="col s12">
                            <h5>My Wish list</h5>
                            <?php if (empty($wishCars)) : ?>
                                <div class="alert-box-none">
                                    Your wishlist is empty now.
                                </div>
                            <?php else: ?>
                                <?= \common\modules\garage\widgets\mycar\MyWishList::widget([
                                    'wishCars' => $wishCars,
                                ]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="col s12 center">
                            <div class="edit-block-section">
                                <a href="#addcar" data-car-type="3"
                                   class="add-car-btn btn-large waves-effect popup-form">add car</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="garage-block">
                    <div class="row">
                        <div class="col s12">
                            <h5>My test-drives</h5>
                            <?php if (empty($testdriveCars)) : ?>
                            <div class="alert-box-none">
                                Your wishlist is empty now.
                            </div>
                            <?php else : ?>
                                <?= \common\modules\garage\widgets\mycar\MyTestDriveCar::widget([
                                    'testdriveCars' => $testdriveCars,
                                ]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="col s12 center">
                            <div class="edit-block-section">
                                <a href="#addcar" data-car-type="4"
                                   class="add-car-btn btn-large waves-effect popup-form">add car</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Confirm wrapper -->
<!-- templates -->
<?= $this->render('templates/my_car') ?>
<!-- /templates -->
