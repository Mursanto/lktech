# LAPORAN AUDIT SISTEM INFORMASI
**BERDASARKAN FRAMEWORK COBIT 2019 (STUDI KASUS: APLIKASI LKTECH)**

---

## 1. Gambaran Objek Audit (Sisfo)
### 1.1 Deskripsi Singkat Sistem:
**LKTech** adalah sistem informasi manajemen terintegrasi berbasis web (Laravel) yang melayani proses operasional inti bisnis, meliputi Manajemen Inventori, Point of Sales (POS), Penyewaan Laptop, dan Pencatatan Servis Purna Jual. Aplikasi ini mendukung fitur keamanan *Role-Based Access Control* (RBAC) dan *Two-Factor Authentication* (2FA/OTP) dengan rata-rata puluhan transaksi inventori dan layanan setiap harinya.

### 1.2 Alur Proses Bisnis Utama:
Input Data Inventori / Stok → Autentikasi Pengguna (Login 2FA) → Proses Transaksi (Penjualan/Penyewaan/Servis) → Validasi Stok Otomatis → Pencetakan Nota/Invoice → Pencatatan Laba (Profit Audit) → Pelaporan.

---

## 2. Hasil Penilaian Capability (Per Proses/Praktik/Aktivitas)
Penilaian difokuskan pada domain inti operasional sistem, yaitu **DSS (Deliver, Service, and Support)** dan **MEA (Monitor, Evaluate, and Assess)**.

| Proses/Praktik | Current Capability (0–5) | Target Capability | Gap | Dokumen / Bukti (Evidence) |
| :--- | :---: | :---: | :---: | :--- |
| **DSS02 – Managed Service Requests and Incidents** | 2 | 3 | -1 | Fitur pelaporan log *error* tersedia, namun pencatatan keluhan operasional (kasir/teknisi) belum memiliki *ticketing system* baku. |
| **DSS05 – Managed Security Services** | 3 | 4 | -1 | Otentikasi aplikasi sangat kuat (2FA, enkripsi password). Namun keamanan infrastruktur *server* fisik belum dipetakan formal. |
| **DSS05.02 – Manage Access to Information** | 3 | 4 | -1 | *Role-Based Access Control* (Spatie) berfungsi sempurna membatasi menu antar divisi. Dokumentasi pedoman hak akses tertulis masih kurang. |
| **MEA01 – Managed Performance and Conformance** | 2 | 3 | -1 | *Activity Logs* mencatat setiap aksi pengguna, namun belum ada evaluasi laporan bulanan secara rutin terhadap performa sistem. |

**Catatan Deskriptif:**
*Current Capability* untuk domain DSS berada pada **Level 2 (Managed)** hingga **Level 3 (Established)**. Aplikasi LKTech telah menjalankan praktik dasar yang baik, terutama dalam hal keamanan kode dan autentikasi (DSS05 telah menyentuh Level 3 karena SOP aplikasi terintegrasi langsung dalam *middleware* Laravel). Namun, untuk operasional harian dan manajemen insiden (DSS02), pencatatan keluhan teknis pengguna (kasir/teknisi) masih bersifat *ad-hoc* tanpa standardisasi pelaporan.

---

## 3. Hasil Perhitungan Maturity
Rekap Maturity per Domain/Area untuk lingkup audit keamanan dan layanan operasional LKTech:

| Domain/Area | Metode | Nilai (0–5) | Level | Catatan |
| :--- | :--- | :---: | :--- | :--- |
| **DSS (Deliver, Service, and Support)** | Rata-rata | 2,67 | Level 2 | Perlu standardisasi SOP pemulihan layanan dan dokumentasi infrastruktur jaringan. |
| **DSS (Khusus Layanan Keamanan / DSS05)** | Berbobot | 3,00 | Level 3 | Skoring berbobot lebih tinggi karena implementasi 2FA dan RBAC sangat solid dan terotomatisasi. |
| **Keseluruhan (Scope Audit)** | Rata-rata | 2,50 | Level 2 | Target mencapai Level 3 (Established) pada tahun depan melalui pelatihan dan standardisasi pelaporan. |

