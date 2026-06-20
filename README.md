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
9. **Kompilasi Aset (Vite Asset Bundler)**:
   Terdapat dua opsi untuk memuat aset CSS/JS (Tailwind):
   * **Opsi A: Mode Kompilasi Permanen (Sangat Direkomendasikan)**
     Kompilasi seluruh aset ke dalam folder `public/build` secara permanen. Setelah langkah ini dijalankan, penguji tidak perlu menjalankan server Vite di background.
     ```bash
     npm run build
     ```
   * **Opsi B: Mode Development (Hot-Reloading)**
     Jalankan server Vite di background jika ingin menguji dengan hot-reloading:
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

## 💡 Catatan

> [!TIP]
> **1. Ukuran Berkas Video Pengujian (PHP Upload Limits)**:
> Secara default, konfigurasi batas maksimal unggahan berkas PHP (`upload_max_filesize` dan `post_max_size`) pada mesin lokal penguji sering kali dibatasi ke `2M` atau `8M`.
> * **Sangat disarankan untuk menguji fitur upload video menggunakan file video berukuran sangat kecil (misal: di bawah 2MB)** agar unggahan berhasil tanpa perlu memodifikasi file `php.ini`.
> * Jika mengunggah berkas melebihi kapasitas `php.ini` Anda, sistem kami telah dilengkapi dengan deteksi error HTTP 413 yang responsif untuk menginfokan error secara bersahabat di antarmuka web beserta langkah solusinya.

