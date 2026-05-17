# Laporan Audit Keamanan Sistem Informasi LKTech

Laporan ini merangkum hasil audit keamanan teknis yang dilakukan pada aplikasi LKTech Inventory & Sales System. Audit ini mencakup validasi input, pencegahan serangan umum, dan mekanisme kontrol akses.

## 1. Validasi Input (Input Validation)
Sistem menerapkan validasi ketat pada setiap permintaan masuk untuk memastikan integritas data.
- **Implementasi**: Menggunakan fitur `$request->validate()` pada level Controller.
- **Cakupan**: Validasi tipe data (integer, string, array), batas karakter, format email, keunikan data (unique), dan konfirmasi password.
- **Hasil**: **LULUS**. Mencegah data sampah atau malformed masuk ke database.

## 2. Pencegahan XSS (Cross-Site Scripting)
Sistem melindungi pengguna dari injeksi skrip berbahaya melalui antarmuka web.
- **Implementasi**: Penggunaan mesin template **Blade** yang secara otomatis melakukan *HTML Entity Encoding* pada output `{{ }}`.
- **Keamanan Khusus**: Penggunaan output mentah `{!! !!}` dibatasi hanya untuk deskripsi produk yang dikelola oleh Admin.
- **Hasil**: **LULUS**. Output pengguna dibersihkan sebelum ditampilkan di browser.

## 3. Pencegahan SQL Injection (SQLi)
Sistem mengamankan lapisan database dari manipulasi query melalui input pengguna.
- **Implementasi**: Menggunakan **Eloquent ORM** dan **Query Builder** yang memanfaatkan *PDO Prepared Statements*.
- **Detail**: Semua input pengguna diperlakukan sebagai data, bukan sebagai bagian dari perintah SQL. Tidak ditemukan penggunaan query mentah yang tidak terikat.
- **Hasil**: **LULUS**. Lapisan database aman dari serangan injeksi SQL.

## 4. Perlindungan CSRF (Cross-Site Request Forgery)
Sistem memastikan bahwa setiap permintaan perubahan data berasal dari pengguna yang sah secara sengaja.
- **Implementasi**: Middleware `VerifyCsrfToken` diaktifkan secara global. Penggunaan direktif `@csrf` pada setiap form HTML.
- **Mekanisme**: Token unik dihasilkan untuk setiap sesi aktif dan divalidasi pada setiap permintaan POST, PUT, atau DELETE.
- **Hasil**: **LULUS**. Mencegah penyerang melakukan aksi atas nama pengguna yang sedang login.

## 5. Hashing Kata Sandi (Password Hashing)
Sistem tidak menyimpan kata sandi dalam bentuk teks biasa (plain text).
- **Implementasi**: Menggunakan fungsi `Hash::make()` dengan algoritma **BCRYPT** yang kuat.
- **Keamanan Tambahan**: Saat penghapusan akun yang memiliki riwayat transaksi, sistem melakukan *scrambling* kata sandi menggunakan string acak 40 karakter sebelum menonaktifkan akun.
- **Hasil**: **LULUS**. Data kredensial pengguna tetap aman meskipun database bocor.

## 6. Kontrol Akses Berbasis Peran (Role-Based Access Control)
Sistem menerapkan pembatasan hak akses yang ketat sesuai dengan fungsi kerja pengguna.
- **Implementasi**: Menggunakan paket `spatie/laravel-permission` dan middleware `role`.
- **Hierarki**:
    - **Admin**: Akses penuh ke seluruh modul, laporan keuangan, dan manajemen user.
    - **Staff/Teknisi**: Akses operasional terbatas (Jual/Servis/Stok) tanpa akses ke laporan keuangan atau log sistem.
    - **Demo/Guest**: Akses hanya baca (*View Only*) pada modul tertentu.
- **Hasil**: **LULUS**. Setiap rute dan elemen UI dilindungi berdasarkan izin yang dimiliki pengguna.

## 7. Keamanan Tambahan (2FA OTP)
Sistem telah dilengkapi dengan fitur **Two-Factor Authentication (2FA)** via Gmail.
- **Implementasi**: Kode OTP 6-digit dihasilkan secara acak dan dikirim ke email terdaftar.
- **Masa Berlaku**: Kode kedaluwarsa dalam 10 menit dan dihapus dari sistem segera setelah digunakan (Single-use code).
- **Hasil**: Menambah lapisan keamanan kedua yang signifikan saat proses login.

---
**Tanggal Audit**: 10 Mei 2026  
**Status Keseluruhan**: **AMAN (SIAP PRODUKSI)**
