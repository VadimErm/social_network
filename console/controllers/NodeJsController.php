<?php

namespace console\controllers;

use console\components\NodeJsServer;
use yii\console\Controller;

class NodeJsController extends Controller
{
    /**
     * @var NodeJsServer
     */
    protected $nodeJsServer;

    public function init()
    {
        parent::init();

        $this->nodeJsServer = \Yii::$app->nodeJsServer;
    }

    public function actionStart()
    {
        if ($this->nodeJsServer->start()) {
            echo "Node js started\n";
        } else {
            echo "Node js server already run\n";
        }
    }

    public function actionStop()
    {
        if ($this->nodeJsServer->stop()) {
            echo "Node js server stopped\n";
        } else {
            echo "Node js is not started\n";
        }
    }
}