<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 07.03.17
 * Time: 17:38
 */

namespace common\modules\garage\widgets\mycar;


use yii\base\Widget;

class MyWishList extends Widget
{
    public $view = false;
    public $wishCars;
    public function run()
    {
        $view = $this->view ? 'my_wish_car_view' : 'my_wish_car';

        return $this->render($view, [
            'wishCars' => $this->wishCars
        ]);
    }

}