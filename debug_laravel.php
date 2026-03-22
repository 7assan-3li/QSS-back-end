<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Laravel DB Config ===\n";
echo "Default Connection: " . config('database.default') . "\n";
$conn = \Illuminate\Support\Facades\DB::connection();
echo "Database Name: " . $conn->getDatabaseName() . "\n";
echo "Driver: " . $conn->getDriverName() . "\n";

$pdo = $conn->getPdo();
if ($conn->getDriverName() === 'sqlite') {
    echo "SQLite file path: " . $pdo->sqliteCreateFunction('...', function(){}) . "\n"; // hack to see if it works
} else {
    echo "MySQL Selected DB: " . $pdo->query('SELECT DATABASE()')->fetchColumn() . "\n";
    echo "MySQL Tables:\n";
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    print_r($tables);
}

try {
    echo "Migrations from DB facade:\n";
    print_r(\Illuminate\Support\Facades\DB::table('migrations')->pluck('migration')->toArray());
} catch (Exception $e) {
    echo "ERROR reading migrations: " . $e->getMessage() . "\n";
}
