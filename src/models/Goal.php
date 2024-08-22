<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Goal extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'goals';
    }

    public function rules(): array
    {
        return [
            [['title', 'description'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['completed'], 'boolean'],
            [['deleted_at'], 'safe'],
        ];
    }


    public function getTasks(): ActiveQuery
    {
        return $this->hasMany(Task::class, ['goal_id' => 'id'])->where(['deleted_at' => null]);
    }

    public function softDelete(): bool
    {
        // Мягкое удаление всех связанных задач
        foreach ($this->tasks as $task) {
            $task->softDelete();
        }

        // Пометка самой цели как удаленной
        $this->deleted_at = date('Y-m-d H:i:s');
        return $this->save(false);
    }

    public static function findOne($condition)
    {
        $query = static::find();

        if (is_array($condition)) {
            $condition['deleted_at'] = null;
        } else {
            $query = $query->andWhere(['deleted_at' => null]);
        }

        return $query->andWhere($condition)->one();
    }

}
