<?php

use app\controllers\CountryController;
use app\models\User;
use yii\debug\Module;
use yii\i18n\PhpMessageSource;
use yii\log\FileTarget;
use yii\redis\Cache;
use yii\redis\Connection;
use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    //    'language' => 'ru-RU',
    'language' => 'en-US',
    'bootstrap' => ['log', 'debug'],
    'modules' => [
        'debug' => [
            'class' => Module::class,
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ImRj6tLYu_G-HqAYirtQPpavFAiLv45f',
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@app/translations',
                    'sourceLanguage' => 'ru-RU',
                    //                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'redis' => [
            'class' => Connection::class,
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        'cache' => [
            'class' => Cache::class,
            'defaultDuration' => 86400,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
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
        'log' => [
            'traceLevel' => YII_DEBUG ? 5 : 0,
            'flushInterval' => 100,
            'targets' => [
                'default' => [
                    'class' => FileTarget::class,
                    'maxLogFiles' => 3,
                    'levels' => ['error', 'warning', 'info'],
                    'logFile' => __DIR__ . '/../logs/errorLog',
                    'logVars' => [],
                    'except' => [
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:403',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:500',
                    ],
                ],
                '400' => [
                    'class' => FileTarget::class,
                    'maxLogFiles' => 1,
                    'levels' => ['error'],
                    'logFile' => __DIR__ . '/../logs/400',
                    'logVars' => [],
                    'categories' => ['yii\web\HttpException:400'],
                ],
                '403' => [
                    'class' => FileTarget::class,
                    'maxLogFiles' => 1,
                    'levels' => ['error'],
                    'logFile' => __DIR__ . '/../logs/403',
                    'logVars' => [],
                    'categories' => ['yii\web\HttpException:403'],
                ],
                '404' => [
                    'class' => FileTarget::class,
                    'maxLogFiles' => 1,
                    'levels' => ['error'],
                    'logFile' => __DIR__ . '/../logs/404',
                    'logVars' => [],
                    'categories' => ['yii\web\HttpException:404'],
                ],
                '500' => [
                    'class' => FileTarget::class,
                    'maxLogFiles' => 1,
                    'levels' => ['error'],
                    'logFile' => __DIR__ . '/../logs/500',
                    'logVars' => [],
                    'categories' => ['yii\web\HttpException:500'],
                ],
                'actionTime' => [
                    'class' => FileTarget::class,
                    'levels' => ['trace'],
                    'logFile' => __DIR__ . '/../logs/actionTime',
                    'logVars' => [],
                    'categories' => ['ActionTime']
                ]
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => UrlRule::class, 'controller' => 'country']
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
