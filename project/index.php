<?php
session_start();

// Memuat konfigurasi wajib dan helper satu kali (require_once)
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

// Whitelist daftar rute yang diizinkan (Latihan 3 & 4)
$routes = [
    'dashboard'   => __DIR__ . '/views/dashboard.php',
    'profil'      => __DIR__ . '/views/profil.php',
    'kontak'      => __DIR__ . '/views/kontak.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
    'auth/login'  => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',
];

// Ambil parameter URL ?page=... (default ke dashboard)
$page = $_GET['page'] ?? 'dashboard';
if (is_string($page)) {
    $page = trim($page, '/');
    if ($page === '') {
        $page = 'dashboard';
    }
}

// Validasi terhadap whitelist (mencegah path traversal / LFI)
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $contentFile = $routes[$page];
}

// Rute aksi/redirect diproses sebelum output HTML header dikirim
$actionRoutes = ['user/delete', 'auth/logout'];
if (in_array($page, $actionRoutes, true)) {
    require $contentFile;
    exit;
}

// Tangkap buffer konten agar redirect (header Location) di modul add/edit/login tetap aman
ob_start();
require $contentFile;
$pageContent = ob_get_clean();

require_once __DIR__ . '/views/header.php';
echo $pageContent;
require_once __DIR__ . '/views/footer.php';
?>
