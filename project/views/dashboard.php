<?php
// Ambil statistik ringkas dari database
$totalUser = (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalGaji = (float) $pdo->query("SELECT COALESCE(SUM(gaji_pokok), 0) FROM users")->fetchColumn();
?>
<section>
    <h2>Dashboard Aplikasi Modular</h2>
    <p>Selamat datang, <strong>Mohamad Faiz Majid (312510338)</strong>. Aplikasi ini mengintegrasikan arsitektur modular PHP, whitelist routing, helper functions, dan operasi CRUD database.</p>

    <div class="card-grid">
        <div class="card">
            <h3>Total Pengguna Terdaftar</h3>
            <div class="value"><?= $totalUser ?> Orang</div>
        </div>
        <div class="card">
            <h3>Total Akumulasi Gaji Pokok</h3>
            <div class="value"><?= formatRupiah($totalGaji) ?></div>
        </div>
        <div class="card">
            <h3>Status Akses Sesi</h3>
            <div class="value" style="font-size: 18px;">
                <?= !empty($_SESSION['user_logged_in']) ? 'Terautentikasi (Admin)' : 'Tamu (Read-Only)' ?>
            </div>
        </div>
    </div>

    <div style="margin-top: 18px;">
        <a href="index.php?page=user/list" class="btn btn-primary">Kelola Data Pengguna &rarr;</a>
        <?php if (empty($_SESSION['user_logged_in'])): ?>
            <a href="index.php?page=auth/login" class="btn btn-secondary">Login untuk Tambah/Edit/Hapus Data</a>
        <?php endif; ?>
    </div>
</section>
