<?php

use yii\db\Migration;

/**
 * Class m230826_074452_add_table_country
 */
class m230826_074452_add_table_country extends Migration
{
    private string $tableName;

    /**
     * {@inheritdoc}
     */
    public function up(): void
    {
        $this->tableName = 'country';
        $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'code' => $this->string(2)->notNull()->unique(),
                'name' => $this->string(52)->notNull(),
                'population' => $this->integer(11)->notNull()->defaultValue('0')
            ]
        );

        $this->batchInsert($this->tableName, ['code', 'name', 'population'], [
            ['AU', 'Australia', 24016400],
            ['BR', 'Brazil', 205722000],
            ['CA', 'Canada', 35985751],
            ['CN', 'China', 1375210000],
            ['DE', 'Germany', 81459000],
            ['FR', 'France', 64513242],
            ['GB', 'United Kingdom', 65097000],
            ['IN', 'India', 1285400000],
            ['RU', 'Russia', 146519759],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down(): void
    {
        $this->dropTable($this->tableName);
    }

}