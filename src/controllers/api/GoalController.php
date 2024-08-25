<?php

namespace app\controllers\api;

use app\models\Goal;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

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
        //        $behaviors['access'] = [
        //            'class' => AccessControl::class,
        //            'rules' => [
        //                [
        //                    'allow' => true,
        //                    'actions' => ['index', 'view'],
        //                    'roles' => ['@'], // Разрешаем просмотр всем авторизованным пользователям
        //                ],
        //                [
        //                    'allow' => true,
        //                    'actions' => ['create', 'update'],
        //                    'roles' => ['@'],
        //                    'matchCallback' => function ($rule, $action) {
        //                        return Yii::$app->user->can('manageGoal');
        //                    },
        //                ],
        //                [
        //                    'allow' => true,
        //                    'actions' => ['delete'],
        //                    'roles' => ['admin'], // Разрешаем удаление и завершение только администраторам
        //                ],
        //                [
        //                    'allow' => false, // Запрещаем все остальные действия
        //                ],
        //            ],
        //        ];

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
