# 4. Metodologi Audit

**4.1 Pendekatan dan Teknik Audit**
Pelaksanaan audit tata kelola Sistem Informasi Manajemen Terintegrasi LKTech dilakukan melalui perpaduan pendekatan kualitatif dan kuantitatif. Pendekatan ini dipilih untuk memastikan bahwa kondisi tata kelola teknologi informasi yang sesungguhnya di lapangan dapat ditangkap secara komprehensif, tidak hanya dari sisi kelengkapan dokumen tetapi juga dari efektivitas implementasi teknis. Teknik pengumpulan data utama yang digunakan meliputi:
*   **Wawancara:** Wawancara mendalam dilakukan kepada 5 (lima) responden utama yang berinteraksi langsung dengan sistem secara intensif. Kelima responden tersebut terdiri dari 1 orang Admin yang mengelola sistem secara keseluruhan, 1 orang Kasir yang mengeksekusi modul *Point of Sales* (POS), 2 orang Teknisi yang menangani modul layanan servis, serta 1 orang Sales yang bertanggung jawab di bidang distribusi inventori.
*   **Review Dokumen:** Melakukan tinjauan terhadap ketersediaan dan kualitas *Standard Operating Procedure* (SOP) pengelolaan sistem, dokumen spesifikasi *Role-Based Access Control* (RBAC), serta kebijakan internal terkait keharusan penggunaan *Two-Factor Authentication* (2FA).
*   **Observasi Lapangan:** Pengamatan langsung terhadap interaksi pengguna dengan antarmuka sistem LKTech, validasi mekanisme masuk (*login*) menggunakan 2FA, rutinitas pencatatan pada POS, serta pengujian atas rekaman *event log* di dalam *database* selama periode Januari hingga Maret 2026.

**4.2 Model Penilaian Capability (0–5)**
Model pengukuran tingkat kapabilitas (capability level) mengacu secara penuh pada kerangka kerja COBIT 2019 *Process Assessment Model* (PAM). Proses evaluasi dilakukan menggunakan instrumen kuesioner berskala Guttman (YA/TIDAK) untuk memverifikasi setiap indikator praktik mulai dari level 0 hingga level 5. Suatu level kapabilitas dinyatakan telah tercapai secara utuh (achieved) hanya jika seluruh aktivitas dan metrik pendukung pada level tersebut telah terpenuhi secara kumulatif dan divalidasi dengan bukti nyata (*evidence*).

**4.3 Skema Rating**
Berdasarkan pedoman pengukuran standar COBIT 2019, pencapaian aktivitas diklasifikasikan ke dalam empat kategori:
*   **Fully (F):** >85% (Praktik dilaksanakan secara komprehensif dan didukung bukti yang solid).
*   **Largely (L):** 50%–85% (Sebagian besar praktik terlaksana, hanya terdapat kelemahan minor).
*   **Partially (P):** 15%–50% (Hanya ada pelaksanaan sebagian, pendekatan tidak terstruktur).
*   **Not (N):** <15% (Praktik tersebut sama sekali tidak dijalankan atau tidak memiliki bukti konkret).

**4.4 Aturan Agregasi Responden**
Untuk menanggulangi potensi bias akibat perbedaan persepsi antar responden yang memiliki peran yang sama (misalnya, perbedaan pandangan antara 2 orang Teknisi), audit ini menerapkan aturan konservatif berlogika *AND*. Apabila terdapat ketidaksesuaian jawaban, maka penilai akan mengambil nilai kapabilitas yang terendah sebagai garis dasar (*baseline*). Perbedaan ini selanjutnya dikonfirmasi ulang melalui pencocokan langsung dengan data *event log* atau riwayat *ticketing* guna mempertahankan validitas temuan audit.

---

# 5. Gambaran Objek Audit (Sisfo)

