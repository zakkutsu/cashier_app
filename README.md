# 🍜 POS Seblak V-1

Aplikasi Point of Sale (POS) untuk restoran seblak yang dibuat menggunakan Electron dengan backend PHP dan database MySQL.

## 🏗️ Struktur Aplikasi
- **Frontend**: Electron (desktop app)
- **Backend**5. Test connection dan save

## 📋 Tutorial Step-by-Step (Untuk Pemula)

### Langkah 1: Persiapan
1. Pastikan Docker Desktop sudah terinstall dan berjalan
2. Buka PowerShell di folder project
3. Install dependencies: `npm install`

### Langkah 2: Setup Database
```powershell
# 1. Jalankan MySQL container
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7

# 2. Tunggu sebentar (15 detik)
Start-Sleep 15

# 3. Import database
Get-Content web/database/db_restoran.sql | docker exec -i mysql-seblak mysql -u root -pmysql db_restoran

# 4. Verifikasi database berjalan
docker ps
```

### Langkah 3: Test Koneksi
```powershell
# Buat file test sederhana
echo '<?php $conn = mysqli_connect("localhost", "root", "mysql", "db_restoran"); if (!$conn) { echo "GAGAL: " . mysqli_connect_error(); } else { echo "BERHASIL!"; } ?>' > test.php

# Jalankan test
.\php\php.exe test.php

# Hapus file test
Remove-Item test.php
```

### Langkah 4: Jalankan Aplikasi
```powershell
# Jalankan aplikasi
npm start
```

### Langkah 5: Login
- Buka aplikasi yang muncul
- Login dengan:
  - Username: `admin`
  - Password: `123`

## 🔄 Command Cepat (Copy-Paste)

Untuk yang ingin langsung jalankan, copy-paste command ini:

```powershell
# Setup lengkap dalam satu go
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7; Start-Sleep 15; Get-Content web/database/db_restoran.sql | docker exec -i mysql-seblak mysql -u root -pmysql db_restoran; npm start
```

## 📊 Database SchemaHP dengan server built-in
- **Database**: MySQL/MariaDB
- **Nama Aplikasi**: POS Seblak V-1

## 📋 Persyaratan Sistem
1. **Node.js** (untuk Electron)
2. **MySQL/MariaDB** (database server)
3. **PHP** sudah disediakan di folder `php/`

## 🚀 Cara Menjalankan Aplikasi

### 1. Setup Database

#### Opsi A: Menggunakan Docker (Recommended)
```powershell
# Jalankan MySQL container dengan Docker
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7

# Tunggu 10-15 detik agar MySQL siap
Start-Sleep 15

# Import database dari file SQL
Get-Content web/database/db_restoran.sql | docker exec -i mysql-seblak mysql -u root -pmysql db_restoran
```

#### Opsi B: Instalasi MySQL/MariaDB Manual
```powershell
# Pastikan MySQL/MariaDB sudah berjalan
# Import database dari file SQL
mysql -u root -p < web/database/db_restoran.sql
```

