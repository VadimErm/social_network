<?php

namespace common\modules\garage\widgets\mycar;

use yii\base\Widget;

class MyCar extends Widget
{
    public $view = false;
    public $main;
    public $cars;
    public function run()
    {
        $view = $this->view ? 'my_car_view' : 'my_car';

        return $this->render($view, [
            'main' => $this->main,
            'cars' => $this->cars
        ]);
    }
}