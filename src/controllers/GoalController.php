<?php

namespace app\controllers;

use app\models\Goal;
use app\models\Task;
use app\traits\AdvancedLogTrait;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class GoalController extends Controller
{
    use AdvancedLogTrait;


    public function actionIndex(): string
    {
        $goals = Goal::find()->where(['deleted_at' => null])->all();
        $this->logEvent('Viewed all goals');
        return $this->render('index', ['goals' => $goals]);
    }

    public function actionView($id)
    {
        $goal = Goal::findOne(['id' => $id, 'deleted_at' => null]);
        if (!$goal) {
            \Yii::$app->session->setFlash('error', 'Запрашиваемя цель не существует либо была удалена.');
            return $this->redirect(['index']);
        }
        $goal->clearTaskCache();

        $tasks = $goal->getTasks();

        \Yii::$app->view->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
        \Yii::$app->view->params['breadcrumbs'][] = $goal->title;

        $this->logEvent('Viewed goal', 'info', ['goal_id' => $goal->id]);

        return $this->render('view', [
            'goal' => $goal,
            'tasks' => $tasks,
        ]);
    }

    public function actionCreate()
    {
        $model = new Goal();

        if ($model->load(Yii::$app->request->post()) && $model->saveGoal()) {
            $this->logAction('Goal created successfully');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionAddTask($goalId)
    {
        $goal = Goal::findOne(['id' => $goalId, 'deleted_at' => null]);
        if (!$goal) {
            \Yii::$app->session->setFlash('error', 'Цель не найдена.');
            return $this->redirect(['index']);
        }

        $task = new Task();
        $task->goal_id = $goalId;

        $goal = Goal::find()->where(['id' => $goalId, 'deleted_at' => null])->one();

        \Yii::$app->view->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
        \Yii::$app->view->params['breadcrumbs'][] = ['label' => $goal->title, 'url' => ['view', 'id' => $goalId]];
        \Yii::$app->view->params['breadcrumbs'][] = 'Add Task';

        if ($task->load(Yii::$app->request->post()) && $task->save()) {
            $goal->clearTaskCache();
            $this->logAction('Task added', ['goal_id' => $goalId, 'task_id' => $task->id]);
            return $this->redirect(['view', 'id' => $goalId]);
        }

        return $this->render('add-task', [
            'task' => $task,
        ]);
    }

    public function actionCompleteGoal($id): Response
    {
        $goal = Goal::find()->where(['id' => $id, 'deleted_at' => null])->one();
        if ($goal) {
            $goal->completed = true;
            $goal->save();
            $this->logAction('Goal marked as completed', ['goal_id' => $id]);
        }
        return $this->redirect(['view', 'id' => $id]);
    }


    public function actionCompleteTask($id)
    {
        $task = Task::findOne(['id' => $id, 'deleted_at' => null]);
        if ($task) {
            $task->completed = true;
            if ($task->save()) {
                $task->goal->clearTaskCache();
                $this->logAction('Task completed', ['task_id' => $task->id]);
            } else {
                \Yii::$app->session->setFlash('error', 'Не удалось завершить задачу.');
            }
            return $this->redirect(['view', 'id' => $task->goal_id]);
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteTask($id)
    {
        $task = Task::findOne(['id' => $id, 'deleted_at' => null]);
        if ($task) {
            $goalId = $task->goal_id;
            $task->softDelete();
            $task->goal->clearTaskCache();
            $this->logAction('Task deleted', ['task_id' => $task->id]);
            return $this->redirect(['view', 'id' => $goalId]);
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteGoal($id)
    {
        $goal = Goal::findOne(['id' => $id, 'deleted_at' => null]);
        if ($goal) {
            $goal->softDelete();
            $goal->clearTaskCache();
            $this->logAction('Goal deleted', ['goal_id' => $goal->id]);
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }
}
