<?php

return [
    // 'errorHandler' => [
    //     'maxSourceLines' => 20,
    // ],
    'formatter' => [
        'dateFormat' => 'dd.MM.yyyy',
        'decimalSeparator' => '.',
        'thousandSeparator' => ' '
    ],
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
        'appendTimestamp' => true,
        // 'linkAssets' => true,
        'forceCopy' => YII_DEBUG,
        'bundles' => [
            'yii\web\JqueryAsset' => ['js' => [YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js']],
            'yii\bootstrap5\BootstrapAsset' => [
                'sourcePath' => '@webroot/templates',
                'css' => [YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',],
            ],
            'yii\bootstrap5\BootstrapPluginAsset' => [
                'sourcePath' => '@webroot/templates',
                'js' => [/* YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js', */]
            ],
            'yii\web\YiiAsset' => [
                'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                'js' => ['yii.js']
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
        'cookieValidationKey' => CSFR_VALIDATION_KEY,
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
        'transport' => MAIL_TRANSPORT,
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
    'db' => DB_CONFIG,
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'enableStrictParsing' => true,
        'suffix' => '/',
        'rules' => [
            'rings' => 'rings/index',
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
            // 'user/signup' => 'user/signup',
            // admin dashboard
            'admin-dashboard/allegiance/view' => 'allegiance/view',
            'admin-dashboard/allegiance/update' => 'allegiance/update',
            'admin-dashboard/allegiance/delete' => 'allegiance/delete',
            'admin-dashboard/allegiance/create' => 'allegiance/create',
            'admin-dashboard/allegiance' => 'allegiance/index',
            // =========================================================================
            'admin-dashboard/modules-price-list/view' => 'modules-price-list/view',
            'admin-dashboard/modules-price-list/update' => 'modules-price-list/update',
            'admin-dashboard/modules-price-list/delete' => 'modules-price-list/delete',
            'admin-dashboard/modules-price-list/create' => 'modules-price-list/create',
            'admin-dashboard/modules-price-list' => 'modules-price-list/index',
            // =========================================================================
            'admin-dashboard/ships-price-list/view' => 'ships-price-list/view',
            'admin-dashboard/ships-price-list/update' => 'ships-price-list/update',
            'admin-dashboard/ships-price-list/delete' => 'ships-price-list/delete',
            'admin-dashboard/ships-price-list/create' => 'ships-price-list/create',
            'admin-dashboard/ships-price-list' => 'ships-price-list/index',
            // =========================================================================
            'admin-dashboard/ships-list/view' => 'ships-list/view',
            'admin-dashboard/ships-list/update' => 'ships-list/update',
            'admin-dashboard/ships-list/delete' => 'ships-list/delete',
            'admin-dashboard/ships-list/create' => 'ships-list/create',
            'admin-dashboard/ships-list' => 'ships-list/index',
            // =========================================================================
            'admin-dashboard/ship-modules-list/view' => 'ship-modules-list/view',
            'admin-dashboard/ship-modules-list/update' => 'ship-modules-list/update',
            'admin-dashboard/ship-modules-list/delete' => 'ship-modules-list/delete',
            'admin-dashboard/ship-modules-list/create' => 'ship-modules-list/create',
            'admin-dashboard/ship-modules-list' => 'ship-modules-list/index',
            // =========================================================================
            'admin-dashboard' => 'admin/index',
            '<action:(captcha)>'  => 'site/<action>',
            // '<controller>/<action>' =>  '<controller>/<action>',
            '' => 'site/index'
        ]
    ],
];
