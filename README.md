# 🍜 POS Seblak V-1

Aplikasi Point of Sale (POS) untuk restoran seblak yang dibuat menggunakan Electron dengan backend PHP dan database MySQL.

## 🏗️ Struktur Aplikasi
- **Frontend**: Electron (desktop app)
- **Backend**5. Test connection dan save

## 📋 Tutorial# Kompres dengan 7-Zip atau WinRAR untuk distribusi
7z a "POS-Seblak-v1.0.7z" "dist/POS Seblak-win32-ia32"
```

## 🚀 Distribusi Aplikasi

### Opsi 1: Portable Application
1. Build aplikasi dengan script: `.\build.ps1`
2. Zip folder hasil build: `dist/POS Seblak-win32-ia32/`
3. Bagikan file .zip
4. User tinggal extract dan jalankan `setup-database.bat`

### Opsi 2: Dengan Installer
```powershell
# Install electron-builder
npm install --save-dev electron-builder

# Build installer
npm run dist
```

### Opsi 3: Cloud Distribution
Upload ke cloud storage dan bagikan link:
- **Google Drive**: Untuk file besar (>25MB)
- **GitHub Releases**: Untuk versi official
- **Dropbox/OneDrive**: Untuk sharing cepat

### 📋 Checklist Distribusi
- ✅ Test aplikasi di komputer lain
- ✅ Pastikan database script berfungsi
- ✅ Sertakan file README.txt
- ✅ Test semua fitur utama
- ✅ Ukuran file wajar (<500MB)
- ✅ Icon aplikasi terlihat
- ✅ Nama aplikasi sesuai

### 🔧 Tips untuk User End
Buat file `CARA-INSTALL.txt` untuk user:
```
CARA INSTALL POS SEBLAK

1. Extract file zip ke folder (contoh: C:\POS-Seblak\)
2. Install Docker Desktop dari https://www.docker.com/
3. Jalankan setup-database.bat
4. Tunggu sampai muncul "Setup Complete"
5. Klik "POS Seblak.exe" untuk memulai
6. Login dengan: admin / 123

TROUBLESHOOTING:
- Jika error Docker: Install Docker Desktop dulu
- Jika error port 3306: Matikan MySQL/XAMPP yang lain
- Jika tidak bisa login: Tunggu 30 detik setelah setup database

CONTACT:
GitHub: https://github.com/zakkutsu/cashier_app
```

## 📊 Database Schema

Aplikasi menggunakan database `db_restoran` dengan tabel:y-Step (Untuk Pemula)

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

## � Tutorial Build Aplikasi menjadi .EXE

### Persiapan Build
Sebelum membuild, pastikan aplikasi berjalan dengan baik di mode development.

### 1. Build untuk Windows (Recommended)
```powershell
# Build untuk Windows 32-bit (lebih kompatibel)
npm run package-win

# Atau gunakan perintah manual untuk lebih banyak kontrol
npx electron-packager . "POS Seblak" --platform=win32 --arch=ia32 --out=dist --overwrite --icon=icons/logo.ico
```

### 2. Build untuk Sistem Lain
```powershell
# Build untuk Windows 64-bit
npx electron-packager . "POS Seblak" --platform=win32 --arch=x64 --out=dist --overwrite --icon=icons/logo.ico

# Build untuk macOS
npm run package-mac

# Build untuk Linux
npm run package-linux
```

### 3. Build dengan Konfigurasi Custom
```powershell
# Build dengan nama dan konfigurasi khusus
npx electron-packager . "Kasir Seblak v1.0" `
  --platform=win32 `
  --arch=ia32 `
  --out=release `
  --overwrite `
  --icon=icons/logo.ico `
  --app-version="1.0.0" `
  --build-version="1.0.0" `
  --version-string.CompanyName="Seblak Corp" `
  --version-string.FileDescription="Aplikasi Kasir Seblak" `
  --version-string.ProductName="POS Seblak" `
  --ignore="node_modules/(electron-prebuilt|electron-packager)" `
  --prune=true
```

### 4. Optimasi Sebelum Build

#### Bersihkan Dependencies
```powershell
# Install dependencies production only
npm ci --production

