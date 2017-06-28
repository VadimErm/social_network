<!-- City block -->
<div class="section city gray-section">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5>Select city</h5>
            </div>
        </div>
        <div class="row">
            <div id="city-wrap">
                <?= \common\widgets\city\City::widget([
                    'items' => [
                        [
                            'top_car' => true,
                            'url' => '#',
                            'title' => 'Dubai',
                            'users' => '167 688',
                            'src' => '/images/city1.jpg'
                        ],
                        [
                            'url' => '#',
                            'title' => 'Dubai',
                            'users' => '167 688',
                            'src' => '/images/city2.jpg'
                        ],
                        [
                            'url' => '#',
                            'title' => 'Dubai',
                            'users' => '167 688',
                            'src' => '/images/city3.jpg'
                        ],
                        [
                            'url' => '#',
                            'title' => 'Dubai',
                            'users' => '167 688',
                            'src' => '/images/city4.jpg'
                        ],
                        [
                            'url' => '#',
                            'title' => 'Dubai',
                            'users' => '167 688',
                            'src' => '/images/city5.jpg'
                        ]
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>
<!-- /City block -->