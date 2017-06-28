<?php
/**
 * @var $items array
 */
?>

<?php foreach ($items as $item) : ?>
<div class="col s12 m6 l3 company">
    <div class="company-wrap">
        <div class="block-preview" style="background-image:url(<?= $item['src'] ?>);">
            <div class="preview-info clearfix">
                <div class="bookmark">
                    <a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>
                </div>
                <div class="rating">
                    <span class="ico-favorites-star-outlined-symbol"></span>Arba rating: <?= $item['rating'] ?>
                </div>
            </div>
        </div>
        <div class="block-padding">
            <div class="block-info">
                <h6 class="truncate"><a href="#"><?= $item['title'] ?></a></h6>
                <ul>
                    <li><?= $item['address'] ?></li>
                    <li><?= $item['email'] ?></li>
                    <li><?= $item['phone'] ?></li>
                    <li><?= $item['website'] ?></li>
                </ul>
            </div>
            <div class="brands-wrap">
                <?php if (!empty($item['brands'])) : ?>
                    <?php foreach ($item['brands'] as $brand) : ?>
                        <div class="brand <?= $brand ?>"></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($item['services'])) : ?>
            <ul>
                <?php foreach ($item['services'] as $service) : ?>
                    <li><?= $service ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endforeach; ?>
