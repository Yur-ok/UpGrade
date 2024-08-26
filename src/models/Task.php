<?php

namespace app\models;

use app\traits\AdvancedLogTrait;
use app\traits\CacheTrait;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    use CacheTrait;
    use AdvancedLogTrait;

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function rules()
    {
        return [
            [['title', 'description', 'goal_id'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['completed'], 'boolean'],
            [['deleted_at'], 'safe'],
            [['goal_id'], 'integer'],
        ];
    }

    public function getGoal()
    {
        return $this->hasOne(Goal::class, ['id' => 'goal_id']);
    }

    public function complete()
    {
        $this->completed = true;
        return $this->save();
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
