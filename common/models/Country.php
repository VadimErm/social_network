<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use Exception;

class Country extends ActiveRecord
{
    public $id;
    public $title;

    public function rules()
    {
        return [
            ['title', 'string']
        ];
    }


}