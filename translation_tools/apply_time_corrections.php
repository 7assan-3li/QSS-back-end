<?php
$file = 'resources/lang/en.json';
$existing = json_decode(file_get_contents($file), true);

$updates = [
    "الكل" => "All",
    "اليوم" => "Today",
    "الأسبوع" => "Week",
    "الشهر" => "Month",
    "يوم" => "Day",
    "30 يوم" => "30 Days",
    "90 يوم" => "90 Days"
];

foreach ($updates as $ar => $en) {
    $existing[$ar] = $en;
    echo "Updated: $ar => $en\n";
}

file_put_contents($file, json_encode($existing, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Done updating en.json with time periods.";
