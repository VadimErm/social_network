<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;

class Blog extends ActiveRecord
{
    public $id;
    public $posts;
    public $author;

    public function rules()
    {
        return [
            ['id', 'integer']
        ];
    }
}