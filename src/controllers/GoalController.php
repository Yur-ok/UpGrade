<?php

namespace app\controllers;

use app\models\Goal;
use app\models\Task;
use app\traits\GoalTrait;
use app\traits\TaskTrait;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class GoalController extends Controller
{
    use GoalTrait;
    use TaskTrait;

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'add-task'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('manageGoal');
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete-goal', 'delete-task', 'complete-goal', 'complete-task'],
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false, 
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $goals = Goal::find()->where(['deleted_at' => null])->all();

        \Yii::$app->view->params['breadcrumbs'][] = 'Goals';

        return $this->render('index', ['goals' => $goals]);
    }

    public function actionCreate()
    {
        $model = new Goal();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $goal = Goal::find()->where(['id' => $id, 'deleted_at' => null])->one();

        if (!$goal) {
            \Yii::$app->session->setFlash('error', 'Запрашиваемя цель не существует либо была удалена.');
            return $this->redirect(['index']);
        }

        if ($goal->load(\Yii::$app->request->post()) && $goal->save()) {
            \Yii::$app->session->setFlash('success', 'Цель успешно обновлена.');
            return $this->redirect(['view', 'id' => $goal->id]);
        }

        return $this->render('update', [
            'model' => $goal,
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
        $goal = Goal::find()->where(['id' => $goalId, 'deleted_at' => null])->one();
        if (!$goal) {
            \Yii::$app->session->setFlash('error', 'Цель не найдена.');
            return $this->redirect(['index']);
        }

        $task = new Task();
        $task->goal_id = $goalId;

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

    public function actionCompleteGoal($id)
    {
        $goal = Goal::find()->where(['id' => $id, 'deleted_at' => null])->one();
        if ($goal) {
            $goal->completed = true;
            if (!$goal->save()) {
                \Yii::$app->session->setFlash('error', 'Не удалось завершить цель.');
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDeleteGoal($id)
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
            if (!$task->save()) {
                \Yii::$app->session->setFlash('error', 'Не удалось завершить задачу.');
            }
        }
        return $this->redirect(['view', 'id' => $task->goal_id]);
    }

    public function actionDeleteTask(int $id)
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
