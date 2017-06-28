<?php

use yii\db\Migration;

class m161228_120134_remove_email_index extends Migration
{
    public function up()
    {
        $this->dropIndex('email', '{{%user}}');
    }

    public function down()
    {
        $this->createIndex('email', '{{%user}}', 'email');
    }
}
