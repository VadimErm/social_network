<?php
use common\modules\garage\widgets\carofday\CarOfDay;
?>
<div class="section top-car">
    <div class="container">
        <div class="row">
            <?= CarOfDay::widget([
                'title' => 'Mercedes C200 AMG',
                'rating' => 540,
                'date' => '27.10.2016',
                'location' => 'Dubai',
                'src' => '/images/candidat1.jpg',
                'url' => '#',
                'candidates' => [
                    [
                        'title' => 'Mercedes C200 AMG',
                        'rating' => 540,
                        'date' => '27.10.2016',
                        'location' => 'Dubai',
                        'src' => '/images/candidat1.jpg',
                        'url' => '/images/candidat1.jpg'
                    ]
                ]
            ]) ?>
        </div>
    </div>
</div>