<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user}}`.
 */
class m240823_140549_add_auth_token_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'auth_token', $this->string(255)->unique());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'auth_token');
    }
}
