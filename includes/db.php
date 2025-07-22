<?php
$host = 'localhost';
$dbName = 'otorezerv';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbName;charset=$charset", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
