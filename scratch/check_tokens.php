<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DeviceTokens;
use App\Models\User;

$tokenCount = DeviceTokens::count();
echo "Total tokens in database: " . $tokenCount . "\n";

$usersWithTokens = DeviceTokens::distinct('user_id')->count('user_id');
echo "Users with tokens: " . $usersWithTokens . "\n";

$tokens = DeviceTokens::latest()->take(5)->get();
foreach($tokens as $t) {
    echo "User ID: {$t->user_id}, Token: " . substr($t->token, 0, 20) . "...\n";
}
