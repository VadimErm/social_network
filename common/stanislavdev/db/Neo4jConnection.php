<?php

namespace common\stanislavdev\db;

use GraphAware\Neo4j\Client\Client;
use GraphAware\Neo4j\Client\ClientBuilder;
use yii\base\Component;
use yii\db\Exception;

class Neo4jConnection extends Component
{
    public $host = 'localhost';
    public $port = 7474;
    public $username;
    public $password;
    public $schema = 'http';
    public $connectionAlias = 'default';
    public $params = [];

    /**
     * @var $_client Client
     */
    private $_client;

    public function addConnection($alias, $sdn)
    {
        if ($this->_client === null) {
            $this->open();
        }

        $this->_client->addConnection($alias, $sdn);
    }
    public function open()
    {
        if (!class_exists(ClientBuilder::class)) {
            throw new Exception(ClientBuilder::class . ' is require');
        }

        $this->_client = ClientBuilder::create($this->params)
            ->addConnection($this->connectionAlias, "{$this->schema}://{$this->username}:{$this->password}@{$this->host}:$this->port")
            ->build();

        return $this;
    }

    public function close()
    {
        $this->_client = null;
    }

    public function run($cql, $params = [])
    {
        if (empty($params)) {
            return $this->_client->run($cql);
        } else {
            return $this->_client->run($cql, $params);
        }
    }
}