**5.1 Deskripsi Singkat Sistem**
Sistem Informasi Manajemen Terintegrasi LKTech merupakan aplikasi *Enterprise Resource Planning* (ERP) berbasis situs web (*web-based*) yang dirancang khusus untuk memenuhi kebutuhan skala Usaha Mikro, Kecil, dan Menengah (UMKM). Aplikasi ini difungsikan sebagai tulang punggung operasional bisnis ritel, menaungi berbagai proses manajerial yang krusial. Sistem ini terbagi ke dalam beberapa modul utama, yaitu Autentikasi dan Otorisasi (mencakup 2FA dan RBAC), modul *Point of Sales* (POS) untuk Kasir, modul Layanan Servis untuk perbaikan perangkat, serta modul pelacakan Inventori yang terintegrasi langsung dengan pelaporan Keuangan *real-time*. Pada saat audit berlangsung, sistem ini diperkirakan memproses puluhan transaksi harian yang menuntut tingkat keandalan, ketersediaan, serta jaminan kerahasiaan data yang sangat tinggi untuk menghindarkan organisasi dari potensi kerugian material maupun penurunan reputasi akibat manipulasi data.

**5.2 Alur Proses Bisnis Utama**
Secara runut, alur proses bisnis inti pada sistem LKTech dijabarkan sebagai berikut:
1.  **Registrasi dan Autentikasi:** Seluruh pengguna (khususnya tingkat hierarki Admin dan Kasir) wajib memverifikasi kredensial mereka melalui lapis keamanan ganda menggunakan kode OTP dari perangkat seluler (*Two-Factor Authentication*) sebelum diizinkan masuk ke *Dashboard*.
2.  **Validasi Transaksional:** Setelah hak akses (*Role-Based*) diberikan, Kasir dapat memasukkan pesanan pada antarmuka POS, atau Teknisi memasukkan detail perbaikan.
3.  **Sinkronisasi Inventori dan Pembayaran:** Setiap penyelesaian transaksi di Kasir akan secara otomatis memotong stok barang yang ada pada *database* pusat. Hal ini memastikan konsistensi jumlah stok fisik dan logis, sehingga menutup celah manipulasi.
4.  **Agregasi Laporan:** Hasil transaksi bermuara pada kalkulasi otomatis laba dan rugi (*KHS/Laporan Harian*) yang langsung disajikan ke layar Admin Utama secara akurat tanpa campur tangan proses manual.

---

# 6. Hasil Penilaian Capability (Per Proses/Praktik/Aktivitas)

Proses audit difokuskan pada pengukuran lima kapabilitas tata kelola yang paling kritis bagi sistem ritel terpadu sesuai standar COBIT 2019, yaitu manajemen operasi (DSS01), manajemen layanan keamanan (DSS05), jaminan optimisasi risiko (EDM03), manajemen risiko (APO12), dan manajemen keamanan siber (APO13). Target yang hendak dicapai oleh manajemen LKTech pada masa depan adalah **Level 3 (Established Process)**, di mana seluruh lapisan telah memiliki standarisasi prosedur yang tertulis rapi. Berdasarkan hasil validasi bukti empiris dan wawancara, nilai kapabilitas (*Current Capability*) diringkas dalam tabel di bawah ini.

**Rekap Capability Level:**

| Proses/Praktik | Current Capability (0–5) | Target Capability | Gap | Dokumen |
| :--- | :--- | :--- | :--- | :--- |
| **EDM03** – Ensured Risk Optimization | 1 | 3 | -2 | Identifikasi risiko berjalan sangat reaktif, tidak ditemukan adanya dokumen formal terkait batas toleransi risiko. |
| **APO12** – Managed Risk | 2 | 3 | -1 | Pemahaman logis mengenai profil risiko sudah ada di level internal, namun format baku mitigasi preventif belum tersedia. |
| **APO13** – Managed Security | 1 | 3 | -2 | Fitur 2FA & mekanisme RBAC aktif secara sistem (berfungsi di dalam *coding*), namun SOP administratif mengenai hak kewajiban akses sama sekali tidak terdokumentasi. |
| **DSS01** – Managed Operations | 2 | 3 | -1 | Operasional transaksi kasir dan servis sangat mulus. Sayangnya, kegiatan penting seperti *backup* dilakukan secara manual dan insidental tanpa jadwal pasti. |
| **DSS05** – Manage Security Services | 0 | 3 | -3 | Walaupun fitur *event log* terpasang pada modul kerangka kerja (*framework*), ia tidak pernah ditinjau sama sekali. Tidak ada notifikasi deteksi anomali sama sekali. |

