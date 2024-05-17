<?php

return [
    'accessAddtodb' => [
        'type' => 2,
        'description' => 'Access to AddToDb page',
    ],
    'accessSandbox' => [
        'type' => 2,
        'description' => 'Access to Sandbox page',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'accessAddtodb',
            'accessSandbox',
        ],
    ],
];
