<?php

namespace app\traits;

use app\models\Task;

trait TaskTrait
{
    public function addTask($goalId, $title, $description): Task
    {
        $task = new Task();
        $task->goal_id = $goalId;
        $task->title = $title;
        $task->description = $description;
        $task->save();
        return $task;
    }

    public function removeTask($id): bool
    {
        $task = Task::findOne($id);
        if ($task) {
            $task->delete();
            return true;
        }
        return false;
    }

    public function getTasks($goalId)
    {
        return Task::find()->where(['goal_id' => $goalId])->all();
    }
}
