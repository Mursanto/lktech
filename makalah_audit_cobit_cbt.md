# MAKALAH AUDIT SISTEM INFORMASI
**EVALUASI TATA KELOLA TEKNOLOGI INFORMASI PADA APLIKASI COMPUTER BASED TEST (CBT) MENGGUNAKAN FRAMEWORK COBIT 2019**

---

## BAB 1 PENDAHULUAN

### 1.1 Latar Belakang
Perkembangan teknologi informasi (TI) telah membawa transformasi digital di berbagai sektor, tidak terkecuali di bidang pendidikan dan asesmen. Institusi pendidikan dan lembaga sertifikasi kini secara masif beralih dari ujian konvensional berbasis kertas (Paper Based Test/PBT) menuju ujian berbasis komputer (Computer Based Test/CBT). Transisi ini menawarkan berbagai efisiensi, mulai dari penghematan biaya operasional, kecepatan pemrosesan hasil ujian, hingga pencegahan kecurangan melalui pengacakan soal.

Namun, ketergantungan yang tinggi terhadap aplikasi CBT memunculkan risiko baru terkait dengan tata kelola TI. Gangguan pada server, kegagalan sistem keamanan (kebocoran soal), ketidaksesuaian fungsionalitas aplikasi dengan kebutuhan pengguna, hingga absennya prosedur penanganan insiden dapat berakibat fatal pada integritas proses evaluasi. Oleh karena itu, diperlukan sebuah evaluasi dan audit sistem informasi yang komprehensif untuk memastikan aplikasi CBT dikelola dengan baik, selaras dengan tujuan institusi, dan risikonya dapat dimitigasi.

Framework COBIT (Control Objectives for Information and Related Technologies) 2019 yang dirilis oleh ISACA merupakan kerangka kerja komprehensif yang diakui secara global untuk tata kelola dan manajemen TI perusahaan. Menggunakan COBIT 2019, makalah ini akan melakukan audit sistem informasi terhadap sebuah aplikasi CBT secara mendalam, mencakup aspek *Governance* dan *Management* untuk mengukur kapabilitas sistem dan memberikan rekomendasi strategis demi penyempurnaan aplikasi.

### 1.2 Rumusan Masalah
Berdasarkan latar belakang di atas, rumusan masalah dalam penelitian ini adalah:
1. Bagaimana kondisi tata kelola teknologi informasi pada aplikasi Computer Based Test (CBT) saat ini?
2. Berapa nilai tingkat kapabilitas (Capability Level) pada aplikasi CBT berdasarkan domain EDM, APO, BAI, DSS, dan MEA pada framework COBIT 2019?
3. Seberapa besar kesenjangan (GAP) yang terjadi antara kondisi kapabilitas TI saat ini dengan target kapabilitas yang diharapkan institusi?
4. Rekomendasi perbaikan apa yang dapat diberikan untuk meningkatkan tata kelola dan kinerja aplikasi CBT?

### 1.3 Tujuan Penelitian
Adapun tujuan dari penulisan makalah ini adalah:
1. Mengevaluasi kondisi tata kelola dan manajemen TI pada aplikasi CBT yang sedang berjalan.
2. Mengukur Capability Level pada proses TI berdasarkan kerangka kerja COBIT 2019.
3. Melakukan GAP Analysis untuk menemukan kekurangan atau kelemahan dari tata kelola sistem.
4. Memberikan usulan dan rekomendasi perbaikan yang realistis, implementatif, dan berbasis risiko untuk pengembangan aplikasi CBT di masa depan.

### 1.4 Manfaat Penelitian
Penelitian ini diharapkan dapat memberikan manfaat sebagai berikut:
1. **Bagi Institusi/Pengembang Aplikasi:** Menjadi rujukan dan landasan evaluasi untuk memperbaiki arsitektur, keamanan, serta manajemen operasional CBT.
2. **Bagi Akademisi:** Menambah literatur dan wawasan praktis mengenai penerapan implementasi framework COBIT 2019 pada aplikasi berskala spesifik.

---

## BAB 2 TINJAUAN PUSTAKA

