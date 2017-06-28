<!-- Car's journals block -->
<div class="section journals">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="heading center">
                    <h4>Car’s journals</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?= \common\modules\garage\widgets\journals\Journals::widget([
                'items' => [
                    [
                        'url' => '#',
                        'src' => '/images/journal1.jpg',
                        'title' => '',
                        'cat' => '',
                        'description' => '',
                        'views' => '',
                        'rating' => '',
                        'likes' => ''
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
<!-- /Car's journals block -->
