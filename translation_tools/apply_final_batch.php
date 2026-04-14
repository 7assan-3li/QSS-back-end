<?php
$file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($file), true);

$final_batch = [
    "لا يوجد" => "None",
    "خدمة" => "Service",
    "قسم" => "Category",
    "رابط خارجي" => "External Link",
    "نشاط الخدمة" => "Service Activity",
    "التوافر الفوري" => "Immediate Availability",
    "التسعير حسب المسافة" => "Pricing by Distance",
    "لا توجد سندات مرفقة" => "No attached bonds",
    "ر.س" => "YER",
    'بيانات"الآيبان" للمزود بدقة. عند إتمام الحوالة، يجب إرفاق مستند الإثبات المالي الصادر من البنك مع رقم السند المرجعي لإغلاق ملف التسوية بشكل آمن.' => "Provide the provider's IBAN accurately. Upon completing the transfer, the financial proof document issued by the bank must be attached with the reference bond number to securely close the settlement file.",
    '⚠️ تنبيه الإدارة: الضغط على الزر أدناه يعني أن المنصة قد استلمت مبلغ العمولة نقدياً أو بنكياً بشكل نهائي.' => "⚠️ Admin Alert: Clicking the button below means the platform has officially received the commission amount in cash or via bank.",
    "إضافة تصنيف جديد" => "Add New Category",
    "حالة النظام" => "System Status",
    "نشط" => "Active",
    "لوحة التحكم" => "Dashboard",
    "غير موجود" => "Not found",
    "غير محدد" => "Not specified",
    "يوم" => "Day"
];

foreach ($final_batch as $ar => $en) {
    $existing[$ar] = $en;
}

file_put_contents($file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Final dictionary batch updated.\n";
