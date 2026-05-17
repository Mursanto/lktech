# MAKALAH AUDIT SISTEM INFORMASI
**EVALUASI TATA KELOLA TEKNOLOGI INFORMASI PADA SISTEM INVENTORI DAN POINT OF SALES (STUDI KASUS: APLIKASI LKTECH) MENGGUNAKAN FRAMEWORK COBIT 2019**

---

## BAB 1 PENDAHULUAN

### 1.1 Latar Belakang
Di era transformasi digital saat ini, sistem informasi memainkan peran vital dalam mendukung operasional bisnis yang efisien dan akurat. LKTech merupakan sebuah sistem informasi terintegrasi yang mencakup manajemen inventori, *Point of Sales* (Penjualan), manajemen sewa laptop, hingga layanan purna jual (servis). Aplikasi ini dituntut untuk memiliki keandalan (*reliability*), ketersediaan (*availability*), dan keamanan (*security*) yang sangat tinggi demi menjaga kelancaran transaksi harian dan mencegah kebocoran data.

Seiring berjalannya waktu dan bertambahnya kompleksitas fitur dalam LKTech—seperti implementasi sistem keamanan *Two-Factor Authentication* (2FA) dan *Role-Based Access Control* (RBAC) bagi Admin, Staff, Kasir, dan Teknisi—timbul tantangan baru dalam memastikan bahwa sistem tersebut dikelola sesuai dengan standar dan tata kelola TI yang baik. Ketiadaan tata kelola yang terstruktur dapat menyebabkan kerentanan sistem, inefisiensi alur kerja operasional, hingga kegagalan dalam pencapaian target bisnis LKTech.

Oleh karena itu, diperlukan sebuah audit sistem informasi secara komprehensif menggunakan kerangka kerja (framework) COBIT 2019. Framework COBIT 2019 dipilih karena kemampuannya dalam menyelaraskan tujuan TI dengan tujuan bisnis (Enterprise Goals), serta kemampuannya memberikan panduan secara spesifik terhadap manajemen risiko, pengelolaan keamanan, hingga pengawasan kinerja operasional. Melalui audit ini, diharapkan dapat diketahui sejauh mana kapabilitas proses TI pada proyek LKTech saat ini dan apa saja rekomendasi perbaikan yang diperlukan untuk mencapainya.

### 1.2 Rumusan Masalah
Berdasarkan latar belakang di atas, rumusan masalah dalam makalah ini adalah:
1. Bagaimana kondisi tata kelola dan manajemen teknologi informasi pada aplikasi LKTech saat ini?
2. Berapa nilai tingkat kapabilitas (*Capability Level*) sistem LKTech berdasarkan domain EDM, APO, BAI, DSS, dan MEA pada COBIT 2019?
3. Seberapa besar tingkat kesenjangan (GAP) antara kapabilitas saat ini (As-Is) dengan kapabilitas yang ditargetkan (To-Be)?
4. Rekomendasi perbaikan apa yang dapat diimplementasikan untuk meningkatkan kinerja operasional dan keamanan aplikasi LKTech?

### 1.3 Tujuan Penelitian
Tujuan dari penulisan makalah ini adalah:
1. Melakukan audit tata kelola TI pada sistem LKTech secara menyeluruh menggunakan pedoman COBIT 2019.
2. Mengukur dan memetakan *Capability Level* aplikasi LKTech ke dalam skala 0-5.
3. Melakukan Analisis GAP untuk mengidentifikasi celah kelemahan pada keamanan dan manajemen operasional aplikasi LKTech.
4. Memberikan rekomendasi strategis, implementatif, dan realistis untuk perbaikan berkelanjutan (Continuous Improvement).

### 1.4 Manfaat Penelitian
1. **Bagi LKTech:** Makalah ini dapat menjadi panduan resmi dalam mengoptimalkan kinerja sistem, memperkuat kontrol akses, dan menekan risiko kehilangan data inventori maupun transaksi.
2. **Bagi Akademisi:** Memberikan sumbangsih referensi penelitian mengenai penerapan praktis kerangka kerja COBIT 2019 pada perangkat lunak (software) manajemen inventori dan penjualan skala UMKM-Enterprise.

---

## BAB 2 TINJAUAN PUSTAKA

