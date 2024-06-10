<?php

$path = __DIR__;
$permissions = 0755;
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

echo "Permissions updated successfully!";
