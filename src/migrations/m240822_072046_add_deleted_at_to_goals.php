<?php

use yii\db\Migration;

/**
 * Handles adding deleted_at to table `{{%goals}}`.
 */
class m240822_072046_add_deleted_at_to_goals extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%goals}}', 'deleted_at', $this->timestamp()->null()->defaultValue(null));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%goals}}', 'deleted_at');
    }
}
