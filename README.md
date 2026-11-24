# Lab9Web.
[README.md](https://github.com/user-attachments/files/35341400/README.md)
# Praktikum 9 Pemrograman Web: PHP Modular (`Lab9Web`)

- **Nama:** Mohamad Faiz Majid
- **NIM:** 312510338
- **Mata Kuliah:** Pemrograman Web
- **Topik:** Modularisasi Program, Function, Template, dan Routing

---

## 1. Tujuan Project
Project ini bertujuan untuk menerapkan konsep **PHP Modular** dengan memisahkan komponen aplikasi ke dalam direktori dan file yang memiliki tanggung jawab spesifik (*Separation of Concerns*), meliputi:
1. Pemisahan konfigurasi koneksi database (`config/database.php`) dengan `require_once`.
2. Pembuatan template antarmuka bersama (`views/header.php` dan `views/footer.php`).
3. Penyusunan pustaka fungsi reusable (`helpers/functions.php`) yang dilengkapi sanitasi output (`htmlspecialchars`) dan proteksi CSRF.
4. Implementasi **Whitelist URL Routing** melalui pintu masuk tunggal (`index.php?page=...`) beserta penanganan halaman `404 Not Found`.
5. Integrasi aplikasi CRUD database ke dalam struktur direktori modular.

---

## 2. Kebutuhan Perangkat
- **Web Server:** Apache (XAMPP / Laragon) dengan modul `mod_rewrite` aktif.
- **PHP:** Versi 8.0 atau lebih baru (ekstensi `pdo_mysql` dan `mbstring` aktif).
- **Database:** MySQL / MariaDB.
- **Editor & Browser:** Visual Studio Code dan Google Chrome / Firefox.

---

## 3. Cara Menjalankan Aplikasi
1. Ekstrak folder `Lab9Web` ke direktori root web server (misalnya `C:\xampp\htdocs\Lab9Web` atau `C:\laragon\www\Lab9Web`).
2. Jalankan service **Apache** dan **MySQL** pada XAMPP/Laragon.
3. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`), buat database baru bernama `db_latihan`, lalu impor file `project/database.sql`.
4. Sesuaikan kredensial database pada `project/config/database.php` jika diperlukan (default: `root` tanpa password).
5. Akses aplikasi melalui browser:
   - **Latihan Dasar (Include/Require & Function):** `http://localhost/Lab9Web/latihan_dasar/uji-function.php`
   - **Latihan 1 (Template Multi-Halaman):** `http://localhost/Lab9Web/latihan_1_template/home.php`
   - **Aplikasi Utama (Router & CRUD Modular):** `http://localhost/Lab9Web/project/index.php`
6. Untuk menguji fitur **Tambah, Edit, dan Hapus Data**, klik menu **Login Admin** dengan kredensial:
   - **Username:** `admin`
   - **Password:** `312510338`

---

## 4. Struktur Direktori
```text
Lab9Web/
├── latihan_dasar/                  # Latihan Bagian C (include/require) & Bagian E (function)
│   ├── pesan.php
│   ├── uji-include.php
│   ├── uji-require.php
│   ├── helpers_latihan.php
│   └── uji-function.php
├── latihan_1_template/             # Latihan 1: Template multi-halaman (Home, Profil, Kontak)
│   ├── header.php
│   ├── footer.php
│   ├── home.php
│   ├── profil.php
│   ├── kontak.php
│   └── style.css
├── project/                        # Latihan 2, 3, 4 & Tantangan Mandiri (Integrasi CRUD Modular)
│   ├── index.php                   # Front Controller & Whitelist Router
│   ├── .htaccess                   # URL Rewrite Apache (opsional clean URL)
│   ├── database.sql                # Skema tabel users & data awal
│   ├── config/
│   │   └── database.php            # Koneksi PDO MySQL terpusat
│   ├── views/
│   │   ├── header.php              # Template header + navigasi aktif + flash message
│   │   ├── footer.php              # Template penutup HTML
│   │   ├── dashboard.php           # Halaman utama ringkasan statistik
│   │   ├── profil.php              # Halaman profil & demo 4 library functions
│   │   ├── kontak.php              # Halaman kontak
│   │   └── 404.php                 # Halaman error jika rute tidak ada di whitelist
│   ├── helpers/
│   │   └── functions.php           # formatRupiah, hitungDiskon, validasiEmail, ringkasTeks, CSRF, Flash
│   ├── modules/
│   │   ├── auth/
│   │   │   ├── login.php           # Autentikasi sesi admin
│   │   │   └── logout.php          # Hapus sesi
│   │   └── user/
│   │       ├── list.php            # Read data pengguna
│   │       ├── add.php             # Create data pengguna (POST + CSRF)
│   │       ├── edit.php            # Update data pengguna (POST + CSRF)
│   │       └── delete.php          # Delete data pengguna (POST + CSRF)
│   └── assets/
│       ├── css/style.css           # Styling antarmuka
│       └── js/app.js               # Konfirmasi penghapusan data
├── screenshots/                    # Dokumentasi screenshot hasil praktikum
│   ├── 1_struktur_direktori_dan_router.png
│   ├── 2_template_dan_demo_function.png
│   ├── 3_routing_404_whitelist.png
│   └── 4_hasil_pengujian_crud.png
└── README.md
```

---

## 5. Daftar Rute Aplikasi (`project/index.php`)
| Parameter `page` | File Tujuan | Keterangan |
| :--- | :--- | :--- |
| `dashboard` (default) | `views/dashboard.php` | Halaman utama ringkasan statistik pengguna |
| `profil` | `views/profil.php` | Profil mahasiswa & demonstrasi 4 helper function |
| `kontak` | `views/kontak.php` | Informasi kontak & repository |
| `user/list` | `modules/user/list.php` | Menampilkan seluruh data pengguna dari database |
| `user/add` | `modules/user/add.php` | Form tambah pengguna baru (wajib login) |
| `user/edit` | `modules/user/edit.php` | Form ubah data pengguna berdasarkan ID (wajib login) |
| `user/delete` | `modules/user/delete.php` | Proses hapus data pengguna via metode POST (wajib login) |
| `auth/login` | `modules/auth/login.php` | Form login administrator |
| `auth/logout` | `modules/auth/logout.php` | Proses keluar dari sesi |
| *(Rute tidak terdaftar)* | `views/404.php` | Mengembalikan HTTP status `404 Not Found` |

---

## 6. Langkah Praktikum & Jawaban Analisis
1. **Pengujian `include` dan `require`:** Membuat `pesan.php`, `uji-include.php`, dan `uji-require.php`. Saat `pesan.php` diubah namanya, `include` hanya memunculkan *Warning* dan tetap menjalankan baris berikutnya, sedangkan `require` memunculkan *Fatal Error* dan menghentikan skrip seketika.
2. **Pembuatan Template Multi-Halaman (`latihan_1_template/`):** Memisahkan bagian atas dokumen ke `header.php` dan penutup ke `footer.php`, lalu memanggilnya pada `home.php`, `profil.php`, dan `kontak.php` menggunakan `require_once __DIR__ . '/header.php'`.
3. **Pembuatan Library Function (`helpers/functions.php`):** Mengimplementasikan `formatRupiah()`, `hitungDiskon()`, `validasiEmail()`, dan `ringkasTeks()` dengan *type declaration* dan nilai kembalian (`return`) yang digunakan ulang pada `views/dashboard.php`, `views/profil.php`, dan `modules/user/list.php`.
4. **Routing Whitelist & Keamanan (`project/index.php`):** Menggunakan array `$routes` sebagai daftar rute resmi agar parameter `$_GET['page']` tidak disisipkan langsung ke `require`, sehingga aman dari serangan *Path Traversal / Local File Inclusion (LFI)*.
5. **Integrasi CRUD Modular & Tantangan Mandiri:** Mengintegrasikan koneksi PDO terpusat, menambahkan penanda *active menu* pada navigasi, *flash message* untuk notifikasi sukses/gagal, proteksi CSRF pada form POST, pembatasan akses login untuk modifikasi data, serta aturan `.htaccess` untuk clean URL.

---

## 7. Kendala yang Ditemukan & Cara Mengatasinya
1. **Kendala Path CSS & Aset Saat URL Di-rewrite (`.htaccess`):**
   - *Penyebab:* Ketika mengakses URL seperti `/project/user/list`, path relatif `assets/css/style.css` dicari browser di dalam `/project/user/assets/...` sehingga tampilan CSS hilang.
   - *Solusi:* Menghitung `$baseUrl` secara dinamis di `views/header.php` menggunakan `dirname($_SERVER['SCRIPT_NAME'])` agar aset selalu dimuat dari root project.
2. **Kendala `Cannot modify header information - headers already sent`:**
   - *Penyebab:* Modul seperti `user/add.php` atau `auth/login.php` melakukan `header('Location: ...')` setelah `views/header.php` mencetak tag HTML.
   - *Solusi:* Menggunakan `ob_start()` dan `ob_get_clean()` di `index.php` untuk mengeksekusi logika modul terlebih dahulu sebelum merender `views/header.php`.
3. **Kendala `Cannot redeclare function`:**
   - *Penyebab:* File helper dipanggil lebih dari satu kali pada file induk dan modul.
   - *Solusi:* Mengganti seluruh pemanggilan file fungsi dan konfigurasi menjadi `require_once __DIR__ . '/...'`.

---

## 8. Dokumentasi Screenshot
- **Struktur Direktori & Kode Router:**
- <img width="1100" height="680" alt="1_struktur_direktori_dan_router" src="https://github.com/user-attachments/assets/c089ee82-e27e-4187-b293-b556775ba555" />
- **Template & Demo Library Function:**
- <img width="1100" height="680" alt="2_template_dan_demo_function" src="https://github.com/user-attachments/assets/b6bccf9f-842d-49c2-b348-5024ffb8bc22" />
- **Pengujian Routing 404 Whitelist:**
- <img width="1100" height="680" alt="3_routing_404_whitelist" src="https://github.com/user-attachments/assets/d852afca-f59f-496d-b286-46070dda49f1" />
- **Hasil Pengujian CRUD Modular:**
- <img width="1100" height="680" alt="4_hasil_pengujian_crud" src="https://github.com/user-attachments/assets/b6d50196-0039-48af-9817-4db75f2808ee" />

