<?php

namespace common\modules\company\widgets\companies;

use yii\base\Widget;

class Companies extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('companies', [
            'items' => $this->items
        ]);
    }
}