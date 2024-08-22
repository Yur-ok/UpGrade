<?php

namespace app\controllers;

use app\models\Goal;
use app\models\Task;
use Yii;
use yii\web\Controller;

class ReflectionController extends Controller
{
    public function actionIndex()
    {
        $goals = Goal::find()->where(['deleted_at' => null])->all();

        \Yii::$app->view->params['breadcrumbs'][] = 'Goals';

        return $this->render('index', [
            'goals' => $goals,
        ]);
    }

    public function actionCreate()
    {
        $model = new Goal();
        $tasks = [new Task(), new Task(), new Task()]; // Создаем массив задач

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach ($tasks as $i => $task) {
                if ($task->load(Yii::$app->request->post()["Task"][$i], '')) {
                    $task->goal_id = $model->id;
                    $task->save();
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'tasks' => $tasks,
        ]);
    }
}
