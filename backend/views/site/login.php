<?php
/**
 * @var $model \common\models\LoginForm
 */
?>

<?php $form = \yii\widgets\ActiveForm::begin() ?>
        <h1>Вход</h1>
        <div>
            <?= $form->field($model, 'username')->textInput(['placeholder' => 'Username'])->label('') ?>
        </div>
        <div>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label('') ?>
        </div>
        <div>
            <?= \yii\helpers\Html::submitButton('Ввойти', [
                'class' => 'btn btn-default submit'
            ]) ?>
            <a class="reset_pass" href="#">Забыли пароль?</a>
        </div>

        <div class="clearfix"></div>

        <div class="separator">
            <div class="clearfix"></div>
            <br />

            <div>
                <h1>KCET</h1>
                <p>©2016 Все права защищены. KCET</p>
            </div>
        </div>
    </form>
<?php \yii\widgets\ActiveForm::end() ?>