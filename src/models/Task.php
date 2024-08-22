<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tasks';
    }

    public function rules(): array
    {
        return [
            [['goal_id', 'title', 'description'], 'required'],
            [['goal_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['completed'], 'boolean'],
            [['deleted_at'], 'safe'],
        ];
    }

    public static function find(): ActiveQuery
    {
        return parent::find()->where(['deleted_at' => null]);
    }

    public function softDelete(): bool
    {
        $this->deleted_at = date('Y-m-d H:i:s');
        return $this->save(false);
    }
}
