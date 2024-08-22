<?php

use yii\db\Migration;

/**
 * Handles adding deleted_at to table `{{%tasks}}`.
 */
class m240822_072209_add_deleted_at_to_tasks extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'deleted_at', $this->timestamp()->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'deleted_at');
    }
}
