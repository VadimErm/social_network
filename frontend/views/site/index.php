<?php

/* @var $this yii\web\View */

$this->title = 'Arba.ae';
?>
<?php if ($isGuest = Yii::$app->user->isGuest) : ?>
    <?= $this->render('_blocks/slider') ?>
<?php else : ?>
    <?= $this->render('_blocks/promo_slider') ?>
<?php endif; ?>

<?= $this->render('_blocks/menu') ?>

<?php if (!$isGuest) : ?>
    <?= $this->render('_blocks/top_car') ?>
<?php endif; ?>

<?= $this->render('_blocks/city') ?>
<?= $this->render('_blocks/journal') ?>
<?= $this->render('_blocks/blog') ?>
<?= $this->render('_blocks/community') ?>
<?= $this->render('_blocks/company') ?>
<?= $this->render('_blocks/promo') ?>