**Narasi Deskriptif Penilaian Capability:**
Nilai kapabilitas (*Current Capability Level*) dari sistem LKTech saat ini berkisar di rentang antara **Level 1 (Performed)** hingga **Level 2 (Managed)**, dengan pengecualian pada beberapa praktik yang masih di **Level 0 (Incomplete)**. Keberadaan nilai Level 2 pada praktik *Managed Operations* (DSS01) dan *Managed Risk* (APO12) mengonfirmasi bahwa roda operasional bisnis harian seperti transaksi kasir dan penyelesaian permintaan servis telah berjalan lancar serta dikelola dengan cukup baik. Masalah utama organisasi tidak terletak pada gagalnya proses IT, melainkan pada masih tingginya ketergantungan organisasi terhadap figur tunggal, seperti staf pengembangan TI (*heroics approach*). 

Di lain sisi, fokus paling kritis tertuju pada kegagalan memenuhi standar praktik *Manage Security Services* (DSS05). Dengan kapabilitas tertahan di Level 0, LKTech saat ini nyaris 'buta' terhadap ancaman peretasan internal. Fitur *event log* pencatatan modifikasi dan rekaman otorisasi memang telah ada berkat bantuan kerangka bahasa pemrograman (*framework*), akan tetapi, tanpa adanya kebiasaan meninjau ulang dan tanpa adanya modul *alerting* dini pada saat serangan *brute force* terjadi, segala kecanggihan sistem hanyalah tempelan semata. Untuk mendobrak ke Target Level 3, langkah revolusioner yang harus diambil tidak hanya memperbaiki fungsi kode, tetapi menstandardisasi *SOP (Standard Operating Procedure)* secara kelembagaan.

---

# 7. Hasil Perhitungan Maturity

Perhitungan *Maturity* berfungsi menyajikan agregasi atau pemetaan holistik dari kondisi organisasi terhadap kapabilitas pengelolaan secara keseluruhan. Berbeda dengan skor spesifik di setiap metrik, indeks kedewasaan ini menjadi gambaran umum manajemen dalam menentukan skala prioritas strategis perbaikan sistem mereka dalam beberapa tahun mendatang.

**Tabel 7.1 Rekap Maturity:**

| Domain/Area | Metode | Nilai (0–5) | Level | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| EDM03 | Rata-rata | 1,35 | Level 1 | Kebijakan toleransi dan limit risiko administratif belum dibentuk |
| APO12 | Rata-rata | 2,10 | Level 2 | Perlu formalisasi pemetaan risiko lokal yang sudah dipahami karyawan |
| APO13 | Rata-rata | 1,45 | Level 1 | Fitur canggih 2FA yang ada secara drastis memerlukan dukungan SOP pembatasan fisik |
| DSS01 | Rata-rata | 2,30 | Level 2 | Skor memuaskan, sangat perlu penjadwalan standardisasi alat rutinitas pelaporan dan *backup* |
| DSS05 | Rata-rata | 0,85 | Level 0 | Menjadi pusaran celah keamanan yang menjadi titik fokus prioritas utama perbaikan |
| **Keseluruhan (scope audit)** | **Rata-rata** | **1,61** | **Level 1** | **Target 3 secara stabil pada tahun 2027** |

