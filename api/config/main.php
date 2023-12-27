<?php
use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    //require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    //require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'response' => [
            'format' =>  Response::FORMAT_JSON,
            'class' => Response::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'signup'=>'site/signup',
                'login'=>'site/login',
                'logout'=>'site/logout',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'comment',
                    'pluralize' => false,
                ],
            ],
        ],
    ],
    'params' => $params,
];
