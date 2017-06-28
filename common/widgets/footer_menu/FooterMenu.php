<?php

namespace common\widgets\footer_menu;

use yii\base\Widget;

class FooterMenu extends Widget
{
    public $items;

    public function run()
    {
        return $this->render('menu', [
            'items' => $this->items
        ]);
    }
}