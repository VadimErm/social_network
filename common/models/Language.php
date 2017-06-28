<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;

class Language extends ActiveRecord
{
    public $title;

    public function rules()
    {
        return [
            ['title', 'string']
        ];
    }
}