<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    // set default timezone GMT+8
    'timezone' => 'Asia/Makassar',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'language' => 'id-ID',
];
