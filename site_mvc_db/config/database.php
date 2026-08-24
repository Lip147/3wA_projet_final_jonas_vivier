<?php
require_once __DIR__ . '/env.php';

$host = env_value('DB_HOST', 'localhost');
$db   = env_value('DB_NAME', 'mamie_gallery');
$user = env_value('DB_USER', 'root');
$pass = env_value('DB_PASSWORD', '');
$charset = env_value('DB_CHARSET', 'utf8mb4');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erreur DB : " . $e->getMessage());
}
