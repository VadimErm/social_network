<?php

namespace common\modules\community\widgets\communities;

use yii\base\Widget;

class Communities extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('communities', [
            'items' => $this->items
        ]);
    }
}