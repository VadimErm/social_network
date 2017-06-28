<?php

use \yii\helpers\Url;

/**
 * @var $items array
 */
?>

<?php foreach ($items as $item) : ?>
    <div class="promo-car-item">
        <div class="promo-car-bg">
            <div class="promo-car-preview">
                <a href="<?= Url::to($item['url']) ?>"><img src="<?= $item['src'] ?>" alt="promo car"></a>
            </div>
            <div class="promo-car-info center">
                <h6 class="truncate"><a href="<?= Url::to($item['url']) ?>"><?= $item['title'] ?></a></h6>
                <p class="truncate"><?= $item['description'] ?></p>
            </div>
        </div>
    </div>
<?php endforeach; ?>