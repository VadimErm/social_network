<?php

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Image extends ActiveRecord
{
    public $id;
    public $src;
    public $description;

    public function rules()
    {
        return [
            ['src', 'string'],
            ['description', 'string']
        ];
    }

    public function asArray()
    {
        $identity = $this;
        return ArrayHelper::toArray($identity, [
            get_class($identity) =>[
                'id',
                'src',
                'description'
                ]
        ]);
    }
}