# Perpustakaan Sekolah Digital

Aplikasi web perpustakaan sekolah berbasis **Laravel 12 + MySQL + Blade + Tailwind CSS**.

## Role Pengguna
- Guest / Tamu
- Member / Anggota
- Admin

## Fitur Utama
- Landing page modern: hero, statistik, kategori, preview buku terbaru/populer, testimoni.
- Login, register, logout.
- Registrasi member dengan status `pending` (harus approval admin).
- Dashboard admin dengan statistik + chart (ApexCharts & Chart.js).
- CRUD Anggota, Buku, Kategori, Transaksi, dan Master Denda.
- Approval pengajuan akun dan pengajuan peminjaman.
- Pengembalian buku dengan kalkulasi denda otomatis.

## Struktur Project (Ringkas)
- `app/Http/Controllers`
- `app/Models`
- `database/migrations`
- `database/seeders`
- `resources/views`
- `routes/web.php`

## Tabel Database
- `users`
- `roles` (Spatie Permission)
- `books`
- `categories`
- `transactions`
- `borrow_requests`
- `account_submissions`
- `fines`
- `fine_payments`
- `ratings`
- `activity_logs`

## Menjalankan via Docker
```bash
docker compose up -d
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan db:seed --force
```

## Promote User Menjadi Admin
```bash
docker compose exec -T -e PROMOTE_ADMIN_EMAIL=emailkamu@example.com app php artisan db:seed --class=PromoteUserToAdminSeeder
```

## Akses Aplikasi
- `http://localhost:8091`

## Catatan
- Guest hanya lihat katalog/detail buku.
- Klik "Pinjam" saat belum login akan diarahkan ke halaman login.
- Member baru wajib menunggu approval admin.
