<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

# 🚀 LKTech - Sistem Informasi Manajemen Terintegrasi (ERP UMKM)

**LKTech** adalah sebuah aplikasi *Enterprise Resource Planning* (ERP) berskala UMKM berbasis web yang dirancang khusus untuk mengelola operasional bisnis toko komputer, laptop, dan *service center*. Aplikasi ini merupakan subjek penelitian/skripsi yang diaudit menggunakan framework **COBIT 2019**.

---

## 🌟 Fitur Utama

Aplikasi ini menggabungkan berbagai modul bisnis esensial menjadi satu pintu terintegrasi:

1. 📦 **Manajemen Inventori**: Pelacakan stok barang masuk/keluar, pencatatan *Serial Number* (SN), kesehatan baterai (laptop), serta penentuan harga modal dan jual.
2. 🛒 **Point of Sales (POS)**: Sistem kasir *real-time* dengan validasi stok, pemotongan stok otomatis, dan pencetakan *invoice* elektronik.
3. 🛠️ **Manajemen Servis**: Pencatatan unit milik klien yang sedang direparasi, update status oleh teknisi, hingga rekapitulasi biaya perbaikan.
4. 💻 **Sistem Penyewaan (Rental)**: Modul khusus untuk mengelola penyewaan laptop lengkap dengan kalkulasi durasi dan tarif.
5. 📈 **Profit Audit (Keuangan)**: Sistem kalkulasi otomatis untuk melacak margin keuntungan (Laba/Rugi) secara harian dan bulanan.
6. 🔐 **High-Level Security**:
   - **Role-Based Access Control (RBAC)**: Pemisahan hak akses mutlak antara `Super Admin`, `Admin`, `Staff/Kasir`, `Sales`, `Teknisi`, dan `Akun Demo`.
   - **Two-Factor Authentication (2FA)**: Kewajiban pemindaian kode Google Authenticator dan OTP Email untuk mencegah pengambilalihan akun.
   - **Activity Logging**: Sistem pelacakan terpusat yang merekam setiap aktivitas *Create/Update/Delete* yang dilakukan oleh pengguna.

---

## 💻 Tech Stack

- **Framework**: Laravel 13.x
- **Language**: PHP 8.3+
- **Database**: MySQL / MariaDB
- **UI/Styling**: TailwindCSS, AlpineJS, Blade Components
- **Key Packages**:
  - `spatie/laravel-permission` (Manajemen *Roles*)
  - `spatie/laravel-activitylog` (Perekam aktivitas)
  - `pragmarx/google2fa-laravel` (Autentikasi 2FA)

---

## ⚙️ Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan LKTech di komputer lokal Anda (menggunakan Laragon / XAMPP):

1. **Clone Repository**
   ```bash
   git clone https://github.com/Mursanto/lktech.git
   cd lktech
   ```

2. **Instalasi Dependencies (PHP & Node.js)**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Konfigurasi Environment**
   - Salin file contoh `.env`
     ```bash
     cp .env.example .env
     ```
   - Buka file `.env` dan sesuaikan nama *database* Anda:
     ```env
     DB_DATABASE=db_lktech
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Generate Key & Migrasi Database**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
   *(Perintah `--seed` akan membuat akun otomatis untuk Admin, Kasir, dan Teknisi)*

5. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```
   Buka browser dan akses: `http://localhost:8000`

---

## 🛡️ Tata Kelola & Audit

Proyek ini telah melalui proses audit tata kelola Sistem Informasi menggunakan kerangka kerja **COBIT 2019**, yang menyoroti:
- **DSS05 (Managed Security Services)**: Implementasi 2FA dan kriptografi sandi yang mencapai *Capability Level 3 (Established)*.
- **APO12 (Managed Risk)**: Validasi stok otomatis dan log aktivitas untuk memitigasi *fraud* operasional.

---

<p align="center">
  <i>Dikembangkan dengan ❤️ untuk keperluan Skripsi & Audit Sistem Informasi COBIT 2019.</i>
</p>
