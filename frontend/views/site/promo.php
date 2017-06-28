
<div class="section promo-cars gray-section">
    <div class="container">
        <div class="row">
            <div id="promo-cars-carousel">
                <?= \common\modules\promotion\widgets\promotion\PromotionWidget::widget([
                    'items' => [
                        [
                            'title' => 'Muscle car',
                            'description' => 'Aenean porta ipsum eget tortor tincidunt',
                            'url' => '#',
                            'src' => '/images/promo-car2.jpg'
                        ],
                        [
                            'title' => 'Muscle car',
                            'description' => 'Aenean porta ipsum eget tortor tincidunt',
                            'url' => '#',
                            'src' => '/images/promo-car2.jpg'
                        ]
                    ]
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col s12 center">
                <a class="btn-large btn-liner waves-effect" href="#">promote your car</a>
            </div>
        </div>
    </div>
</div>