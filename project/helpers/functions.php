<?php
// helpers/functions.php

/**
 * Escaping output HTML untuk mencegah XSS
 */
function e(string $nilai): string {
    return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
}

/**
 * Latihan 2.1: Format angka ke mata uang Rupiah
 */
function formatRupiah(float $angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/**
 * Latihan 2.2: Hitung nominal diskon
 */
function hitungDiskon(float $harga, float $persen = 10): float {
    if ($persen < 0) $persen = 0;
    if ($persen > 100) $persen = 100;
    return $harga * ($persen / 100);
}

/**
 * Latihan 2.3: Validasi format alamat email
 */
function validasiEmail(string $email): bool {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Latihan 2.4: Meringkas teks panjang dengan batas karakter tertentu
 */
function ringkasTeks(string $teks, int $batas = 60): string {
    $teksBersih = trim(strip_tags($teks));
    if (mb_strlen($teksBersih) <= $batas) {
        return $teksBersih;
    }
    return mb_substr($teksBersih, 0, $batas) . '...';
}

/**
 * Tantangan Mandiri: Helper active navigation berdasarkan rute aktif
 */
function isMenuActive(string $currentPage, array $targetRoutes): string {
    return in_array($currentPage, $targetRoutes, true) ? 'active' : '';
}

/**
 * Tantangan Mandiri: Flash Message (Pesan Sukses & Gagal)
 */
function setFlashMessage(string $type, string $message): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash_message'] = [
        'type' => $type, // 'success' atau 'danger'
        'message' => $message
    ];
}

function getFlashMessage(): ?array {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $msg;
    }
    return null;
}

/**
 * CSRF Token sederhana untuk keamanan form POST
 */
function generateCsrfToken(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(?string $token): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && is_string($token) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
