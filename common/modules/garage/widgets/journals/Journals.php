<?php

namespace common\modules\garage\widgets\journals;

use yii\base\Widget;

class Journals extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('journals', [
            'items' => $this->items
        ]);
    }
}