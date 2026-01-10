# API Sistem Manajemen Event dan Pendaftaran Peserta

## 📌 Deskripsi Proyek
Proyek ini merupakan Web Service berbasis RESTful API yang digunakan sebagai backend
untuk sistem manajemen event dan pendaftaran peserta. Sistem ini dirancang untuk
mengelola data event, kategori, peserta, serta pendaftaran event secara terpusat,
terstruktur, dan aman.

Proyek ini dikembangkan sebagai bagian dari tugas **Ujian Akhir Semester (UAS)**
mata kuliah **Pemrograman Web Service**.

---

## 🎯 Tujuan Proyek
- Membangun RESTful API sebagai backend sistem manajemen event
- Mengimplementasikan autentikasi dan otorisasi menggunakan JSON Web Token (JWT)
- Mengelola data event dan pendaftaran peserta secara efisien
- Menerapkan konsep keamanan dan struktur API sesuai standar Web Service

---

## ⚙️ Teknologi yang Digunakan
- PHP 8+
- Laravel Framework
- MySQL
- JSON Web Token (JWT)
- Postman (API Testing & Documentation)
- GitHub (Version Control)

---

## 🚀 Fitur Utama
- Autentikasi pengguna (Register dan Login)
- Manajemen data event (Create, Read, Update, Delete)
- Manajemen kategori event
- Pendaftaran peserta ke event
- Pencatatan log aktivitas sistem
- Response API dalam format JSON

---

## 🧑‍🤝‍🧑 Anggota Kelompok
- **Muhammad Adrian Ansyori** – Ketua Kelompok  
  Tugas:
  - Perancangan arsitektur sistem
  - Implementasi autentikasi pengguna menggunakan JWT
  - Pengelolaan repository GitHub
  - Pengujian endpoint utama

- **Nayla Kanaya** – Anggota  
  Tugas:
  - Perancangan dan implementasi database
  - Pembuatan endpoint CRUD data event
  - Pendaftaran peserta ke event
  - Pencatatan log aktivitas sistem
  - Penyusunan dokumentasi API

---

## 📂 Struktur Project
app/  
├── Http/  
│   └── Controllers/  
├── Models/  
database/  
├── migrations/  
routes/  
├── api.php  
config/  

---

## ▶️ Cara Menjalankan Project
1. Clone repository ini:
git clone https://github.com/muhammadadrianansyori/api-manajemen-event.git


2. Masuk ke folder project:cd api-manajemen-event


3. Install dependency:composer install


4. Salin file environment: cp .env.example .env


5. Atur konfigurasi database pada file `.env`

6. Generate application key: php artisan key:generate

7. Jalankan migrasi database: php artisan migrate

8. Jalankan server: php artisan serve


---

## 🔐 Keamanan
File `.env` tidak disertakan dalam repository GitHub dan telah diamankan
menggunakan `.gitignore` untuk menjaga kerahasiaan konfigurasi sistem.

---

## 📬 Dokumentasi API
Dokumentasi API disediakan menggunakan Postman Collection atau Swagger
untuk memudahkan pengujian dan penggunaan seluruh endpoint yang tersedia.

---

## 📄 Lisensi
Proyek ini dibuat untuk keperluan akademik dan pembelajaran.






