<?php

namespace common\modules\garage\widgets\candidates;

use yii\base\Widget;

class Candidates extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('candidates', [
            'items' => $this->items
        ]);
    }
}