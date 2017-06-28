<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // test user
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => '$2y$13$lp4CYZELKF6W5vqwKHDvXuBzWf4akaPHfZDWhWcsBbisNu/a7KwlK', //admin999
            'status' => \common\models\User::STATUS_ACTIVE,
            'email' => 'admin',
            'created_at' => 1476192012,
            'updated_at' => 1476192012
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
