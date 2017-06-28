<?php

namespace common\widgets\menu;

use yii\base\Widget;

class Menu extends Widget
{
    public $ulClass = '';
    public $items;

    public function run()
    {
        return $this->render('menu', [
            'items' => $this->items,
            'ulClass' => $this->ulClass
        ]);
    }
}