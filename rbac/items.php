<?php

return [
    'accessAddtodb' => [
        'type' => 2,
        'description' => 'Access to AddToDb page',
    ],
    'accessAdmin' => [
        'type' => 2,
        'description' => 'Access to admin pages',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'accessAddtodb',
            'accessAdmin'
        ],
    ],
];
