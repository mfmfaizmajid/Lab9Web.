<?php
require_once __DIR__ . '/helpers_latihan.php';

echo "<h2>Hasil Pengujian Latihan Function (Bagian E)</h2>";
echo "<ul>";
echo "<li>30°C ke Fahrenheit: <strong>" . konversiCelciusKeFahrenheit(30) . " °F</strong></li>";
echo "<li>Nilai 88 mendapat predikat: <strong>" . tentukanStatusNilai(88) . "</strong></li>";
echo "<li>Total Belanja (3 item @ Rp 45.000): <strong>Rp " . number_format(hitungTotal(45000, 3), 0, ',', '.') . "</strong></li>";
echo "</ul>";
?>
