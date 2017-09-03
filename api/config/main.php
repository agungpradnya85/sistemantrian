<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => true,
            'rules' => [
                'v1/authentications/login' => 'v1/auth/login',
                //'v1/reservations/view' => 'v1/reservasi/show-antrian',
                [
                    'pluralize' => true,
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/clinic',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                ],
                [
                    'pluralize' => true,
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/reservation',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST create' => 'create',
                        'POST cancel-reservation' => 'cancel-reservation',
                    ],
                ],
                [
                    'pluralize' => true,
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/profile',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST change-password' => 'change-password',
                        //'POST update' => 'update',
                    ],
                ],
            ], 
        ]
    ],
    'params' => $params,
];



