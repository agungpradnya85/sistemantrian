<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    // set default timezone GMT+8
    'timezone' => 'Asia/Makassar',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'id_ID', //ej. 'es-ES'
            'timeZone' => 'UTC'
        ]
    ],
    'language' => 'id-ID',
];
