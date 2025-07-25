<?php
// Oturumu başlat (tekrar başlatmaya karşı kontrol var)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/config.php";


// Veritabanı bağlantısı dahil et
require_once __DIR__ . '/db.php';


// Yardımcı fonksiyonlar
require_once __DIR__ . '/functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Giriş kontrolü varsa burada yapılabilir
// if (!isset($_SESSION['login_user_id'])) header("Location: login.php");

$public_pages = ['login.php', 'register.php'];

$current_file = basename($_SERVER['PHP_SELF']);

if (!in_array($current_file, $public_pages)) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}