#### Opsi C: Menggunakan TablePlus GUI
1. Install [TablePlus](https://tableplus.com/)
2. Buat koneksi baru ke MySQL:
   - Host: `localhost`
   - Port: `3306`
   - User: `root`
   - Password: `mysql`
   - Database: `db_restoran`
3. Import file `web/database/db_restoran.sql` melalui TablePlus

### 2. Konfigurasi Database
Edit file `web/connection/koneksi.php` jika perlu:
- Host: `localhost`
- Username: `root` 
- Password: `mysql`
- Database: `db_restoran`

### 3. Install Dependencies
```powershell
npm install
```

### 4. Jalankan Aplikasi
```powershell
npm start
```

Aplikasi akan berjalan di **port 5555** dan otomatis membuka window Electron yang menampilkan web interface PHP.

## 🚨 Troubleshooting

### Masalah Umum dan Solusi

#### 1. Error: "No connection could be made because the target machine actively refused it"
**Penyebab:** MySQL server tidak berjalan
**Solusi:**
```powershell
# Cek apakah container MySQL berjalan
docker ps

# Jika tidak ada, jalankan MySQL container
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7
```

#### 2. Error: "The server requested authentication method unknown to the client"
**Penyebab:** MySQL 8.0 menggunakan authentication method yang tidak kompatibel dengan PHP 7.2
**Solusi:** Gunakan MySQL 5.7 (sudah diperbaiki di tutorial di atas)

#### 3. Error: "PHP server not started. Retrying..."
**Penyebab:** Port 5555 sudah digunakan atau masalah permission
**Solusi:**
```powershell
# Cek port yang digunakan
netstat -ano | findstr :5555

# Kill process jika ada yang menggunakan port 5555
taskkill /PID [PID_NUMBER] /F

# Jalankan ulang aplikasi
npm start
```

#### 4. Container MySQL sudah ada
**Solusi:**
```powershell
# Hapus container lama
docker rm mysql-seblak

# Buat container baru
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7
```

### Test Koneksi Database
Buat file `test_connection.php` untuk memastikan koneksi berhasil:
```php
<?php
$conn = mysqli_connect("localhost", "root", "mysql", "db_restoran");
if (!$conn) {
    echo "Connection failed: " . mysqli_connect_error();
} else {
    echo "Connection successful!";
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM tb_user");
    $row = mysqli_fetch_assoc($result);
    echo "\nTotal users: " . $row['count'];
}
?>
```

Jalankan test:
```powershell
.\php\php.exe test_connection.php
```

Jika output menampilkan "Connection successful!" dan jumlah users, maka database sudah siap.

## 🐳 Docker Setup (Alternative)

## 🔑 Akun Default untuk Login

Berdasarkan database, tersedia akun:
- **Administrator**: username: `admin`, password: `123`
- **Kasir**: username: `hendro`, password: `123`
- **Kasir**: username: `fitri`, password: `123`
- **Kasir**: username: `yafi`, password: `123`
- **Kasir**: username: `fiaz`, password: `123`
- **Owner**: username: `lia`, password: `123`

## 📱 Fitur Aplikasi

### Role Administrator
- Kelola Akun
- Kelola Menu & Harga
- Entry Transaksi
- Generate Laporan

### Role Kasir
- Entry Order
- Entry Transaksi
- Generate Laporan

### Role Owner
- Generate Laporan

### Role Pelanggan
- Generate Laporan

## 🔧 Package & Build

Untuk membuat executable aplikasi:

- **Windows**: `npm run package-win`
- **Mac**: `npm run package-mac`
- **Linux**: `npm run package-linux`

File executable akan dibuat di folder `release-builds/`.

## � Docker Setup (Alternative)

Jika Anda ingin menggunakan Docker untuk menjalankan seluruh aplikasi:

### 1. Buat docker-compose.yml
```yaml
version: '3.8'
services:
  mysql:
    image: mysql:8.0
    container_name: mysql-seblak
    environment:
      MYSQL_ROOT_PASSWORD: mysql
      MYSQL_DATABASE: db_restoran
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
      - ./web/database/db_restoran.sql:/docker-entrypoint-initdb.d/init.sql

volumes:
  mysql_data:
```

### 2. Jalankan Docker Compose
```powershell
docker-compose up -d
```

## 🗄️ Database Management dengan TablePlus

[TablePlus](https://tableplus.com/) adalah GUI database yang sangat baik untuk mengelola MySQL:

### Keuntungan menggunakan TablePlus:
- ✅ Interface yang user-friendly
- ✅ Syntax highlighting untuk SQL
- ✅ Auto-completion
- ✅ Import/Export data mudah
- ✅ Multiple database connections
- ✅ Cross-platform (Windows, Mac, Linux)

### Setup Connection di TablePlus:
1. Buka TablePlus
2. Klik "Create a new connection"
3. Pilih MySQL
4. Masukkan detail:
   ```
   Name: POS Seblak
   Host: localhost
   Port: 3306
   User: root
   Password: mysql
   Database: db_restoran
   ```
5. Test connection dan save

## �📊 Database Schema

Aplikasi menggunakan database `db_restoran` dengan tabel:
- `tb_user` - Data pengguna
- `tb_level` - Level akses pengguna
- `tb_masakan` - Data menu makanan
- `tb_order` - Data pesanan
- `tb_pesan` - Detail pesanan
- `tb_stok` - Data stok

## 🛠️ Teknologi yang Digunakan
- **Electron** - Desktop app framework
- **PHP** - Backend server
- **MySQL/MariaDB** - Database
- **Bootstrap** - CSS framework
- **jQuery** - JavaScript library

## 🎨 Perbaikan UI Terbaru
- ✅ **Grid Card Menu** - Layout yang lebih konsisten dan rapi
- ✅ **Responsive Design** - Tampilan adaptif di berbagai ukuran layar
- ✅ **Hover Effects** - Interaksi yang lebih menarik
- ✅ **Modern Card Design** - Desain kartu yang lebih modern dengan shadow
- ✅ **Image Preview** - Overlay untuk preview gambar menu

## 📝 Lisensi
CC0-1.0

## 👨‍💻 Developer
- Author: zakkutsu
- Repository: https://github.com/zakkutsu/cashier_app