<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FAQ & Pusat Bantuan - LKTech TN SEREAL</title>
    <meta name="description" content="Temukan jawaban atas pertanyaan seputar pembelian laptop, servis komputer, kebijakan garansi, cara pembayaran, dan layanan LKTech lainnya.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .faq-answer {
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        }
        .category-pill.active {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 4px 12px rgba(37,99,235,0.25);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <x-navbar />

    <main class="flex-grow w-full">

        <!-- Hero Header -->
        <div class="bg-gradient-to-br from-brand-600 via-blue-700 to-cyan-600 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
            </div>
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-8 lg:py-10 text-center relative z-10">
                <div class="inline-flex items-center gap-1 sm:gap-1.5 bg-white/20 backdrop-blur-sm border border-white/30 rounded-full px-2.5 py-0.5 sm:px-3 sm:py-1 text-[10px] sm:text-xs font-semibold mb-2.5 sm:mb-4">
                    <i class='bx bx-help-circle text-sm sm:text-base'></i>
                    <span>Pusat Bantuan & FAQ</span>
                </div>
                <h1 class="text-[1.35rem] sm:text-2xl lg:text-4xl font-black font-montserrat leading-tight mb-1.5 sm:mb-3 drop-shadow-sm">
                    Ada Pertanyaan? <br>Kami Siap Bantu! 🙋
                </h1>
                <p class="text-blue-100 text-[10.5px] sm:text-sm lg:text-base max-w-2xl mx-auto leading-normal sm:leading-relaxed px-1 sm:px-0">
                    Temukan jawaban atas pertanyaan yang paling sering ditanyakan seputar pembelian, pembayaran, garansi, dan layanan LKTech. Santai aja, kami jelaskan dengan bahasa yang mudah dipahami.
                </p>
            </div>
        </div>

        <!-- Main FAQ Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-10 sm:py-10 lg:py-14"
             x-data="{
                 activeCategory: 'semua',
                 openItem: null,
                 categories: [
                     { id: 'semua', label: '🏠 Semua', icon: 'bx-list-ul' },
                     { id: 'pembelian', label: '🛒 Pembelian', icon: 'bx-cart' },
                     { id: 'garansi', label: '🛡️ Garansi', icon: 'bx-shield-check' },
                     { id: 'servis', label: '🔧 Servis', icon: 'bx-wrench' },
                     { id: 'lainnya', label: '💡 Lainnya', icon: 'bx-info-circle' },
                 ],
                 faqs: [
                     {
                         id: 1, cat: 'semua',
                         q: 'LKTech itu toko apa sih? Jual apa aja?',
                         a: 'LKTech TN Sereal adalah toko IT terpercaya di kawasan Tanah Sereal, Bogor. Spesialisasi utama kami ada di penjualan laptop dan komputer (baru maupun second premium), servis & perbaikan hardware, rakit PC custom, sewa perangkat IT, lisensi software digital, dan jasa pembuatan website profesional. Singkatnya: semua urusan IT dan digital Anda, serahkan ke kami! 😄'
                     },
                     {
                         id: 2, cat: 'semua',
                         q: 'Di mana lokasi toko LKTech?',
                         a: 'Kami berlokasi di Villa Mutiara 1 Sektor 2, BLOK i-18 No.03, Tanah Sereal, Bogor 16168. Bisa juga hubungi kami dulu via WhatsApp di nomor +62 856-7354-046 sebelum berkunjung, biar kami siapkan unitnya terlebih dahulu. 🗺️'
                     },
                     {
                         id: 3, cat: 'semua',
                         q: 'Jam operasional LKTech?',
                         a: 'Kami buka Senin – Sabtu, pukul 09.00 – 17.00 WIB. Untuk konsultasi dan tanya-tanya, chat WhatsApp kami biasanya responsif mulai pagi hingga malam hari. Jadi jangan ragu hubungi kapan saja! ⏰'
                     },
                     {
                         id: 4, cat: 'pembelian',
                         q: 'Metode pembayaran apa saja yang diterima?',
                         a: 'Kami menerima berbagai metode pembayaran agar transaksi Anda makin mudah:\n\n• Transfer bank: Mandiri (Livin\'), BNI (wondr)\n• E-Wallet: GoPay, OVO, DANA, ShopeePay, LinkAja\n• QRIS (scan di tempat)\n• Tunai langsung di toko\n• Cicilan & PayLater via Tokopedia (Cicilan Kartu Kredit, GoPayLater, Shopee PayLater, dll)\n\nPunya metode pembayaran lain yang diinginkan? Hubungi kami dulu, kami cari solusinya bersama! 💳'
                     },
                     {
                         id: 5, cat: 'pembelian',
                         q: 'Bisa beli lewat Tokopedia dan bayar cicilan atau PayLater?',
                         a: 'Bisa banget! Toko resmi LKTech di Tokopedia tersedia di sini: tokopedia.com/lktech-tn-sereal\n\nDi Tokopedia, Anda bisa memanfaatkan fitur:\n• Cicilan Kartu Kredit (0%)\n• GoPayLater – bayar belakangan, praktis!\n• Shopee PayLater\n• Cicilan tanpa kartu kredit via layanan BNPL (Buy Now Pay Later) lainnya yang tersedia di Tokopedia\n\nBelanja online lebih aman, ada perlindungan transaksi dari platform. Klik tombol Tokopedia di bawah untuk mulai belanja! 🛍️'
                     },
                     {
                         id: 6, cat: 'pembelian',
                         q: 'Apakah produk yang dijual original dan berkualitas?',
                         a: 'Tentu! Setiap produk yang kami jual, terutama laptop dan komputer second, wajib melewati 2 tahap Quality Control (QC) ketat yang kami terapkan:\n\n1. QC Fisik – Kondisi body, layar, keyboard, port, dan baterai\n2. QC Performa – Stress test CPU/GPU, benchmark, cek software dan driver\n\nBarang baru yang kami jual juga 100% produk resmi dengan kelengkapan garansi resmi dari distributor atau produsen. Kami tidak jual produk abal-abal! ✅'
                     },
                     {
                         id: 7, cat: 'pembelian',
                         q: 'Apakah bisa pesan dulu sebelum datang ke toko?',
                         a: 'Sangat direkomendasikan! Hubungi kami via WhatsApp di +62 856-7354-046 terlebih dahulu untuk:\n• Mengecek ketersediaan stok terkini\n• Konsultasi spesifikasi yang sesuai kebutuhan dan budget\n• Reservasi unit agar tidak kehabisan\n\nKami juga siap kirim via ekspedisi untuk pelanggan di luar Bogor. 📦'
                     },
                     {
                         id: 8, cat: 'pembelian',
                         q: 'Apakah ada layanan pengiriman untuk pelanggan di luar Bogor?',
                         a: 'Ada! Kami melayani pengiriman ke seluruh Indonesia via JNE, J&T, SiCepat, dan ekspedisi lainnya. Untuk pembelian melalui Tokopedia, pengiriman sudah terintegrasi langsung dengan platform dan terlindungi asuransi pengiriman. Harga ongkir dihitung otomatis berdasarkan berat dan tujuan. 🚚'
                     },
                     {
                         id: 9, cat: 'garansi',
                         q: 'Berapa lama masa garansi produk dari LKTech?',
                         a: 'Kami memberikan jaminan garansi yang transparan:\n\n• Garansi Mesin: 2 (dua) minggu sejak tanggal pembelian\n• Garansi Software (khusus OS dan MS Office): Lifetime (Seumur Hidup) selama tidak di-uninstall atau instal ulang.\n\nMasa garansi mesin dihitung dari tanggal yang tertera di nota/struk pembelian. Simpan nota Anda baik-baik ya! 📋'
                     },
                     {
                         id: 10, cat: 'garansi',
                         q: 'Apa saja syarat untuk klaim garansi?',
                         a: 'Agar klaim garansi dapat diproses dengan lancar, pastikan kondisi berikut terpenuhi:\n\n✅ Nota pembelian wajib dilampirkan atau ditunjukkan saat pengajuan klaim\n✅ Segel garansi toko di bagian bawah laptop harus masih utuh, tidak rusak atau sobek\n✅ Kerusakan bukan disebabkan oleh kelalaian pengguna (human error) seperti: terjatuh, terkena air/cairan, korsleting listrik, atau modifikasi pihak ketiga\n\nJika Anda tidak yakin apakah kerusakan termasuk cakupan garansi, hubungi kami dulu via WhatsApp untuk konsultasi awal. Kami akan bantu evaluasi kondisinya! 🤝'
                     },
                     {
                         id: 11, cat: 'garansi',
                         q: 'Bagaimana prosedur klaim garansi / pengembalian barang?',
                         a: 'Prosesnya mudah dan transparan:\n\n1. Hubungi kami via WhatsApp untuk laporan awal dan penjadwalan\n2. Bawa unit beserta kelengkapannya (charger + tas/dus jika ada) ke toko kami\n3. Teknisi kami akan melakukan pemeriksaan menyeluruh\n4. Estimasi waktu: 1–3 hari kerja untuk diagnosis\n5. Kami berikan keputusan: perbaikan gratis (dalam garansi) atau penggantian unit (jika stok tersedia)\n\nKami komitmen memberikan keputusan yang adil dan transparan. Kepercayaan Anda adalah prioritas! 🛡️'
                     },
                     {
                         id: 12, cat: 'garansi',
                         q: 'Garansi apa yang TIDAK ditanggung?',
                         a: 'Ada beberapa kondisi yang tidak termasuk dalam cakupan garansi kami:\n\n❌ Kerusakan akibat jatuh, terbentur, atau tekanan fisik\n❌ Kerusakan akibat terkena air atau cairan lainnya\n❌ Kerusakan akibat korsleting atau tegangan listrik tidak stabil\n❌ Kerusakan akibat modifikasi hardware/software oleh pihak ketiga tanpa sepengetahuan LKTech\n❌ Segel garansi toko yang rusak/dicongkel\n\nNamun jangan khawatir, kami tetap bisa membantu servis di luar garansi dengan biaya yang terjangkau dan transparan! 😊'
                     },
                     {
                         id: 13, cat: 'servis',
                         q: 'Layanan servis apa saja yang tersedia di LKTech?',
                         a: 'Kami melayani berbagai kebutuhan servis IT:\n\n🔧 Perbaikan hardware: penggantian layar, keyboard, baterai, RAM, SSD, motherboard\n💿 Instalasi & reinstall ulang sistem operasi Windows/Linux\n🦠 Pembersihan virus, malware, dan optimasi sistem\n🌡️ Deep cleaning dan thermal paste (bersih kipas, pasta processor)\n⚡ Upgrade spesifikasi laptop/PC (tambah RAM, ganti SSD)\n📊 Backup & recovery data\n🏢 Maintenance berkala untuk instansi/perusahaan\n\nHubungi kami untuk konsultasi gratis! 📞'
                     },
                     {
                         id: 14, cat: 'servis',
                         q: 'Berapa lama waktu servis laptop/komputer?',
                         a: 'Estimasi waktu servis tergantung jenis kerusakan:\n\n• Servis ringan (install ulang, clean virus): 1 hari kerja\n• Servis sedang (ganti baterai, keyboard, RAM): 1–2 hari kerja\n• Servis berat (ganti layar, motherboard, data recovery): 3–7 hari kerja\n• Kasus khusus (menunggu spare part): bisa lebih lama, kami informasikan lebih lanjut\n\nKami selalu update perkembangan servis via WhatsApp agar Anda tidak perlu khawatir! 📱'
                     },
                     {
                         id: 15, cat: 'servis',
                         q: 'Apakah ada biaya konsultasi atau diagnosa?',
                         a: 'Tidak ada! Konsultasi awal dan diagnosa kerusakan di toko kami GRATIS. Kami percaya kejujuran adalah fondasi kepercayaan.\n\nSetelah diagnosa, kami akan sampaikan estimasi biaya perbaikan secara transparan sebelum pengerjaan dimulai. Anda bebas memutuskan untuk lanjut atau tidak, tanpa ada tekanan atau biaya tersembunyi. 👍'
                     },
                     {
                         id: 16, cat: 'servis',
                         q: 'Bagaimana cara mendaftar servis laptop/komputer?',
                         a: 'Sangat mudah! Ada beberapa cara:\n\n1. Langsung datang ke toko kami di Tanah Sereal, Bogor\n2. Hubungi via WhatsApp di +62 856-7354-046 untuk booking jadwal servis\n3. Ceritakan gejala kerusakan, kami bantu diagnosis awal via chat\n\nSarankan untuk hubungi dulu sebelum datang agar antrian bisa diatur dan teknisi kami siap menerima unit Anda. 🗓️'
                     },
                     {
                         id: 17, cat: 'lainnya',
                         q: 'Apakah LKTech menyediakan layanan rakit PC custom?',
                         a: 'Iya, ini salah satu layanan unggulan kami! 💻\n\nKami melayani konsultasi dan perakitan PC sesuai kebutuhan Anda:\n• PC Gaming – performa tinggi dengan budget tepat\n• PC Office/Editing – stabil dan efisien\n• PC Rendering/Server – spesifikasi berat untuk profesional\n\nProses kami: konsultasi → penentuan spesifikasi → pengadaan komponen → perakitan → stress test → pengiriman/pengambilan. Kunjungi halaman Rakit PC kami atau langsung konsultasi via WhatsApp!'
                     },
                     {
                         id: 18, cat: 'lainnya',
                         q: 'Apakah LKTech menyediakan jasa pembuatan website?',
                         a: 'Tentu! Kami membantu bisnis dan UMKM go-digital dengan jasa pembuatan website profesional:\n\n🌐 Company profile dan landing page\n🛒 Website toko online / e-commerce\n📊 Sistem manajemen internal (ERP/CRM sederhana)\n📝 Blog dan portal berita\n\nSemua dibuat responsif, cepat loading, dan SEO-friendly. Harga mulai dari yang terjangkau hingga enterprise. Konsultasi gratis via WhatsApp! 🚀'
                     },
                     {
                         id: 19, cat: 'lainnya',
                         q: 'LKTech juga punya layanan lain selain IT?',
                         a: 'Sebagai bentuk diversifikasi dan kemitraan, kami juga bermitra dalam beberapa layanan tambahan:\n\n📶 WiFi Voucher Starlink – Solusi internet satelit untuk desa, kos-kosan, atau kawasan wisata (info via WhatsApp)\n🪑 Jasa Furniture – Konsultasi dan pengadaan furnitur untuk rumah atau kantor (info via WhatsApp)\n🍫 Martabak Jawara – Rekomendasi kuliner martabak premium di area Bogor\n\nLayanan ini bersifat mitra/tambahan dan tidak mengganggu fokus utama kami di bidang IT & teknologi. Tanya via WhatsApp untuk info lebih lanjut!'
                     },
                     {
                         id: 20, cat: 'lainnya',
                         q: 'Apakah LKTech menerima kerjasama atau pengadaan partai besar?',
                         a: 'Sangat welcome! Kami terbuka untuk:\n\n🤝 Pengadaan laptop/komputer untuk instansi, sekolah, atau perusahaan (dalam jumlah besar)\n🏢 Kontrak maintenance IT berkala untuk kantor atau instansi\n🔄 Program reseller dan kemitraan distribusi\n\nHubungi kami langsung via WhatsApp untuk mendapatkan penawaran harga khusus dan negosiasi lebih lanjut. Kami senang membangun kemitraan jangka panjang! 📊'
                     },
                     {
                         id: 21, cat: 'pembelian',
                         q: 'Bagaimana cara melakukan order atau pembelian langsung di website LKTech?',
                         a: 'Sangat mudah! Pilih produk yang Anda inginkan dari halaman Katalog, lalu klik tombol &quot;Beli / Pesan&quot;. Masukkan produk ke keranjang, isi formulir data diri beserta alamat pengiriman dengan lengkap. Setelah itu, selesaikan pesanan (Checkout). Sistem akan otomatis memproses pesanan Anda. 🛒'
                     },
                     {
                         id: 22, cat: 'pembelian',
                         q: 'Apakah saya akan mendapatkan tagihan dan Invoice untuk pesanan saya?',
                         a: 'Tentu saja! Setelah Anda menyelesaikan form checkout, sistem kami akan otomatis mengirimkan tagihan awal (Proforma Invoice) ke alamat email Anda.\n\nSetelah Anda melakukan pembayaran dan kami konfirmasi, Anda akan menerima email bukti lunas beserta lampiran file PDF Invoice resmi yang dapat Anda unduh dan simpan. 📄'
                     },
                     {
                         id: 23, cat: 'pembelian',
                         q: 'Bagaimana cara melacak pesanan (tracking) yang sudah saya beli?',
                         a: 'Setiap pesanan yang berhasil dibuat akan mendapatkan Nomor Unik (Nomor Pesanan) yang akan dikirimkan ke email Anda.\n\nAnda dapat menggunakan nomor unik tersebut untuk melakukan tracking atau mengecek status proses maupun resi pengiriman barang secara langsung dengan menghubungi admin kami via WhatsApp. 📍'
                     },
                     {
                         id: 24, cat: 'pembelian',
                         q: 'Kemana saya harus melakukan konfirmasi pembayaran setelah transfer?',
                         a: 'Setelah melakukan transfer pembayaran sesuai dengan nominal tagihan di Proforma Invoice, Anda dapat mengonfirmasi pembayaran dengan cara mengirimkan bukti transfer/struk langsung ke nomor WhatsApp admin kami di +62 856-7354-046 agar pesanan Anda dapat langsung kami proses ke tahap pengiriman! 📲'
                     },
                     {
                         id: 25, cat: 'pembelian',
                         q: 'Apakah bisa melakukan pembayaran menggunakan Kartu Kredit?',
                         a: 'Bisa banget! Anda dapat membayar pesanan menggunakan Kartu Kredit dengan dua cara yang sangat mudah:\n\n1. Melakukan scan QRIS di toko atau dari tagihan kami (Pastikan aplikasi Mobile Banking Anda mendukung pembayaran QRIS dengan sumber dana dari Kartu Kredit).\n2. Melakukan pembelian melalui toko resmi kami di Tokopedia (Anda dapat menggunakan Kartu Kredit untuk pembayaran lunas maupun menikmati fasilitas cicilan 0%).\n\nPilih metode yang paling nyaman untuk Anda! 💳'
                     },
                     {
                         id: 26, cat: 'garansi',
                         q: 'Apakah pembelian software berlisensi seperti Windows atau Office juga mendapat garansi?',
                         a: 'Tentu saja! Khusus untuk setiap pembelian software berlisensi original seperti Microsoft Office LTSC, Microsoft Windows 10 Pro, dan Windows 11 Pro, LKTech memberikan **Garansi Lifetime (Seumur Hidup)**!\n\nLisensi dijamin aktif secara permanen. Jika ada kendala aktivasi kapan pun di masa depan, Anda bisa langsung menghubungi kami untuk mendapatkan bantuan penuh. 🛡️'
                     },
                 ],
                 get filteredFaqs() {
                     if (this.activeCategory === 'semua') return this.faqs;
                     return this.faqs.filter(f => f.cat === this.activeCategory || f.cat === 'semua');
                 },
                 toggle(id) {
                     this.openItem = this.openItem === id ? null : id;
                 }
             }">

            <!-- Category Pills & Policy Links -->
            <div class="flex flex-wrap justify-center gap-1.5 sm:gap-2 mb-5 sm:mb-8 xl:flex-nowrap">
                <template x-for="cat in categories" :key="cat.id">
                    <button
                        @click="activeCategory = cat.id; openItem = null"
                        :class="activeCategory === cat.id
                            ? 'bg-brand-600 text-white shadow-lg shadow-brand-200 scale-105'
                            : 'bg-white text-gray-600 border border-gray-200 hover:border-brand-300 hover:text-brand-600'"
                        class="category-pill px-2.5 py-1 sm:px-4 sm:py-2 rounded-full text-[11px] sm:text-sm font-bold transition-all duration-200 cursor-pointer whitespace-nowrap"
                        x-text="cat.label">
                    </button>
                </template>
                
                <!-- Policy Anchor Links -->
                <a href="#kebijakan-privasi" 
                   class="bg-white text-gray-600 border border-gray-200 hover:border-blue-300 hover:text-blue-600 category-pill px-2.5 py-1 sm:px-4 sm:py-2 rounded-full text-[11px] sm:text-sm font-bold transition-all duration-200 cursor-pointer whitespace-nowrap flex items-center justify-center">
                    🔒 Privasi
                </a>
                <a href="#syarat-ketentuan" 
                   class="bg-white text-gray-600 border border-gray-200 hover:border-emerald-300 hover:text-emerald-600 category-pill px-2.5 py-1 sm:px-4 sm:py-2 rounded-full text-[11px] sm:text-sm font-bold transition-all duration-200 cursor-pointer whitespace-nowrap flex items-center justify-center">
                    📝 Ketentuan
                </a>
            </div>

            <!-- FAQ Count Info -->
            <div class="flex items-center justify-between mb-6">
                <p class="text-xs sm:text-sm text-gray-500">
                    Menampilkan <span class="font-bold text-gray-700" x-text="filteredFaqs.length"></span> pertanyaan
                </p>
                <button @click="openItem = null" x-show="openItem !== null" class="text-xs text-brand-600 hover:underline font-semibold" x-cloak>
                    Tutup semua
                </button>
            </div>

            <!-- FAQ Accordion List -->
            <div class="space-y-3">
                <template x-for="faq in filteredFaqs" :key="faq.id">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200"
                         :class="openItem === faq.id ? 'border-brand-300 shadow-md ring-1 ring-brand-200' : ''">

                        <!-- Question Header -->
                        <button @click="toggle(faq.id)"
                                class="w-full flex items-center justify-between gap-3 px-4 py-3 sm:gap-4 sm:px-5 sm:py-4 text-left rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-400 focus:ring-offset-1 group">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full flex items-center justify-center shrink-0 transition-colors duration-200"
                                     :class="openItem === faq.id ? 'bg-brand-600 text-white' : 'bg-brand-50 text-brand-600 group-hover:bg-brand-100'">
                                    <i class='bx bx-question-mark text-sm sm:text-base'></i>
                                </div>
                                <span class="font-bold text-gray-800 text-xs sm:text-base leading-tight"
                                      :class="openItem === faq.id ? 'text-brand-700' : ''"
                                      x-text="faq.q"></span>
                            </div>
                            <div class="shrink-0 w-6 h-6 sm:w-7 sm:h-7 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="openItem === faq.id ? 'bg-brand-600 text-white rotate-180' : 'bg-gray-100 text-gray-400 group-hover:bg-gray-200'">
                                <i class='bx bx-chevron-down text-base sm:text-lg'></i>
                            </div>
                        </button>

                        <!-- Answer Body -->
                        <div x-show="openItem === faq.id"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             x-cloak>
                            <div class="px-4 pb-4 sm:px-5 sm:pb-5 pt-0">
                                <div class="ml-9 sm:ml-10 pl-0 border-t border-gray-100 pt-3">
                                    <p class="text-gray-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line" x-text="faq.a"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Empty state -->
                <div x-show="filteredFaqs.length === 0" class="py-12 text-center" x-cloak>
                    <i class='bx bx-search-alt text-5xl text-gray-300 block mb-3'></i>
                    <p class="text-gray-500 font-semibold">Tidak ada FAQ di kategori ini.</p>
                </div>
            </div>

            <!-- Informasi Kebijakan & Ketentuan -->
            <div class="mt-12 space-y-6">
                <!-- Kebijakan Garansi -->
                <div id="kebijakan-garansi" class="bg-amber-50 border border-amber-200 rounded-2xl p-4 sm:p-6 transition-all hover:shadow-md scroll-mt-24">
                    <div class="flex items-start gap-3 sm:gap-4">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                            <i class='bx bx-shield-check text-lg sm:text-xl text-amber-600'></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-amber-800 mb-1 sm:mb-2 text-base sm:text-lg">Kebijakan Garansi Resmi</h3>
                            <p class="text-amber-700 text-xs sm:text-sm leading-relaxed text-justify">
                                Syarat dan ketentuan garansi dibuat untuk melindungi hak Anda sebagai pembeli dan menjaga transparansi setiap transaksi di LKTech.
                                Garansi mesin berlaku <strong>2 minggu</strong> sejak tanggal pembelian, garansi software (khusus OS dan MS Office) berlaku <strong>Lifetime</strong> selama tidak di-uninstall atau instal ulang.
                                Klaim garansi mesin wajib disertai nota pembelian & segel garansi yang masih utuh.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Kebijakan Privasi -->
                    <div id="kebijakan-privasi" class="bg-blue-50 border border-blue-200 rounded-2xl p-4 sm:p-6 transition-all hover:shadow-md scroll-mt-24">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                                <i class='bx bx-lock-alt text-lg sm:text-xl text-blue-600'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-blue-800 mb-1 sm:mb-2 text-base sm:text-lg">Kebijakan Privasi</h3>
                                <p class="text-blue-700 text-xs sm:text-sm leading-relaxed text-justify">
                                    Kami sangat menghargai privasi Anda. Data pribadi yang Anda berikan (seperti nama, alamat, nomor telepon, dan email) hanya digunakan untuk keperluan pemrosesan pesanan, pengiriman, dan layanan pelanggan terkait. Kami tidak akan membagikan atau menjual informasi pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <div id="syarat-ketentuan" class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 sm:p-6 transition-all hover:shadow-md scroll-mt-24">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                                <i class='bx bx-file text-lg sm:text-xl text-emerald-600'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-emerald-800 mb-1 sm:mb-2 text-base sm:text-lg">Syarat & Ketentuan</h3>
                                <p class="text-emerald-700 text-xs sm:text-sm leading-relaxed text-justify">
                                    Dengan melakukan transaksi di LKTech, Anda setuju dengan ketentuan yang berlaku. Harga dan ketersediaan stok dapat berubah sewaktu-waktu. Segala bentuk pembatalan pesanan setelah barang dikirim mengikuti kebijakan retur. LKTech berhak membatalkan pesanan jika terdapat ketidaksesuaian data atau indikasi kecurangan demi keamanan bersama.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-10 bg-gradient-to-br from-brand-600 to-blue-700 rounded-3xl p-8 text-white text-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white rounded-full"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white rounded-full"></div>
                </div>
                <div class="relative z-10">
                    <h3 class="text-lg sm:text-2xl font-black font-montserrat mb-1 sm:mb-2">Masih Ada Pertanyaan? 🤔</h3>
                    <p class="text-blue-100 text-xs sm:text-base mb-5 sm:mb-6 max-w-lg mx-auto leading-relaxed px-2">
                        Jangan ragu untuk langsung menghubungi kami! Tim kami siap membantu Anda dengan ramah dan profesional, dari Senin sampai Sabtu.
                    </p>
                    <div class="flex flex-row gap-2 sm:gap-3 justify-center">
                        <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20punya%20pertanyaan%20seputar%20layanan%20LKtech."
                           target="_blank"
                           class="inline-flex flex-1 sm:flex-none items-center justify-center gap-1.5 sm:gap-2 bg-emerald-500 hover:bg-emerald-400 text-white font-bold px-3 py-2.5 sm:px-6 sm:py-3 rounded-xl text-[11px] sm:text-base transition-all duration-200 hover:-translate-y-0.5 shadow-lg shadow-emerald-900/30">
                            <i class='bx bxl-whatsapp text-base sm:text-xl'></i>
                            WhatsApp
                        </a>
                        <a href="https://www.tokopedia.com/lktech-tn-sereal"
                           target="_blank"
                           class="inline-flex flex-1 sm:flex-none items-center justify-center gap-1.5 sm:gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-bold px-3 py-2.5 sm:px-6 sm:py-3 rounded-xl border border-white/30 text-[11px] sm:text-base transition-all duration-200 hover:-translate-y-0.5">
                            <i class='bx bx-store text-base sm:text-xl'></i>
                            Tokopedia
                        </a>
                    </div>
                    <p class="text-blue-200 text-[10px] sm:text-xs mt-4 sm:mt-4">
                        ⭐ Cicilan & PayLater tersedia di Tokopedia | 📍 Tanah Sereal, Bogor
                    </p>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
