<?php

namespace common\modules\promotion\widgets\promo;

use yii\base\Widget;

class Promo extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('promo', [
            'items' => $this->items
        ]);
    }
}