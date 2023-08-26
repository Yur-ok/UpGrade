<?php

namespace app\controllers;

use app\models\Country;
use yii\web\Controller;

class CrudController extends Controller
{

    public function actionIndex(): string
    {
        $countries = Country::findAll([]);
        return $this->render('index', compact($countries));
    }
}