### 2.1 Konsep Sistem Informasi
Sistem Informasi adalah suatu sistem di dalam sebuah organisasi yang mempertemukan kebutuhan pengolahan transaksi harian, mendukung operasi, bersifat manajerial, dan kegiatan strategi dari suatu organisasi serta menyediakan pihak luar tertentu dengan laporan-laporan yang diperlukan. Komponen utama dari sebuah sistem informasi meliputi perangkat keras (hardware), perangkat lunak (software), basis data (database), jaringan (network), prosedur, dan sumber daya manusia (brainware).

### 2.2 Konsep Computer Based Test (CBT)
Computer Based Test (CBT) merupakan sistem pelaksanaan ujian yang menggunakan komputer dan jaringan internet/intranet sebagai media utama. Karakteristik utama CBT adalah kemampuannya menyajikan soal dalam berbagai format multimedia, sistem pewaktuan (*timer*) otomatis, fitur *auto-grading* yang memproses nilai secara seketika (*real-time*), serta mekanisme *anti-cheating* seperti penguncian peramban (*Safe Exam Browser*).

### 2.3 Penjelasan COBIT 2019
COBIT 2019 adalah kerangka kerja tata kelola TI (IT Governance) yang diterbitkan oleh ISACA (Information Systems Audit and Control Association). Berbeda dengan versi sebelumnya (COBIT 5), COBIT 2019 menekankan pada fleksibilitas melalui konsep *design factors* yang memungkinkan kerangka kerja dirancang khusus (tailored) sesuai dengan ukuran dan kebutuhan organisasi. COBIT 2019 secara tegas membedakan antara Tata Kelola (Governance) yang merupakan domain Dewan Direksi/Manajemen Puncak, dan Manajemen (Management) yang merupakan domain eksekutif TI operasional.

### 2.4 Domain COBIT 2019
Kerangka kerja Inti (Core Model) COBIT 2019 membagi 40 sasaran tata kelola dan manajemen ke dalam 5 domain utama:
1. **EDM (Evaluate, Direct, and Monitor):** Merupakan ranah Tata Kelola. Menitikberatkan pada evaluasi opsi strategis, pemberian arahan ke manajemen TI, serta pemantauan pencapaian strategi (contoh: EDM03 - *Ensure Risk Optimization*).
2. **APO (Align, Plan, and Organize):** Ranah Manajemen. Mengelola strategi, struktur organisasi, inovasi, hingga anggaran TI agar selaras dengan tujuan bisnis (contoh: APO12 - *Managed Risk*).
3. **BAI (Build, Acquire, and Implement):** Ranah Manajemen. Berhubungan dengan pembangunan sistem, akuisisi, pengujian, hingga rilis implementasi aplikasi (contoh: BAI03 - *Managed Solutions Identification and Build*).
4. **DSS (Deliver, Service, and Support):** Ranah Manajemen. Domain teknis operasional harian, termasuk manajemen insiden, layanan, dan keamanan siber (contoh: DSS05 - *Managed Security Services*).
5. **MEA (Monitor, Evaluate, and Assess):** Ranah Manajemen. Proses evaluasi berkala mengenai performa sistem dan kepatuhan terhadap regulasi (contoh: MEA01 - *Managed Performance and Conformance Monitoring*).

### 2.5 Capability Level (0-5)
COBIT 2019 menggunakan model penilaian *Capability Level* berbasis CMMI (Capability Maturity Model Integration). Skala penilaian berjenjang dari 0 hingga 5:
- **Level 0 (Incomplete):** Proses tidak diimplementasikan atau gagal mencapai tujuan proses.
- **Level 1 (Performed):** Proses telah diimplementasikan dan berhasil mencapai tujuannya namun belum terstruktur secara baik (ad-hoc).
- **Level 2 (Managed):** Proses telah dikelola, direncanakan, dipantau, dan disesuaikan. Memiliki kebijakan dasar.
- **Level 3 (Established):** Proses telah didefinisikan dengan standar yang baku dan terdokumentasi dengan baik di seluruh organisasi.
- **Level 4 (Predictable):** Proses berjalan di dalam batas yang ditentukan secara kuantitatif (dapat diukur tingkat kesuksesannya dengan metrik yang jelas).
- **Level 5 (Optimizing):** Proses terus-menerus ditingkatkan secara berkesinambungan (continuous improvement) melalui inovasi teknologi.

