<?php
/**
 * @var $items array
 */
use yii\helpers\Url;

?>
<ul class="<?= $ulClass ?>">
    <?php foreach ($items as $item) : ?>
        <li><a href="<?= Url::to($item['url']) ?>"><?= $item['label'] ?></a></li>
    <?php endforeach; ?>
</ul>