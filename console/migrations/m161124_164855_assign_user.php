<?php

use yii\db\Migration;

class m161124_164855_assign_user extends Migration
{
    public function up()
    {
        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'user',
            'user_id' => 2,
            'created_at' => time()
        ]);
    }

    public function down()
    {
        $this->delete('{{%auth_assignment}}', ['item_name' => 'user']);
    }
}
