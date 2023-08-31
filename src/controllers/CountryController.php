<?php

namespace app\controllers;

use app\models\Country;
use sizeg\jwt\JwtHttpBearerAuth;
use Yii;
use yii\caching\DbDependency;
use yii\filters\ContentNegotiator;
use yii\filters\PageCache;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\Response;

class CountryController extends ActiveController
{
    public $modelClass = Country::class;

//    public  $cors = [
//        'Origin' => [
//            '*',
//        ],
//        'Access-Control-Request-Method' => [
//            'GET',
//            'POST',
//        ],
//    ];


    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'index',
            ],
        ];
//        $behaviors[] =
//            [
//                'class' => ContentNegotiator::class,
//                'formats' => [
//                    'application/json' => Response::FORMAT_JSON,
//                    'application/xml' => Response::FORMAT_XML,
//                ],
//                'languages' => [
//                    'ru-RU',
//                    'en-US',
//                ],
//            ];
//        $behaviors['pageCache'] = [
//            'class' => PageCache::class,
//            'only' => ['index'],
//            'dependency' => [
//                'class' => DbDependency::class,
//                'sql' => 'SELECT COUNT(*) FROM country',
//            ],
//            'variations' => [
//                Yii::$app->language,
//            ]
//        ];
//        $behaviors['verbs'] = [
//            'class' => VerbFilter::class,
//            'actions' => [
//                'index' => ['get'],
//                'view' => ['get'],
//                'create' => ['get', 'post'],
//                'update' => ['get', 'post'],
//                'delete' => ['post'],
//            ],
//        ];

        return $behaviors;
    }


}