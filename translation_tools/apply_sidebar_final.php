<?php
$file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($file), true);

$sidebar_updates = [
    "لوحة الإدارة" => "Admin Dashboard",
    "نظرة عامة والتحليل" => "Overview & Analytics",
    "الرئيسية" => "Home",
    "التقارير المالية" => "Financial Reports",
    "طلبات السحب" => "Withdrawal Requests",
    "الإشراف والرقابة" => "Supervision & Control",
    "نزاعات الطلبات" => "Order Disputes",
    "شكاوى النظام" => "System Complaints",
    "سندات العمولات" => "Commission Bonds",
    "إدارة الشركاء والتوثيق" => "Partners & Verification Management",
    "طلبات الشراكة" => "Partnership Requests",
    "توثيق الهوية" => "Identity Verification",
    "قائمة المزودين" => "Providers List",
    "الاشتراكات والمدفوعات" => "Subscriptions & Payments",
    "اشتراكات التوثيق" => "Verification Subscriptions",
    "اشتراكات النقاط" => "Points Subscriptions",
    "إدارة السوق والمستخدمين" => "Market & User Management",
    "إدارة المستخدمين" => "User Management",
    "سجل طلبات الخدمات" => "Service Requests Log",
    "أقسام السوق" => "Market Categories",
    "إدارة الخدمات" => "Service Management",
    "إدارة الإعلانات" => "Ads Management",
    "إعدادات المنصة والتهيئة" => "Platform Settings & Config",
    "باقات النقاط" => "Points Packages",
    "حزم التوثيق" => "Verification Packages",
    "الحسابات البنكية" => "Bank Accounts",
    "إعدادات النظام" => "System Settings",
    "مشرف النظام" => "System Admin",
    "إجمالي الخدمات" => "Total Services",
    "معدل النمو اللحظي: نشط" => "Real-time Growth Rate: Active",
    "أدخل اسم الباقة..." => "Enter package name..."
];

foreach ($sidebar_updates as $ar => $en) {
    if (!isset($existing[$ar]) || $existing[$ar] === $ar) {
        $existing[$ar] = $en;
        echo "Updated sidebar term: $ar => $en\n";
    }
}

file_put_contents($file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Sidebar and additional terms updated successfully.\n";
