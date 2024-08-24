<?php

namespace app\controllers\api;

use app\models\Goal;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class GoalController extends ActiveController
{
    public $modelClass = Goal::class;

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
                    'roles' => ['admin', 'user'],
                ],
            ],
        ];

        return $behaviors;
    }

    // Дополнительные действия
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
