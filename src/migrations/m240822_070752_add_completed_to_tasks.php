<?php

use yii\db\Migration;

/**
 * Handles adding completed to table `{{%tasks}}`.
 */
class m240822_070752_add_completed_to_tasks extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'completed', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'completed');
    }
}
