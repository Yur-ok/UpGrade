<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserRefreshToken extends ActiveRecord
{
    public bool $enableCsrfValidation = false;
}