---

## BAB 3 METODOLOGI PENELITIAN

### 3.1 Jenis Penelitian
Penelitian ini menggunakan metode kualitatif deskriptif. Pendekatan kualitatif dipilih karena memungkinkan peneliti untuk membedah masalah tata kelola TI secara kontekstual melalui narasi, fakta operasional, dan justifikasi logis terhadap pengelolaan aplikasi CBT.

### 3.2 Teknik Pengumpulan Data
Data yang valid merupakan fondasi penilaian audit yang obyektif. Pengumpulan data dalam audit CBT ini menggunakan tiga metode:
1. **Observasi:** Melakukan inspeksi langsung pada lingkungan produksi CBT, mencakup arsitektur server, manajemen database, dan antarmuka *admin/user*.
2. **Wawancara Terstruktur:** Dilakukan terhadap pemangku kepentingan kunci yang meliputi:
   - Manajer TI / Penanggung Jawab Sistem (Chief Information Officer).
   - Pengembang Perangkat Lunak (Developer/Programmer).
   - Administrator Ujian (End-user management).
3. **Kuesioner Pemetaan (COBIT 2019 Toolset):** Penyebaran kuesioner berbasis COBIT 2019 *Capability Assessment* kepada responden untuk memvalidasi aktivitas proses (Process Activities).

### 3.3 Pemetaan Domain COBIT yang Digunakan
Karena tidak semua ke-40 proses COBIT relevan untuk studi kasus aplikasi skala spesifik, audit ini menggunakan prinsip *tailoring* dan memfokuskan penilaian pada 5 objektif proses yang mewakili kelima domain COBIT:
1. **EDM03:** Ensure Risk Optimization (Optimalisasi Risiko)
2. **APO07:** Managed Human Resources (Manajemen SDM TI)
3. **BAI03:** Managed Solutions Identification and Build (Pembangunan Solusi)
4. **DSS05:** Managed Security Services (Layanan Keamanan)
5. **MEA01:** Managed Performance and Conformance Monitoring (Pemantauan Kinerja)

### 3.4 RACI Chart Sederhana (Studi Kasus DSS05)
Untuk memperjelas tanggung jawab proses keamanan (DSS05), digunakan diagram RACI (Responsible, Accountable, Consulted, Informed):
| Aktivitas DSS05 (Keamanan CBT) | Direktur / Kepala Sekolah | Manajer TI | Programmer | Staf Pengawas Ujian |
| :--- | :---: | :---: | :---: | :---: |
| DSS05.01 Melindungi dari Malware | I | A | R | I |
| DSS05.02 Manajemen Jaringan (DDoS) | I | A | R | - |
| DSS05.03 Keamanan Fisik Server | I | A/R | C | - |
| DSS05.04 Manajemen Akses (RBAC) | C | A | R | I |

### 3.5 Skala Penilaian Capability Level
Perhitungan kuesioner dilakukan menggunakan skala rasio kecukupan pemenuhan indikator dari ISACA:
- **N (Not Achieved):** 0% - 15% (Skor 0)
- **P (Partially Achieved):** 15% - 50% (Skor proporsional, belum mencapai level penuh)
- **L (Largely Achieved):** 50% - 85% (Mendekati level penuh)
- **F (Fully Achieved):** 85% - 100% (Proses sepenuhnya tercapai)
Rata-rata dari nilai pembobotan aktivitas pada tiap domain akan direpresentasikan menjadi skor bulat/desimal untuk analisis GAP.

---

## BAB 4 HASIL DAN PEMBAHASAN

