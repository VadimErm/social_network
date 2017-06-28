<?php
/**
 * @var $items array
 */

use yii\helpers\Url;

?>

<?php foreach ($items as $item) : ?>
    <div class="city-item">
        <div class="city-bg">
            <div class="city-preview">
                <?php if (!empty($item['top_car'])) : ?>
                    <div class="city-badge">
                        <img src="/images/city-badge.png" alt="car of the day">
                    </div>
                <?php endif; ?>
                <a href="<?= Url::to($item['url']) ?>"><img src="<?= $item['src'] ?>" alt="city"></a>
            </div>
            <div class="city-info center">
                <h6 class="truncate"><a href="<?= Url::to($item['url']) ?>"><?= $item['title'] ?></a></h6>
                <p class="truncate"><span class="ico-user-outline-shape"></span><?= $item['users'] ?> users</p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
