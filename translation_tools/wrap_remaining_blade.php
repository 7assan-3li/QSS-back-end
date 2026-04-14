<?php
$files = [
    'resources/views/admin/advertisements/create.blade.php',
    'resources/views/admin/advertisements/edit.blade.php',
    'resources/views/admin/withdrawals/show.blade.php',
    'resources/views/requests/show.blade.php',
    'resources/views/services/edit.blade.php',
    'resources/views/services/show.blade.php',
    'resources/views/settings/index.blade.php',
    'resources/views/requestComplaints/index.blade.php',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Wrap simple phrases in arrays or attributes
    $content = preg_replace("/'لا يوجد'/", "__('لا يوجد')", $content);
    $content = preg_replace("/'خدمة'/", "__('خدمة')", $content);
    $content = preg_replace("/'قسم'/", "__('قسم')", $content);
    $content = preg_replace("/'رابط خارجي'/", "__('رابط خارجي')", $content);
    
    // Wrap common span/text content
    $content = preg_replace("/>\s*نشاط الخدمة\s*</u", ">{{ __('نشاط الخدمة') }}<", $content);
    $content = preg_replace("/>\s*التوافر الفوري\s*</u", ">{{ __('التوافر الفوري') }}<", $content);
    $content = preg_replace("/>\s*التسعير حسب المسافة\s*</u", ">{{ __('التسعير حسب المسافة') }}<", $content);
    $content = preg_replace("/>\s*لا توجد سندات مرفقة\s*</u", ">{{ __('لا توجد سندات مرفقة') }}<", $content);
    
    // Currency symbols
    $content = preg_replace("/ر\.س/u", "{{ __('ر.س') }}", $content);
    
    // Handle the specific withdrawal show text if found
    $old_withdrawal_text = 'بيانات"الآيبان" للمزود بدقة. عند إتمام الحوالة، يجب إرفاق مستند الإثبات المالي الصادر من البنك مع رقم السند المرجعي لإغلاق ملف التسوية بشكل آمن.';
    if (strpos($content, $old_withdrawal_text) !== false) {
        $content = str_replace($old_withdrawal_text, "{{ __('" . $old_withdrawal_text . "') }}", $content);
    }
    
    // Handle the specific request alert if found
    $old_request_alert = '⚠️ تنبيه الإدارة: الضغط على الزر أدناه يعني أن المنصة قد استلمت مبلغ العمولة نقدياً أو بنكياً بشكل نهائي.';
    if (strpos($content, $old_request_alert) !== false) {
        $content = str_replace($old_request_alert, "{{ __('" . $old_request_alert . "') }}", $content);
    }

    file_put_contents($file, $content);
    echo "Updated $file\n";
}