**Deskripsi Analisis Maturity Level Domain:**
Berdasarkan agregasi dari perhitungan *maturity level* menggunakan metode kuantifikasi standar COBIT 2019, gabungan domain penilaian tata kelola secara keseluruhan di LKTech mencapai angka indeks rata-rata **1,61**. Angka ini menempatkan LKTech pada batas transisi antara tata kelola tahap **Level 1 (Initial/Ad-hoc)** menuju **Level 2 (Managed)**. Artinya, proses perumusan layanan teknologi informasi sudah tidak lagi pada taraf uji coba, melainkan telah menjadi denyut nadi keseharian yang diandalkan untuk menunjang omzet toko. 

Khusus pada sub-domain *Managed Operations* (DSS01), nilai yang dicapai adalah 2,30. Ini adalah hal yang membanggakan bagi institusi skala UMKM karena hal tersebut merepresentasikan bahwa sistem transaksi yang diprogram tidak pernah mengalami hambatan struktural yang berujung pada terhentinya bisnis Kasir. Kendati demikian, lemahnya *maturity* operasional pengamanan (*Manage Security Services* - DSS05) yang amblas di angka 0,85 telah merusak fondasi keandalan aplikasi itu sendiri. Organisasi tidak boleh cepat berpuas diri dengan kelancaran antarmuka (UI). Angka rata-rata **1,61** ini menjadi justifikasi logis betapa rentannya organisasi terhadap ketiadaan prosedur tanggap darurat, sehingga pencapaian **Target Level 3 (Established)** di tahun 2027 mutlak membutuhkan serangkaian program intervensi berupa pembentukan buku manual pelaporan metrik keamanan secara persisten.

---

# 8. Temuan Audit & Analisis Risiko

Tindakan wawancara yang disilangkan dengan observasi pada log database melahirkan berbagai temuan kerentanan teknis maupun non-teknis. Tabel di bawah ini merangkum *vulnerabilities* aktual tersebut beserta *risk impact*-nya, sehingga manajemen memperoleh visibilitas mendalam atas konsekuensi bisnisnya.

**Tabel 8.1 Rekap Temuan:**

| No | Temuan | Risiko | Severity | Proses/Objektif COBIT |
| :--- | :--- | :--- | :--- | :--- |
| 1 | Tidak ada regulasi atau implementasi kode untuk *auto-logout* sesi setelah dibiarkan (*idle*). PC Kasir sering ditinggalkan begitu saja saat jam istirahat atau pertukaran sif. | Terjadinya manipulasi pelaporan transaksi POS secara sepihak oleh individu internal yang tidak memiliki otorisasi (Kasir pengganti yang curang). | High | APO13 |
| 2 | Tidak ada satupun petugas (termasuk Admin) yang memiliki rutinitas melakukan validasi ulang (*review*) atas *event log* harian. | Celah bagi skenario peretasan berkelanjutan seperti manipulasi *database* internal atau pengambilalihan akun secara repetitif tanpa jejak. | High | DSS05 |
| 3 | Pengelola (Developer) mencadangkan (*backup*) keseluruhan sistem hanya pada momentum insidental ketika server dirasa mulai mengalami degradasi performa (*slowdown*). | Kehilangan permanen atas rekaman penjualan kasir mingguan dan hilangnya riwayat suku cadang di gudang apabila server utama (*hosting*) mengalami kegagalan piranti keras tak terduga. | Medium | DSS01 |
| 4 | Karyawan sama sekali tidak dibekali sosialisasi lewat dokumen baku ihwal tanggung jawab memegang kunci akses seperti menjaga kerahasiaan OTP (2FA) di peramban yang dibagikan. | Kebocoran kredensial akses ganda (*password dan token gawai*) dikarenakan murni faktor kelalaian manusia (*human error*) atau pancingan rekayasa sosial di tempat umum. | Low | APO12 |

