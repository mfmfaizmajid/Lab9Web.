<?php
// Pembatasan akses & wajib POST + CSRF (Bagian I & Tantangan Mandiri)
if (empty($_SESSION['user_logged_in'])) {
    setFlashMessage('danger', 'Akses ditolak! Silakan login terlebih dahulu.');
    header('Location: index.php?page=auth/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    setFlashMessage('danger', 'Metode tidak diizinkan. Penghapusan wajib menggunakan metode POST.');
    header('Location: index.php?page=user/list');
    exit;
}

if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
    setFlashMessage('danger', 'Token keamanan CSRF tidak valid.');
    header('Location: index.php?page=user/list');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    setFlashMessage('success', 'Data pengguna berhasil dihapus.');
} else {
    setFlashMessage('danger', 'ID pengguna tidak ditemukan.');
}

header('Location: index.php?page=user/list');
exit;
?>
