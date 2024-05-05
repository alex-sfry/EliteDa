<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$mail = require __DIR__ . '/mail_config.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'sass' => [
                        'css',
                        'sass --style=compressed {from} {to}',
                    ],
                ],
            ],
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => ['jquery.min.js']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'app\assets\YiiAssetMin' => [
                    'sourcePath' => '@app/assetsMin',
                    'js' => ['yii.js']
                ],
                'yii\web\YiiAsset' => [
                    'sourcePath' => '@app/assetsMin',
                    'js' => [ 'yii.js']
                ],
                'yii\grid\GridViewAsset' => [
                    'sourcePath' => '@app/assetsMin',
                    'js' => ['yii.gridView.js']
                ],
                'yii\captcha\CaptchaAsset' => [
                    'sourcePath' => '@app/assetsMin',
                    'js' => ['yii.captcha.js']
                ],
                'yii\widgets\ActiveFormAsset' => [
                    'sourcePath' => '@app/assetsMin',
                    'js' => ['yii.activeForm.js']
                ],
                'yii\validators\ValidationAsset' => [
                    'sourcePath' => '@app/assetsMin',
                    'js' => ['yii.validation.js']
                ]
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'y6-kI8DCYXsT-N2nIJALHgB291FX8bGO',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
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
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'transport' => $mail,
            // send all mails to a file by default.
            'useFileTransport' => false,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
               'contact' => 'site/contact',
                // 'entry' => 'site/entry',
                'engineers' => 'engineers/index',
                'engineers/details/<id:\w+>' => 'engineers/details',
                'systems/index/<sys:\w+>' => 'systems/index',
                'stations/index/<station:\w+>' => 'stations/index',
                'shipyard-ships' => 'shipyard-ships/index',
                'ship-modules' => 'ship-modules/index',
                'commodities' => 'commodities/index',
                'trade-routes' => 'trade-routes/index',
                'materials' => 'materials/index',
                'material-traders' => 'material-traders/index',
                '<controller>/<action>' =>  '<controller>/<action>',
                '' => 'site/index'
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
        'panels' => [
            'httpclient' => [
                'class' => 'yii\httpclient\debug\HttpClientPanel',
            ],
        ],
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
