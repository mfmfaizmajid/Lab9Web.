<?php
// Hitung base URL secara dinamis agar CSS & link tetap berjalan meski menggunakan .htaccess rewrite
$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$baseUrl = ($scriptDir === '' || $scriptDir === '.') ? '' : $scriptDir;
$currentPage = $page ?? 'dashboard';
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Pengguna Modular - Mohamad Faiz Majid</title>
    <link rel="stylesheet" href="<?= e($baseUrl) ?>/assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Sistem Informasi Manajemen Pengguna (PHP Modular)</h1>
        <p>Praktikum 9 Pemrograman Web &mdash; Mohamad Faiz Majid (NIM: 312510338)</p>
    </header>
    <nav>
        <div class="nav-links">
            <a href="index.php?page=dashboard" class="<?= isMenuActive($currentPage, ['dashboard']) ?>">Dashboard</a>
            <a href="index.php?page=user/list" class="<?= isMenuActive($currentPage, ['user/list', 'user/add', 'user/edit']) ?>">Data Pengguna (CRUD)</a>
            <a href="index.php?page=profil" class="<?= isMenuActive($currentPage, ['profil']) ?>">Profil & Demo Helper</a>
            <a href="index.php?page=kontak" class="<?= isMenuActive($currentPage, ['kontak']) ?>">Kontak</a>
        </div>
        <div>
            <?php if (!empty($_SESSION['user_logged_in'])): ?>
                <span style="font-size: 13px; margin-right: 8px;">Halo, <strong><?= e($_SESSION['username'] ?? 'Admin') ?></strong></span>
                <a href="index.php?page=auth/logout" class="btn btn-secondary">Logout</a>
            <?php else: ?>
                <a href="index.php?page=auth/login" class="<?= isMenuActive($currentPage, ['auth/login']) ?>">Login Admin</a>
            <?php endif; ?>
        </div>
    </nav>
    <main>
        <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>">
                <?= e($flash['message']) ?>
            </div>
        <?php endif; ?>
