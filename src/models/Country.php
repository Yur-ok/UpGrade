<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property $id
 * @property $code
 * @property $name
 * @property $population
 */
class Country extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['code', 'name', 'population'], 'required'],
        ];
    }

}