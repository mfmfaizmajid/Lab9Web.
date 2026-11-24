-- Database Schema untuk Integrasi CRUD Praktikum 9
CREATE DATABASE IF NOT EXISTS db_latihan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_latihan;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role VARCHAR(50) NOT NULL DEFAULT 'Mahasiswa',
    gaji_pokok DECIMAL(12,2) NOT NULL DEFAULT 0,
    diskon_persen DECIMAL(5,2) NOT NULL DEFAULT 0,
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (nama, email, role, gaji_pokok, diskon_persen, bio) VALUES
('Mohamad Faiz Majid', 'faiz.majid@example.com', 'Administrator', 5500000, 10, 'Mahasiswa Teknik Informatika dengan NIM 312510338 yang fokus pada pengembangan web modular.'),
('Rina Kartika', 'rina.kartika@example.com', 'Editor', 4200000, 15, 'Bertanggung jawab mengelola konten digital dan dokumentasi teknis proyek.'),
('Budi Santoso', 'budi.santoso@example.com', 'Member', 3500000, 5, 'Pengguna terdaftar pada sistem informasi manajemen data.');
