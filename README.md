<div align="center">
<h1>Event Management API</h1>
</div>

## Deskripsi Singkat
Event Management API adalah REST API berbasis Laravel untuk mengelola **event**, **kategori**, dan **partisipan** dengan sistem **role-based access control (Admin & User)** serta **JWT Authentication** untuk mengamankan endpoint.

---

## Requirement

Pastikan Anda telah menginstal:

Git (2.51.2 atau lebih baru)
Composer (2.9.1 atau lebih baru)
XAMPP (8.2.12)
PHP (8.1+)

yaml
Copy code

---

## Cara Menjalankan Sistem

### 1. Clone Repository
git clone https://github.com/USERNAME/event-management-api.git
cd event-management-api

shell
Copy code

### 2. Install Dependency
composer install

shell
Copy code

### 3. Setup Environment
Ubah .env.example menjadi .env
Atur konfigurasi database MySQL

css
Copy code

<details>
<summary>Contoh konfigurasi .env</summary>

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_api
DB_USERNAME=root
DB_PASSWORD=

bash
Copy code
</details>

### 4. Generate App Key
php artisan key:generate

shell
Copy code

### 5. Setup JWT Authentication
composer require tymon/jwt-auth
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret

shell
Copy code

### 6. Migration & Seeder
php artisan migrate
php artisan db:seed

shell
Copy code

### 7. Jalankan Server
php artisan serve

markdown
Copy code

---

## Akun Uji Coba

### Admin
- email: `admin@example.com`
- password: `password`
- role: `admin`

### User
- email: `user@example.com`
- password: `password`
- role: `user`

---

## Hak Akses Role

| Fitur | Admin | User |
|------|------|------|
| Login | ✅ | ✅ |
| Lihat Event | ✅ | ✅ |
| Buat Event | ✅ | ❌ |
| Update Event | ✅ | ❌ |
| Hapus Event | ✅ | ❌ |
| Join Event | ❌ | ✅ |
| Lihat Peserta Event | ✅ | ❌ |
| CRUD Kategori | ✅ | ❌ |

---

## Endpoint API

### Authentication
- POST `/api/register`
- POST `/api/login`
- POST `/api/logout`
- GET `/api/me`
- PUT `/api/profile`

### Event
- GET `/api/events`
- GET `/api/events/{id}`
- POST `/api/events` (Admin)
- PUT `/api/events/{id}` (Admin)
- DELETE `/api/events/{id}` (Admin)
- POST `/api/events/{id}/join` (User)
- GET `/api/events/{id}/participants` (Admin)

### Category
- GET `/api/categories`
- POST `/api/categories` (Admin)
- PUT `/api/categories/{id}` (Admin)
- DELETE `/api/categories/{id}` (Admin)

---


## Catatan Penting
- Admin tidak diperbolehkan join event
- User tidak bisa membuat event
- Kategori tidak dapat dihapus jika masih digunakan oleh event
- Semua endpoint dilindungi JWT Authentication

---

## TODO
- [x] JWT Authentication
- [x] Role-based access control
- [x] CRUD Event
- [x] Join Event (User)
- [x] Cek Partisipan Event
- [x] CRUD Category
- [x] Seeder Admin & User
- [ ] Testing Endpoint
- [ ] Postman Collection Publish

---

## Author
Nama Kamu  
Project UAS – Event Management API

---

## License
Free to use for educational purposes
