<?php


namespace common\modules\garage\widgets\mycar;


use yii\base\Widget;

class MyTestDriveCar extends Widget
{
    public $view = false;
    public $testdriveCars;
    public function run()
    {
        $view = $this->view ? 'my_testdrive_cars_view' : 'my_testdrive_cars';

        return $this->render($view, [
            'testdriveCars' => $this->testdriveCars
        ]);
    }

}