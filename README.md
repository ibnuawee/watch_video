# Sistem Perizinan Menonton Video (Laravel)

Sistem Perizinan Menonton Video adalah aplikasi web berbasis Laravel yang dirancang untuk membatasi dan mengelola hak akses customer terhadap video yang di-upload langsung oleh admin. Customer dapat mengajukan permintaan perizinan menonton video tertentu, dan admin dapat menyetujui request tersebut dengan durasi waktu akses yang ditentukan.

Aplikasi ini dibangun menggunakan konsep **Clean Architecture** dengan menerapkan **Repository Pattern** untuk memisahkan logika database dari Controller sehingga kode tetap bersih, modular, dan mudah di-maintain.

---

## Fitur Utama

### Fitur Admin Area
* **Dashboard Statistik**: Menampilkan ringkasan total customer, kategori, video, status request perizinan (pending, approved, rejected), dan daftar request terbaru.
* **CRUD Customer**: Mengelola data customer (nama, email, password, no. telepon, alamat) dengan *soft delete*.
* **CRUD Kategori Video**: Mengelompokkan video ke dalam kategori-kategori (otomatis generate slug).
* **CRUD Video (Upload Lokal)**: Mengunggah file video (MP4, MOV, AVI, MKV) dan thumbnail cover langsung ke penyimpanan server lokal.
* **Manajemen Perizinan (Access Requests)**:
  * Menyetujui request perizinan dengan durasi waktu akses kustom (`access_start_at` dan `access_end_at`).
  * Menolak request perizinan.

### Fitur Customer Area
* **Dashboard Statistik**: Memantau ringkasan video tersedia, request pending, akses aktif, dan akses kedaluwarsa.
* **Explore Videos**: Melihat daftar seluruh video beserta status akses terkini.
* **Detail & Request Akses**: Melihat detail deskripsi materi video, dan mengajukan/mengajukan ulang izin akses.
* **Watch Video & Live Countdown**: Menonton video secara instan melalui pemutar media interaktif HTML5 dengan tampilan hitung mundur sisa waktu akses secara real-time.
* **Riwayat Request**: Melacak riwayat pengajuan akses video beserta filter status.

---

## Desain & Arsitektur (Repository Pattern)

Aplikasi ini menggunakan **Repository Pattern** untuk menjaga controller tetap bersih (*clean controllers*). Semua logika interaksi dengan model Eloquent diletakkan dalam direktori repositori:

```text
app/Repositories
├── Contracts
│   ├── CustomerRepositoryInterface.php
│   ├── VideoCategoryRepositoryInterface.php
│   ├── VideoRepositoryInterface.php
│   └── VideoAccessRequestRepositoryInterface.php
└── Eloquent
    ├── CustomerRepository.php
    ├── VideoCategoryRepository.php
    ├── VideoRepository.php
    └── VideoAccessRequestRepository.php
```

Setiap interface dideklarasikan dan di-bind ke kelas Eloquent konkret di dalam [AppServiceProvider](file:///Users/mac/Ibnu/projek/test_web/watch_video/app/Providers/AppServiceProvider.php). Pengontrol (*Controllers*) menggunakan Dependency Injection untuk mengakses data.

---

##  Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project ini secara lokal:

1. **Clone repositori** ke komputer Anda.
2. **Instal dependensi PHP** menggunakan Composer:
   ```bash
   composer install
   ```
3. **Instal dependensi Javascript** menggunakan NPM:
   ```bash
   npm install
   ```
4. **Salin file konfigurasi lingkungan**:
   ```bash
   cp .env.example .env
   ```
5. **Konfigurasikan database** di dalam file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_mysql_anda
   DB_PASSWORD=password_mysql_anda
   ```
6. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
7. **Jalankan Migrasi & Seeding**:
   ```bash
   php artisan migrate:fresh --seed
   ```
8. **Hubungkan direktori storage**:
   ```bash
   php artisan storage:link
   ```
9. **Jalankan Vite (Assets Bundler)**:
   ```bash
   npm run dev
   ```
10. **Jalankan server lokal Laravel**:
    ```bash
    php artisan serve
    ```

---

## 🔑 Akun Demo Pengujian

Setelah menjalankan seeder, Anda dapat menggunakan akun di bawah ini untuk pengujian:

### 👨‍💼 Akun Admin
* **Email**: `admin@mail.com`
* **Password**: `password`
* **Role**: Admin

### 👥 Akun Customer
* **Email**: `customer@mail.com`
* **Password**: `password`
* **Role**: Customer

---

## 💡 Catatan untuk Penguji
> [!TIP]
> **Ukuran Berkas Video Pengujian**:
> Karena konfigurasi batas maksimal upload default PHP (`upload_max_filesize`) di komputer penguji biasanya diatur sangat kecil (default `2M` atau `10M`), **sangat disarankan untuk melakukan pengujian upload dengan file video berukuran kecil (di bawah 2MB)**.
>
> Hal ini dilakukan agar penguji tidak perlu repot-repot mengubah konfigurasi `php.ini` lokal mereka secara manual hanya untuk melihat fungsionalitas dan jalannya progress bar unggahan.

