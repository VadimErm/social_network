<?php

namespace common\widgets\city;

use yii\base\Widget;

class City extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('select_city', [
            'items' => $this->items
        ]);
    }
}