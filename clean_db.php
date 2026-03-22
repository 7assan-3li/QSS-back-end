<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db = 'qss_db';
    
    echo "Dropping database...\n";
    $pdo->exec("DROP DATABASE IF EXISTS `$db`");
    
    echo "Creating database...\n";
    $pdo->exec("CREATE DATABASE `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "Database cleanly dropped and recreated.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