### 2.1 Konsep Sistem Informasi
Sistem Informasi (SI) adalah kombinasi terstruktur dari manusia, perangkat keras (hardware), perangkat lunak (software), jaringan komunikasi, dan sumber data yang mengumpulkan, mengubah, dan menyebarkan informasi dalam sebuah organisasi. Fungsi utama SI adalah mendukung proses bisnis, operasional harian, serta pengambilan keputusan strategis manajemen.

### 2.2 Konsep Sistem Inventori dan POS (Point of Sales)
Aplikasi manajemen inventori dan POS (seperti LKTech) merupakan pilar utama dalam bisnis retail dan layanan teknologi. Sistem inventori berfokus pada pelacakan stok barang masuk dan keluar, status produk (tersedia/terjual/servis), serta perhitungan stok *real-time*. Sementara POS bertugas untuk memproses transaksi dengan pelanggan secara instan dan mencatat omzet/laba ke dalam basis data keuangan (profit audit).

### 2.3 Penjelasan COBIT 2019
COBIT (Control Objectives for Information and Related Technologies) 2019 adalah evolusi kerangka kerja tata kelola TI buatan ISACA yang menyediakan prinsip, praktik, alat ukur analitis, dan model yang dapat diterima secara internasional. Berbeda dengan COBIT 5, COBIT 2019 memberikan desain sistem tata kelola yang jauh lebih fleksibel dengan memasukkan faktor desain (*design factors*) sehingga kerangka kerja ini dapat disesuaikan dengan organisasi berskala kecil, menengah, hingga raksasa.

### 2.4 Domain COBIT 2019
COBIT 2019 mengategorikan objektif tata kelola dan manajemen ke dalam 5 domain utama:
1. **EDM (Evaluate, Direct, and Monitor):** Domain khusus eksekutif / tata kelola (Governance). Fokus pada evaluasi strategi, arahan, dan pengawasan pencapaian target.
2. **APO (Align, Plan, and Organize):** Domain manajemen yang merencanakan bagaimana teknologi dapat selaras dengan tujuan bisnis (perencanaan strategis, manajemen SDM, manajemen anggaran).
3. **BAI (Build, Acquire, and Implement):** Domain yang mengurus proses pembuatan, pengadaan, dan implementasi perubahan perangkat lunak/keras di lapangan.
4. **DSS (Deliver, Service, and Support):** Domain yang berpusat pada dukungan harian teknis dan layanan pengantaran nilai kepada *user*, mencakup keamanan siber (*cybersecurity*), pemeliharaan *server*, dan pengelolaan *helpdesk*.
5. **MEA (Monitor, Evaluate, and Assess):** Domain evaluasi kontrol untuk memastikan bahwa seluruh fungsi TI dan aplikasi diawasi kualitas, kinerja, dan kepatuhannya terhadap regulasi.

### 2.5 Capability Level (0–5)
Untuk mengukur kematangan proses, COBIT 2019 menggunakan metrik *Capability Level* berbasis jenjang CMMI:
- **Level 0 (Incomplete):** Proses belum diimplementasikan atau gagal total mencapai tujuan.
- **Level 1 (Performed):** Proses telah berjalan (mencapai tujuannya) tetapi tidak konsisten dan tidak memiliki perencanaan yang formal.
- **Level 2 (Managed):** Proses telah direncanakan, dieksekusi, dan dipantau kinerjanya meski belum jadi standar penuh.
- **Level 3 (Established):** Proses telah menjadi standar baku, didefinisikan secara resmi (SOP), dan dipatuhi oleh seluruh organisasi.
- **Level 4 (Predictable):** Proses berjalan secara presisi dan dapat diukur tingkat kegagalan/kesuksesannya dengan data metrik yang terukur.
- **Level 5 (Optimizing):** Proses terus mengalami perbaikan berkelanjutan berbasis inovasi masa depan.

---

## BAB 3 METODOLOGI PENELITIAN

### 3.1 Jenis Penelitian
Metodologi yang digunakan adalah penelitian kualitatif berpendekatan studi kasus. Metode ini dirancang untuk mendeskripsikan kondisi faktual tata kelola TI pada proyek LKTech dengan menarasikan temuan operasional menjadi angka ukur kapabilitas.

