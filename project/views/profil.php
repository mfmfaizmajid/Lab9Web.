<section>
    <h2>Profil Mahasiswa & Demonstrasi Library Function</h2>
    <p>Halaman ini mendemonstrasikan penggunaan 4 fungsi utama pada <code>helpers/functions.php</code> (Latihan 2):</p>

    <table>
        <tr><th width="240">Nama Mahasiswa</th><td>Mohamad Faiz Majid</td></tr>
        <tr><th>Nomor Induk Mahasiswa (NIM)</th><td>312510338</td></tr>
        <tr><th>Demo <code>formatRupiah(1250000)</code></th><td><?= formatRupiah(1250000) ?></td></tr>
        <tr><th>Demo <code>hitungDiskon(1250000, 15)</code></th><td><?= formatRupiah(hitungDiskon(1250000, 15)) ?> (Diskon 15%)</td></tr>
        <tr><th>Demo <code>validasiEmail()</code></th><td><code>faiz.majid@example.com</code> &rarr; <strong><?= validasiEmail('faiz.majid@example.com') ? 'Valid' : 'Tidak Valid' ?></strong></td></tr>
        <tr><th>Demo <code>ringkasTeks()</code></th><td><?= e(ringkasTeks('Modularisasi memisahkan konfigurasi database, template antarmuka, fungsi bantuan, dan logika modul agar kode mudah dipelihara.', 65)) ?></td></tr>
    </table>
</section>