**Narasi Deskriptif:**
Temuan-temuan yang terdeteksi di lapangan menggarisbawahi paradoks tata kelola TI modern pada sektor usaha mikro. Secara teknologi (*Technology Adoption*), LKTech sudah berada pada standar industri teratas dengan menerapkan Two-Factor Authentication dan kriptografi berlapis pada pengelolaan basis datanya. Sayangnya, investasi teknologi ini tidak disusul oleh transformasi budaya operasional karyawannya. Sesi PC di pos *checkout* kasir yang tidak pernah dipaksa keluar (*logout*) oleh sistem menjadikan perlindungan ganda autentikasi sama sekali tidak berguna di kala jam transisi pekerja. Lebih dari itu, keabsenan kultur meninjau jejak *log* sistem membuat kejahatan berbasis manipulasi data seolah mendapatkan karpet merah akibat miskinnya supervisi digital.

---

# 9. Analisis Gap (Current vs Target)

Analisis tingkat kesenjangan (*Gap Analysis*) merupakan pemetaan jarak yang harus ditempuh organisasi untuk menyelaraskan realitas saat ini dengan impian yang dicita-citakan di masa depan. Analisis *gap* ini sangat esensial sebagai pijakan awal perumusan solusi konkret.

**Tabel 9.1 Rekapitulasi Analisis Kesenjangan:**

| Proses/ Aktivitas | Current | Target | Gap | Dampak | Prioritas |
| :--- | :--- | :--- | :--- | :--- | :--- |
| DSS05 – Keamanan Sistem | 0 | 3 | 3 | Terjadinya peretasan secara masif dari *back-end* atas akun Administrator Utama tanpa notifikasi pencegahan, berujung pada keruntuhan fungsional integritas laporan laba. | 1 (Tertinggi) |
| APO13 – Keamanan Akses | 1 | 3 | 2 | Pembiaran kerentanan akses secara fisik, penyalahgunaan fiktif sesi Kasir oleh non-karyawan saat komputer lepas dari pantauan sementara. | 2 |
| EDM03 – Tata Kelola Risiko | 1 | 3 | 2 | Kehilangan pijakan respons; tata kelola terguncang dan organisasi berlarut-larut lumpuh dalam merespons insiden gangguan sistem secara terorganisir. | 3 |
| DSS01 – Operasional & Backup | 2 | 3 | 1 | Interupsi rantai proses layanan akibat memakan jeda pemulihan *database* yang berkepanjangan ketika terjadi disfungsi di pihak penyedia peladen (*server host*). | 4 |
| APO12 – Manajemen Risiko | 2 | 3 | 1 | Kekacauan operasional ringan lantaran kebiasaan repetitif karyawan baru merusak batasan prosedur *Role-Based Access Control* (RBAC). | 5 |

**Narasi Deskriptif:**
Berdasarkan pemaparan matriks di atas, rentang *gap* terbesar (*Skor Gap = 3*) sangat didominasi oleh tidak berfungsinya domain perlindungan keamanan layanan *Manage Security Services* (DSS05). Kegagalan ini dikategorikan ke dalam tingkat prioritas penyelesaian satu (1) akibat dampak destruktif yang disebabkannya pada keberlangsungan aplikasi secara absolut. Meskipun proses rutinitas Kasir memegang *gap* sangat kecil (skor 1 pada DSS01), sistem manajemen TI pada LKTech diibaratkan seperti mobil tangguh yang mampu melaju amat kencang tetapi ketiadaan spion belakang (*monitoring log*) membuatnya tak sadar akan adanya ancaman kecelakaan hingga semuanya sudah terlambat. Kesenjangan lebar ini menjadi mandat bagi para pengambil keputusan internal untuk mengerahkan perhatian eksklusif pada pembentukan mekanisme *monitoring* yang ketat.

---

# 10. Rekomendasi & Rencana Tindak Lanjut

Dalam rangka menjembatani jurang *gap* kapabilitas hingga setidaknya mencapai zona estabilitas (*Level 3*), auditor memformulasikan rencana tindak lanjut taktis (*Action Plan*). Rencana intervensi ini tidak hanya menitikberatkan pada perbaikan struktur program (perangkat lunak), melainkan secara sadar membidik pembenahan administrasi dan dokumentasi sebagai unsur pemaksa *compliance* di kalangan staf lapangan.

