<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%goals}}`.
 */
class m240822_061904_create_goal_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%goals}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%goals}}');
    }
}
