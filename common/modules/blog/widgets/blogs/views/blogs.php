<?php
/**
 * @var $items array
 */
use yii\helpers\Url;

?>

<?php foreach ($items as $item) : ?>
<div class="col s12 m6 l3 blog">
    <div class="blog-wrap">
        <a href="<?= Url::to($item['url']) ?>">
            <div class="block-preview" style="background-image:url(<?= $item['src'] ?>);"></div>
        </a>
        <div class="block-padding">
            <div class="block-info">
                <p><a href="<?= Url::to($item['url']) ?>"><?= $item['description'] ?></a></p>
            </div>
            <div class="block-meta clearfix">
                <a href="<?= Url::to($item['user_url']) ?>">
                    <div class="avatar round" style="background-image:url(<?= $item['avatar'] ?>);"></div>
                    <p><?= $item['username'] ?></p>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>