<?php

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    // comment out the following two lines when deployed to production
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

require __DIR__ . '/../helpers/debug.php';
require __DIR__ . '/../helpers/keep_single_quote.php';

(new yii\web\Application($config))->run();
