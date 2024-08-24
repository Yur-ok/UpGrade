<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function fields()
    {
        $fields = parent::fields();

        // удаляем небезопасные поля
        unset($fields['auth_key'], $fields['password_hash'], $fields['access_token'], $fields['status']);

        return $fields;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Если у вас есть токены доступа
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function generateAuthToken(): void
    {
        $this->auth_token = \Yii::$app->security->generateRandomString();
        $this->save(false); // Сохраняем токен в базе данных
    }

    public function generateAuthKey(): void
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
        $this->save(false); // Сохраняем токен в базе данных
    }

    public function generateAccessToken(): void
    {
        $this->access_token = \Yii::$app->security->generateRandomString();
        $this->save(false); // Сохраняем токен в базе данных
    }

    public function removeAuthToken(): void
    {
        $this->auth_token = null;
        $this->save(false);
    }

    public function removeAccessToken(): void
    {
        $this->access_token = null;
        $this->save(false);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function changePassword($newPassword): bool
    {
        $this->setPassword($newPassword);
        return $this->save(false);
    }

}
