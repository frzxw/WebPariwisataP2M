# Web Pariwisata P2M

Sistem manajemen pariwisata berbasis web yang dibangun dengan Laravel 11 untuk mengelola transaksi pembayaran kavling wisata, pelanggan, dan dashboard analytics.

## Tech Stack

**Backend:**
- Laravel 11.31
- PHP 8.2+
- MySQL Database

**Frontend:**
- Vite 6.0.11
- TailwindCSS 3.4.17
- Flowbite 3.1.2
- ApexCharts 3.46.0

**Tools:**
- Composer 2.x
- Node.js 18+
- NPM/Yarn

## Persyaratan Sistem

Pastikan sistem Anda memiliki:

- **PHP 8.2** atau lebih tinggi
- **Composer 2.x**
- **Node.js 18+** dan NPM
- **Git**


## Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/rayplv/WebPariwisataP2M.git
cd WebPariwisataP2M
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Install Dependencies Node.js
```bash
npm install
```

### 4. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Setup Database & Seeding
```bash
php artisan migrate:fresh --seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

### Default Test Accounts
Setelah menjalankan seeder, Anda dapat menggunakan akun berikut untuk testing:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**Regular Users:**
- Generated automatically via factory (10 users)
- Password default: `password` untuk semua user yang di-generate

### Testing Complete Booking Flow

1. **Homepage**: http://127.0.0.1:8000/
   - Lihat lokasi camping yang tersedia
   - Klik "Booking" untuk memulai reservasi

2. **Booking Form**: http://127.0.0.1:8000/booking
   - Pilih tanggal check-in/check-out
   - Pilih jumlah tamu
   - Pilih equipment rental (opsional)
   - Isi informasi kontak
   - Submit booking

3. **Booking Confirmation**: 
   - Setelah submit, akan redirect ke halaman konfirmasi
   - Lihat detail booking dan total pembayaran
   - Klik "Lanjut ke Pembayaran"

4. **Payment Page**:
   - Pilih metode pembayaran (Bank Transfer)
   - Upload bukti pembayaran
   - Submit pembayaran

5. **Account Management**: http://127.0.0.1:8000/account
   - **Profil Saya**: Edit informasi profil, ganti password
   - **Booking Terbaru**: Lihat 5 booking terakhir dengan status
   - **Statistik**: Total booking dan pengeluaran

6. **Transaction History**: http://127.0.0.1:8000/transaction
   - Lihat semua riwayat transaksi
   - Filter berdasarkan status
   - Aksi untuk setiap booking (bayar, lihat detail)


## Deployment

### Production Setup
```bash
# 1. Clone dan setup di server
git clone https://github.com/rayplv/WebPariwisataP2M.git
cd WebPariwisataP2M

# 2. Install dependencies
composer install --no-dev --optimize-autoloader
npm ci --production

# 3. Setup environment
cp .env.example .env
# Edit .env untuk production

# 4. Generate key dan cache
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Setup database
php artisan migrate --force

# 6. Build assets
npm run build

# 7. Set permissions
chmod -R 755 storage bootstrap/cache
```

### Server Requirements
```bash
# Apache/Nginx configuration
# Document root: /path/to/project/public

# PHP configuration
post_max_size = 100M
upload_max_filesize = 100M
max_execution_time = 300
```