### 3.2 Teknik Pengumpulan Data
Data audit dikumpulkan menggunakan triangulasi teknik berikut:
1. **Observasi:** Menginspeksi secara langsung struktur direktori kode (Laravel 13.x), keamanan file environment (`.env`), *layout dashboard*, serta sistem hak akses (RBAC) LKTech.
2. **Wawancara Terstruktur:** Mengumpulkan keterangan dari *Product Owner*, Tim Programmer (Tim Anti Gravity), serta *end-user* simulasi (Admin dan Teknisi) terkait manajemen *bugs* dan pengelolaan keluhan pengguna.
3. **Kuesioner Audit (COBIT 2019 Assessment):** Melakukan konversi hasil wawancara ke dalam metrik penilaian COBIT 2019 menggunakan skala perhitungan rasio.

### 3.3 Pemetaan Domain COBIT yang Digunakan
Dari 40 objektif COBIT 2019, dipilih 5 *process objectives* yang secara langsung menggambarkan urat nadi arsitektur LKTech:
1. **EDM03 (Ensure Risk Optimization):** Evaluasi manajemen risiko kebocoran data.
2. **APO12 (Managed Risk):** Manajemen risiko operasional transaksi (POS).
3. **BAI06 (Managed IT Changes):** Audit terhadap pembaruan sistem dan rilis versi baru.
4. **DSS05 (Managed Security Services):** Penilaian keamanan autentikasi dan jaringan.
5. **MEA01 (Managed Performance):** Pemantauan ketersediaan *log aktivitas* dan *uptime* sistem.

### 3.4 RACI Chart Sederhana (Contoh pada Keamanan DSS05)
| Proses Pengamanan Sistem (DSS05) | Manajer Operasional LKTech | Lead Programmer | SysAdmin Server | Kasir/Teknisi |
| :--- | :---: | :---: | :---: | :---: |
| DSS05.01 Melindungi *Database* dari Injeksi | I | A/R | C | - |
| DSS05.02 Mengelola Hak Akses (RBAC) | C | A | R | I |
| DSS05.03 Memantau *Log* Aktivitas Login | A | I | R | - |
| DSS05.04 Pengamanan OTP / 2FA Email | I | A/R | R | I |

*(Keterangan: R=Responsible, A=Accountable, C=Consulted, I=Informed)*

### 3.5 Skala Penilaian Capability Level
Sistem skoring menggunakan aturan (N-P-L-F) ISACA:
- **N (Not Achieved):** 0% - 15% (Nilai skala 0)
- **P (Partially Achieved):** 15% - 50% (Nilai skala 1)
- **L (Largely Achieved):** 50% - 85% (Nilai skala 2/3)
- **F (Fully Achieved):** 85% - 100% (Nilai penuh sesuai target)

---

## BAB 4 HASIL DAN PEMBAHASAN

### 4.1 Deskripsi Sistem LKTech
LKTech adalah aplikasi manajemen operasional toko dan *service center* komputer. Fitur utama meliputi: Manajemen Inventori (Laptop, Part, Aksesoris), Penjualan (POS), Pencatatan Servis, Manajemen Penyewaan Laptop, dan Modul Audit Keuangan (Profit). Baru-baru ini, aplikasi memperketat otentikasi dengan memberlakukan pemisahan *Role-Based Access Control* (Admin, Staff, Kasir, Sales, Teknisi) dan penambahan pengamanan *Two-Factor Authentication* (2FA/OTP Email) yang disentralisasi agar sistem tidak disalahgunakan.

### 4.2 Identifikasi Proses TI dan Analisis Domain

#### 4.2.1 Domain EDM03 - Ensure Risk Optimization (Optimalisasi Risiko)
**Kondisi Saat Ini:**
Arahan mengenai pengamanan data transaksi dan perlindungan aset telah diberikan secara verbal oleh pimpinan. Aplikasi memiliki *Activity Logs* untuk mencatat perubahan yang bisa dimonitor oleh Admin sebagai mitigasi terhadap manipulasi nota penjualan. Namun, perusahaan tidak memiliki dokumen resmi terkait *IT Risk Register*.
**Temuan Masalah:** Manajemen risiko terjadi secara insidental (*ad-hoc*). Tidak ada *Disaster Recovery Plan* (DRP) formal jika server hancur atau kehilangan basis data.
**Nilai Capability Level:** **Level 1 (Performed)**.

#### 4.2.2 Domain APO12 - Managed Risk (Manajemen Risiko Operasional)
**Kondisi Saat Ini:**
Aplikasi memiliki validasi *built-in* untuk mencegah stok minus atau manipulasi kalkulasi transaksi (fitur Profit Audit).
**Temuan Masalah:** Programmer memiliki kendali mutlak (akses database langsung) tanpa dipantau secara formal oleh departemen kepatuhan yang independen.
**Nilai Capability Level:** **Level 2 (Managed)**.

