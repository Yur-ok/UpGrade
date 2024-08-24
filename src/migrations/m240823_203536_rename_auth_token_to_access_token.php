<?php

use yii\db\Migration;

/**
 * Class m240823_123456_rename_auth_token_to_access_token
 */
class m240823_203536_rename_auth_token_to_access_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user', 'auth_token', 'access_token');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user', 'access_token', 'auth_token');
    }
}
