<?php
// Pembatasan akses (Tantangan Mandiri)
if (empty($_SESSION['user_logged_in'])) {
    setFlashMessage('danger', 'Akses ditolak! Silakan login terlebih dahulu untuk menambah data pengguna.');
    header('Location: index.php?page=auth/login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        setFlashMessage('danger', 'Token keamanan CSRF tidak valid.');
        header('Location: index.php?page=user/add');
        exit;
    }

    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? 'Member');
    $gajiPokok = (float) ($_POST['gaji_pokok'] ?? 0);
    $diskonPersen = (float) ($_POST['diskon_persen'] ?? 0);
    $bio = trim($_POST['bio'] ?? '');

    if ($nama === '' || !validasiEmail($email)) {
        setFlashMessage('danger', 'Nama wajib diisi dan format email harus valid!');
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (nama, email, role, gaji_pokok, diskon_persen, bio) VALUES (:nama, :email, :role, :gaji, :diskon, :bio)");
            $stmt->execute([
                ':nama' => $nama,
                ':email' => $email,
                ':role' => $role,
                ':gaji' => $gajiPokok,
                ':diskon' => $diskonPersen,
                ':bio' => $bio
            ]);
            setFlashMessage('success', 'Data pengguna baru berhasil ditambahkan!');
            header('Location: index.php?page=user/list');
            exit;
        } catch (PDOException $e) {
            setFlashMessage('danger', 'Gagal menyimpan data: Email sudah terdaftar.');
        }
    }
}
$csrfToken = generateCsrfToken();
?>
<section style="max-width: 600px;">
    <h2>Tambah Pengguna Baru</h2>
    <form method="post" action="index.php?page=user/add">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>
        </div>
        <div class="form-group">
            <label>Alamat Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="Administrator">Administrator</option>
                <option value="Editor">Editor</option>
                <option value="Member" selected>Member</option>
            </select>
        </div>
        <div class="form-group">
            <label>Gaji Pokok (Rp)</label>
            <input type="number" name="gaji_pokok" value="3500000" min="0" step="1000" required>
        </div>
        <div class="form-group">
            <label>Persentase Diskon/Tunjangan (%)</label>
            <input type="number" name="diskon_persen" value="10" min="0" max="100" step="0.5" required>
        </div>
        <div class="form-group">
            <label>Bio Singkat</label>
            <textarea name="bio" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
        <a href="index.php?page=user/list" class="btn btn-secondary">Batal</a>
    </form>
</section>
