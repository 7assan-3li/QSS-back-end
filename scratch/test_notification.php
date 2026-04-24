<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\NotificationService;
use App\Models\DeviceTokens;
use Illuminate\Support\Facades\Log;

$service = app(NotificationService::class);

// Find a token to test with
$tokenData = DeviceTokens::first();

if (!$tokenData) {
    echo "Error: No device tokens found in the database. Please make sure the mobile app has registered at least one device.\n";
    exit(1);
}

echo "Testing notification for User ID: {$tokenData->user_id} with token starting with: " . substr($tokenData->token, 0, 10) . "...\n";

try {
    $result = $service->sendPushNotification($tokenData->token, "Test Title", "This is a test notification from the server logic.");
    
    if ($result) {
        echo "Success! Firebase accepted the notification.\n";
    } else {
        echo "Failed! Check storage/logs/laravel.log for details.\n";
    }
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
