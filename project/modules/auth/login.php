<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === 'admin' && $password === '312510338') {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = 'Mohamad Faiz Majid';
        setFlashMessage('success', 'Login berhasil! Anda sekarang memiliki akses penuh untuk Tambah, Edit, dan Hapus data.');
        header('Location: index.php?page=user/list');
        exit;
    } else {
        setFlashMessage('danger', 'Username atau password salah! Gunakan username: admin dan password: 312510338.');
        header('Location: index.php?page=auth/login');
        exit;
    }
}
?>
<section style="max-width: 440px; margin: 0 auto;">
    <h2>Login Administrator</h2>
    <p>Masuk untuk mengakses fitur modifikasi data CRUD (Tambah, Ubah, Hapus).</p>
    <form method="post" action="index.php?page=auth/login">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="admin" required>
        </div>
        <div class="form-group">
            <label>Password (NIM)</label>
            <input type="password" name="password" value="312510338" required>
        </div>
        <button type="submit" class="btn btn-primary">Masuk</button>
    </form>
</section>