### 4.1 Deskripsi Sistem CBT
Aplikasi CBT yang diaudit adalah sistem ujian berbasis web yang dibangun menggunakan framework PHP (Laravel) dan basis data MySQL. Aplikasi ini mencakup fitur:
- Manajemen Bank Soal (Pilihan Ganda, Essay).
- Manajemen Peserta Ujian dan Pengawas.
- Sistem Token/PIN dinamis untuk login sesi ujian.
- Penghitung mundur waktu ujian otomatis.
- *Real-time grading* dan *Leaderboard*.

### 4.2 Identifikasi dan Analisis Domain TI

#### 4.2.1 Domain EDM03 - Ensure Risk Optimization
**Kondisi Saat Ini:**
Tata kelola risiko terhadap kegagalan ujian (misalnya listrik mati atau server *down* akibat lonjakan *traffic* dari ribuan peserta secara bersamaan) sudah mulai dipikirkan. Namun, kebijakan mitigasi risiko tersebut belum didokumentasikan dalam Standard Operating Procedure (SOP) formal. Keputusan penambahan *bandwidth* dilakukan secara reaktif saat masalah terjadi.

**Temuan Masalah:**
Manajemen puncak belum memiliki profil risiko TI yang jelas (*IT Risk Register*). Mitigasi risiko sangat bergantung pada intuisi Manajer TI.

**Nilai Capability Level:** **Level 1 (Performed)**.
Proses mitigasi risiko dilakukan secara ad-hoc dan reaktif. Belum ada manajemen risiko yang terencana dan didokumentasikan (Managed - Level 2).

#### 4.2.2 Domain APO07 - Managed Human Resources
**Kondisi Saat Ini:**
Pengembangan dan pemeliharaan aplikasi dikerjakan oleh tim IT internal yang terdiri dari 2 orang Programmer dan 1 orang SysAdmin. Pengetahuan teknis (Transfer Knowledge) hanya bersirkulasi di antara individu tersebut tanpa dokumentasi tertulis.

**Temuan Masalah:**
Ketergantungan yang berlebihan pada individu (Key Person Risk). Jika *programmer* utama *resign*, institusi akan kesulitan untuk memperbaiki *bug* atau memelihara sistem. Tidak ada program pelatihan (*training*) berkesinambungan untuk tim IT tentang celah keamanan aplikasi web terbaru.

**Nilai Capability Level:** **Level 2 (Managed)**.
Terdapat struktur tim yang jelas, namun belum ada standarisasi proses pengelolaan kompetensi secara institusional (Level 3).

#### 4.2.3 Domain BAI03 - Managed Solutions Identification and Build
**Kondisi Saat Ini:**
Sistem telah dibangun dengan *framework* modern (Laravel) dan versi PHP terbaru yang didukung *library* pengamanan *built-in*. Namun, pengembangan fitur (misalnya penambahan modul ujian Essay) tidak melalui tahap *Software Development Life Cycle* (SDLC) yang ketat dan jarang melalui pengujian *User Acceptance Test* (UAT) sebelum diunggah ke *production*.

**Temuan Masalah:**
Ketiadaan lingkungan pengujian yang terpisah secara tegas (*Testing/Staging Environment*). *Bugs* baru kerap muncul di lingkungan *live* saat pengguna melaksanakan ujian.

**Nilai Capability Level:** **Level 2 (Managed)**.
Proses pengembangan perangkat lunak berhasil (*performed*) dan memiliki rancangan, tetapi tidak memiliki dokumentasi rilis dan pengujian formal (*Establishment*).

#### 4.2.4 Domain DSS05 - Managed Security Services
**Kondisi Saat Ini:**
Keamanan otentikasi cukup baik; kata sandi peserta dan admin telah dienkripsi (Bcrypt), dan terdapat fitur *Role-Based Access Control* (RBAC). Namun, tidak ada mitigasi terhadap akses tidak sah secara fisik dan belum ada log keamanan terpusat untuk mendeteksi *brute-force attack*.

**Temuan Masalah:**
Akun *SuperAdmin* hanya dilindungi *password* sederhana tanpa *Two-Factor Authentication* (2FA). Peserta dapat membuka tab (jendela) baru selama ujian untuk mencari jawaban karena sistem *Safe Exam Browser* (penguncian peramban) belum diimplementasikan dengan sempurna di sisi klien.

