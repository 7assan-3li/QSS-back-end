<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Resetting seeker_policy for all users...\n";
$count = User::query()->update(['seeker_policy' => false]);
echo "Updated $count users.\n";