**Tabel 10.1 Action Plan:**

| No | Rekomendasi | Output/Deliverable | PIC | Timeline | Indikator Sukses | Prioritas |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | Implementasi batasan kadaluwarsa *auto-logout* sesi berbasis aktivitas. | Penyusunan ulang modul manajemen sesi di dalam aplikasi LKTech dengan mengeset durasi toleransi *session idle* maksimal 10 menit. | Admin TI | Jul 2026 | >95% sesi statis otomatis mati. | High |
| 2 | Konstruksi alat peraga (UI) standardisasi peringatan *event log*. | Fitur tabel rekapan terpusat *dashboard* Admin yang dibarengi aktivasi modul notifikasi email untuk upaya pendobrakan siber. | Admin TI | Ags 2026 | Anomali pencatatan dapat dideteksi 100%. | High |
| 3 | Otomatisasi CRON jadwal pencadangan ganda harian pangkalan data secara *remote*. | Baris *CRON job script server* dengan kapabilitas pelemparan *dump database* harian menuju *Cloud Storage* cadangan independen. | Teknisi | Jul 2026 | Siklus log harian tercapai >99%. | Medium |
| 4 | Fabrikasi buku dokumentasi pedoman operasional keamanan RBAC dan pengelolaan sesi peramban. | Realisasi manual fisik berupa dokumen *Standard Operating Procedure (SOP)* per divisi dengan lampiran tanggung jawab akses. | Manajer | Sep 2026 | Audit acak memperlihatkan seluruh karyawan mendalami SOP. | Medium |

**Narasi Deskriptif:**
Rekomendasi di atas menekankan pada perbaikan *quick-wins*, di mana biaya pengadaan fitur dirancang seminim mungkin tanpa memberatkan limitasi anggaran usaha UMKM namun tetap meyakinkan bahwa dampak efikasinya menyentuh parameter kritis COBIT 2019. Modifikasi minor semacam algoritma deteksi durasi tidak aktif (*idle detection*) pada modul sesi aplikasi tidak akan mengambil waktu pengembangan (*development time*) hingga berbulan-bulan, tetapi kontribusinya pada ketahanan otorisasi (APO13) meningkat berlipat ganda. Demikian pula pembentukan antarmuka (*dashboard*) sederhana yang khusus membaca *event log* tanpa perlu *query manual*, menjamin Admin dapat memverifikasi ada tidaknya kecurangan operasional semudah mereka memeriksa margin penjualan harian.

---

# 11. Roadmap Peningkatan

Sebelum mendelegasikan waktu kapan rencana perbaikan akan dieksekusi secara kronologis, tahapan fundamental pertama adalah mengenali peta posisi internal dan eksternal LKTech lewat kajian *Strengths, Weaknesses, Opportunities, dan Threats* (SWOT) guna memastikan *roadmap* ini bersifat wajar dan dapat dicerna.

**Analisis SWOT Dasar:**

*   **S – Strengths (Kekuatan):**
    1. Mesin inti (*core engine*) proses transaksi harian (POS, Kalkulasi Inventori otomatis) sudah teruji fungsionalitas dan kelancarannya secara mumpuni (*Level 2 - Managed*).
    2. Arsitektur bawaan aplikasi nyatanya telah dikodifikasi dengan menyertakan fitur otorisasi kekinian yaitu *Two-Factor Authentication* (2FA) dan manajemen batasan divisi (RBAC).
    3. Kompetensi literasi digital para staf dan teknisi lapangan rata-rata sangat baik karena terbiasa dengan antarmuka digital yang serba transaksional.

*   **W – Weaknesses (Kelemahan):**
    1. Tradisi peninjauan dan pembacaan *event log* aktivitas keamanan belum pernah disentuh secara rutin oleh siapapun, nyaris melumpuhkan *domain* DSS05 secara praktikal.
    2. Ketahanan pencadangan sistem (*disaster resiliency*) berada dalam pusaran bahaya sebab sepenuhnya diserahkan pada memori personal pengembang secara insidental (manual).
    3. Tata bahasa keorganisasian seperti SOP administratif nyaris menyentuh nihil, hal ini mengekspos institusi kepada celah *human error* peletakan gawai atau komputer kasir yang sembarangan.

