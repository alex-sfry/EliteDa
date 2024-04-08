<?php

return [
    'accessAddtodb' => [
        'type' => 2,
        'description' => 'Access to AddToDb page',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'accessAddtodb',
        ],
    ],
];
