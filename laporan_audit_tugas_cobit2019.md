# LAPORAN HASIL AUDIT SISTEM INFORMASI
**Sistem Informasi Manajemen Terintegrasi LKTech (Inventori, POS, dan Servis)**

**Periode Audit:** 1 Mei 2026 - 15 Mei 2026  
**Versi Dokumen:** v1.0  

---

## DAFTAR ISI
1. Executive Summary
2. BAB II: Latar Belakang & Tujuan
   - 2.1 Latar Belakang
   - 2.2 Tujuan Audit
   - 2.3 Kriteria/Standar/Acuan: COBIT 2019
3. BAB III: Ruang Lingkup Audit
   - 3.1 Objek Audit
   - 3.2 Proses COBIT yang Dinilai
4. BAB IV: Hasil Penilaian & Analisis Kesenjangan
   - 4.1 Hasil Penilaian Capability Level
   - 4.2 Hasil Perhitungan Maturity
   - 4.3 Analisis Gap (Current vs Target)
5. BAB V: Kesimpulan dan Rekomendasi
   - 5.1 Kesimpulan Eksekutif
   - 5.2 Rencana Tindak Lanjut (*Action Plan*)

---

## 1. Executive Summary

**1.1 Ringkasan Tujuan Audit:**  
Mengevaluasi kapabilitas tata kelola proses keamanan (DSS05), manajemen risiko operasional (APO12), dan operasional layanan (DSS01) pada sistem aplikasi LKTech untuk memastikan keandalan, integritas stok, dan keamanan akses (*Role-Based Access Control* & *2FA*) berjalan efektif.

**1.2 Ringkasan Ruang Lingkup:**  
Audit berfokus pada empat proses COBIT 2019: APO12 (Managed Risk), BAI06 (Managed IT Changes), DSS01 (Managed Operations), dan DSS05 (Managed Security Services). Target penilaian berfokus pada kelancaran operasional POS, keamanan autentikasi, serta kontinuitas *database*.

**1.3 Ringkasan Hasil (Highlight):**  
Secara agregat, *Current Capability* sistem LKTech berada pada **Level 2 (Managed)**. Proses DSS05 (Keamanan Layanan) mendapat nilai tertinggi di **Level 3** karena terimplementasinya *middleware* 2FA/OTP yang ketat. Namun, pada aspek pengelolaan perubahan (BAI06) dan *backup* (DSS01), sistem masih memiliki kelemahan administratif yang memerlukan standardisasi dan otomatisasi prosedur. 

