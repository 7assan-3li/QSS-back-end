<?php
$file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($file), true);

$updates = [
    "ادمن النظام" => "System Admin",
    "إدارة الشركاء والتوثيق" => "Partners & Verification Management",
    "تأخر تحصيل عمولات" => "Delayed commission collection",
    "يوجد :count طلبات مكتملة منذ أكثر من 7 أيام ولم يتم تحصيل عمولتها بعد." => "There are :count completed orders for more than 7 days that haven't been commissioned yet.",
    "نص سياسة طالب الخدمة" => "Seeker Policy Text",
    "نص سياسة مزود الخدمة" => "Provider Policy Text",
    "الخدمات" => "Services",
    "الاسم" => "Name",
    "عدد الخدمات" => "Number of services",
    "تم إضافة الإعلان بنجاح" => "Ad added successfully",
    "تم تحديث الإعلان بنجاح" => "Ad updated successfully",
    "تم حذف الإعلان بنجاح" => "Ad deleted successfully",
    "تنبيه سيولة نقدية" => "Cash Liquidity Alert",
    "كود الشكوى" => "Complaint Code",
    "اسم الشاكي" => "Complainant Name",
    "محتوى الشكوى" => "Complaint Content",
    "تم تحديث بيانات الخدمة بواسطة المسؤول بنجاح" => "Service data successfully updated by admin",
    "كود البلاغ" => "Report Code",
    "المصدر" => "Source",
    "صاحب البلاغ" => "Report Owner"
];

foreach ($updates as $ar => $en) {
    if (!isset($existing[$ar]) || $existing[$ar] === $ar || $existing[$ar] === 'Addicted to the system') {
        $existing[$ar] = $en;
        echo "Updated: $ar => $en\n";
    }
}

file_put_contents($file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Done updating en.json with corrections.";
