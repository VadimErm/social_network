<!-- User's blogs-->
<div class="section gray-section blogs">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="heading center">
                    <h4>User’s blogs</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?= \common\modules\blog\widgets\blogs\Blogs::widget([
                'items' => [
                    [
                        'user_url' => '#',
                        'src' => '/images/blog1.jpg',
                        'url' => '#',
                        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        'avatar' => '/images/u-avatar1.jpg',
                        'username' => 'Aahil Asad'
                    ]
                ]
            ]) ?>
        </div>
        <div class="row">
            <div class="col s12 center">
                <a class="btn-large btn-liner waves-effect" href="#">see all</a>
            </div>
        </div>
    </div>
</div>
<!-- /User's blogs-->