<?php

/**
 * Possible values for YII_ENV:
 * dev - enable debug panel, use uncompressed assets etc
 * test
 * prod - disable debug panel, use compressed assets etc
 *
 * Possible values for YII_DEBUG:
 * true -enable detailed error's info
 * false -disable detailed error's info
 *
 */

define('YII_DEBUG', true);
define('YII_ENV', 'dev');
define('CSFR_VALIDATION_KEY', 'y6-kI8DCYXsT-N2nIJALHgB291FX8bGO');
define(
    'MAIL_TRANSPORT',
    [
        'scheme' => 'smtps',
        'host' => 'smtp.my_host.com',
        'username' => 'mail@mail.aa',
        'password' => 'password',
        'port' => 465,
    ]
);

if (YII_ENV !== 'dev') {
    define(
        'DB_CONFIG',
        [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=my_db',
            'username' => 'user',
            'password' => 'password',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ]
    );
} else {
    define(
        'DB_CONFIG',
        [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=my_db',
            'username' => 'user',
            'password' => 'password',
            'charset' => 'utf8',

            // Schema cache options (for production environment)
            //'enableSchemaCache' => true,
            //'schemaCacheDuration' => 60,
            //'schemaCache' => 'cache',
        ]
    );
}