**Analisis Maturity Level Domain DSS:**
Berdasarkan perhitungan *maturity*, domain DSS berada pada **Level 2 (Managed)** dengan nilai rata-rata 2,67. Hal ini menunjukkan proses layanan TI telah berjalan baik, direncakanan, dan diimplementasikan dengan pengamanan teknis (2FA & RBAC) yang terstruktur. Pada aspek spesifik keamanan akses (DSS05), *maturity* berbobot mencapai **3,00 (Level 3)**. Walau demikian, maturity keseluruhan (*scope audit*) tertahan pada angka 2,50 (Level 2) akibat kurangnya standardisasi pelaporan insiden/error teknis di lapangan. Hal ini menegaskan perlunya program standardisasi artefak proses pelaporan berbasis metrik agar manajemen LKTech dapat mencapai Target Level 3 pada 2027.

---

## 4. Temuan Audit & Analisis Risiko
| No | Temuan | Risiko | Severity | Proses/Objektif COBIT |
| :---: | :--- | :--- | :---: | :---: |
| 1 | Tidak ada sistem antrean laporan (*Ticketing*) jika kasir mendapati error sistem saat memproses transaksi. | Keterlambatan penanganan (*response time*) dan operasional toko terhenti. | Medium | DSS02.02 |
| 2 | Backup *database* belum dilakukan secara otomatis dan terotomatisasi di beda lokasi (*off-site*). | Hilangnya data riwayat penjualan jika *server* fisik rusak atau terkena *ransomware*. | High | DSS04.07 |
| 3 | Pengawasan sistem terpusat pada *developer*, tidak ada *review* kepatuhan independen. | Tidak adanya transparansi menyeluruh (Blind spot operasional). | Low | MEA01.03 |

---

## 5. Analisis Gap (Current vs Target)
| Proses / Aktivitas | Current | Target | Gap | Dampak | Prioritas |
| :--- | :---: | :---: | :---: | :--- | :---: |
| **DSS02 – Manajemen Insiden (Keseluruhan)** | 2 | 3 | 1 | Kualitas layanan terganggu jika banyak *error* teknis bersamaan tidak dicatat. | 4 |
| **DSS04.07 – Pencadangan & Pemulihan Data** | 1 | 3 | 2 | Potensi kehilangan *database* master produk dan laba perusahaan. | 5 (Kritis) |
| **DSS05.02 – Hak Akses Pengguna** | 3 | 4 | 1 | Keterbatasan bukti dokumentasi jika terjadi sengketa akses di internal (Kasir vs Staff). | 3 |
| **MEA01 – Evaluasi Kinerja Sistem** | 2 | 3 | 1 | Performa aplikasi (*uptime*) dan efektivitas algoritma belum dapat dinilai secara kuantitatif. | 2 |

---

## 6. Rekomendasi & Rencana Tindak Lanjut (*Action Plan*)
| No | Rekomendasi | Output / Deliverable | PIC | Timeline | Indikator Sukses | Prioritas |
| :---: | :--- | :--- | :--- | :--- | :--- | :---: |
| 1 | **Implementasi Auto-Backup Database** (mysqldump otomatis via *Cron Job* ke AWS S3/G-Drive). | *Script Cron Job* aktif & *Log backup* harian. | *Lead Programmer* | Jun 2026 | 100% *backup* harian tersimpan di *cloud* eksternal. | High |
| 2 | **Standardisasi Pelaporan Error** untuk pengguna (Kasir & Teknisi) menggunakan formulir elektronik/sistem *ticketing* simpel. | SOP Pelaporan Error & Integrasi *Ticketing Helpdesk*. | *Manajer IT LKTech* | Ags 2026 | 100% *error* tercatat & diselesaikan < 24 jam. | Medium |
| 3 | **Review Log Aktivitas Bulanan** untuk mendeteksi anomali login pengguna. | Laporan Analisis Log (PIR Bulanan). | *System Admin* | Okt 2026 | *Zero incident* pada kegagalan akses otorisasi ganda. | Low |

