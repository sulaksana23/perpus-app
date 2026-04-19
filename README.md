# Perpustakaan Sekolah Digital

Aplikasi web manajemen perpustakaan sekolah berbasis **Laravel 12 + MySQL + Blade + Tailwind CSS** dengan 3 role utama:

- `Guest / Tamu`
- `Member / Anggota`
- `Admin`

Aplikasi ini dirancang untuk kebutuhan **UKK Rekayasa Perangkat Lunak**: modern, rapi, responsive, clean code, dan siap dipresentasikan.

---

## Tech Yang Dipakai

- Laravel 12
- PHP 8.2+
- Blade Template
- Tailwind CSS
- MySQL 8
- Redis
- Docker + Docker Compose
- Spatie Laravel Permission
- ApexCharts
- Chart.js

## Dukung Developer

Jika project ini bermanfaat, bisa support di Trakteer:

- https://trakteer.id/bali_techsolution

---

## 1. Ringkasan Fitur

### Guest / Tamu
- Landing page modern (navbar, hero, tentang, statistik, testimoni, footer).
- Lihat katalog buku.
- Search buku berdasarkan judul/penulis/kode.
- Lihat detail buku, rating, stok, kategori.
- Tombol pinjam akan redirect ke login.

### Member / Anggota
- Register akun anggota.
- Status akun default `pending` dan harus di-approve admin.
- Login setelah akun `active`.
- Dashboard member:
  - profil saya
  - ajukan peminjaman
  - ringkasan transaksi pribadi
  - status pengajuan
  - denda belum dibayar

### Admin
- Dashboard admin lengkap:
  - KPI (anggota, buku, transaksi, pinjaman aktif, pending approval)
  - grafik transaksi bulanan (ApexCharts)
  - distribusi status transaksi (Chart.js)
  - kategori buku terbanyak
  - transaksi terbaru
  - stok buku menipis
  - recent pengajuan akun & pengajuan pinjam
- CRUD Anggota
- CRUD Buku
- CRUD Kategori
- CRUD Transaksi
- CRUD Master Denda
- Approval Pengajuan Akun (approve/reject)
- Approval Pengajuan Peminjaman (approve/reject)
- Proses pengembalian + kalkulasi denda otomatis

---

## 2. Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL 8
- **RBAC/Role**: Spatie Laravel Permission
- **Frontend**: Blade + Tailwind CSS (CDN)
- **Chart**: ApexCharts + Chart.js (CDN)
- **Container**: Docker + Docker Compose
- **Queue**: Redis + worker container

Catatan UI:
- Menggunakan Tailwind via CDN, sehingga **tidak wajib `npm run dev`** untuk menjalankan tampilan utama.

---

## 3. Alur Bisnis Utama

### 3.1 Registrasi & Approval Akun
1. User register sebagai member.
2. Sistem membuat user dengan status:
   - `role = member`
   - `is_approved = false`
   - `status = pending`
3. Data masuk ke menu **Pengajuan Akun** admin.
4. Admin bisa:
   - `Approve` -> status user menjadi `active`
   - `Reject` -> status user menjadi `rejected`
5. Member hanya bisa login jika akun sudah aktif.

### 3.2 Pengajuan Peminjaman
1. Member mengajukan peminjaman buku.
2. Status request = `pending`.
3. Admin review pengajuan:
   - `Approve`:
     - request -> `approved`
     - stok buku berkurang
     - transaksi baru otomatis dibuat status `dipinjam`
   - `Reject`:
     - request -> `rejected`

### 3.3 Pengembalian & Denda Otomatis
Saat admin memproses pengembalian:
- Input kondisi buku: `bagus`, `rusak_ringan`, `rusak_berat`, `hilang`, `telat`
- Sistem hitung:
  - denda telat (berdasarkan per hari)
  - denda kondisi buku (fixed/percentage/full price)
- Semua komponen denda dicatat ke `fine_payments`
- Jika buku tidak hilang, stok dikembalikan (+1)

---

## 4. Struktur Folder Project

```bash
perpus-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docker/
│   └── php/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── docker-compose.yml
├── composer.json
└── README.md
```

---

## 5. Modul & File Penting

