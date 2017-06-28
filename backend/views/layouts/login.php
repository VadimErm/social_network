<?php
/**
 * @var $this \yii\web\View
 */

use backend\assets\LoginCustomAsset;
use yii\helpers\Html;

?>
<?php LoginCustomAsset::register($this) ?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->language ?>">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="<?= Yii::$app->language ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="login">
<?php $this->beginBody() ?>
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?= $content ?>
            </section>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>