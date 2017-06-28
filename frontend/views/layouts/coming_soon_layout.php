<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Html;
use \frontend\assets\SocialAsset;
?>

<?php SocialAsset::register($this) ?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <!-- Favicons -->
        <link rel="shortcut icon" href="/images/favicon.ico">
        <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">

        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>