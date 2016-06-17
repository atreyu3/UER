<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config=[ 'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
        'model'=>[
            'class'     => 'yii\gii\generators\model\Generator',
            'templates' => ['myModel' => '@app/templatesgii/model/default']
        ],
        'crud'   => [
            'class'     => 'yii\gii\generators\crud\Generator',
            'templates' => ['mycrud' => '@app/templatesgii/crud/default']
        ]
        ]
    ];


return $config;