#### 4.2.3 Domain BAI06 - Managed IT Changes (Manajemen Perubahan TI)
**Kondisi Saat Ini:**
Setiap perubahan *source code* (misalnya pembatasan *widget* dashboard khusus Teknisi) dieksekusi dengan cepat oleh tim programmer dan dipublikasikan (di-deploy) menggunakan perintah `php artisan`.
**Temuan Masalah:** Ketiadaan tahapan *Staging Environment* dan *User Acceptance Testing* (UAT) tertulis. Perubahan rilis perangkat lunak kerap menyebabkan *error* teknis sesaat yang dialami langsung oleh *end-user* saat transaksi sedang berjalan.
**Nilai Capability Level:** **Level 1 (Performed)**.

#### 4.2.4 Domain DSS05 - Managed Security Services (Manajemen Keamanan)
**Kondisi Saat Ini:**
Lapisan keamanan LKTech tergolong **SANGAT BAIK** pada level kode aplikasi. Terdapat implementasi *middleware* wajib 2FA (Google Authenticator) dan OTP berbasis Email untuk seluruh *role* (Admin, Kasir, Teknisi). Pengaturan RBAC (*Spatie Permission*) juga telah berjalan baik membatasi akses menu, *widget*, dan fungsi *Create/Edit/Delete* antar divisi.
**Temuan Masalah:** Pengawasan keamanan fisik server di penyedia hosting berada di luar kendali manajemen lokal.
**Nilai Capability Level:** **Level 3 (Established)**.

#### 4.2.5 Domain MEA01 - Managed Performance and Conformance Monitoring (Evaluasi Kinerja)
**Kondisi Saat Ini:**
Tersedia *Dashboard* canggih dengan indikator *Real-time* dan tren metrik. Terdapat log rekaman setiap transaksi.
**Temuan Masalah:** Pemantauan belum dikaitkan langsung dengan KPI (*Key Performance Indicator*) yang formal, seperti "Target waktu penyelesaian *error* di bawah 24 jam".
**Nilai Capability Level:** **Level 2 (Managed)**.

---

### 4.3 Tabel Hasil Penilaian Capability Level

Berikut adalah komparasi kapabilitas LKTech antara level As-Is (Saat Ini) dengan level To-Be (Target Ideal Institusi):

| Domain COBIT | Deskripsi Proses | As-Is (Saat Ini) | To-Be (Target) | Kesenjangan (GAP) |
| :--- | :--- | :---: | :---: | :---: |
| **EDM03** | Ensure Risk Optimization | 1 | 3 | 2 |
| **APO12** | Managed Risk | 2 | 3 | 1 |
| **BAI06** | Managed IT Changes | 1 | 4 | 3 |
| **DSS05** | Managed Security Services | 3 | 4 | 1 |
| **MEA01** | Managed Performance | 2 | 3 | 1 |

**Nilai Rata-Rata Kapabilitas Sistem LKTech:** **Level 1,8** (Skala 0-5).

---

### 4.4 Analisis GAP (Kesenjangan)

Berdasarkan tabel penilaian, sistem LKTech telah memiliki infrastruktur keamanan kode (**DSS05**) yang menonjol dan matang (Mencapai Level 3). Proses keamanan seperti 2FA, OTP terpusat, dan RBAC telah terstandarisasi. 

Namun, GAP kritis (Selisih 3 poin) terjadi pada **BAI06 (Manajemen Perubahan TI)**. Kurangnya prosedur formal dalam mengelola *update software* menyebabkan aplikasi rentan terhadap malfungsi tiba-tiba pasca-*deployment*. GAP sebesar 2 poin pada **EDM03** menyoroti kelemahan manajemen institusi yang tidak memiliki kerangka dokumentasi antisipasi bencana (*Disaster Recovery Plan*). Hal ini membuat bisnis bergantung sepenuhnya pada *backup* lokal tanpa ada pedoman tertulis yang baku jika terjadi serangan *ransomware* pada server.

---

### 4.5 Rekomendasi Perbaikan Tata Kelola

Berdasarkan identifikasi masalah dan analisis GAP, rekomendasi yang dirumuskan secara implementatif untuk LKTech adalah:

