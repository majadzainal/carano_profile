# Panduan Deployment ke Shared Hosting (cPanel) — PT. CARANO UTAMA LOGISTIK

Website ini dibangun dengan **Laravel + Inertia.js + Vue 3 + Tailwind CSS**, dan sudah dirancang khusus agar berjalan mulus di **Shared Hosting biasa (tanpa Node.js di server)**.

---

## 1. Persiapan di Komputer Lokal Sebelum Upload

Jalankan perintah berikut di folder proyek `c:\wamp64\www\carano_profile`:

```powershell
# 1. Compile seluruh aset Vue 3 & Tailwind CSS menjadi file statis di public/build/
npm run build

# 2. Optimasi dependency PHP untuk produksi (opsional sebelum ZIP)
composer install --optimize-autoloader --no-dev
```

> Setelah `npm run build`, semua file frontend sudah terkompilasi rapi di `public/build/`. Anda **tidak perlu** mengunggah folder `node_modules/`.

---

## 2. Pengaturan Database MySQL di cPanel

1. Buka **cPanel → MySQL® Databases**.
2. Buat database baru (misalnya `u12345_carano_utama_db`) dan user MySQL beserta password kuat, lalu hubungkan (*Add User To Database* → *All Privileges*).
3. Export database lokal `carano_utama_db` melalui **phpMyAdmin** WAMP lokal menjadi file `.sql`, lalu **Import** ke database cPanel melalui phpMyAdmin hosting (atau jalankan `php artisan migrate --seed` bila hosting menyediakan Terminal/SSH).

---

## 3. Struktur Upload Aman di Shared Hosting

Agar file `.env` dan kode inti Laravel terlindungi dari akses publik:

1. Buat folder baru di root akun hosting (sejajar dengan `public_html`, **bukan** di dalamnya), misal:
   ```text
   /home/username_hosting/carano_core/
   ```
2. Upload seluruh isi proyek **KECUALI** `public/`, `node_modules/`, `.git/`, dan `Logo Carano/` ke dalam `/home/username_hosting/carano_core/`.
3. Upload **seluruh isi folder `public/`** (termasuk `build/`, `images/`, `uploads/`, `index.php`, `favicon.ico`, `.htaccess`) ke dalam:
   ```text
   /home/username_hosting/public_html/
   ```
4. Edit file `/home/username_hosting/public_html/index.php` dan ubah 3 path relatif menuju `../carano_core/`:

```php
if (file_exists($maintenance = __DIR__.'/../carano_core/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../carano_core/vendor/autoload.php';

$app = require_once __DIR__.'/../carano_core/bootstrap/app.php';
```

5. Pastikan permission folder `carano_core/storage`, `carano_core/bootstrap/cache`, dan `public_html/uploads` adalah `775` (atau `755`).

---

## 4. Konfigurasi `.env` Produksi

Edit `/home/username_hosting/carano_core/.env`:

```env
APP_NAME="PT. CARANO UTAMA LOGISTIK"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainanda.co.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u12345_carano_utama_db
DB_USERNAME=u12345_carano_user
DB_PASSWORD=password_mysql_kuat

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

> **Catatan PHP Hosting**: Buka menu **Select PHP Version** di cPanel dan pilih **PHP 8.3** atau **PHP 8.4** dengan ekstensi aktif: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`, `tokenizer`, `xml`, `ctype`.

---

## 5. Login CMS Dashboard

- **URL CMS**: `https://www.caranoutama.co.id/carano-admin`
- **Email Default**: `admin@caranologistik.co.id`
- **Password Default**: `Carano2026!`

Segera ganti kata sandi melalui menu **Pengguna CMS** di sidebar setelah berhasil masuk pertama kali.
