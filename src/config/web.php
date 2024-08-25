<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3EvwIUw7BAZrNGNjH5OcDPbcKr4OZoC3',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,  // Для стандартных страниц включены сессии
            'loginUrl' => ['site/login'],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // 'defaultRoles' => ['guest'], // Опционально: если хотите задать роли по умолчанию
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        //        'log' => [
        //            'traceLevel' => YII_DEBUG ? 3 : 0,
        //            'targets' => [
        //                [
        //                    'class' => 'yii\log\FileTarget',
        //                    'levels' => ['error', 'warning'],
        //                ],
        //            ],
        //        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 1 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace'],  // Добавлены уровни info и trace
                    'logVars' => [],  // Отключает запись глобальных переменных, чтобы логи были чище
                    'categories' => [
                        'application',
                        'yii\db\*',  // Логи SQL запросов
                        'yii\web\HttpException:*',  // Логи HTTP ошибок
                    ],
                ],
            ],
        ],

        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'enableStrictParsing' => true,
            'rules' => [
                // Подключение web маршрутов
                'goal' => 'goal/index',
                'reflection' => 'reflection/index',
                'reflection/create' => 'reflection/create',
                // Подключение api маршрутов
                'DELETE api/goal/<id:\d+>' => 'api/goal/delete',
                'POST api/goal' => 'api/goal/create',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/goal'],
                    'pluralize' => false,
                    'prefix' => 'api',
//                    'extraPatterns' => [
//                        'GET,HEAD goal' => 'index',
//                        'POST api/goal' => 'create',
//                        'GET,HEAD goal/<id>' => 'view',
//                        'PUT goal/<id>' => 'update',
//                        'DELETE goal/<id>' => 'delete',
//                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/task'],
                    'pluralize' => false,
                    'prefix' => 'api',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/auth'],
                    'pluralize' => false,
                    'prefix' => 'api',
                ],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
