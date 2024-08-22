<?php

namespace app\traits;

use app\models\Goal;

trait GoalTrait
{
    public function addGoal($title, $description): Goal
    {
        $goal = new Goal();
        $goal->title = $title;
        $goal->description = $description;
        $goal->save();
        return $goal;
    }

    public function removeGoal($id): bool
    {
        $goal = Goal::findOne($id);
        if ($goal) {
            $goal->delete();
            return true;
        }
        return false;
    }

    public function getGoals()
    {
        return Goal::find()->all();
    }
}
