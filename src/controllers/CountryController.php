<?php

namespace app\controllers;

use app\models\Country;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class CountryController extends Controller
{

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'show', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }


    public function actionIndex(): string
    {
        $query = Country::find();
        $countries = $query->orderBy('name')->all();

        return $this->render('index', compact('countries'));
    }

    public function actionShow($id): string
    {
        $country = Country::findOne(['id' => $id]);

        return $this->render('show', compact('country'));
    }

    public function actionCreate(): string
    {
        $country = new Country();
        if ($country->load(Yii::$app->request->post()) && $country->validate()) {
            $country->save();
            return $this->render('create-done', compact('country'));
        }

        $errors = $country->errors;

        return $this->render('create', compact('country', 'errors'));
    }

    public function actionUpdate(int $id): string
    {
        $country = Country::find()->where(['id' => $id])->one();

        if (Yii::$app->request->isPost) {
            $country->load(Yii::$app->request->post());
            $country->save();
            $this->redirect('index');
        }

        return $this->render('update', compact('country'));
    }

    public function actionDelete(int $id): Response
    {
        Country::deleteAll(['id' => $id]);
        return $this->redirect('index');
    }

}