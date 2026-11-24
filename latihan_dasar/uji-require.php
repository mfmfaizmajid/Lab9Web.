<?php
echo "<h3>Pengujian require</h3>";
echo "Sebelum pemanggilan<br>";
require __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan (berhenti total jika file tidak ditemukan)<br>";
?>
