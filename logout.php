<?php
session_start();

// Tüm oturum verilerini temizle
$_SESSION = [];

// Eğer varsa oturum çerezini de sil
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Oturumu sonlandır
session_destroy();

// Login sayfasına yönlendir
header('Location: login.php');
exit;
