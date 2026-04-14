<?php
$file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($file), true);
$untranslated = [];

foreach ($existing as $key => $value) {
    // If key equals value and it contains Arabic characters
    if ($key === $value && preg_match('/[\x{0600}-\x{06FF}]/u', $key)) {
        $untranslated[] = $key;
    }
}

file_put_contents('keys_needing_translation.json', json_encode($untranslated, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Found " . count($untranslated) . " items where Arabic key equals the value.\n";
