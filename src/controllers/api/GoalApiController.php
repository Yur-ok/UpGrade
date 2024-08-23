<?php

namespace app\controllers\api;

use app\models\Goal;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class GoalApiController extends ActiveController
{
    public $modelClass = Goal::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Добавляем поддержку CORS для работы с запросами с других доменов
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        // Аутентификация по токену
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        // RBAC проверка разрешений
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin', 'user'],
                ],
            ],
        ];

        return $behaviors;
    }

    // Дополнительные действия, такие как завершение цели
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update']); // Если хотите заменить стандартное действие update
        return $actions;
    }

    public function actionComplete($id)
    {
        $goal = $this->findModel($id);
        $goal->completed = true;
        if ($goal->save()) {
            return $goal;
        }

        return ['error' => 'Unable to complete goal'];
    }

    protected function findModel($id)
    {
        return Goal::findOne($id);
    }
}
