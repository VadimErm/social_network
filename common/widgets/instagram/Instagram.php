<?php

namespace common\widgets\instagram;

use yii\base\Widget;

class Instagram extends Widget
{
    public $items;
    public function run()
    {
        return $this->render('images', [
            'items' => $this->items
        ]);
    }
}