### Controllers
- `AuthController` -> login/register/logout/dashboard
- `LandingController` -> halaman guest + katalog + detail buku
- `AccountSubmissionController` -> approval akun
- `BorrowRequestController` -> pengajuan pinjam + approval + return + denda
- `BookController` -> CRUD buku
- `MemberController` -> CRUD anggota
- `TransactionController` -> CRUD transaksi
- `CategoryController` -> CRUD kategori
- `FineController` -> CRUD master denda
- `ProfileController` -> profil member

### Models
- `User`, `Book`, `Category`, `Transaction`, `BorrowRequest`
- `AccountSubmission`, `Fine`, `FinePayment`, `Rating`, `ActivityLog`

### Middleware
- `AdminMiddleware`
- `RoleMiddleware`

### Views
- `resources/views/landing/*` -> halaman tamu
- `resources/views/dashboard.blade.php` -> dashboard admin/member
- `resources/views/books/*`, `members/*`, `transactions/*`, `categories/*`, `fines/*`
- `resources/views/account_submissions/*`
- `resources/views/borrow_requests/*`

---

## 6. Daftar Tabel Database

### Tabel utama
- `users`
- `roles` / `model_has_roles` / `permissions` (Spatie)
- `books`
- `categories`
- `transactions`
- `borrow_requests`
- `account_submissions`
- `fines`
- `fine_payments`
- `ratings`
- `activity_logs`

### Relasi inti
- `books.category_id -> categories.id`
- `borrow_requests.member_id -> users.id`
- `borrow_requests.book_id -> books.id`
- `transactions.member_id -> users.id`
- `transactions.book_id -> books.id`
- `transactions.borrow_request_id -> borrow_requests.id`
- `fine_payments.transaction_id -> transactions.id`
- `fine_payments.fine_id -> fines.id`
- `ratings.member_id -> users.id`
- `ratings.book_id -> books.id`

---

## 7. Route Utama (Web)

### Guest
- `GET /` -> landing page
- `GET /katalog`
- `GET /katalog/{book}`

### Auth
- `GET /login`
- `POST /login`
- `GET /register`
- `POST /register`
- `POST /logout`

### Member (auth)
- `GET /dashboard`
- `GET /profil-saya`
- `PUT /profil-saya`
- `GET /pengajuan-peminjaman/create`
- `POST /pengajuan-peminjaman`

### Admin
- Resource:
  - `/users`
  - `/members`
  - `/books`
  - `/transactions`
  - `/categories`
  - `/fines`
- Approval akun:
  - `GET /pengajuan-akun`
  - `POST /pengajuan-akun/{id}/approve`
  - `POST /pengajuan-akun/{id}/reject`
- Approval pinjam:
  - `GET /pengajuan-peminjaman`
  - `POST /pengajuan-peminjaman/{id}/approve`
  - `POST /pengajuan-peminjaman/{id}/reject`
- Pengembalian:
  - `POST /transaksi/{id}/pengembalian`

---

## 8. Instalasi dan Menjalankan (Docker - Rekomendasi)

### Prasyarat
- Docker
- Docker Compose

### Langkah
```bash
# 1) Clone repo
git clone https://github.com/sulaksana23/perpus-app.git
cd perpus-app

# 2) Jalankan container
docker compose up -d

# 3) Generate app key (jika belum ada)
docker compose exec -T app php artisan key:generate

# 4) Jalankan migration
docker compose exec -T app php artisan migrate --force

# 5) Jalankan seeder
docker compose exec -T app php artisan db:seed --force

# 6) Storage link untuk file upload
docker compose exec -T app php artisan storage:link

# 7) Clear cache (opsional)
docker compose exec -T app php artisan optimize:clear
```

### Akses
- App: `http://localhost:8091`
- MySQL host machine: `127.0.0.1:3315`
- Redis host machine: `127.0.0.1:6398`

---

## 9. Instalasi Non-Docker (Opsional)

### Prasyarat
- PHP 8.2+
- Composer
- MySQL 8+
- Extension PHP umum Laravel (`pdo_mysql`, `mbstring`, `openssl`, dll.)

