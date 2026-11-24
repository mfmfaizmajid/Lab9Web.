<?php
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
$csrfToken = generateCsrfToken();
?>
<section>
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        <h2>Daftar Pengguna (Integrasi CRUD)</h2>
        <a href="index.php?page=user/add" class="btn btn-primary">+ Tambah Pengguna</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Gaji Pokok</th>
                <th>Potongan Diskon</th>
                <th>Ringkasan Bio</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="8" style="text-align: center;">Belum ada data pengguna.</td></tr>
            <?php else: ?>
                <?php foreach ($users as $i => $row): ?>
                    <?php $nominalDiskon = hitungDiskon((float)$row['gaji_pokok'], (float)$row['diskon_persen']); ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= e($row['nama']) ?></strong></td>
                        <td><?= e($row['email']) ?></td>
                        <td><?= e($row['role']) ?></td>
                        <td><?= formatRupiah((float)$row['gaji_pokok']) ?></td>
                        <td><?= formatRupiah($nominalDiskon) ?> (<?= (float)$row['diskon_persen'] ?>%)</td>
                        <td><?= e(ringkasTeks((string)$row['bio'], 40)) ?></td>
                        <td style="white-space: nowrap;">
                            <a href="index.php?page=user/edit&id=<?= (int)$row['id'] ?>" class="btn btn-warning">Edit</a>
                            <form method="post" action="index.php?page=user/delete" class="form-delete" style="display: inline;">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>