**Nilai Capability Level:** **Level 1 (Performed)**.
Keamanan logis dasar (enkripsi DB) tersedia, namun standar keamanan layanan berkelanjutan masih lemah dan tidak proaktif dalam mendeteksi ancaman sesi ujian.

#### 4.2.5 Domain MEA01 - Managed Performance and Conformance Monitoring
**Kondisi Saat Ini:**
Kinerja aplikasi CBT dipantau semata-mata dengan melihat kelancaran jalannya ujian. Tidak ada indikator kinerja (Key Performance Indicators / KPI) yang didefinisikan secara kuantitatif (seperti target *uptime* 99,9% atau batas *response time* di bawah 2 detik). 

**Temuan Masalah:**
Aktivitas sistem (Activity Logs) tidak dimonitor secara rutin. Tidak ada audit kepatuhan (baik internal maupun eksternal) untuk memvalidasi integritas data hasil ujian pasca-implementasi.

**Nilai Capability Level:** **Level 1 (Performed)**.
Pemantauan dilakukan secara reaktif atas dasar teguran operasional, tanpa adanya kerangka evaluasi berbasis metrik (Predictable).

---

### 4.3 Tabel Hasil Penilaian Capability Level

Tabel berikut menunjukkan perbandingan Level Kapabilitas saat ini (As-Is) dan Target yang diharapkan (To-Be) oleh manajemen institusi demi kelancaran ujian CBT:

| Domain | Deskripsi Proses COBIT 2019 | Current Level (As-Is) | Target Level (To-Be) | GAP | Status |
| :--- | :--- | :---: | :---: | :---: | :--- |
| **EDM03** | Ensure Risk Optimization | 1 | 3 | 2 | Perlu Perbaikan Segera |
| **APO07** | Managed Human Resources | 2 | 3 | 1 | Perlu Peningkatan |
| **BAI03** | Managed Solutions Build | 2 | 3 | 1 | Perlu Peningkatan |
| **DSS05** | Managed Security Services | 1 | 4 | 3 | **Kritis / Prioritas Utama** |
| **MEA01** | Managed Performance | 1 | 3 | 2 | Perlu Perbaikan Segera |

*Keterangan Target: Level 3 dan 4 menargetkan agar tata kelola sistem distandardisasi dan dapat diukur secara kuantitatif, sangat penting untuk reliabilitas ujian berskala besar.*

---

### 4.4 Analisis GAP (Kesenjangan)

Berdasarkan tabel di atas, rata-rata *Capability Level* aplikasi CBT berada pada kisaran **Level 1,4**. GAP terbesar dan paling krusial terletak pada domain keamanan operasional **(DSS05)** dengan jarak 3 poin (Level 1 ke Level 4).

Tingginya GAP pada DSS05 mengindikasikan bahwa meskipun CBT berjalan fungsional (bisa untuk ujian), sistem ini sangat rentan terhadap manipulasi nilai, kebocoran soal ujian, maupun serangan siber (DDoS) saat pelaksanaan ujian serentak. 

GAP pada **EDM03** (Risiko) dan **MEA01** (Evaluasi Kinerja) dengan selisih 2 poin memperlihatkan bahwa manajemen tidak memiliki instrumen kendali. Jika ujian terputus masal (server lumpuh), tidak ada SOP mitigasi yang disiapkan secara formal. Ketiadaan dokumentasi arsitektur di **BAI03** juga menjadi bahaya laten jika terjadi pergantian SDM IT (**APO07**).

---

### 4.5 Rekomendasi Perbaikan Tata Kelola

Berdasarkan analisis GAP dan kelemahan kondisi saat ini, usulan perbaikan (Rekomendasi) yang adaptif dan dapat langsung diimplementasikan pada aplikasi CBT adalah:

1. **Rekomendasi Domain EDM03 (Optimalisasi Risiko):**
   - Manajemen harus menyusun *IT Risk Register* yang mendata potensi kegagalan ujian (mati listrik, *bandwidth* penuh, server *crash*) lengkap dengan skenario pemulihannya (Disaster Recovery Plan / DRP).
   - Menyiapkan arsitektur *High Availability* atau penyewaan VPS cadangan selama masa pekan ujian.

