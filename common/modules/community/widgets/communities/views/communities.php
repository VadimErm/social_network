<?php
/**
 * @var $items array
 */
use yii\helpers\Url;
?>

<?php foreach ($items as $item) : ?>
<div class="col s12 m6 l3 community">
    <div class="community-wrap">
        <a href="<?= Url::to($item['url']) ?>">
            <div class="block-preview" style="background-image:url(<?= $item['src'] ?>);"></div>
        </a>
        <div class="block-padding">
            <div class="block-meta clearfix">
                <div class="avatar round"
                     style="background-image:url(<?= $item['avatar'] ?>);"></div>
                <div class="community-info">
                    <div class="community-info-inner">
                        <h5 class="trancute"><a href="<?= Url::to($item['url']) ?>"><?= $item['title'] ?></a></h5>
                        <p><span class="ico-user-outline-shape"></span><?= $item['members'] ?> members</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>