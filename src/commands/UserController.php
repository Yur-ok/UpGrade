<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionCreateAdmin($username = 'admin', $password = 'admin', $email = 'admin@mail.com'): void
    {
        if (User::findByUsername($username)) {
            return;
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        if ($user->save()) {
            echo "Admin user created successfully.\n";
        } else {
            echo "Error creating admin user.\n";
        }
    }

    public function actionCreateUser($username = 'user', $password = 'user', $email = 'user@mail.com'): void
    {
        if (User::findByUsername($username)) {
            return;
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        if ($user->save()) {
            echo "User '{$username}' has been successfully created.\n";
        } else {
            echo "Failed to create user '{$username}'.\n";
            print_r($user->errors);  // Выводим ошибки валидации, если они есть
        }
    }

    public function actionChangePassword($username, $newPassword): void
    {
        $user = User::findByUsername($username);

        if (!$user) {
            echo "User with username '{$username}' not found.\n";
            return;
        }

        if ($user->changePassword($newPassword)) {
            echo "Password for user '{$username}' has been successfully changed.\n";
        } else {
            echo "Failed to change the password for user '{$username}'.\n";
        }
    }


}
