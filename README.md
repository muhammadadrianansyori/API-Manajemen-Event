# API Sistem Manajemen Event dan Pendaftaran Peserta

## Deskripsi Proyek
Proyek ini merupakan Web Service berbasis RESTful API yang digunakan sebagai backend
untuk sistem manajemen event dan pendaftaran peserta. Sistem ini dirancang untuk
mengelola data event, kategori, peserta, serta pendaftaran event secara terpusat,
terstruktur, dan aman.
Proyek ini dikembangkan sebagai bagian dari tugas **Ujian Akhir Semester (UAS)**
mata kuliah **Pemrograman Web Service**.

## Tujuan Proyek
- Membangun RESTful API sebagai backend sistem manajemen event
- Mengimplementasikan autentikasi dan otorisasi menggunakan JSON Web Token (JWT)
- Mengelola data event dan pendaftaran peserta secara efisien
- Menerapkan konsep keamanan dan struktur API sesuai standar Web Service

## Teknologi yang Digunakan
- PHP 8+
- Laravel Framework
- MySQL
- JSON Web Token (JWT)
- Postman (API Testing & Documentation)
- GitHub (Version Control)


## Fitur Utama
- Autentikasi User: Sistem daftar (Register) dan masuk (Login) yang aman menggunakan token.
- Manajemen Event (CRUD): Kelola data acara secara lengkap (Tambah, Lihat, Ubah, Hapus).
- Hak Akses (Security): Proteksi data agar hanya pengguna sah yang bisa memodifikasi event.
- Validasi Input: Menjamin data yang masuk (seperti tanggal & nama event) sesuai format dan benar.
- RESTful API: Output data dalam format JSON yang siap dikonsumsi oleh aplikasi Android, iOS, atau Web
  
## Anggota Kelompok
- **Muhammad Adrian Ansyori** – Ketua Kelompok  
  Tugas:
  - Perancangan arsitektur sistem
  - Implementasi autentikasi pengguna menggunakan JWT
  - Pengelolaan repository GitHub
  - Pengujian endpoint utama

- **Izza Mahendra** - Anggota
 Tugas:
  - Perancangan dan implementasi database
  - Pembuatan endpoint CRUD data event
  - Pendaftaran peserta ke event
    
- **Nayla Kanaya** – Anggota  
  Tugas:
  - Pencatatan log aktivitas sistem
  - Penyusunan dokumentasi API


## Cara Menjalankan Project
1. Clone repository ini:
    git clone https://github.com/muhammadadrianansyori/api-manajemen-event.git
2. Masuk ke folder project:cd api-manajemen-event
3. Install dependency:composer install
4. Salin file environment: cp .env.example .env
5. Atur konfigurasi database pada file `.env`
6. Generate application key: php artisan key:generate
7. Jalankan migrasi database: php artisan migrate
8. Jalankan server: php artisan serve

##  Keamanan
File `.env` tidak disertakan dalam repository GitHub dan telah diamankan
menggunakan `.gitignore` untuk menjaga kerahasiaan konfigurasi sistem.

##  Dokumentasi API End Point
Dokumentasi End Point API disediakan menggunakan Postman Collection atau Swagger
untuk memudahkan pengujian dan penggunaan seluruh endpoint yang tersedia.
**https://documenter.getpostman.com/view/41409584/2sBXVfjBSv**







