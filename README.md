# 🍽️ Aplikasi Pemesanan Makanan

Aplikasi web pemesanan tiket konser restoran berbasis Laravel. Pelanggan dapat melihat daftar event, memilih event, dan melakukan pembelian. Admin dapat mengelola daftar event dan memproses pembelian.

---

## 📋 Fitur

### Sisi Pembeli (Publik)
- Melihat daftar event
- Filter menu berdasarkan kategori (Musik, Festival, Seminar)
- Memilih event & mengatur jumlah tiket
- Mengisi nama & email
- Konfirmasi pesanan sebelum checkout
- Melakukan checkout pesanan

### Sisi Admin (Login Diperlukan)
- Login dengan akun admin
- Melihat rekap pesanan yang masuk
- Mengubah status pesanan (Pending → Confirmed → Cancelled)
- CRUD (Tambah, Lihat, Edit, Hapus) data event
- Upload gambar event saat tambah/edit

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| PHP | - | Bahasa pemrograman utama |
| Laravel | - | Framework PHP |
| MySQL | - | Database |
| Tailwind CSS | CDN | Styling tampilan |
| Laravel Breeze | - | Autentikasi (login/register) |

---

## 📦 Persyaratan Sistem

Sebelum instalasi, pastikan sudah terpasang:

- **XAMPP / Laragon** (untuk Apache & MySQL)
- **PHP** versi 8.1 atau lebih baru
- **VS Code** (untuk edit kode)

---

### Langkah Instalasi

1. Clone repository
git clone https://github.com/yyissaa/praserkom_amirah
cd maujajan

2. Install dependency PHP
composer install

3. Install dependency JS
npm install

4. Copy file environment
cp .env.example .env

5. Generate application key
php artisan key:generate

6. Konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_ticket_konser
DB_USERNAME=root
DB_PASSWORD=

7. Jalankan migrasi + seeder
php artisan migrate:fresh --seed

8. Link storage untuk gambar
php artisan storage:link

9. Build aset frontend
npm run build

10. Jalankan server
php artisan serve

Buka di browser: http://127.0.0.1:8000