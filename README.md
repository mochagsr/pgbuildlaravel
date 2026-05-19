# CV. Pustaka Grafika — Website Company Profile

Website company profile dan katalog buku berbasis Laravel 13 untuk CV. Pustaka Grafika, Malang.

---

## Tech Stack

- **Backend**: Laravel 13 (PHP 8.3)
- **Frontend**: Tailwind CSS v4, Vite
- **Database**: MySQL
- **Storage**: Laravel Storage (public disk)

---

## Fitur

- Halaman profil perusahaan (Home, Tentang, Kontak)
- Katalog buku dengan filter kategori & jenjang
- Halaman detail produk dengan carousel gambar & lightbox
- Admin panel (CRUD produk, kategori, galeri gambar)
- Upload cover & galeri per produk

---

## Development Lokal

### Requirement
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL

### Setup
```bash
git clone https://github.com/mochagsr/pgbuildlaravel.git
cd pgbuildlaravel

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```
DB_DATABASE=pgbuildlaravel
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

Akses di `http://localhost:8000`

---

## Deployment ke Produksi

### Infrastruktur

| Komponen | Layanan |
|---|---|
| VPS | AWS Lightsail |
| Control Panel | aaPanel |
| Domain | Domanesia |
| DNS / CDN | Cloudflare |

---

### 1. Buat VPS di AWS Lightsail

