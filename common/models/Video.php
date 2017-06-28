<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 27.06.17
 * Time: 17:28
 */

namespace common\models;

use common\stanislavdev\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class Video extends ActiveRecord
{
    public $src;

    public function rules()
    {
        return [
            ['src', 'string'],

        ];
    }

}