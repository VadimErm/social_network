<?php

namespace common\stanislavdev\db;

use GraphAware\Neo4j\Client\Formatter\Type\Node;
use GraphAware\Neo4j\Client\Formatter\Type\Relationship;
use Yii;
use yii\base\Model;

abstract class Neo4jDataProvider extends Model
{
    private $_cql = '';
    private $_params;

    private $_start;
    private $_create;
    private $_match;
    private $_optional_match;
    private $_where;
    private $_set;
    private $_merge;
    private $_with;
    private $_skip;
    private $_limit;
    private $_foreach;
    private $_remove;
    private $_delete;
    private $_orderBy;
    private $_asArray = false;
    private $_return;

    public function build()
    {
        if (!empty($this->_start)) {
            $this->_cql .= $this->_start;
        }

        if (!empty($this->_match)) {
            $this->_cql .= $this->_match;
        }

        if (!empty($this->_optional_match)) {
            $this->_cql .= $this->_optional_match;
        }

        if (!empty($this->_create)) {
            $this->_cql .= $this->_create;
        }

        if (!empty($this->_foreach)) {
            $this->_cql .= $this->_foreach;
        }

        if (!empty($this->_remove)) {
            $this->_cql .= $this->_foreach;
        }


        if (!empty($this->_with)) {
            $this->_cql .= $this->_with;
        }

        if (!empty($this->_where)) {
            $this->_cql .= $this->_where;
        }

        if (!empty($this->_delete)) {
            $this->_cql .= $this->_delete;
        }

        if (!empty($this->_set)) {
            $this->_cql .= $this->_set;
        }

        if (!empty($this->_merge)) {
            $this->_cql .= $this->_merge;
        }

        if (!empty($this->_return)) {
            $this->_cql .= $this->_return;
        }

        if (!empty($this->_orderBy)) {
            $this->_cql .= $this->_orderBy;
        }

        if (!empty($this->_skip)) {
            $this->_cql .= $this->_skip;
        }

        if (!empty($this->_limit)) {
            $this->_cql .= $this->_limit;
        }

        $this->_cql = trim($this->_cql);

        //var_dump($this->_cql); exit;
    }

    public function query($cql, $params = [])
    {
        $this->_cql = $cql;
        $this->_params = $params;
    }

    public function execute($one = false)
    {
        $this->build();

        if (empty($this->_cql)) return false;

        $result = $this->getDb()->open()->run($this->_cql, $this->_params);

        if (empty($result->getRecords())) {
            return null;
        }

        return $one ? $result->getRecord() : $result->getRecords();
    }

    public function asArray()
    {
        $this->_asArray = true;

        return $this;
    }

    public function all()
    {
        $records = $this->execute();

        return empty($records) ? null : $this->queryAll($records);
    }

    protected function queryOne($record)
    {
        $model = $this->createModel();
        $keys = $record->keys();

        $first = reset($keys);

        foreach ($keys as $key) {
            $value = $record->value($key);

            if (($value instanceof Node) && $key == $first) {
                // It's node
                $id = $value->identity();
                $labels = $value->labels();
                $labelName = reset($labels);
                $attributes = $value->values();
                $attributes['id'] = $id;

                if ($model::labelName() == $labelName) {
                    $model->setAttributes($attributes);
                } else {
                    if ($this->_asArray) {
                        $obj = $this->_createObject($labelName, $attributes);
                        $model->{$key} = $this->getObjVars($obj);
                    } else {
                        $model->{$key} = $this->_createObject($labelName, $attributes);
                    }
                }
            } elseif(is_object($value)) {
                $labels = $value->labels();
                $labelName = reset($labels);
                if($this->_asArray){
                    $obj = $this->_createObject($labelName, $value->values());
                    $model->$key = $this->getObjVars($obj);
                } else{
                    $model->$key = $this->_createObject($labelName, $value->values());
                }

            } elseif (is_array($value)) {
                foreach ($value as $node) {
                    $labels = $node->labels();
                    $labelName = reset($labels);
                    if ($this->_asArray) {
                        $obj = $this->_createObject($labelName, $node->values());
                        $model->{$key}[] = $this->getObjVars($obj);
                    } else {
                        $model->{$key}[] = $this->_createObject($labelName, $node->values());
                    }
                }
            } else {
                $model->{$key} = $value;
            }
        }

        if ($this->_asArray) {
            return $this->getObjVars($model);
        }

        return $model;
    }

    protected function getObjVars($obj)
    {
        // get only public properties
        return call_user_func('get_object_vars', $obj);
    }

    protected function queryAll($records)
    {
        $models = [];

        foreach ($records as $record) {
            $models[] = $this->queryOne($record);
        }

        return $models;
    }

    public function one()
    {
        $record = $this->execute(true);

        return empty($record) ? null : $this->queryOne($record);
    }

    private function _createObject($class, $attributes)
    {
        $obj = new \ReflectionClass($this);
        $namespace = $obj->getNamespaceName();
        $obj = null;
        $className = $namespace . '\\' . $class;

        if (class_exists($className)) {
            $obj = new $className();
            $obj->setAttributes($attributes);
        } else {
            $obj = \Yii::createObject(array_merge(['class' => 'stdClass'], $attributes));
        }

        return $obj;
    }

    protected function createModel()
    {
        $class = get_called_class();

        return new $class;
    }

    public function getDb()
    {
        return \Yii::$app->get('neo4jDb');
    }

    public function __destruct()
    {
        $this->getDb()->close();
    }

    public static function labelName()
    {
        return (new \ReflectionClass(get_called_class()))->getShortName();
    }


    public function match($condition)
    {
        $match = 'MATCH ' . $condition . ' ';
        $this->_match = empty($this->_match) ? $match : $this->_match . $match;

        return $this;
    }

    public function optionalMatch($condition)
    {
        $this->_optional_match = "OPTIONAL MATCH $condition ";

        return $this;
    }

    public function get($condition)
    {
        $this->_return = "RETURN $condition ";

        return $this;
    }

    public function where($condition)
    {
        $this->_where = "WHERE $condition ";

        return $this;
    }

    public function create($condition)
    {
        $this->_create = "CREATE $condition ";

        return $this;
    }

    public function start($condition)
    {
        $this->_start = "START $condition ";

        return $this;
    }

    public function set($condition)
    {
        $this->_set = "SET $condition ";

        return $this;
    }

    public function merge($condition)
    {
        $this->_cql = "MERGE $condition ";

        return $this;
    }

    public function with($condition)
    {
        $this->_cql = "WITH $condition ";


        return $this;
    }

    public function skip($condition)
    {
        $this->_cql = "SKIP $condition ";

        return $this;
    }

    public function limit($condition)
    {
        $this->_cql = "LIMIT $condition ";

        return $this;
    }

    public function foreach_($condition)
    {
        $this->_cql = "FOREACH $condition ";

        return $this;
    }

    public function remove($condition)
    {
        $this->_cql = "REMOVE $condition ";

        return $this;
    }

    public function delete($condition)
    {
        $this->_delete = "DELETE $condition ";

        return $this;
    }

    public function orderBy($condition)
    {
        $this->_cql = "ORDER BY $condition ";
        
        return $this;
    }

    public static function find()
    {
        return new static;
    }

    public function attributes()
    {
        return get_object_vars($this);
    }
}