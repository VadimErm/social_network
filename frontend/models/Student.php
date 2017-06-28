<?php

namespace frontend\models;

use neo4j\db\ActiveQuery;
use neo4j\db\ActiveRecord;

class Student extends ActiveRecord
{
    public $name;
    public $age;

    public function getFriend()
    {
        return $this->hasMany(self::className(), ['friend'], ActiveQuery::DIRECTION_IN);
    }
}