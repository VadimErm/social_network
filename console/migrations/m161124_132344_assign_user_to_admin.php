<?php

use yii\db\Migration;

class m161124_132344_assign_user_to_admin extends Migration
{
    public function up()
    {
        $this->insert('{{%auth_assignment}}', [
            'item_name' => 'admin',
            'user_id' => 1,
            'created_at' => time()
        ]);
    }

    public function down()
    {
        $this->delete('{{%auth_assignment}}', ['item_name' => 'admin']);
    }
}
