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
            'rules' => [
                // Подключение web маршрутов
                'goal' => 'goal/index',
                'reflection' => 'reflection/index',
                'reflection/create' => 'reflection/create',
                // Подключение api маршрутов
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/goal', 'api/task', 'api/auth',],
                    'pluralize' => false,
//                    'prefix' => 'api' // только для урлов ?!
//                    'extraPatterns' => [
//                        'PUT,PATCH goal/update/<id>' => 'api/goal/update',
//                        'POST login' => 'login',
//                        'POST register' => 'register',
//                        'POST logout' => 'logout',
//                        'GET me' => 'me',
//                        'GET test' => 'test',
//                    ],
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
