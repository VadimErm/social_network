<?php
/**
 * @var $items array
 */
?>

<div class="col s6 m6 l6">
    <ul class="bottom-menu">
        <?php foreach ($items['column1'] as $item) : ?>
            <li><a href="<?= \yii\helpers\Url::to($item['url']) ?>"><?= $item['title'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="col s6 m6 l3">
    <ul class="bottom-menu">
        <?php foreach ($items['column2'] as $item) : ?>
            <li><a href="<?= \yii\helpers\Url::to($item['url']) ?>"><?= $item['title'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
