<?php

namespace app\controllers;

use app\models\Country;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class CrudController extends Controller
{

    public function actionIndex(): string
    {
        $query = Country::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
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
}