*   **O – Opportunities (Peluang):**
    1. Kelak ketika transformasi kapabilitas kematangan berhasil ditarik mencapai standar mapan Level 3, pengalaman tersebut akan membangun preseden kuat ihwal kredibilitas solusi *SaaS (Software as a Service)* UMKM yang berpotensi ditawarkan kepada cabang ritel lain dalam jaringan kemitraan.
    2. Sentuhan otomatisasi pada pengawasan analitik jejak aplikasi terbukti secara empiris berpotensi mendegradasi kerumitan beban kerja rutinitas audit akuntansi internal.

*   **T – Threats (Ancaman):**
    1. Mesin klien Kasir yang dibiarkan hidup menyala lepas kendali tanpa ter-logout (*abandoned sessions*) sangat memicu terjadinya eksploitasi pelaporan omzet dari dalam organisasi secara sunyi.
    2. Tumbangnya penyedia layanan peladen (*cloud server failure*) yang menimpa pada saat *database* mutakhir urung dibackup mingguan, akan seketika membangkrutkan sejarah data riwayat persediaan dan pelunasan piutang pelanggan untuk selamanya.

**Roadmap Realisasi Jangka Panjang:**

Berangkat dari kalkulasi komposit *SWOT*, langkah-langkah *action plan* dibelah ke dalam tiga fase perjalanan peningkatan sebagai berikut:

*   **Jangka Pendek (0–3 Bulan): Fase Stabilisasi Krisis Keamanan.** Fokus fase ini adalah pencegahan kerusakan dengan mengaktifkan proteksi wajib. Manajemen wajib menuntut tim teknis merilis (*deployment*) pembaruan algoritma *session timeout* berdurasi maksimal sepuluh menit pada seluruh PC. Pada waktu yang persis bersinggungan, tim infrastruktur memberlakukan aktivasi rutinitas skrip otomatis *backup database server* dan mulai menyusun draft manual *SOP password* kepegawaian untuk dibagikan.
*   **Jangka Menengah (3–12 Bulan): Fase Kepatuhan dan Pembangunan Otomatisasi Visual.** Setelah kerentanan esensial ditambal, ini adalah waktu mengasah instrumen deteksi. Tim pengembang perangkat lunak wajib menelurkan layar *dashboard monitoring event log* di area Admin. Melalui antarmuka inilah budaya pemeriksaan anomali harian pada data transaksi kasir tak dikenal, maupun kelakuan masuk sistem secara paksa (*brute-force*), dapat dikalkulasi setiap akhir bulan di meja manajerial.
*   **Jangka Panjang (>12 Bulan): Fase Pembaharuan Konsisten (Continuous Improvement).** Sistem sudah matang di Level 3 secara *de facto*. Tugas pada tahun-tahun mendatang adalah mengintegrasikan sistem peringatan dengan kapabilitas kecerdasan analitik prediktif untuk menanggulangi ancaman *malware* maupun intrusi siber. Sebagai perisai pamungkas, institusi wajib melatih kebiasaan penerapan agenda audit tata kelola internal evaluatif secara terus-menerus setiap setahun sekali.

---

# 12. Kesimpulan

Secara fundamental, kerangka dan pelaksanan audit tata kelola Sistem Informasi Manajemen Terintegrasi ERP skala UMKM yang dirancang oleh LKTech menghasilkan gambaran komprehensif atas kemampuan mereka menahan degradasi performa akibat guncangan ancaman teknis dan non-teknis. Berdasarkan agregasi dari model pengukuran COBIT 2019 secara metodologis, rata-rata tingkat kematangan fungsional (*maturity level*) keseluruhan sistem menapak di angka indikatif **1,61 (Level 1 menuju ke ranah Level 2 - Managed)**. Capaian ini menjadi semacam rapor kuning bila ditabrakkan dengan tuntutan impian organisasi, di mana target ideal fungsional sebagai pilar operasional berisiko tinggi harusnya sudah mapan terstandarisasi di posisi **Level 3 (Established Process)**.

