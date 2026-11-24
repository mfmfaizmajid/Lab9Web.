<?php
function konversiCelciusKeFahrenheit(float $c): float {
    return ($c * 9 / 5) + 32;
}

function tentukanStatusNilai(float $nilai): string {
    if ($nilai >= 85) return 'A (Sangat Baik)';
    if ($nilai >= 75) return 'B (Baik)';
    if ($nilai >= 60) return 'C (Cukup)';
    if ($nilai >= 50) return 'D (Kurang)';
    return 'E (Tidak Lulus)';
}

function hitungTotal(float $harga, int $jumlah): float {
    return $harga * $jumlah;
}
?>
