<?php
$file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($file), true);

$updates = [
    "لوحة التحكم" => "Dashboard",
    "التصنيفات" => "Categories",
    "الخدمات" => "Services",
    "البنوك" => "Banks",
    "المستخدمين" => "Users",
    "طلبات مزودي الخدمات" => "Provider Requests",
    "طلبات الخدمات" => "Service Requests",
    "طلبات التوثيق" => "Verification Requests",
    "باقات التحقق" => "Verification Packages",
    "طلبات اشتراك الباقات" => "Package Subscriptions",
    "باقات النقاط" => "Points Packages",
    "طلبات شحن النقاط" => "Points Top-up Requests",
    "طلبات السحب" => "Withdrawal Requests",
    "شكاوى النظام" => "System Complaints",
    "بلاغات الطلبات" => "Order Reports",
    "إعدادات النظام الديناميكية" => "Dynamic System Settings",
    "تسجيل خروج" => "Logout",
    "مرحباً" => "Hello",
    "شكراً لتسجيلك في تطبيق QSS." => "Thank you for registering in the QSS app.",
    "لتأكيد بريدك الإلكتروني، يرجى استخدام رمز التحقق التالي:" => "To confirm your email, please use the following verification code:",
    "الرمز صالح لمدة 10 دقائق." => "The code is valid for 10 minutes.",
    "إذا لم تطلب هذا الرمز، يمكنك تجاهل هذه الرسالة." => "If you did not request this code, you can ignore this message.",
    "مع تحياتنا 🌟" => "Best regards 🌟",
    "فريق QSS" => "QSS Team",
    "تأكيد البريد الإلكتروني" => "Email Verification",
    "تنبيه الإدارة: الضغط على الزر أدناه يعني أن المنصة قد استلمت مبلغ العمولة نقدياً أو بنكياً بشكل نهائي." => "Admin Alert: Clicking the button below means the platform has received the commission amount in cash or safely via bank.",
    "لا توجد سندات مرفقة" => "No attached bonds",
    "صلاحيات التزويد اللوجستي." => "Logistics Supply Permissions.",
    "معالج التدقيق الإداري" => "Audit Processing Admin",
    "ارتباط برمجي" => "System Link",
    "غير موجود" => "Not found",
    "غير محدد" => "Not specified",
    "مشرف النظام" => "System Admin",
    "عرض شامل لجميع سندات دفع العمولات المقدمة من المزودين." => "Comprehensive display of all commission payment bonds submitted by providers.",
    "تحليل وتيرة الواردات اليومية" => "Analyze the daily rate of incoming",
    "نشاط الخدمة" => "Service Activity",
    "التوافر الفوري" => "Immediate Availability",
    "التسعير حسب المسافة" => "Pricing by Distance",
    "حالة النظام" => "System Status"
];

foreach ($updates as $ar => $en) {
    $existing[$ar] = $en;
}

file_put_contents($file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Done updating en.json with all missing sidebar and email words.\n";