2. **Rekomendasi Domain APO07 (Manajemen SDM):**
   - Mewajibkan *programmer* membuat *System Documentation* dan *User Manual* yang *up-to-date*.
   - Menyimpan seluruh *source code* aplikasi pada *version control* (Git) institusi, bukan di *repository* pribadi programmer, untuk mengurangi mitigasi *key person risk*.

3. **Rekomendasi Domain BAI03 (Pembangunan Solusi):**
   - Menerapkan metodologi SDLC (misal: Agile).
   - Memisahkan secara kaku antara server *Testing* (untuk uji coba soal/fitur) dan server *Production* (untuk ujian langsung). Setiap rilis wajib diuji stres (Stress Testing) menggunakan alat seperti Apache JMeter untuk mensimulasikan login ribuan peserta secara bersamaan.

4. **Rekomendasi Domain DSS05 (Keamanan Layanan) - PRIORITAS KRITIS:**
   - **Teknis:** Segera aplikasikan fitur keamanan *Two-Factor Authentication* (2FA) menggunakan Google Authenticator atau OTP via Email khusus bagi akun level *Admin/Superadmin* untuk mencegah pengambilalihan hak akses bank soal.
   - **Klien:** Integrasikan aplikasi CBT dengan teknologi peramban terkunci (misalnya Safe Exam Browser / SEB) untuk menonaktifkan fitur *copy-paste* dan menutup tab lain saat peserta mengerjakan ujian.
   - Mengaktifkan rekam log transaksi lengkap (*Activity Logs*) yang mencatat alamat IP dan aktivitas perubahan jawaban/nilai secara *real-time*.

5. **Rekomendasi Domain MEA01 (Pemantauan Kinerja):**
   - Memasang fitur metrik pemantauan server (*Server Monitoring*) di halaman *dashboard* admin yang menunjukkan utilitas CPU, RAM, dan I/O secara langsung.
   - Melakukan evaluasi rutin antar panitia ujian dan tim TI setelah setiap periode ujian selesai untuk mendiskusikan *bug* yang terjadi dan rencana perbaikannya.

---

## BAB 5 PENUTUP

### 5.1 Kesimpulan
Berdasarkan hasil audit sistem informasi menggunakan framework COBIT 2019 terhadap aplikasi *Computer Based Test* (CBT), dapat disimpulkan bahwa tata kelola dan kapabilitas sistem saat ini masih berada pada rata-rata **Level 1,4 (antara Performed dan Managed)**. Aplikasi telah berhasil memfasilitasi kebutuhan fungsional ujian, namun sangat lemah dalam hal standarisasi, pengawasan, serta keamanan siber berkelanjutan. Kesenjangan (GAP) yang paling parah terdapat pada kapabilitas layanan keamanan (DSS05). Ketiadaan manajemen risiko formal (EDM03) menjadikan sistem sangat berisiko gagal saat digunakan dalam ujian serentak dalam skala besar.

### 5.2 Saran
Pihak institusi pengelola sistem direkomendasikan untuk tidak hanya berfokus pada penambahan fitur antarmuka, melainkan harus mulai memprioritaskan tata kelola di level *back-end* dan prosedur organisasional. Rekomendasi paling krusial yang harus segera dijalankan adalah implementasi keamanan ganda (2FA) bagi administrator, integrasi penguncian peramban anti-curang, pembuatan dokumentasi sumber kode, serta pengadaan infrastruktur server yang diuji secara reguler menggunakan beban tinggi (*stress test*). Melalui langkah-langkah perbaikan ini, diharapkan aplikasi CBT dapat mencapai level *Established* (Level 3) hingga *Predictable* (Level 4) demi menjamin objektivitas, reliabilitas, dan keamanan asesmen pendidikan di masa yang akan datang.

---
*Makalah ini disusun sebagai laporan akademis dan profesional audit tata kelola Sistem Informasi berstandar COBIT 2019.*
