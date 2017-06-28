<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 07.03.17
 * Time: 16:50
 */

namespace common\modules\garage\widgets\mycar;


use yii\base\Widget;

class MyExCar extends Widget
{
    public $view = false;
    public $exCars;
    public function run()
    {
        $view = $this->view ? 'my_excar_view' : 'my_excar';

        return $this->render($view, [

            'exCars' => $this->exCars
        ]);
    }

}