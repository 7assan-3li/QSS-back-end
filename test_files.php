<?php
$path = __DIR__ . '/database/migrations/*.php';
echo "Globbing path: $path\n";
$files = glob($path);
echo "Files found: " . count($files) . "\n";
foreach ($files as $file) {
    echo "- " . basename($file) . "\n";
}

$iterator = new RecursiveDirectoryIterator(__DIR__ . '/database/migrations');
$count = 0;
foreach (new RecursiveIteratorIterator($iterator) as $file) {
    if ($file->isFile()) $count++;
}
echo "Iterator found: $count files.\n";
