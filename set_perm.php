<?php

$path = __DIR__;
$paths0777 = [
    '/public_html/assets',
    'runtime'
] ;
$paths = __DIR__ . '/public_html/assets';
$permissions = 0755;
$permissions0777 = 0777;

$excluded = [
    'runtime',
    'public_html/assets',
    'yii',
    '.project',
    'cgi-bin',
    'logs',
    'stats',
    'vendor',
    'public_html/node_modules'
];

// Get all files and directories inside the specified path
$items = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($items as $item) {
    // Skip excluded directories
    $skip = false;
    foreach ($excluded as $exclude) {
        if (strpos($item->getPathname(), $exclude) !== false) {
            $skip = true;
            break;
        }
    }

    // Skip the current folder and excluded folders
    if ($skip || $item->getPathname() === $path) {
        continue;
    }

    // Apply chmod only to directories
    if ($item->isDir()) {
        chmod($item->getPathname(), $permissions);
    }
}

foreach ($paths0777 as $item) {
    chmod($item, $permissions0777);
}

echo "Permissions updated successfully!";
