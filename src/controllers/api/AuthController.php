<?php

namespace app\controllers\api;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\Controller;
use app\models\LoginForm;
use app\models\User;
use yii\web\BadRequestHttpException;

class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя.
     *
     * @return array|User
     * @throws BadRequestHttpException
     */
    public function actionRegister()
    {
        $model = new User();
        $model->load(Yii::$app->request->post(), '');

        if ($model->validate()) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->generateAuthToken();
            if ($model->save()) {
                return $model;
            }

            throw new BadRequestHttpException('Failed to save user.');
        }

        return ['errors' => $model->errors];
    }

    /**
     * Логин пользователя и генерация токена.
     *
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = Yii::$app->user->identity;
            $user->generateAccessToken(); // Генерация токена
            return [
                'access_token' => $user->access_token,
            ];
        }

        return [
            'error' => 'Invalid credentials',
        ];
    }

    /**
     * Логаут пользователя (удаление токена).
     *
     * @return array
     */
    public function actionLogout()
    {
        $user = Yii::$app->user->identity;
        if ($user) {
            $user->removeAccessToken();
            Yii::$app->user->logout();
            return ['message' => 'Logout successful'];
        }

        throw new BadRequestHttpException('No user logged in.');
    }

    /**
     * Получение информации о текущем пользователе.
     *
     * @return User|string[]|\yii\web\IdentityInterface
     */
    public function actionMe()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->statusCode = 401;
            return [
                'status' => 'error',
                'message' => 'User is not authenticated.',
            ];
        }

        return Yii::$app->user->identity;
    }

    public function actionTest()
    {
        return 'test';
    }

}
