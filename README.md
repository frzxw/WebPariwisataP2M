# Web Pariwisata P2M

Sistem manajemen pariwisata berbasis web yang dibangun dengan Laravel 11 untuk mengelola transaksi pembayaran kavling wisata, pelanggan, dan dashboard analytics.

## 🛠️ Tech Stack

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

## 📋 Persyaratan Sistem

Pastikan sistem Anda memiliki:

- **PHP 8.2** atau lebih tinggi
- **Composer 2.x**
- **Node.js 18+** dan NPM
- **Git**


## 🚀 Instalasi

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
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Setup Database
```bash
# Buat file database (jika belum ada)

# Jalankan migrasi
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

### 6. Jalankan di Terminal Berbeda
```bash
php artisan serve

npm run dev
```

Aplikasi akan berjalan di: `http://localhost:8000`

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