<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \frontend\models\SignupForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container container-login">
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to signup:</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'passwordConfirm')->passwordInput() ?>

                <?= $form->field($model, 'phone')->textInput() ?>

                <?= $form->field($model, 'first_name')->textInput() ?>

                <?= $form->field($model, 'last_name')->textInput() ?>

                <?= $form->field($model, 'show_real_name')->checkbox() ?>

                <?= $form->field($model, 'gender')->radioList([
                    SignupForm::MALE_TYPE => 'Male',
                    SignupForm::FEMALE_TYPE => 'Female'
                ], ['class' => 'signup-option']) ?>

                <?= $form->field($model, 'birthday')->textInput() ?>

                <?= $form->field($model, 'show_real_birthday')->checkbox() ?>

                <?= $form->field($model, 'main_language')->textInput() ?>

                <?= $form->field($model, 'languages')->textInput() ?>

                <?= $form->field($model, 'country')->textInput() ?>

                <?= $form->field($model, 'city')->textInput() ?>

                <?= $form->field($model, 'avatar')->fileInput() ?>

                <?= $form->field($model, 'summary')->textarea() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
