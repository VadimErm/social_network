<!-- Promo block-->
<div class="section promo">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="heading center">
                    <h4>Promo</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?= \common\modules\promotion\widgets\promo\Promo::widget([
                'items' => [
                    [
                        'src' => '/images/promo1.jpg',
                        'url' => '#',
                        'rating' => '544',
                        'title' => '50% Discount on car repair',
                        'location' => 'Dubai',
                        'date' => '01.11.2016-01.12.2016',
                        'service' => 'Oil changes',
                        'brands' => ['b1', 'b2', 'b3', 'b4', 'b5'],
                        'likes' => '144',
                        'uploads' => '144'
                    ]
                ]
            ]) ?>
        </div>
        <div class="row">
            <div class="col s12 center">
                <a class="btn-large waves-effect" href="#">see all</a>
            </div>
        </div>
    </div>
</div>
<!-- /Promo block-->
