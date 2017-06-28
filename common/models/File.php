<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 23.06.17
 * Time: 15:48
 */

namespace common\models;

use common\stanislavdev\db\ActiveRecord;

class File extends ActiveRecord
{
    public $path;


    public function rules()
    {
        return [
            ['path', 'string'],
        ];
    }

}