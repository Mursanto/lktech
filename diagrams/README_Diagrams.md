# 📊 Diagram Skripsi - Sistem Informasi Inventori & Penjualan LKTech

> **Judul Skripsi:**  
> **PENGEMBANGAN SISTEM INFORMASI INVENTORI DAN PENJUALAN BERBASIS WEB  
> MENGGUNAKAN LARAVEL DENGAN PENERAPAN KEAMANAN AUTENTIKASI PADA LKTECH**

---

## 📁 Daftar File Diagram (Mermaid)

Semua file diagram dalam format `.mmd` (Mermaid) dapat dibuka di:
- **VS Code** dengan ekstensi *Mermaid Preview*
- **[mermaid.live](https://mermaid.live)** — Editor online resmi Mermaid
- **Draw.io** (import Mermaid)

---

## 3.4.1 Use Case Diagram

| File | Deskripsi |
|------|-----------|
| [`UseCase_LKTech.mmd`](UseCase_LKTech.mmd) | Use Case Diagram lengkap seluruh sistem |

**Aktor:**
- 👤 **Customer** — Pelanggan umum (tanpa login)
- 👤 **Admin** — Akses penuh ke semua modul
- 👤 **Staff / Kasir** — Akses penjualan, servis, rental
- 👤 **Teknisi** — Akses modul servis

**Modul Use Case:**
- 🌐 Modul Publik (UC-01 s/d UC-05)
- 🔐 Modul Autentikasi (UC-06 s/d UC-10)
- 📦 Modul Inventori (UC-11 s/d UC-14)
- 🛒 Modul Penjualan (UC-15 s/d UC-20)
- 🔧 Modul Servis (UC-21 s/d UC-24)
- 💻 Modul Rental (UC-25 s/d UC-27)
- 📊 Modul Laporan (UC-28 s/d UC-30)
- ⚙️ Modul Manajemen Admin (UC-31 s/d UC-33)

---

## 3.4.2 Activity Diagram

| File | Deskripsi |
|------|-----------|
| [`ActivityDiagram_Login_LKTech.mmd`](ActivityDiagram_Login_LKTech.mmd) | Proses Login dengan Autentikasi 2FA |
| [`ActivityDiagram_Penjualan_LKTech.mmd`](ActivityDiagram_Penjualan_LKTech.mmd) | Proses Transaksi Penjualan |
| [`ActivityDiagram_Servis_LKTech.mmd`](ActivityDiagram_Servis_LKTech.mmd) | Proses Servis Perangkat |

---

## 3.4.3 Sequence Diagram

| File | Deskripsi |
|------|-----------|
| [`SequenceDiagram_Login2FA_LKTech.mmd`](SequenceDiagram_Login2FA_LKTech.mmd) | Sequence Login + Verifikasi 2FA (Google Auth & Email OTP) |
| [`SequenceDiagram_Penjualan_LKTech.mmd`](SequenceDiagram_Penjualan_LKTech.mmd) | Sequence Transaksi Penjualan end-to-end |

---

## 3.4.4 Class Diagram

| File | Deskripsi |
|------|-----------|
| [`ClassDiagram_LKTech.mmd`](ClassDiagram_LKTech.mmd) | Class Diagram lengkap (Models + Controllers + Relasi) |

**Model yang dicakup:**
`User` · `Customer` · `Category` · `Product` · `Sale` · `SaleDetail` · `Service` · `ServicePart` · `Rental` · `ActivityLog`

**Controller yang dicakup:**
`LoginController` · `TwoFactorController` · `DashboardController` · `ProductController` · `SaleController` · `ServiceController` · `RentalController` · `ReportController` · `ActivityLogController` · `UserController` · `CartController` · `CategoryController`

---

## 3.4.5 Entity Relationship Diagram (ERD)

| File | Deskripsi |
|------|-----------|
| [`ERD_LKTech_Skripsi.mmd`](ERD_LKTech_Skripsi.mmd) | ERD lengkap dengan semua entitas dan atribut |

**Entitas:** `users` · `customers` · `categories` · `products` · `sales` · `sale_details` · `services` · `service_parts` · `rentals` · `activity_logs`

---

## 3.4.6 Logical Record Structure (LRS)

| File | Deskripsi |
|------|-----------|
| [`LRS_LKTech_Skripsi.mmd`](LRS_LKTech_Skripsi.mmd) | LRS dengan tipe data fisik database (BIGINT, VARCHAR, DECIMAL, dll) |

> ⚠️ **Perbedaan ERD vs LRS:**
> - **ERD** → Konseptual: menampilkan entitas, atribut, dan hubungan semantik
> - **LRS** → Logis/Fisik: menampilkan nama kolom, **tipe data spesifik** (BIGINT_UNSIGNED, VARCHAR_255, DECIMAL_15_2), PK, FK, dan constraint

---

## 🔐 Fitur Keamanan Autentikasi

Sesuai fokus skripsi, implementasi keamanan mencakup:

| Fitur | Implementasi |
|-------|-------------|
| **Login Rate Limiting** | Cache::put lockout setelah 5x gagal (10 menit) |
| **Google Authenticator (TOTP)** | Sonata GoogleAuthenticator, Secret terenkripsi di DB |
| **Email OTP** | Kode 6 digit, expiry 10 menit, dikirim via SMTP |
| **Role-Based Access Control** | Spatie Laravel Permission (Admin/Staff/Teknisi) |
| **Activity Log** | Semua aksi user dicatat: login, CRUD, 2FA event |
| **Password Hashing** | Bcrypt (Laravel default) |
| **Session Security** | regenerate() setelah login, invalidate() setelah logout |
| **CSRF Protection** | Laravel @csrf di semua form |

---

## 🛠️ Cara Membuka Diagram

### Option 1: mermaid.live (Rekomendasi)
1. Buka [https://mermaid.live](https://mermaid.live)
2. Copy isi file `.mmd`
3. Paste ke editor

### Option 2: VS Code
1. Install ekstensi: **Mermaid Preview** atau **Markdown Preview Mermaid Support**
2. Buka file `.mmd`
3. Tekan `Ctrl+Shift+P` → "Mermaid: Preview Current Diagram"

---

*Dibuat untuk keperluan Skripsi — Sistem Informasi Inventori & Penjualan LKTech*
