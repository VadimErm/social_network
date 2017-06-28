<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 */
class m170613_140148_create_country_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $sql = file_get_contents(__DIR__ .'/countries-create.sql');
        Yii::$app->db->createCommand($sql)->execute();
        $data = file_get_contents(__DIR__ .'/countries-data.sql');
        Yii::$app->db->createCommand($data)->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('country');
    }
}