---

## 7. Roadmap Peningkatan

### 7.1 Analisis SWOT
*   **S – Strengths (Kekuatan):**
    1. Arsitektur kode aplikasi menggunakan Laravel terkini dan memiliki *Activity Logs* (Pencatatan transaksional sudah sangat baik).
    2. Sistem proteksi sangat mutakhir (2FA via Google Authenticator dan Email OTP) sudah berjalan di level *production*.
    3. *Role-Based Access Control* (RBAC) di *sidebar* dan *dashboard* sangat efisien membedakan hak akses Kasir, Teknisi, dan Admin.
*   **W – Weaknesses (Kelemahan):**
    1. *Disaster Recovery Plan* (DRP) seperti penjadwalan *backup off-site* belum berjalan secara otonom.
    2. Ketiadaan standardisasi form keluhan/kendala teknis (insiden) dari sisi pengguna (Kasir).
*   **O – Opportunities (Peluang):**
    1. Menarik kepercayaan klien korporat dengan menunjukkan keamanan aplikasi berskala Enterprise.
    2. Modul *Activity Logs* yang telah ada dapat diintegrasikan menjadi laporan *monitoring* sistem analitik secara otomatis.
*   **T – Threats (Ancaman):**
    1. Kegagalan perangkat keras (server) yang tidak dapat diprediksi mengancam basis data tunggal (jika tidak ada *backup* eksternal).
    2. *Downtime* di jam sibuk pelayanan pelanggan.

### 7.2 Rencana Peta Jalan (*Roadmap*)
*   **Jangka Pendek (0–3 Bulan):** Standardisasi *script* penjadwalan *backup database* otomatis (DRP Dasar) dan sosialisasi alur pelaporan insiden (*error*) kepada seluruh staf operasional.
*   **Jangka Menengah (3–12 Bulan):** Pembuatan dokumen SOP Tata Kelola Aplikasi dan evaluasi (*major incident review*) bulanan berbasis tren dari *Activity Logs* LKTech.
*   **Jangka Panjang (>12 Bulan):** Penerapan *dashboard analytic* prediktif untuk memantau beban trafik server dan ekspansi menuju lingkungan *High-Availability Server* (Level 4 Predictable).

---

## 8. Kesimpulan
1. **Ringkasan Capability & Maturity:** *Current Capability* domain layanan keamanan (DSS05) berada di **Level 3 (Established)**, sedangkan manajemen operasional (DSS02) di **Level 2 (Managed)**. Secara keseluruhan, *maturity* domain DSS mencapai rata-rata **2,50 (Level 2)**.
2. **Risiko Utama:** Absennya mekanisme pencadangan basis data yang otomatis (*auto-backup off-site*) memaparkan LKTech pada risiko *Single Point of Failure*, yang dapat berakibat hilangnya data operasional jika server rusak permanen.
3. **Rekomendasi Prioritas:** Terapkan otomasi pencadangan data *database* segera mungkin (*Cron Job backup*), dan kembangkan kerangka pelaporan kendala teknis (SOP Insiden) agar penyelesaian *error* pengguna dapat terukur dengan jelas demi mencapai operasional yang stabil (Target Level 3).

---

## LAMPIRAN
*   **Lampiran A:** Daftar Responden & RACI Chart (Pemetaan Tanggung Jawab Tim Pengembang LKTech dan Pimpinan Operasional)
*   **Lampiran B:** Instrumen Kuesioner Capability Model COBIT 2019 (Formulir Asesmen)
*   **Lampiran C:** Rekap Perhitungan Kapabilitas dan *Maturity Level*
*   **Lampiran D:** Bukti Pendukung (*Evidence*): *Screenshot Dashboard* LKTech, Konfigurasi *Role-Based Access Control*, dan Layar Verifikasi 2FA Authenticator.
