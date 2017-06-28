<?php
/**
 *@var $items array
 */
use yii\helpers\Url;

?>
<?php foreach ($items as $item) : ?>
    <div class="col s12 m6 l6 promo-item">
    <div class="promo-wrap">
        <div class="block-preview">
            <div class="preview-info clearfix">
                <div class="bookmark">
                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                </div>
                <div class="rating">
                    <span class="ico-favorites-star-outlined-symbol"></span>Arba rating: <?= $item['rating'] ?>
                </div>
            </div>
            <img src="<?= $item['src'] ?>" alt="promo">
        </div>
        <div class="block-padding">
            <div class="block-info">
                <h6 class="truncate"><a href="<?= Url::to($item['url']) ?>"><?= $item['title'] ?></a></h6>
                <ul>
                    <li><span class="ico-maps-placeholder-outlined-tool"></span><?= $item['location'] ?></li>
                    <li><span class="ico-empty-daily-calendar-page"></span><?= $item['date'] ?></li>
                    <li><span class="ico-helm-wheel"></span><?= $item['service'] ?></li>
                </ul>
            </div>
            <div class="brands-wrap">
                <?php if (!empty($item['brands'])) : ?>
                    <?php foreach ($item['brands'] as $brand) : ?>
                        <div class="brand <?= $brand ?>"></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="share-block">
            <div class="share-item">
                <a href="#"><span class="ico-heart-outline"></span><?= $item['likes'] ?></a>
            </div>
            <div class="share-item">
                <a href="#"><span class="ico-upload-symbol"></span><?= $item['uploads'] ?></a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>