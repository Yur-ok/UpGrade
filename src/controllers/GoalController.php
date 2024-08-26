<?php

namespace app\controllers;

use app\helpers\FormGenerator;
use app\models\Goal;
use app\models\Task;
use Yii;
use yii\web\Controller;
use app\traits\GoalTrait;
use app\traits\TaskTrait;
use yii\web\Response;

class GoalController extends Controller
{
    use GoalTrait;
    use TaskTrait;

    public function actionIndex(): string
    {
        $goals = Goal::find()->where(['deleted_at' => null])->all();

        \Yii::$app->view->params['breadcrumbs'][] = 'Goals';

        return $this->render('index', ['goals' => $goals]);
    }

    public function actionCreate()
    {
        $model = new Goal();
        $formHtml = FormGenerator::generateForm($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'formHtml' => $formHtml,
            'model' => $model,
        ]);
    }


    public function actionView($id)
    {
        $goal = Goal::find()->where(['id' => $id, 'deleted_at' => null])->one();
        if (!$goal) {
            \Yii::$app->session->setFlash('error', 'Запрашиваемя цель не существует либо была удалена.');
            return $this->redirect(['index']);
        }

        $tasks = $this->getTasks($id);

        \Yii::$app->view->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
        \Yii::$app->view->params['breadcrumbs'][] = $goal->title;

        return $this->render('view', [
            'goal' => $goal,
            'tasks' => $tasks,
        ]);
    }

    public function actionAddTask($goalId)
    {
        $task = new Task();
        $task->goal_id = $goalId;

        $goal = Goal::find()->where(['id' => $goalId, 'deleted_at' => null])->one();

        \Yii::$app->view->params['breadcrumbs'][] = ['label' => 'Goals', 'url' => ['index']];
        \Yii::$app->view->params['breadcrumbs'][] = ['label' => $goal->title, 'url' => ['view', 'id' => $goalId]];
        \Yii::$app->view->params['breadcrumbs'][] = 'Add Task';

        if ($task->load(\Yii::$app->request->post()) && $task->save()) {
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
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDeleteGoal($id): Response
    {
        $goal = Goal::find()->where(['id' => $id, 'deleted_at' => null])->one();
        if ($goal) {
            $goal->softDelete();
        }
        return $this->redirect(['index']);
    }

    public function actionCompleteTask($id)
    {
        $task = Task::find()->where(['id' => $id, 'deleted_at' => null])->one();
        if ($task) {
            $task->completed = true;
            $task->save();
        }
        return $this->redirect(['view', 'id' => $task->goal_id]);
    }

    public function actionDeleteTask($id): Response
    {
        $task = Task::find()->where(['id' => $id, 'deleted_at' => null])->one();
        if ($task) {
            $goalId = $task->goal_id;
            $task->softDelete();
            return $this->redirect(['view', 'id' => $goalId]);
        }
        return $this->redirect(['index']);
    }
}
