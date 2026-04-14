<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (preg_match_all('/__\(\s*\$[\w\-]+\s*\)/', $content, $m)) {
            echo $file->getPathname() . "\n";
            echo implode(', ', $m[0]) . "\n";
        }
        if (preg_match_all('/__\(\s*\$[\w\-]+\->[\w\-]+\s*\)/', $content, $m2)) {
            echo $file->getPathname() . "\n";
            echo implode(', ', $m2[0]) . "\n";
        }
    }
}
