<?php

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;

class InstallController extends Controller
{
    protected function mysql()
    {
        echo "Configure mysql db...\n";

        echo "Input host[localhost]:";
        $host = Console::stdin();
        $host = $host ? $host : 'localhost';

        echo "Input dbName:";
        $dbname = Console::stdin();

        echo "Input username:";
        $username = Console::stdin();

        echo "Input password:";
        $password = Console::stdin();

        $mysqlConfig = trim("
            <?php
               return [
                   'class'    => 'yii\\db\\Connection',
                   'dsn'      => 'mysql:host=$host;dbname=$dbname',
                   'username' => '$username',
                   'password' => '$password',
                   'charset'  => 'utf8',
                   'enableSchemaCache' => true
               ];
            ");

        file_put_contents(\Yii::getAlias('@common/config/db.php'), $mysqlConfig);
        echo "Mysql configure\n\n";
    }

    protected function neo4j()
    {
        echo "Configure Neo4j...\n";

        echo "Input username:";
        $username = Console::stdin();

        echo "Input password:";
        $password = Console::stdin();

        $neo4jConfig = trim("
        <?php
            return [
                'class' => '\\common\\stanislavdev\\db\\Neo4jConnection',
                'username' => '$username',
                'password' => '$password'
            ];");

        file_put_contents(\Yii::getAlias('@common/config/neo4j-db.php'), $neo4jConfig);

        echo "Neo4j configured\n";
    }

    public function actionIndex()
    {
        $install = Console::confirm('Install social network?');

        echo "Installing...\n";

        if ($install) {
            $this->mysql();
            $this->neo4j();
        } else {
            echo "Canceled\n";
        }
    }
}