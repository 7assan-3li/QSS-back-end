<?php

$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('resources/views'));
$matches = [];
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        preg_match_all('/__\(\s*\'(.*?)\'\s*\)/u', $content, $m);
        $matches = array_merge($matches, $m[1]);
        preg_match_all('/__\(\s*"(.*?)"\s*\)/u', $content, $m2);
        $matches = array_merge($matches, $m2[1]);
    }
}

$unique_keys = array_unique($matches);

$lang_file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($lang_file), true) ?: [];

$missing = [];
foreach ($unique_keys as $key) {
    if (!isset($existing[$key])) {
        $missing[] = $key;
    }
}

echo "Total unique keys in views: " . count($unique_keys) . "\n";
echo "Existing keys in en.json: " . count($existing) . "\n";
echo "Missing keys to add: " . count($missing) . "\n";

file_put_contents('missing_translations.json', json_encode($missing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Missing keys written to missing_translations.json\n";