Ditinjau lebih dalam, pencapaian skor mumpuni justru dipanen dari sub-domain fungsional *Managed Operations* (DSS01), yang menjadi bukti autentik kelancaran mesin program modul antarmuka transaksi Kasir. Ironisnya, kekuatan koding fitur lapis ganda otorisasi lewat *Two Factor Authentication* dan restriksi *Role-Based Access Control* (APO13) secara masif tertimbun oleh celah kegagalan institusi untuk mendisiplinkan SOP kebiasaan membiarkan sesi PC Kasir (*abandoned endpoint*) serta parahnya ketiadaan tradisi mengkaji ulasan deteksi perilaku anomali (*event log*) pada sub-domain *Manage Security Services* (DSS05). Absennya prosedur pengintaian keamanan sistem inilah yang menjelma menjadi jurang ancaman risiko prioritas tinggi, yakni terbukanya pintu lebar bagi kolusi manipulasi data transaksi yang sulit divalidasi keabsahannya oleh pimpinan UMKM.

Guna mengatasi rintangan kesenjangan tingkat layanan keamanan (*capability gaps*) yang mengancam kredibilitas LKTech, maka inisiatif solusi taktis (*roadmap*) harus menyasar integrasi pada lini pertahanan administratif dan rutinitas pengawasan. Rekomendasi prioritas puncak yang wajib direalisasikan dalam waktu kurang dari triwulan meliputi penerapan skrip restriksi kedaluwarsa sesi secara terotomasi (*auto-logout module*), penyemaian jadwal pencadangan ganda arsip pangkalan data setiap senja ke media eksternal (CRON eksternal), serta konstruksi antarmuka panel *dashboard* untuk memfasilitasi pembacaan ringkasan *event log*. Kepatuhan manajemen terhadap penyelesaian ketiga tonggak ini niscaya akan menjadi pelumas transformasi signifikan demi meraih level Established Process (Level 3) sekaligus membalut sistem LKTech sebagai mahakarya tata kelola TI berbasis keunggulan reaktif sekaligus prediktif di kancah persaingan niaga UMKM di masa mendatang.

---

# LAMPIRAN
*   **Lampiran A. Daftar Responden & RACI** (Memuat bagan peran tanggung jawab dan hierarki konsultasi kelima responden yang teridentifikasi, yaitu Manajer Operasional sebagai *Accountable*, teknisi dan kasir sebagai *Responsible*, serta jalur koordinasi ke pihak *Consulted*).
*   **Lampiran B. Instrumen Kuesioner (Guttman/CPM)** (Menyajikan instrumen *checklist* tabel konfirmasi Guttman [YA/TIDAK] parameter metrik turunan COBIT 2019 pada level 0-5 secara rigid yang dikomparasi secara silang antar responden).
*   **Lampiran C. Evidence Register (Daftar Bukti)** (Merangkum seluruh koleksi hasil pemotretan tangkapan layar terkait konfigurasi basis data peladen, riwayat *commit coding* fitur 2FA, serta keabsenan bundel dokumen kebijakan proteksi secara definitif).
*   **Lampiran D. Rekap Perhitungan Capability & Maturity** (Melampirkan hitung-hitungan statistika mentah, perkalian matriks persentase kapabilitas dalam wujud lembar lajur perhitungan komprehensif penentu indeks 1,61).
*   **Lampiran E. Bukti Pendukung** (Galeri lampiran tambahan memvisualisasikan *Dashboard* modul Kasir, panel manajemen Inventori, dan form *login* sekuritas yang diamati saat periode audit berjalan pada permulaan kuartal pertama tahun 2026).
