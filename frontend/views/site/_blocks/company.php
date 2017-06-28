<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 21.12.16
 * Time: 11:39
 */
?>

<!-- Companies block-->
<div class="section companies gray-section">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="heading center">
                    <h4>Companies</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?= \common\modules\company\widgets\companies\Companies::widget([
                'items' => [
                    [
                        'src' => '/images/company1.jpg',
                        'rating' => '544',
                        'title' => 'Mercedes-Benz Service',
                        'url' => '#',
                        'address' => 'Financial Centre Road,Downtown Dubai',
                        'email' => 'mercedes@uae.ae',
                        'phone' => '+971 800 382246255',
                        'website' => 'www.mercedes.ae',
                        'brands' => ['b1', 'b2', 'b3', 'b4', 'b5', 'b6'],
                        'services' => [
                            'Painting',
                            'Oil changes',
                            'Car engine repair',
                            'Body car service'
                        ]
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
<!-- /Companies block-->
