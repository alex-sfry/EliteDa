<?php

use yii\db\Expression;

return [
    'user1' => [
        'id' => 2,
        'username' => 'user1',
        'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
        'password_reset_token' => 'reset_token01',
        'verification_token' => 'verification_token01',
        'email' => 'user1@example.com',
        'access_token' => 'access_token01',
        'auth_key' => 'test100key',
        'status' => 10,
        'created_at' => new Expression('NOW()'),
        'updated_at' => new Expression('NOW()'),
    ],
    'user2' => [
        'id' => 3,
        'username' => 'user2',
        'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
        'password_reset_token' => 'reset_token02',
        'verification_token' => 'verification_token02',
        'email' => 'user2@example.com',
        'access_token' => 'access_token02',
        'auth_key' => 'test100key',
        'status' => 10,
        'created_at' => new Expression('NOW()'),
        'updated_at' => new Expression('NOW()'),
    ],
    'user3' => [
        'id' => 4,
        'username' => 'user3',
        'password_hash' => Yii::$app->security->generatePasswordHash('123456'),
        'password_reset_token' => 'reset_token03',
        'verification_token' => 'verification_token03',
        'email' => 'user3@example.com',
        'access_token' => 'access_token03',
        'auth_key' => Yii::$app->security->generateRandomString(),
        'status' => 10,
        'created_at' => new Expression('NOW()'),
        'updated_at' => new Expression('NOW()'),
    ]

];
