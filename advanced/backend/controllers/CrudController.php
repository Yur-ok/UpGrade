<?php

namespace backend\controllers;

use backend\models\Country;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class CrudController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'read', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['get', 'post'],
                    'read' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $countries = Country::findAll([]);

        return $this->render('index', compact($countries));
    }
    public function actionCreate()
    {
    }

    public function actionRead()
    {
    }

    public function actionUpdate()
    {
    }

    public function actionDelete()
    {
    }

}