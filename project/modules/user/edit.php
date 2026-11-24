<?php
// Pembatasan akses (Tantangan Mandiri)
if (empty($_SESSION['user_logged_in'])) {
    setFlashMessage('danger', 'Akses ditolak! Silakan login terlebih dahulu untuk mengubah data pengguna.');
    header('Location: index.php?page=auth/login');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    setFlashMessage('danger', 'ID pengguna tidak valid.');
    header('Location: index.php?page=user/list');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch();

if (!$user) {
    setFlashMessage('danger', 'Data pengguna tidak ditemukan.');
    header('Location: index.php?page=user/list');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? null)) {
        setFlashMessage('danger', 'Token keamanan CSRF tidak valid.');
        header('Location: index.php?page=user/edit&id=' . $id);
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
            $update = $pdo->prepare("UPDATE users SET nama = :nama, email = :email, role = :role, gaji_pokok = :gaji, diskon_persen = :diskon, bio = :bio WHERE id = :id");
            $update->execute([
                ':nama' => $nama,
                ':email' => $email,
                ':role' => $role,
                ':gaji' => $gajiPokok,
                ':diskon' => $diskonPersen,
                ':bio' => $bio,
                ':id' => $id
            ]);
            setFlashMessage('success', 'Data pengguna berhasil diperbarui!');
            header('Location: index.php?page=user/list');
            exit;
        } catch (PDOException $e) {
            setFlashMessage('danger', 'Gagal memperbarui data: Email sudah digunakan.');
        }
    }
}
$csrfToken = generateCsrfToken();
?>
<section style="max-width: 600px;">
    <h2>Edit Data Pengguna</h2>
    <form method="post" action="index.php?page=user/edit&id=<?= (int)$user['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?= e($user['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat Email</label>
            <input type="email" name="email" value="<?= e($user['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value="Administrator" <?= $user['role'] === 'Administrator' ? 'selected' : '' ?>>Administrator</option>
                <option value="Editor" <?= $user['role'] === 'Editor' ? 'selected' : '' ?>>Editor</option>
                <option value="Member" <?= $user['role'] === 'Member' ? 'selected' : '' ?>>Member</option>
            </select>
        </div>
        <div class="form-group">
            <label>Gaji Pokok (Rp)</label>
            <input type="number" name="gaji_pokok" value="<?= (float)$user['gaji_pokok'] ?>" min="0" step="1000" required>
        </div>
        <div class="form-group">
            <label>Persentase Diskon/Tunjangan (%)</label>
            <input type="number" name="diskon_persen" value="<?= (float)$user['diskon_persen'] ?>" min="0" max="100" step="0.5" required>
        </div>
        <div class="form-group">
            <label>Bio Singkat</label>
            <textarea name="bio" rows="3"><?= e((string)$user['bio']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php?page=user/list" class="btn btn-secondary">Batal</a>
    </form>
</section>
