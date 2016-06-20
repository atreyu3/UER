<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'es', // spanish}
    'modules'=>[
				'gridview' => [
						'class' => '\kartik\grid\Module'
				]
		],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DiCuGjRNPrz42ECBOoLR_AxKjPXY7OAG',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'uersistema@gmail.com',
            'password' => 'S1stemauer',
            'port' => '465',
            'encryption' => 'ssl',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [  // you wrote `urlManager` which must change to 'urlManager'
    			'class' => 'yii\web\UrlManager',
    			'enablePrettyUrl' => true,
    			'showScriptName' => false
    	],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
        'model'=>[
            'class'     => 'yii\gii\generators\model\Generator',
            'templates' => ['mymodel' => '@app/templatesgii/model/default']
        ],
        'crud'   => [
            'class'     => 'yii\gii\generators\crud\Generator',
            'templates' => ['mycrud' => '@app/templatesgii/crud/default']
        ]
        ]
    ];
}

return $config;
