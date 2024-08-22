<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;

class RbacController extends Controller
{
    public function actionInit(): void
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;

        // Проверяем наличие разрешения createGoal, если его нет, то создаем
        if (!$auth->getPermission('createGoal')) {
            $createGoal = $auth->createPermission('createGoal');
            $createGoal->description = 'Create a goal';
            $auth->add($createGoal);
        }

        // Проверяем наличие разрешения manageGoal, если его нет, то создаем
        if (!$auth->getPermission('manageGoal')) {
            $manageGoal = $auth->createPermission('manageGoal');
            $manageGoal->description = 'Manage goals';
            $auth->add($manageGoal);
        }

        // Проверяем наличие роли user, если её нет, то создаем
        if (!$auth->getRole('user')) {
            $user = $auth->createRole('user');
            $auth->add($user);
            $auth->addChild($user, $createGoal);
        }

        // Проверяем наличие роли admin, если её нет, то создаем
        $admin = $auth->getRole('admin');
        if (!$admin) {
            $admin = $auth->createRole('admin');
            $auth->add($admin);
            $auth->addChild($admin, $manageGoal);
            $auth->addChild($admin, $user);
        } else {
            $admin = $auth->getRole('admin'); // Получаем объект роли admin, если она уже существует
        }

        // Пытаемся найти пользователя с username 'admin'
        $adminUser = User::findOne(['username' => 'admin']);
        if ($adminUser) {
            // Проверяем, назначена ли уже роль admin этому пользователю
            if (!$auth->getAssignment('admin', $adminUser->id)) {
                $auth->assign($admin, $adminUser->id);
                echo "Role 'admin' has been successfully assigned to user 'admin'.\n";
            } else {
                echo "Role 'admin' is already assigned to user 'admin'.\n";
            }
        } else {
            echo "Administrator user with username 'admin' not found.\n";
        }
    }

    public function actionAssignRole(string $username, string $roleName): void
    {
        $auth = Yii::$app->authManager;
        $user = User::findOne(['username' => $username]);

        if ($user) {
            $role = $auth->getRole($roleName);
            if ($role) {
                $auth->assign($role, $user->id);
                echo "Role '{$roleName}' has been assigned to user '{$username}'.\n";
            } else {
                echo "Role '{$roleName}' does not exist.\n";
            }
        } else {
            echo "User '{$username}' not found.\n";
        }
    }


    public function actionCreateRole(string $roleName): void
    {
        $auth = Yii::$app->authManager;

        // Проверяем наличие роли с таким названием
        if ($auth->getRole($roleName)) {
            echo "Role '{$roleName}' already exists.\n";
            return;
        }

        $role = $auth->createRole($roleName);
        $auth->add($role);
        echo "Role '{$roleName}' has been created.\n";
    }


    public function actionCreatePermission(string $permissionName, string $description = null): void
    {
        $auth = Yii::$app->authManager;

        // Проверяем наличие разрешения с таким названием
        if ($auth->getPermission($permissionName)) {
            echo "Permission '{$permissionName}' already exists.\n";
            return;
        }

        $permission = $auth->createPermission($permissionName);
        $permission->description = $description;
        $auth->add($permission);
        echo "Permission '{$permissionName}' has been created.\n";
    }

    public function actionRenamePermission(string $permissionOldName, string $permissionNewName): void
    {
        $auth = Yii::$app->authManager;

        // Проверяем наличие разрешения с таким названием
        if (!$auth->getPermission($permissionOldName)) {
            echo "Permission '{$permissionOldName}' does not exists.\n";
            return;
        }

        //достаем описание из старого разарешения
        $oldDescription = $auth->getPermission($permissionOldName)->description;

        // удаляем разрешение
        $auth->remove($auth->getPermission($permissionOldName));

        // создаём новое разрешение со старым описанием
        $this->actionCreatePermission($permissionNewName, $oldDescription);
    }


    public function actionAddPermissionToRole(string $roleName, string $permissionName): void
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($roleName);
        $permission = $auth->getPermission($permissionName);

        if (!$role) {
            echo "Role '{$roleName}' does not exist.\n";
            return;
        }

        if (!$permission) {
            echo "Permission '{$permissionName}' does not exist.\n";
            return;
        }

        if ($auth->hasChild($role, $permission)) {
            echo "Role '{$roleName}' already has permission '{$permissionName}'.\n";
            return;
        }

        $auth->addChild($role, $permission);
        echo "Permission '{$permissionName}' has been added to role '{$roleName}'.\n";
    }

    public function actionGetPermissionsByUser(string $username): void
    {
        // Находим пользователя по имени
        $user = User::findOne(['username' => $username]);

        if (!$user) {
            echo "User with username '{$username}' not found.\n";
            return;
        }

        // Получаем все разрешения пользователя
        $permissions = Yii::$app->authManager->getPermissionsByUser($user->id);

        if (empty($permissions)) {
            echo "User '{$username}' has no permissions.\n";
            return;
        }

        // Выводим список разрешений
        echo "User '{$username}' has the following permissions:\n";
        foreach ($permissions as $name => $permission) {
            echo "- {$name}: {$permission->description}\n";
        }
    }

    public function actionListRolesWithPermissions(): void
    {
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRoles();

        if (empty($roles)) {
            echo "No roles found.\n";
            return;
        }

        foreach ($roles as $roleName => $role) {
            echo "Role: {$roleName}\n";
            echo "Permissions:\n";

            $permissions = $authManager->getPermissionsByRole($roleName);
            if (empty($permissions)) {
                echo "  No permissions assigned to this role.\n";
            } else {
                foreach ($permissions as $permissionName => $permission) {
                    echo "  - {$permissionName}: {$permission->description}\n";
                }
            }
            echo "\n";
        }
    }

    public function actionListPermissions(): void
    {
        $authManager = Yii::$app->authManager;
        $permissions = $authManager->getPermissions();

        if (empty($permissions)) {
            echo "No permissions found.\n";
            return;
        }

        echo "List of all permissions:\n";
        foreach ($permissions as $permissionName => $permission) {
            echo "- {$permissionName}: {$permission->description}\n";
        }
    }


}
