<?php
/*use common\widgets\menu\Menu;
?>
<div class="main-menu">
    <div class="container">
        <div class="row">
            <div class="col s6 m6 l2">
                <img class="logo" src="/images/logo.svg" alt="logo">
            </div>
            <div class="col s6 m6 l10 right-align">
                <?= Menu::widget([
                    'ulClass' => 'top-list clearfix hide-on-med-and-down',
                    'items' => [
                        ['label' => 'Top cars', 'url' => '/garage/car/top'],
                        ['label' => 'Car’s journals', 'url' => '#'],
                        ['label' => 'User’s blogs', 'url' => '#'],
                        ['label' => 'Communities', 'url' => '#'],
                        ['label' => 'Achievements', 'url' => '#'],
                        ['label' => 'Companies', 'url' => '#'],
                        ['label' => 'Promo', 'url' => '#'],
                        ['label' => 'News', 'url' => '#'],
                    ]
                ]) ?>
                <a href="#" data-activates="slide-out2" class="menu-btn hide-on-large-only"><span
                        class="ico-bars"></span></a>
            </div>
        </div>
    </div>
</div>
<?php */ ?>
<div ng-controller="HomeCtrl">
	<ng-include src="'../../live/arba-app/views/default/top-nav.html'"></ng-include>
</div>