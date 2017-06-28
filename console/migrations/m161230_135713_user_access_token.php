<?php

use yii\db\Migration;

class m161230_135713_user_access_token extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string(32));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