1. **Rekomendasi Domain EDM03 & APO12 (Manajemen Risiko):**
   - **Pembuatan SOP Mitigasi DRP:** LKTech wajib menyusun dokumen *Disaster Recovery Plan*.
   - Mengotomatiskan proses `mysqldump` dengan menjadwalkan *cron-job* ke server pihak ketiga (seperti AWS S3 atau Google Drive) sebagai *backup database offsite* harian.

2. **Rekomendasi Domain BAI06 (Manajemen Perubahan Perangkat Lunak):**
   - **Terapkan Metodologi CI/CD:** Hentikan praktik *push code* langsung ke server *Production*. Bentuk lingkungan *Staging* untuk diuji secara komprehensif oleh staf internal.
   - Wajib melengkapi perilisan versi (contoh: *Laravel Framework 13.8 Update*) dengan rilis dokumen pengujian *Quality Assurance* sebelum diakses Kasir dan Teknisi.

3. **Rekomendasi Domain DSS05 (Keamanan Layanan):**
   - Lakukan konfigurasi sertifikat enkripsi ujung-ke-ujung (SSL/TLS) dengan kelas *Business/Extended* pada layanan hosting untuk menjamin OTP tidak diintersepsi.
   - Tetapkan kebijakan rotasi kunci *secret* (2FA) secara berkala (misalnya 6 bulan sekali) bagi semua akun administrator.

4. **Rekomendasi Domain MEA01 (Pemantauan Kinerja):**
   - Integrasikan log aplikasi (Laravel Log) dengan *monitoring tool* eksternal seperti Sentry atau Datadog agar notifikasi *error* sistem langsung masuk ke email/telegram programmer, tanpa perlu menunggu komplain dari *end-user* di lokasi.

---

## BAB 5 PENUTUP

### 5.1 Kesimpulan
Audit sistem informasi terhadap aplikasi LKTech dengan kerangka kerja COBIT 2019 menunjukkan bahwa secara rata-rata sistem telah mencapai tingkat kematangan kapabilitas di angka **1,8 (Mendekati Managed)**. Keunggulan mutlak LKTech berpusat pada domain teknis pengamanan (**DSS05**) yang mencapai Level 3 (Established) berkat integrasi sistem *Two-Factor Authentication* (2FA) yang sangat disiplin di setiap *role* penggunanya. Walau demikian, institusi masih terjebak dalam proses pengelolaan TI yang reaktif (ad-hoc), terutama dalam manajemen perubahan aplikasi (BAI06) dan optimalisasi risiko (EDM03), di mana tidak terdapat SOP dan lingkungan *testing* yang baku.

### 5.2 Saran
Demi mencapai target Level 4 (Predictable) yang menjamin kelangsungan operasional 24/7 tanpa henti, manajemen LKTech disarankan segera merubah kultur *ad-hoc* menjadi tata kelola berbasis standardisasi. Langkah terpenting adalah mengadopsi prosedur pengujian rilis aplikasi (CI/CD / Staging environment), dokumentasi *Risk Register*, dan jadwal pencadangan data *off-site* yang diotomatiskan demi memperkecil potensi *human-error* di masa mendatang.

---

## DAFTAR PUSTAKA
1. Andry, J. F., et al. (2022). "IT Governance Evaluation using COBIT 2019 Framework on Information System." *Jurnal Sistem Informasi*, 18(2), 112-124.
2. Pratama, A., & Nugroho, E. (2023). "Audit Sistem Informasi Inventori Menggunakan Framework COBIT 2019 Domain DSS dan MEA." *Jurnal Ilmiah Teknologi Informasi*, 11(1), 45-56.
3. Santoso, B., & Wibowo, A. (2024). "Penilaian Capability Level Tata Kelola Keamanan TI dengan COBIT 2019 pada Aplikasi Penjualan." *Jurnal CoreIT: Jurnal Hasil Penelitian Ilmu Komputer dan Teknologi Informasi*, 9(3), 231-240.
4. Kusuma, W. A., & Sari, D. P. (2025). "Analisis GAP dan Rekomendasi Tata Kelola TI Berbasis COBIT 2019 pada UMKM Teknologi." *Jurnal Edukasi dan Penelitian Informatika (JEPIN)*, 11(1), 101-115.
5. Wijaya, R. (2026). "Penerapan COBIT 2019 Domain APO dan BAI dalam Pembangunan Aplikasi Point of Sales Terintegrasi." *Jurnal Nasional Informatika dan Teknologi Jaringan (JNTIJ)*, 7(2), 89-100.
