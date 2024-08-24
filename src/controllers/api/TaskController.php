<?php

namespace app\controllers\api;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\Cors;
use app\models\Task;

class TaskController extends ActiveController
{
    public $modelClass = Task::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Поддержка CORS
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        // Аутентификация по токену
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        // Проверка RBAC
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                    'roles' => ['@'], // Разрешаем просмотр всем авторизованным пользователям
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
                    'roles' => ['admin'], // Разрешаем удаление и завершение только администраторам
                ],
                [
                    'allow' => false, // Запрещаем все остальные действия
                ],
            ],
        ];

        return $behaviors;
    }

    // Дополнительные действия
    public function actionComplete($id)
    {
        $task = $this->findModel($id);
        $task->completed = true;
        if ($task->save()) {
            return $task;
        }

        return ['error' => 'Unable to complete task'];
    }

    protected function findModel($id)
    {
        return Task::findOne($id);
    }
}
