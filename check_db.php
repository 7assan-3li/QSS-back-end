<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'qss_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "TABLES in $db:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }

    if (in_array('migrations', $tables)) {
        echo "\nMIGRATIONS table content:\n";
        $stmt = $pdo->query("SELECT migration FROM migrations");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- " . $row['migration'] . "\n";
        }
    } else {
        echo "\nNo migrations table found.\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
