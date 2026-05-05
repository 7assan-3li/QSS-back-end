<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking Policy Status for all users...\n";

$usersWithSeekerPolicyTrue = User::where('seeker_policy', true)->count();
$usersWithSeekerPolicyFalse = User::where('seeker_policy', false)->count();

$usersWithProviderPolicyTrue = User::where('provider_policy', true)->count();
$usersWithProviderPolicyFalse = User::where('provider_policy', false)->count();

echo "Seeker Policy distribution:\n";
echo "- True: $usersWithSeekerPolicyTrue\n";
echo "- False: $usersWithSeekerPolicyFalse\n";

echo "Provider Policy distribution:\n";
echo "- True: $usersWithProviderPolicyTrue\n";
echo "- False: $usersWithProviderPolicyFalse\n";

$rolesSeekerTrue = User::where('seeker_policy', true)->select('role', DB::raw('count(*) as count'))->groupBy('role')->get();
echo "Roles with Seeker Policy = true:\n";
foreach($rolesSeekerTrue as $r) echo "- {$r->role}: {$r->count}\n";

$rolesProviderTrue = User::where('provider_policy', true)->select('role', DB::raw('count(*) as count'))->groupBy('role')->get();
echo "Roles with Provider Policy = true:\n";
foreach($rolesProviderTrue as $r) echo "- {$r->role}: {$r->count}\n";
