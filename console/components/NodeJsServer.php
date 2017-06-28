<?php
namespace console\components;

use yii\base\Component;

class NodeJsServer extends Component
{
    private $_pid;
    private $_pidFile;
    public $pidKey = 'node_server';
    public $logFile = 'node_log.txt';
    public $serverPath;
    public $host = 'localhost';
    public $port = 3000;

    public function init()
    {
        parent::init();

        $this->logFile = dirname($this->serverPath) . '/' . $this->logFile;
        $this->_pidFile = dirname($this->serverPath) . '/pid.txt';

        if (file_exists($this->_pidFile)) {
            $this->_pid = file_get_contents($this->_pidFile);
        } else {
            $this->_pid = null;
        }
    }

    private function setPid($pid)
    {
        file_put_contents($this->_pidFile, (int)$pid);
        $this->_pid = (int)$pid;
    }

    private function getPid()
    {
        $this->_pid = empty($this->_pid) ? (int)file_get_contents($this->_pidFile) : (int)$this->_pid;

        return $this->_pid;
    }

    public function start()
    {
        if ($this->isInProcess()) {
            return false;
        }

        $command = "nohup node {$this->serverPath} > {$this->logFile} --host {$this->host} --port {$this->port} 2>&1 & echo $!";
        exec($command, $op);
        $this->setPid((int)$op[0]);

        return !empty((int)$op[0]);
    }

    public function stop()
    {
        if ($this->isInProcess()) {
            $pid = $this->getPid();
            $this->setPid(null);

            `kill $pid`;

            return true;
        }

        return false;
    }

    protected function isInProcess()
    {
        return !empty($this->_pid);
    }

    public function restart()
    {
        if ($this->isInProcess()) {
            $this->stop();
        }

        return $this->start();
    }
}