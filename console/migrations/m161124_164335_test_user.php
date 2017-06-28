<?php

use yii\db\Migration;

class m161124_164335_test_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // test user
        $this->insert('{{%user}}', [
            'username' => 'user',
            'password_hash' => '$2y$13$lp4CYZELKF6W5vqwKHDvXuBzWf4akaPHfZDWhWcsBbisNu/a7KwlK', //admin999
            'status' => \common\models\User::STATUS_ACTIVE,
            'email' => 'user@gmail.com',
            'created_at' => 1476192012,
            'updated_at' => 1476192012
        ]);

        $time = time();

        $this->insert('{{%auth_item}}', [
            'name' => 'user',
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
        $this->delete('{{%user}}', ['username' => 'user']);
    }
}
