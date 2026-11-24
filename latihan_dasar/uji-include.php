<?php
echo "<h3>Pengujian include</h3>";
echo "Sebelum pemanggilan<br>";
include __DIR__ . '/pesan.php';
echo "Sesudah pemanggilan (tetap dieksekusi meskipun file hilang)<br>";
?>
