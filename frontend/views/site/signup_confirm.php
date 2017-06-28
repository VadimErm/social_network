<?php
/**
 * @var $this \yii\web\View
 */
?>
<?= $this->registerJs('location.hash="#confirm"', \yii\web\View::POS_END) ?>
<?= $this->render('_blocks/promo_slider') ?>
<?= $this->render('_blocks/menu') ?>
<?= $this->render('_blocks/breadcrums', [
    'category' => 'confirm',
    'page' => 'main',
    'url' => '/',
    'id' => 'confirm'
]) ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="bordered-box confirm">
                    <div class="row">
                        <div class="col s12">
                            <div class="bordered-box-top">
                                <h6>Confirm registration</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l10 offset-l1">
                            <div class="bordered-box-content">
                                <h4>Thank you for your registration! You’re automatically signed in.</h4>
                                <a href="<?= Yii::$app->getHomeUrl() ?>">go to homepage</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>