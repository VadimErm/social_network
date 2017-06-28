<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cities`.
 */
class m170613_144926_create_cities_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $sql = file_get_contents(__DIR__ .'/cities-create.sql');
        Yii::$app->db->createCommand($sql)->execute();
        $data = file_get_contents(__DIR__ .'/cities-data.sql');
        Yii::$app->db->createCommand($data)->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cities');
    }
}
