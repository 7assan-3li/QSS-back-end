<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'qss_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Creating 'test_table'...\n";
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_table (id INT PRIMARY KEY)");
    echo "Done.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