1. Login ke [AWS Lightsail](https://lightsail.aws.amazon.com)
2. **Create instance** → pilih **Linux/Unix** → **OS Only** → **Ubuntu 22.04 LTS**
3. Pilih plan minimal **$10/bulan** (2 GB RAM) untuk Laravel
4. Beri nama instance, klik **Create**
5. Setelah running, buka tab **Networking** → tambahkan firewall rule:
   - Port **80** (HTTP)
   - Port **443** (HTTPS)
   - Port **8888** (aaPanel, bisa dihapus setelah setup selesai)
6. Buat **Static IP** dan attach ke instance — catat IP-nya

---

### 2. Install aaPanel

SSH ke server:
```bash
ssh ubuntu@<IP-LIGHTSAIL> -i <your-key.pem>
```

Install aaPanel:
```bash
wget -O install.sh http://www.aapanel.com/script/install-ubuntu_6.0_en.sh
sudo bash install.sh
```

Catat **URL, username, dan password** aaPanel yang muncul setelah instalasi selesai.

---

### 3. Setup Stack di aaPanel

Setelah login ke aaPanel:

1. **App Store** → install:
   - **Nginx** (versi terbaru)
   - **MySQL 8.0**
   - **PHP 8.3**
2. Setelah PHP terinstall, masuk ke **PHP 8.3 → Extensions** → install ekstensi:
   `fileinfo`, `openssl`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `bcmath`, `gd`, `zip`
3. Opsional: install **phpMyAdmin** untuk manajemen database via browser

---

### 4. Buat Database

Di aaPanel → **Database** → **Add Database**:
- DB Name: `pgbuildlaravel`
- Username: buat user baru (jangan pakai root)
- Password: gunakan password yang kuat
- Catat semua credentials ini

---

### 5. Setup DNS di Cloudflare

#### A. Tambahkan Domain ke Cloudflare

1. Login ke [cloudflare.com](https://cloudflare.com) → klik **Add a Site**
2. Ketik `pustakagrafika.com` → klik **Continue**
3. Pilih plan **Free** → klik **Continue**
4. Cloudflare akan scan DNS lama — abaikan hasilnya, klik **Continue**

#### B. Ganti Nameserver di Domanesia

Cloudflare akan menampilkan **2 nameserver** miliknya, contoh:
```
aria.ns.cloudflare.com
leo.ns.cloudflare.com
```
> Nameserver Anda mungkin berbeda — gunakan yang tertera di halaman Cloudflare, bukan contoh di atas.

Langkah di Domanesia:
1. Login ke panel Domanesia → **Domain** → klik `pustakagrafika.com`
2. Pilih menu **Nameserver** atau **Ubah Nameserver**
3. Hapus nameserver lama, isi dengan 2 nameserver dari Cloudflare di atas
4. Simpan — proses propagasi biasanya **5–30 menit**, maksimal 24 jam
5. Kembali ke Cloudflare → klik **Done, check nameservers**
6. Tunggu hingga status berubah menjadi **Active** (halaman akan auto-refresh atau kirim email)

#### C. Tambah DNS Record di Cloudflare

Setelah status **Active**, masuk ke menu **DNS → Records** → klik **Add record**:

**Record pertama (domain utama):**
- Type: `A`
- Name: `@`
- IPv4 address: `<IP-LIGHTSAIL>` ← isi IP Static dari Lightsail
- Proxy status: **Proxied** (ikon awan oranye — aktifkan)
- Klik **Save**

**Record kedua (www):**
- Type: `A`
- Name: `www`
- IPv4 address: `<IP-LIGHTSAIL>` ← sama seperti di atas
- Proxy status: **Proxied** (ikon awan oranye — aktifkan)
- Klik **Save**

Hasilnya di tabel DNS:

| Type | Name | Content | Proxy Status |
|---|---|---|---|
| A | `@` | `<IP-LIGHTSAIL>` | Proxied (oranye) |
| A | `www` | `<IP-LIGHTSAIL>` | Proxied (oranye) |

> **Proxied (oranye)** artinya traffic lewat Cloudflare — aktifkan agar dapat proteksi dan CDN gratis. Jika ikon awannya abu-abu (DNS only), klik ikon tersebut untuk mengaktifkan.

#### D. Setting SSL/TLS di Cloudflare

Sebelum lanjut ke langkah berikutnya, atur dulu enkripsi di Cloudflare:

1. Masuk ke **SSL/TLS** (menu kiri)
2. Klik tab **Overview**
3. Ubah mode enkripsi ke **Full (strict)**

> Jangan pilih "Flexible" — ini akan menyebabkan redirect loop setelah SSL dipasang di server.

---

### 6. Buat Website di aaPanel

1. **Website** → **Add Site**
2. Domain: `pustakagrafika.com` (sesuaikan)
3. PHP Version: **8.3**
4. Database: pilih database yang sudah dibuat
5. Root path: `/www/wwwroot/pustakagrafika.com`

---

### 7. Deploy Kode ke Server

**Opsi A — via Git (direkomendasikan):**
```bash
cd /www/wwwroot
sudo rm -rf pustakagrafika.com
git clone https://github.com/mochagsr/pgbuildlaravel.git pustakagrafika.com
cd pustakagrafika.com
```

**Opsi B — via aaPanel File Manager:**
- Zip seluruh folder project di lokal
- Upload via aaPanel → File Manager → ekstrak di folder site

---

### 8. Konfigurasi Aplikasi

```bash
cd /www/wwwroot/pustakagrafika.com

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install & build frontend
npm install
npm run build

# Buat file .env
cp .env.example .env
php artisan key:generate
```

Edit `.env` untuk produksi:
```env
APP_NAME="Pustaka Grafika"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://pustakagrafika.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pgbuildlaravel
DB_USERNAME=<db-user>
DB_PASSWORD=<db-password>

FILESYSTEM_DISK=public
SESSION_DRIVER=file
CACHE_STORE=file
LOG_CHANNEL=stack
```

```bash
# Jalankan migrasi database
php artisan migrate --force

# Buat symlink untuk storage gambar
php artisan storage:link

# Optimasi cache untuk produksi
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permission folder
chmod -R 755 storage bootstrap/cache
chown -R www:www storage bootstrap/cache
```

---

### 9. Konfigurasi Nginx

Di aaPanel → **Website** → klik nama site → **Config** → ganti isi konfigurasi Nginx:

```nginx
server {
    listen 80;
    server_name pustakagrafika.com www.pustakagrafika.com;
    root /www/wwwroot/pustakagrafika.com/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/tmp/php-cgi-83.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
```

> **Penting**: `root` harus mengarah ke folder `/public`, bukan root project.

---

### 10. Pasang SSL (HTTPS)

1. aaPanel → **Website** → klik nama site → **SSL**
2. Pilih tab **Let's Encrypt**
3. Centang domain dan www → klik **Apply**
4. Setelah berhasil, aktifkan **Force HTTPS**

Di Cloudflare → **SSL/TLS** → ubah enkripsi mode ke **Full (strict)**.

---

### 11. Buat Akun Admin Pertama

```bash
cd /www/wwwroot/pustakagrafika.com
php artisan tinker
```

```php
App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@pustakagrafika.com',
    'password' => bcrypt('password-anda-yang-kuat'),
]);
exit
```

Login di: `https://pustakagrafika.com/admin/login`

---

### 12. Upload Gambar Produk Lama (Jika Ada)

Jika ada gambar di `public/images/produk/` di lokal, upload ke server:

```bash
# Dari komputer lokal:
scp -r -i <key.pem> public/images ubuntu@<IP>:/www/wwwroot/pustakagrafika.com/public/
```

Atau upload manual via aaPanel File Manager.

---

## Update Kode (Deployment Ulang)

```bash
cd /www/wwwroot/pustakagrafika.com
git pull origin master
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Troubleshooting

| Masalah | Solusi |
|---|---|
| Halaman 500 Error | Set `APP_DEBUG=true` sementara, cek `storage/logs/laravel.log` |
| Gambar tidak muncul | Jalankan `php artisan storage:link` |
| Upload gambar gagal | `chmod -R 775 storage` dan `chown -R www:www storage` |
| CSS / JS tidak load | Jalankan `npm run build` ulang |
| 404 pada semua route | Pastikan konfigurasi Nginx sudah benar (`try_files`) |
| DB connection error | Cek credentials di `.env`, pastikan MySQL berjalan |
| CSRF / 419 error | Pastikan `APP_URL` sesuai dengan domain yang diakses |

---

## Informasi Proyek

**CV. Pustaka Grafika**
Penerbit & Percetakan Buku, Malang

WhatsApp: [0811-371-171](https://wa.me/62811371171)
GitHub: [github.com/mochagsr/pgbuildlaravel](https://github.com/mochagsr/pgbuildlaravel)
