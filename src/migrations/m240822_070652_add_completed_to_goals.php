<?php

use yii\db\Migration;

/**
 * Handles adding completed to table `{{%goals}}`.
 */
class m240822_070652_add_completed_to_goals extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%goals}}', 'completed', $this->boolean()->defaultValue(false));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%goals}}', 'completed');
    }
}
