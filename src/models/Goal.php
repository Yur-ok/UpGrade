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

    public static function findOne($id)
    {
        if (!is_numeric($id) || (int)$id != $id) {
            throw new \InvalidArgumentException('ID must be an integer.');
        }

        $query = static::find()
            ->andWhere(['deleted_at' => null])
            ->andWhere(['id' => (int)$id]);

        return $query->one();
    }

}
