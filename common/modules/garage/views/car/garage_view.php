<?php
/**
 * @var $this \yii\web\View
 * @var $mainCar object|null
 * @var $myCars array
 */
use yii\helpers\Url;

?>

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
                    <div id="garage-my-cars">
                        <?= \common\modules\garage\widgets\mycar\MyCar::widget([
                            'view' => true,
                            'cars' => $myCars,
                            'main' => $mainCar
                        ]) ?>
                    </div>
                </div>
                <div class="garage-block">
                    <div class="row">
                        <div class="col s12">
                            <h5>My ex-cars</h5>
                        </div>
                        <?= \common\modules\garage\widgets\mycar\MyExCar::widget([
                            'view' => true,
                            'exCars' => $exCars,

                        ]) ?>

                        <div class="col s12 center">
                        </div>
                    </div>
                </div>
                <div class="garage-block">
                    <div class="row">
                        <div class="col s12">
                            <h5>My Wish list</h5>
                        </div>
                        <?= \common\modules\garage\widgets\mycar\MyWishList::widget([
                            'view' => true,
                            'wishCars' => $wishCars,

                        ]) ?>

                        <div class="col s12 center">
                            <div class="edit-block-section">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="garage-block">
                    <div class="row">
                        <div class="col s12">
                            <h5>My test-drives</h5>
                        </div>
                        <?= \common\modules\garage\widgets\mycar\MyTestDriveCar::widget([
                            'view' => true,
                            'testdriveCars' => $testdriveCars,

                        ]) ?>

                        <div class="col s12 center">
                            <div class="edit-block-section">
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
