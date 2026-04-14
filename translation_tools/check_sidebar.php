<?php
$content = file_get_contents('resources/views/partials/admin/sidebar.blade.php');
preg_match_all('/__\(\s*[\'"](.*?)[\'"]\s*\)/u', $content, $m);
$existing = json_decode(file_get_contents('resources/lang/en.json'), true);
$missing = [];
foreach(array_unique($m[1]) as $ar) {
    if(!isset($existing[$ar])) {
        $missing[] = $ar;
    }
}
file_put_contents('missing_sidebar.json', json_encode($missing, JSON_UNESCAPED_UNICODE));
echo count($missing) . " missing.\n";
