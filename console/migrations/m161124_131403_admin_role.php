<?php

use yii\db\Migration;

class m161124_131403_admin_role extends Migration
{
    public function up()
    {
        $time = time();

        $this->insert('{{%auth_item}}', [
            'name' => 'admin',
            'type' => \yii\rbac\Role::TYPE_ROLE,
            'description' => 'Administrator role',
            'data' => null,
            'created_at' => $time,
            'updated_at' => $time
        ]);
    }

    public function down()
    {
        $this->delete('{{%auth_item}}', ['name' => 'admin']);
    }
}