### Langkah
```bash
composer install
cp .env.example .env
php artisan key:generate

# atur DB_* di .env
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan serve
```

---

## 10. Konfigurasi Environment (Contoh)

```env
APP_NAME="Perpus App"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8091

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=perpus
DB_USERNAME=perpus_user
DB_PASSWORD=perpus_pass

REDIS_HOST=redis
REDIS_PORT=6379
```

Jika non-docker, sesuaikan `DB_HOST` dan `DB_PORT` dengan server lokal.

---

## 11. Seeder dan Akun Default

Seeder utama membuat:
- role `admin` dan `member`
- user admin default
- data member dummy
- kategori dummy
- buku dummy
- master denda
- transaksi dummy
- rating dummy

### Akun default admin
- Email: `admin@example.com`
- Password: `password123`

### Promote user tertentu jadi admin
```bash
docker compose exec -T -e PROMOTE_ADMIN_EMAIL=emailkamu@example.com app php artisan db:seed --class=PromoteUserToAdminSeeder
```

---

## 12. Status dan Enum yang Dipakai

### Status user
- `pending`
- `active`
- `rejected`
- `nonactive` (untuk pengelolaan anggota)

### Status borrow request
- `pending`
- `approved`
- `rejected`

### Status transaksi
- `pending`
- `dipinjam`
- `dikembalikan`
- `ditolak`
- `terlambat`

### Kondisi buku saat pengembalian
- `bagus`
- `rusak_ringan`
- `rusak_berat`
- `hilang`
- `telat`

---

## 13. Master Denda Default

- Buku rusak ringan = `10000`
- Buku rusak berat = `25000`
- Buku hilang = `100%` harga buku (type percentage)
- Telat per hari = `2000`
- Cover sobek = `5000`
- Halaman hilang = `15000`

---

## 14. Query SQL Cepat untuk Monitoring

```sql
-- total anggota
SELECT COUNT(*) AS total_anggota
FROM users u
JOIN model_has_roles mhr ON mhr.model_id = u.id
JOIN roles r ON r.id = mhr.role_id
WHERE r.name = 'member';

-- total buku
SELECT COUNT(*) AS total_buku FROM books;

-- total transaksi
SELECT COUNT(*) AS total_transaksi FROM transactions;

-- pending approval akun
SELECT COUNT(*) AS pending_akun FROM account_submissions WHERE status='pending';

-- pending approval pinjam
SELECT COUNT(*) AS pending_pinjam FROM borrow_requests WHERE status='pending';

-- total denda belum dibayar
SELECT COALESCE(SUM(amount),0) AS total_unpaid_fine
FROM fine_payments
WHERE status='unpaid';
```

---

## 15. Pengujian

```bash
# jalankan test di container
docker compose exec -T app php artisan test
```

Jika ada test gagal karena data local tertentu, jalankan ulang migration fresh di environment testing.

---

## 16. Troubleshooting

### Error: akun member tidak bisa login
- Pastikan user sudah di-approve admin (`is_approved = true`, `status = active`).

### Error: asset gambar tidak tampil
- Jalankan `php artisan storage:link`.
- Pastikan file berada di `storage/app/public`.

### Error: route/cache lama
- Jalankan `php artisan optimize:clear`.

### Error: conflict migration di env baru
- Gunakan:
  - `php artisan migrate:fresh --seed` untuk reset total (hati-hati, menghapus data).

### Error Docker permission
- Pastikan user punya akses ke docker daemon.

---

## 17. Roadmap Pengembangan (Opsional)

- Export PDF transaksi.
- Export Excel buku.
- QR code buku.
- Notifikasi toast + SweetAlert global.
- Realtime search (debounce AJAX).
- Dark mode.
- Audit activity log yang lebih detail per aksi.

---

## 18. Kontribusi

1. Fork repository.
2. Buat branch fitur baru.
3. Commit perubahan.
4. Push branch.
5. Buat Pull Request.

---

## 19. Lisensi

Project ini menggunakan lisensi **MIT**.

---

## 20. Kontak

Jika kamu butuh versi presentasi/UKK (slide + skenario demo), kamu bisa lanjutkan dari repo ini dan menambahkan screenshot per fitur pada README.
