<?php

namespace common\helpers;

use yii\base\Model;

class ValidationHelper
{
    /**
     * @param $model Model
     * @param $field
     */
    public static function getError($model, $field)
    {
        if (empty($model->getFirstError($field))) {
            return 'wrong';
        } else {
            return $model->getFirstError($field);
        }
    }

    public static function getSelectError($model, $field)
    {
        return $model->getFirstError($field);
    }

    public static function isInvalid($model, $field)
    {
        if (!empty($model->getFirstError($field))) {
            return 'invalid';
        }
    }
}