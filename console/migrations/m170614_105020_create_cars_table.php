<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cars`.
 */
class m170614_105020_create_cars_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $sql = file_get_contents(__DIR__ .'/cars-create.sql');
        Yii::$app->db->createCommand($sql)->execute();
        $data = file_get_contents(__DIR__ .'/cars-data.sql');
        Yii::$app->db->createCommand($data)->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cars');
    }
}
