<?php

use yii\db\Migration;

class m161223_100150_add_user_avatar extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'avatar', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'avatar');
    }
}
