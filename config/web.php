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
    'controllerMap' => [
        'sandbox' => 'app\sandbox\SandboxController',
    ],
    // 'language' => 'ru-RU',
    // 'sourceLanguage' => 'en-US',
    'components' => [
        // 'errorHandler' => [
        //     'maxSourceLines' => 20,
        // ],
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
            // 'appendTimestamp' => true,
            // 'linkAssets' => true,
            // 'forceCopy' => YII_ENV_DEV ? true : false,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'app\assets\BootstrapAssetMin' => [
                    'baseUrl' => '@web/templates/',
                    'css' => [YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                    'js' => [YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js']
                ],
                'yii\web\YiiAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => [ 'yii.js']
                ],
                'yii\grid\GridViewAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.gridView.js']
                ],
                'yii\captcha\CaptchaAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.captcha.js']
                ],
                'yii\widgets\ActiveFormAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.activeForm.js']
                ],
                'yii\validators\ValidationAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.validation.js']
                ],
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
                'engineers' => 'engineers/index',
                'engineers/details/<id:\w+>' => 'engineers/details',
                'systems/index/<sys:\w+>' => 'systems/index',
                'stations/details/<id:\w+>/ship-modules/<cat:\w+>' => 'stations/ship-modules',
                'stations/details/<id:\w+>/ship-modules' => 'stations/ship-modules',
                'stations/details/<id:\w+>/market' => 'stations/market',
                'stations/details/<id:\w+>' => 'stations/details',
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
    'container' => [
        'definitions' => [
            'app\sandbox\StationMarket' => [
                'class' => 'app\sandbox\StationMarket',
                // 'property1' => 'value1',
            ],
            'app\models\StationMarket' => [
                'class' => 'app\models\StationMarket',
            ],
            'app\models\ShipMods' => [
                'class' => 'app\models\ShipMods',
            ],
        ],
    ],
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
