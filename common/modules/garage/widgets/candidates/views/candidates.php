<?php
/**
 * @var $items array
 */
use yii\helpers\Url;

?>
<div class="col s12 m5 l4">
    <h5>Candidats</h5>
    <ul class="candidats-slider">
        <?php foreach ($items as $item) : ?>
            <li style="background-image:url(<?= $item['src'] ?>)">
                <div class="top-car-top-block clearfix">
                    <h6 class="truncate"><a href="<?= Url::to($item['url']) ?>"><?= $item['title'] ?></a></h6>
                    <div class="top-car-meta">
                        <div class="meta-item"><span class="ico-favorites-star-outlined-symbol"></span><?= $item['rating'] ?></div>
                        <div class="meta-item"><span class="ico-maps-placeholder-outlined-tool"></span><?= $item['location'] ?></div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>