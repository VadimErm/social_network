<?php
/**
 * Created by PhpStorm.
 * User: stanislav
 * Date: 21.12.16
 * Time: 11:37
 */
?>

<!-- Communities block-->
<div class="section communities">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="heading center">
                    <h4>Communities</h4>
                    <div class="heading-separator">
                        <img src="/images/arba.png" alt="separator">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?= \common\modules\community\widgets\communities\Communities::widget([
                'items' => [
                    [
                        'avatar' => '/images/community-ava1.jpg',
                        'src' => '/images/community1.jpg',
                        'url' => '#',
                        'title' => 'BMW Lovers Club',
                        'members' => '19889'
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
<!-- /Communities block-->
