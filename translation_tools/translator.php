<?php
$missing_file = 'missing_translations.json';
$lang_file = 'resources/lang/en.json';

$missing = json_decode(file_get_contents($missing_file), true);
$existing = json_decode(file_get_contents($lang_file), true) ?: [];

function translateBatch($texts) {
    if (empty($texts)) return [];
    
    // Using MyMemory translation API as it supports bulk or is faster for bulk sentences
    // Let's stick to Google Translate but fast
    $translatedList = [];
    foreach($texts as $text) {
        $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=ar&tl=en&dt=t&q=" . urlencode($text);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        $response = curl_exec($ch);
        curl_close($ch);
        
        $res = json_decode($response, true);
        $translated_text = "";
        if (isset($res[0]) && is_array($res[0])) {
            foreach ($res[0] as $r) {
                $translated_text .= $r[0];
            }
        }
        $translatedList[$text] = empty($translated_text) ? $text : $translated_text;
        usleep(100000); // 0.1s
    }
    return $translatedList;
}

// Filter missing that are ALREADY in existing
$toTranslate = [];
foreach ($missing as $key) {
    if (!isset($existing[$key]) && trim($key) !== '') {
        $toTranslate[] = $key;
    }
}

echo "Remaining to translate: " . count($toTranslate) . " items...\n";

$count = 0;
foreach (array_chunk($toTranslate, 30) as $chunk) {
    $results = translateBatch($chunk);
    foreach ($results as $original => $english) {
        $existing[$original] = $english;
        $count++;
        echo "[$count/" . count($toTranslate) . "] $original => $english\n";
    }
    file_put_contents($lang_file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

echo "\nTranslation fully complete! Saved to en.json\n";
