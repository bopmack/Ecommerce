<?php
$DB_HOST = '127.0.0.1';
$DB_PORT = 8889;
$DB_DATABASE = 'shop';
$DB_USERNAME = 'root';
$DB_PASSWORD = 'root';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE;charset=utf8mb4",
        $DB_USERNAME,
        $DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
