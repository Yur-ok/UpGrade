<?php

namespace app\models;

use app\traits\AdvancedLogTrait;
use app\traits\CacheTrait;
use yii\db\ActiveRecord;

class Goal extends ActiveRecord
{
    use CacheTrait;
    use AdvancedLogTrait;

    public static function tableName(): string
    {
        return 'goals';
    }

    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['completed'], 'boolean'],
            [['deleted_at'], 'safe'],
        ];
    }

    public function getTasks()
    {
        $cacheKey = "goal_{$this->id}_tasks";
        $tasks = $this->cacheGet($cacheKey);

        if ($tasks === false) {
            $tasks = $this->hasMany(Task::class, ['goal_id' => 'id'])->all();
            $this->cacheSet($cacheKey, $tasks);
        }

        return $tasks;
    }

    public function clearTaskCache()
    {
        $cacheKey = "goal_{$this->id}_tasks";
        $this->cacheDelete($cacheKey);
    }

    // Пример использования
    public function addTask(Task $task)
    {
        if ($task->save()) {
            $this->clearTaskCache();
            return true;
        }

        return false;
    }

    public function deleteTask(Task $task)
    {
        $task->softDelete();
        $this->clearTaskCache();
        $this->logAction('Task deleted', ['goal_id' => $this->id, 'task_id' => $task->id]);
    }

    public function completeTask(Task $task)
    {
        $task->complete();
        $this->clearTaskCache();
        $this->logAction('Task completed', ['goal_id' => $this->id, 'task_id' => $task->id]);
    }

    public function complete()
    {
        $this->completed = true;
        if ($this->save()) {
            $this->logAction('Goal completed', ['goal_id' => $this->id]);
            $this->cacheDelete("goal_{$this->id}_tasks");
            return true;
        }
        return false;
    }

    public function softDelete(): bool
    {
        // Мягкое удаление всех связанных задач
        foreach ($this->tasks as $task) {
            $task->softDelete();
        }

        // Пометка самой цели как удаленной
        $this->deleted_at = date('Y-m-d H:i:s');
        if ($this->save()) {
            $this->logAction('Goal soft deleted', ['goal_id' => $this->id]);
            $this->cacheDelete("goal_{$this->id}_tasks");
            return true;
        }
        return false;
    }

    public function saveGoal()
    {
        return $this->save();
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
