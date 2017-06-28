<?php

use yii\db\Migration;

class m161228_083437_premium_status extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'is_premium', $this->boolean() . ' DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'is_premium');
    }
}
