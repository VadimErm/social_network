<?php

namespace common\widgets;

use yii\base\Widget;

class Preloader extends Widget
{
    public function run()
    {
        return '<div class="preloader-wrapper small active" style="display: none;">
    <div class="spinner-layer spinner-green-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>';
    }
}