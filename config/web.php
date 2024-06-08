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
            'identityClass' => 'app\models\ar\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login']
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
            'enableStrictParsing' => true,
            'rules' => [
               'contact' => 'site/contact',
                'engineers' => 'engineers/index',
                'engineer/<id:\w+>' => 'engineers/details',
                'station/ships/<id:\w+>' => 'stations/ships',
                'station/ship-modules-<cat:\w+>/<id:\w+>' => 'stations/ship-modules',
                'station/ship-modules-hardpoint/<id:\w+>' => 'stations/ship-modules',
                'station/market/<id:\w+>' => 'stations/market',
                'station/<id:\w+>' => 'stations/details',
                'stations' => 'stations/index',
                'system-station/<sys_st:[\w\s\']+>' => 'stations/system-station',
                'system/get/<sys:[\w\s\']+>' => 'systems/system',
                'system/<id:\w+>' => 'systems/details',
                'systems' => 'systems/index',
                'shipyard-ships' => 'shipyard-ships/index',
                'ship-modules' => 'ship-modules/index',
                'commodities' => 'commodities/index',
                'trade-routes' => 'trade-routes/index',
                'materials' => 'materials/index',
                'material-traders' => 'material-traders/index',
                'user/login' => 'user/login',
                'user/logout' => 'user/logout',
                'user/signup' => 'user/signup',
                '<action:(captcha)>'  => 'site/<action>',
                // '<controller>/<action>' =>  '<controller>/<action>',
                '' => 'site/index'
            ],
        ],
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            'app\models\StationMarket' => [
                'class' => 'app\models\StationMarket',
            ],
            'app\models\ShipMods' => [
                'class' => 'app\models\ShipMods',
            ],
            'app\models\ShipyardShips' => [
                'class' => 'app\models\ShipyardShips',
            ],
            'app\models\search\EngineersSearch' => [
                'class' => 'app\models\search\EngineersSearch',
            ]
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
