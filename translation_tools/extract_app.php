<?php
$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app'));
$matches = [];
foreach ($dir as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        preg_match_all('/__\(\s*\'(.*?)\'\s*\)/u', file_get_contents($file->getPathname()), $m);
        $matches = array_merge($matches, $m[1]);
        preg_match_all('/__\(\s*"(.*?)"\s*\)/u', file_get_contents($file->getPathname()), $m2);
        $matches = array_merge($matches, $m2[1]);
    }
}
$existing = json_decode(file_get_contents('resources/lang/en.json'), true);
$missing = [];
foreach(array_unique($matches) as $req) {
    if (!isset($existing[$req])) {
        $missing[] = $req;
    }
}
file_put_contents('missing_app_translations.json', json_encode($missing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Found " . count($missing) . " missing translations in app directory.\n";
