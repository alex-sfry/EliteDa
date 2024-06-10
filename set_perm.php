<?php

$directory = '/home/user/web/elida.space';
$permissions = '755'; // Adjust permissions as needed

// Folders to exclude
$excludedFolders = [
    'runtime',
    'public_html/assets',
    'yii',
    'cgi-bin',
    'logs',
    'stats',
    'vendor',
    'public_html/node_modules',
    '.git'
];

// Shell command with exclusion logic
$command = "find $directory -type d ";

$first = true;

foreach ($excludedFolders as $folder) {
    if ($first) {
        $command .= " -path '!' -prune -o ";
        $first = false;
    } else {
        $command .= " -o -path ";
    }
    $command .= "'$directory/$folder' -prune -o ";
}

$command .= "-exec chmod -c $permissions {} \;";
$output = shell_exec($command);

if ($output) {
    echo "Error changing permissions: $output";
} else {
    echo "Permissions changed successfully for subfolders within $directory 
        (excluding current directory and specified folders)";
}
