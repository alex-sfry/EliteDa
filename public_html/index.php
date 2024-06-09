<?php

file_exists(__DIR__ . '/../env.php') && require_once __DIR__ . '/../env.php';

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

require __DIR__ . '/../helpers/debug.php';
require __DIR__ . '/../helpers/keep_single_quote.php';

(new yii\web\Application($config))->run();
