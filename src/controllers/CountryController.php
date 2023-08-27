<?php

namespace app\controllers;

use app\models\Country;
use Yii;
use yii\caching\DbDependency;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\PageCache;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class CountryController extends ActiveController
{
    public $modelClass = Country::class;

    public array $cors = [
        'Origin' => [
            '*',
        ],
        'Access-Control-Request-Method' => [
            'GET',
            'POST',
        ],
    ];


    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
                'languages' => [
                    'ru-RU',
                    'en-US',
                ],
            ],
            'pageCache' => [
                'class' => PageCache::class,
                'only' => ['index'],
                'dependency' => [
                    'class' => DbDependency::class,
                    'sql' => 'SELECT COUNT(*) FROM country',
                ],
                'variations' => [
                    Yii::$app->language,
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index'  => ['get'],
                    'view'   => ['get'],
                    'create' => ['get', 'post'],
                    'update' => ['get', 'post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }


}