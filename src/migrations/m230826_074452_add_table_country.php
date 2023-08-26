<?php

use yii\db\Migration;

/**
 * Class m230826_074452_add_table_country
 */
class m230826_074452_add_table_country extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230826_074452_add_table_country cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230826_074452_add_table_country cannot be reverted.\n";

        return false;
    }
    */
}
