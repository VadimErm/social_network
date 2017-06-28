<?php

namespace common\modules\promotion\widgets\promotion;

use yii\base\Widget;

class PromotionWidget extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('carousel', [
            'items' => $this->items
        ]);
    }
}