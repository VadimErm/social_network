<?php

namespace common\stanislavdev\db;

use Yii;

class ActiveRecord extends Neo4jDataProvider
{
    public function getIsNewRecord()
    {
        return empty($this->id);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->getIsNewRecord()) {
            $model = $this->insert($runValidation, $attributeNames);
            $this->id = $model->id;

            return true;
        } else {
            $model = $this->update($runValidation, $attributeNames);
            $this->id = $model->id;

            return $model != false;
        }
    }

    public function insert($runValidation = true, $attributes = null)
    {
        if ($runValidation && !$this->validate($attributes)) {
            Yii::info('Model not inserted due to validation error.', __METHOD__);
            return false;
        }

        if ($attributes == null) {
            $attributes = $this->attributes();
        }

        $attributesStr = $this->getAttributesStr($attributes);
        $labelName = static::labelName();

        return $this->create("(n: {$labelName} " . "{" .$attributesStr. "})")
            ->get('n')
            ->one();
    }

    public function update($runValidation  = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate($attributeNames)) {
            Yii::info('Model not updated due to validation error.', __METHOD__);
            return false;
        }

        if ($attributeNames == null) {
            $attributeNames = $this->attributes();
        }

        $attributesStr = $this->getAttributesForUpdate($attributeNames);
        $labelName = static::labelName();

        return $this->match("(n: $labelName)")
            ->where("ID(n)={$this->id}")
            ->set($attributesStr)
            ->one();
    }

    public function getAttributesForUpdate($attributes, $nodeName = 'n')
    {
        $str = '';

        if (isset($attributes['id'])) {
            unset($attributes['id']);
        }

        foreach ($attributes as $key => $value) {
            if (is_object($value) || $value == null || is_array($value)) {
                continue;
            }

            if (strpos($value, '0') !== false) {
                // phone number
                $value = addslashes($value);
                $str .= "$nodeName.$key='$value'";
            } elseif (is_numeric($value)) {
                $str .= "$nodeName.$key=$value";
            } elseif (is_string($value)) {
                $value = addslashes($value);
                $str .= "$nodeName.$key='$value'";
            }

            $str .= ', ';
        }

        return substr($str, 0, strlen($str) - 2);
    }

    public function getAttributesStr($attributes = [])
    {
        $str = '';
        if (isset($attributes['id'])) {
            unset($attributes['id']);
        }

        foreach ($attributes as $key => $value) {
            if (is_object($value) || $value == null || is_array($value)) {
                continue;
            }

            if (strpos($value, '0') !== false) {
                // phone number
                $value = addslashes($value);
                $str .= "$key: '$value'";
            } elseif (is_numeric($value)) {
                $str .= "$key: $value";
            } elseif (is_string($value)) {
                $value = addslashes($value);
                $str .= "$key: '$value'";
            }

            $str .= ', ';
            // TODO check if value is array
        }

        return substr($str, 0, strlen($str) - 2);
    }

    public function attributes()
    {
        return get_object_vars($this);
    }

    public function del()
    {
        parent::match('(n)')
            ->where('ID(n) = ' . $this->id .' DETACH DELETE n')
            ->one();

        return true;
    }

    public function findById($id)
    {
        $labelName = static::labelName();
        return $this->match("(n: $labelName)")
            ->where("ID(n)={$id}")
            ->get('n, ID(n) as id')
            ->one();
    }



}