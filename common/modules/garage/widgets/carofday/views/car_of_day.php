<?php
/**
 * @var
 */
use yii\helpers\Url;
use \common\modules\garage\widgets\candidates\Candidates;
?>
<div class="col s12 m7 l8">
    <h5>Car of the day</h5>
    <div class="top-car-wrap" style="background-image:url(<?= $src ?>)">
        <div class="top-car-top-block clearfix">
            <h4 class="truncate"><a href="<?= Url::to($url) ?>"><?= $title ?></a></h4>
            <div class="top-car-rating">
                <span class="ico-favorites-star-outlined-symbol"></span> <?= $rating ?>
            </div>
            <div class="top-car-meta">
                <div class="meta-item"><span class="ico-empty-daily-calendar-page"></span><?= $date ?></div>
                <div class="meta-item"><span class="ico-maps-placeholder-outlined-tool"></span><?= $location ?></div>
            </div>
        </div>
        <div class="top-car-bottom-block center">
            <a class="btn-large btn-liner waves-effect" href="<?= $selectCarUrl ?>">select car of the day</a>
        </div>
    </div>
</div>
<?= Candidates::widget(['items' => $candidates]) ?>