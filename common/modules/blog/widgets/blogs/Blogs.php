<?php

namespace common\modules\blog\widgets\blogs;

use yii\base\Widget;

class Blogs extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('blogs', [
            'items' => $this->items
        ]);
    }
}