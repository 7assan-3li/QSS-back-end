<?php
$path = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($path);
$content = preg_replace('/<span class="text">([\x{0600}-\x{06FF}\s_]+)<\/span>/u', '<span class="text">{{ __(\'$1\') }}</span>', $content);
$content = preg_replace('/<input type="submit" class="text" value="([\x{0600}-\x{06FF}\s_]+)">/u', '<input type="submit" class="text" value="{{ __(\'$1\') }}">', $content);
file_put_contents($path, $content);
echo "Updated app.blade.php\n";

$translations = [
    "لوحة التحكم", "التصنيفات", "الخدمات", "البنوك", "المستخدمين", 
    "طلبات مزودي الخدمات", "طلبات الخدمات", "طلبات التوثيق", "باقات التحقق",
    "طلبات اشتراك الباقات", "باقات النقاط", "طلبات شحن النقاط", "طلبات السحب",
    "شكاوى النظام", "بلاغات الطلبات", "إعدادات النظام الديناميكية", "تسجيل خروج",
    // Also include the ones for services/edit
    "نشاط الخدمة", "التوافر الفوري", "التسعير حسب المسافة",
    // verification_packages etc
    "إضافة تصنيف جديد"
];

$lang_file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($lang_file), true);

function translate($text) {
    if (trim($text) === '') return $text;
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
    return empty($translated_text) ? $text : $translated_text;
}

foreach ($translations as $ar) {
    if (!isset($existing[$ar])) {
        $existing[$ar] = translate($ar);
    }
}
file_put_contents($lang_file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Translations added to en.json\n";