# Atau hapus dev dependencies
npm prune --production
```

#### Update package.json untuk build
```json
{
  "main": "main.js",
  "scripts": {
    "start": "electron .",
    "build-win32": "electron-packager . --platform=win32 --arch=ia32 --out=dist/",
    "build-win64": "electron-packager . --platform=win32 --arch=x64 --out=dist/",
    "build-all": "electron-packager . --all --out=dist/"
  }
}
```

### 5. Troubleshooting Build

#### Error: electron-packager not found
```powershell
# Install electron-packager global
npm install -g electron-packager

# Atau install local
npm install --save-dev electron-packager
```

#### Error: Icon tidak ditemukan
```powershell
# Pastikan file icon ada dan format benar
# Windows: .ico
# macOS: .icns  
# Linux: .png

# Convert icon jika perlu
# https://convertio.co/png-ico/
```

#### Error: Build gagal karena size
```powershell
# Hapus file tidak perlu sebelum build
Remove-Item node_modules/.cache -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item .git -Recurse -Force -ErrorAction SilentlyContinue

# Atau tambahkan ignore list
--ignore="node_modules/.cache" --ignore=".git"
```

### 6. Hasil Build

Setelah build berhasil, Anda akan mendapat:
```
dist/
├── POS Seblak-win32-ia32/
│   ├── POS Seblak.exe          ← File executable utama
│   ├── resources/
│   │   └── app.asar            ← Kode aplikasi terbungkus
│   ├── php/                    ← PHP runtime
│   ├── web/                    ← File web aplikasi
│   └── ... (file Electron lainnya)
```

### 7. Distribusi Aplikasi

#### Buat Installer (Optional)
```powershell
# Install electron-builder untuk installer
npm install --save-dev electron-builder

# Tambah script di package.json
"build": "electron-builder",
"dist": "npm run build"
```

#### Konfigurasi electron-builder
Buat file `electron-builder.json`:
```json
{
  "appId": "com.seblak.pos",
  "productName": "POS Seblak",
  "directories": {
    "output": "installer"
  },
  "files": [
    "**/*",
    "!dist",
    "!installer"
  ],
  "win": {
    "target": "nsis",
    "icon": "icons/logo.ico"
  },
  "nsis": {
    "oneClick": false,
    "allowToChangeInstallationDirectory": true
  }
}
```

#### Testing Aplikasi .exe
1. **Copy folder database** - Pastikan MySQL tetap running di host
2. **Test di komputer lain** - Pastikan aplikasi berjalan tanpa dependencies
3. **Check koneksi database** - Update config jika perlu

### 8. Tips untuk Distribusi

#### Portable Version
```powershell
# Tambahkan file portable.txt di folder aplikasi
echo "portable" > "dist/POS Seblak-win32-ia32/portable.txt"

# Copy database setup script
Copy-Item "setup-database.bat" "dist/POS Seblak-win32-ia32/"
```

#### Database Bundling
Untuk distribusi yang mudah, buat script setup database:
```batch
@echo off
echo Setting up POS Seblak Database...
docker run --name mysql-seblak -e MYSQL_ROOT_PASSWORD=mysql -e MYSQL_DATABASE=db_restoran -p 3306:3306 -d mysql:5.7
timeout /t 15
echo Database ready!
echo Starting POS Seblak...
"POS Seblak.exe"
```

### � File Pendukung yang Disertakan

#### Script Build Otomatis
- `build.ps1` - Script PowerShell untuk build otomatis
- `setup-database.bat` - Setup database untuk distribusi (Windows Batch)
- `setup-database.ps1` - Setup database untuk distribusi (PowerShell)

#### Penggunaan Script Build
```powershell
# Build default (Windows 32-bit)
.\build.ps1

# Build Windows 64-bit
.\build.ps1 -Architecture "x64"

# Build ke direktori khusus
.\build.ps1 -OutputDir "release"
```

### �📊 Size Optimization

File .exe akan berukuran sekitar:
- **Minimal build**: ~150-200 MB
- **Dengan PHP runtime**: ~200-250 MB  
- **Full build dengan dependencies**: ~300-400 MB

Untuk mengurangi ukuran:
```powershell
# Hapus file PHP yang tidak perlu
Remove-Item php/ext/php_oci8_12c.dll, php/ext/php_pdo_oci.dll -ErrorAction SilentlyContinue

# Kompres dengan 7-Zip atau WinRAR untuk distribusi
7z a "POS-Seblak-v1.0.7z" "dist/POS Seblak-win32-ia32"
```

## �📊 Database SchemaHP dengan server built-in
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