**1.4 Kesimpulan Eksekutif:**  
Arsitektur keamanan dan logika aplikasi LKTech telah berjalan dan terproteksi dengan sangat baik secara sistem. Namun, tata kelola di balik layar (Standardisasi SOP, Pengujian Rilis, dan DRP/*Disaster Recovery Plan*) belum konsisten terukur. Rekomendasi utama ditujukan pada penetapan lingkungan pengujian (*Staging*), otomasi proses pencadangan basis data (*Auto-Backup*), dan standardisasi log pelaporan insiden harian.

---

## B A B  I I
## LATAR BELAKANG DAN TUJUAN

### 2.1 Latar Belakang
Transformasi digital telah mendorong sektor ritel dan UMKM untuk mengadopsi sistem informasi berbasis web terintegrasi, termasuk dalam manajemen inventori, *Point of Sales* (POS), dan layanan servis. Digitalisasi ini bertujuan meningkatkan efisiensi pencatatan stok, transparansi profit, dan kepuasan pelanggan. Namun, keberhasilan transformasi ini bergantung pada kualitas tata kelola teknologi informasi (TI). Tanpa tata kelola TI yang memadai, aplikasi Enterprise Resource Planning (ERP) skala UMKM seperti LKTech berisiko menghadapi manipulasi harga, kebocoran data, serta menurunkan integritas pelaporan omzet harian.

Sistem LKTech memiliki karakteristik krusial, di mana transaksi berjalan *real-time* dan pengelolaan data hak akses pengguna (*Admin, Kasir, Teknisi, Sales*) bersifat sensitif. Mengingat sistem ini beroperasi secara *online* / *cloud*, berbagai risiko dapat muncul seperti akses ilegal, ancaman keamanan dari celah autentikasi, dan interupsi pada saat layanan toko sedang sibuk. Tanpa pemetaan kesenjangan (*gap analysis*), peningkatan fitur aplikasi cenderung bersifat reaktif. Oleh karena itu, audit menggunakan kerangka kerja COBIT 2019 sangat diperlukan untuk mengidentifikasi kelemahan, memitigasi risiko keamanan (melalui analisis 2FA & RBAC), serta merumuskan rekomendasi operasional yang lebih sistematis.

### 2.2 Tujuan Audit
Tujuan pelaksanaan audit sistem informasi ini adalah mengevaluasi tingkat kapabilitas tata kelola teknologi informasi pada aplikasi manajemen terintegrasi LKTech menggunakan framework COBIT 2019. Secara khusus, tujuan audit meliputi:
1. Mengukur tingkat kapabilitas (*current capability level*) proses pengelolaan operasional dan keamanan LKTech.
2. Mengidentifikasi kesenjangan (*gap analysis*) antara tingkat kapabilitas tata kelola TI saat ini dengan target organisasi yaitu **Level 3 (Established Process)**.
3. Mengevaluasi efektivitas penerapan kontrol keamanan (2FA & RBAC) serta stabilitas operasional basis data.
4. Menyusun rekomendasi perbaikan agar arsitektur dan operasional sistem LKTech sejalan dengan praktik terbaik tata kelola TI global.

### 2.3 Kriteria/Standar/Acuan: COBIT 2019

#### 2.3.1 Alasan Pemilihan COBIT 2019
COBIT 2019 dipilih karena mampu memetakan hubungan antara tujuan bisnis (mencegah kerugian inventori) dengan *objective* tata kelola TI. Fitur *Design Factors* memungkinkan proses audit disesuaikan khusus (tailored) untuk kebutuhan aplikasi *single-tenant* (seperti ERP LKTech) tanpa kehilangan objektivitas penilaian kapabilitas skala 0–5.

#### 2.3.2 Komponen COBIT 2019 yang Digunakan
1. **Design Factors:** Dasar penyesuaian sistem tata kelola TI dengan karakteristik dan skala UMKM LKTech.
2. **Domain Objective:** Penentuan proses manajemen TI yang relevan (APO, BAI, DSS).
3. **Capability Level 0–5:** Mengukur kematangan implementasi tata kelola sistem.
4. **Target Capability Level:** Acuan analisis kesenjangan (Target LKTech: Level 3).

#### 2.3.3 Design Factor COBIT 2019 (Studi Kasus LKTech)
*   **Enterprise Strategy:** Optimalisasi layanan penjualan (POS) dan efisiensi manajemen persediaan barang melalui integrasi digital.
*   **Enterprise Goals:** Menjaga kontinuitas transaksi kasir, meningkatkan keandalan perhitungan *Profit*, serta mengamankan hak akses operasional.
*   **Risk Profile:** Risiko utama berupa kebocoran akses akun (diatasi dengan 2FA terpusat), kegagalan database (*server down*), dan ketidaksesuaian jumlah inventori (stok minus).
*   **Threat Landscape:** Ancaman *credential stuffing*, *brute-force* halaman otentikasi, dan manipulasi data melalui rilis kode yang tidak teruji (*Bugs*).
*   **Role of IT:** Sistem TI bertindak krusial; apabila sistem *down*, operasional toko fisik (Penjualan & Servis) terganggu drastis.

#### 2.3.4 Capability Level COBIT 2019
*   **Level 0 (Incomplete):** Tidak tercapai sama sekali.
*   **Level 1 (Performed):** Diimplementasikan secara reaktif / *ad-hoc*.
*   **Level 2 (Managed):** Direncanakan, dipantau, namun belum berskala penuh.
*   **Level 3 (Established):** Standarisasi terdokumentasi (SOP baku).
*   **Level 4 (Predictable):** Pengendalian berbasis metrik presisi.
*   **Level 5 (Optimizing):** Peningkatan berkesinambungan.

#### 2.3.5 Skala Penilaian
Menggunakan rasio standar ISACA:
*   **Fully Achieved (F):** > 85%
*   **Largely Achieved (L):** 50% - 85%
*   **Partially Achieved (P):** 15% - 50%
*   **Not Achieved (N):** < 15%

#### 2.3.6 Target Penilaian Capability
Target yang diharapkan organisasi (LKTech) adalah **Level 3 (Established Process)**, di mana sistem keamanan, siklus pembaruan perangkat lunak, dan operasional pelaporan *error* didukung oleh dokumentasi dan *Standard Operating Procedure* (SOP) tertulis.

---

## B A B  I I I
## RUANG LINGKUP AUDIT

### 3.1 Objek Audit
Objek audit adalah **Aplikasi Manajemen Terintegrasi LKTech (Inventori, POS, dan Servis)** berbasis Web (Laravel 13.x, PHP 8.3, dan MySQL). Audit difokuskan pada modul utama yang memiliki fungsi kritis keamanan operasional, yaitu:
1. **Modul Autentikasi Keamanan & RBAC:** Mekanisme pemisahan akses (*Sidebar & Dashboard widgets*) bagi pengguna Kasir, Teknisi, dan Admin, serta sistem proteksi 2FA / *One-Time Password* (OTP).
2. **Modul Manajemen Inventori & Penjualan:** Modul pencatatan transaksi POS secara otomatis dan penguncian stok untuk menjamin integritas aset toko.
3. **Modul Layanan Servis & Sewa:** Log pencatatan perangkat klien beserta *history* modifikasi oleh Teknisi.
4. **Modul Keuangan (Profit Audit):** Kalkulasi *real-time* laba harian yang menuntut akurasi basis data yang solid.

### 3.2 Proses COBIT yang Dinilai
Berdasarkan *Design Factors*, 4 proses utama dipilih:
1. **APO12 - Managed Risk:** Mengevaluasi kemampuan LKTech memitigasi celah manipulasi transaksi dan kerusakan data.
2. **BAI06 - Managed IT Changes:** Menilai seberapa baik transisi/perubahan fitur *source code* dirilis tanpa menghentikan pelayanan (*downtime*).
3. **DSS01 - Managed Operations:** Mengevaluasi rutinitas operasional seperti sistem pelaporan *error* harian dari Kasir dan rutinitas *backup* data.
4. **DSS05 - Managed Security Services:** Membedah keampuhan lapisan perisai sistem; mulai dari penerapan 2FA terpusat, pengacakan *password* (*Bcrypt*), hingga enkripsi pertukaran data logis.

---

## B A B  I V
## HASIL PENILAIAN DAN ANALISIS GAP

### 4.1 Hasil Penilaian Capability Level (As-Is vs To-Be)

| Proses/Praktik | *Current Capability* | *Target* | Gap | Deskripsi / Evidence Aktual |
| :--- | :---: | :---: | :---: | :--- |
| **APO12 (Managed Risk)** | 2 | 3 | -1 | Log aktivitas sudah tersedia dan merekam setiap pengubahan. Namun, dokumentasi formal risiko bisnis (*Risk Register*) belum tertulis. |
| **BAI06 (Managed IT Changes)** | 1 | 3 | -2 | Rilis pembaruan (*Update code*) langsung dilakukan pada tahap produksi (Live) tanpa adanya metodologi uji coba di server *Staging/Testing*. |
| **DSS01 (Managed Operations)** | 1 | 3 | -2 | Backup basis data belum terotomatisasi (manual `mysqldump`). Prosedur penanganan *error* dari Kasir tidak memiliki mekanisme pelacakan tiket (*Helpdesk*). |
| **DSS05 (Managed Security Services)** | 3 | 4 | -1 | Validasi keamanan aplikasi mencapai tahap *Established*. Terdapat pemisahan otorisasi ketat (RBAC) dan kewajiban pengaturan 2FA. |

### 4.2 Hasil Perhitungan Maturity
Secara garis besar, rata-rata tingkat kematangan (Maturity) pada lingkup aplikasi LKTech adalah **Level 1,75 (Mendekati Level 2 - Managed)**. Keunggulan absolut berada di kapabilitas **Keamanan Layanan (DSS05)**, di mana fitur teknis berhasil mendikte prosedur keamanan bagi penggunanya (mewajibkan akun melakukan pengaturan Google Authenticator sebelum dapat mengakses *dashboard*). Meskipun begitu, rutinitas administratif pendukung aplikasi (seperti penyusunan *timeline backup* dan pengujian *bugs*) masih bergantung pada memori dan kebiasaan *Programmer* secara individu, sehingga skor agregat tertekan ke batas Level 2.

### 4.3 Analisis Gap (Current vs Target)

| Proses | Gap | Dampak Risiko (*Impact*) | Prioritas |
| :--- | :---: | :--- | :---: |
| **DSS01** | 2 | Kegagalan *hardware server* dapat merusak/menghilangkan catatan transaksi historis toko apabila tidak ada cadangan data eksternal (*off-site*). | Tinggi (Kritis) |
| **BAI06** | 2 | Perubahan sistem secara tiba-tiba tanpa pengujian mendalam memicu potensi *error bugs* di hadapan pelanggan. | Tinggi |
| **APO12** | 1 | Kurangnya panduan evaluasi kerentanan secara berkala. | Menengah |
| **DSS05** | 1 | Bukti logis *Log Activity* harus dikelola agar tidak menumpuk dan mengurangi performa basis data. | Rendah |

---

## B A B  V
## KESIMPULAN DAN REKOMENDASI

### 5.1 Kesimpulan Eksekutif
Berdasarkan hasil audit sistem informasi berpedoman kerangka COBIT 2019, aplikasi LKTech (Sistem Informasi Manajemen Terintegrasi ERP UMKM) saat ini telah memiliki fungsionalitas dan kendali keamanan sistem yang **unggul dan sangat kuat**. Pemenuhan nilai kapabilitas Level 3 pada domain keamanan (*DSS05*) membuktikan bahwa langkah organisasi mengimplementasikan *Role-Based Access Control* (Kasir, Teknisi, Admin) dan teknologi otentikasi ganda (2FA & OTP Email) telah sukses mengatasi celah eksploitasi peretasan. Namun, masih terdapat kesenjangan (Gap) pada operasional infrastruktur di balik layar; absennya metodologi *backup* otomatis dan manajemen *testing* (*deployment*) menandakan bahwa tata kelola sistem masih bersifat *Ad-Hoc* (Level 1/2) dan harus segera diperbaiki agar mencapai *Level 3 (Established)* secara menyeluruh.

### 5.2 Rekomendasi & Rencana Tindak Lanjut (*Action Plan*)
Untuk menjembatani *Gap* operasional pada aplikasi LKTech, berikut adalah rekomendasi strategis tindak lanjut:
1. **Otomatisasi Infrastruktur Backup (Mengatasi Gap DSS01):**
   *Tindakan:* Penjadwalan (*Cron Job*) pengekstrakan *database* MySQL (`mysqldump`) harian dan diunggah langsung ke penyimpanan penyimpanan awan pihak ketiga (misalnya: Google Drive API atau AWS S3).
2. **Penerapan Siklus Pengujian UAT (Mengatasi Gap BAI06):**
   *Tindakan:* Organisasi wajib menangguhkan praktik rilis pembaruan fitur (modifikasi kode) langsung ke *live server*. Pembaruan wajib diuji kelayakannya secara internal pada lingkungan *Local/Testing* untuk menghindari malfungsi ketika Kasir sedang melayani konsumen.
3. **Pembuatan SOP Insiden Pelaporan (Mengatasi Gap APO12):**
   *Tindakan:* Mendesain modul *Ticketing* / formulir aduan terpisah, sehingga Teknisi dan Kasir tidak hanya melapor kendala sistem via pesan instan, melainkan tercatat resmi pada riwayat sistem (*Helpdesk Log*).
4. **Maintenance Log Aktivitas (Tindak Lanjut DSS05):**
   *Tindakan:* Mengatur penjadwalan fungsi *Log Clearing* bulanan bagi aktivitas rutin yang telah lewat dari 90 hari, guna menjaga respons waktu (*loading time*) basis data agar tetap prima.
