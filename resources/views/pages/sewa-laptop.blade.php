<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sewa PC &amp; Laptop - LKTech TN SEREAL</title>
    <meta name="description" content="Sewa PC dan Laptop harian, mingguan, dan bulanan di LKTech. Spesifikasi tinggi, harga terjangkau, antar ke lokasi. Cek status kontrak sewa dengan nomor tiket.">

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
        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        .text-shimmer-emerald {
            background: linear-gradient(to right, #059669 20%, #34d399 50%, #059669 80%);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fadeInUp 0.5s ease forwards; }
        .ticket-input:focus { box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15); }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .float-anim { animation: float 3s ease-in-out infinite; }
        .float-anim:nth-child(2) { animation-delay: 0.5s; }
        .float-anim:nth-child(3) { animation-delay: 1s; }
        .float-anim:nth-child(4) { animation-delay: 1.5s; }
        .float-anim:nth-child(5) { animation-delay: 2s; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header -->
    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full pb-20 md:pb-0">

        <!-- Hero Section -->
        <div class="relative bg-gradient-to-br from-emerald-50 via-teal-50/70 to-cyan-50 py-12 px-4 sm:px-6 lg:px-8 text-center border-b border-emerald-100/70 w-full overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-emerald-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-teal-200/20 rounded-full blur-3xl pointer-events-none"></div>



            <h1 class="text-2xl md:text-4xl font-black font-montserrat text-gray-900 mb-2 tracking-tight">
                Sewa <span class="text-shimmer-emerald">PC &amp; Laptop</span>
            </h1>
            <p class="text-gray-600 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed mt-2">
                Solusi cerdas kebutuhan perangkat IT harian, mingguan, hingga bulanan. Spesifikasi tinggi, bebas riset harga, tanpa perlu beli baru.
            </p>

            <!-- Quick CTA -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center mt-6">
                <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin info Sewa PC/Laptop.') }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg text-sm">
                    <i class='bx bxl-whatsapp text-lg'></i> Konsultasi Sewa Sekarang
                </a>
                <a href="#cara-sewa"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-emerald-600 text-emerald-600 font-bold rounded-xl transition-all hover:bg-emerald-50 text-sm">
                    <i class='bx bx-info-circle text-lg'></i> Cara Sewa
                </a>
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap justify-center gap-6 mt-8">
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600"><i class='bx bx-calendar text-base'></i></span>
                    Sewa Harian / Bulanan
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600"><i class='bx bx-car text-base'></i></span>
                    Antar ke Lokasi Anda
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600"><i class='bx bx-support text-base'></i></span>
                    Support &amp; Maintenance Gratis
                </div>
            </div>
        </div>

        <!-- =====================================================================
             FITUR TRACKING STATUS SEWA
             ===================================================================== -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-500 py-10 px-4 sm:px-6 lg:px-8"
             x-data="{
                 contractNo: '',
                 status: null,
                 loading: false,
                 error: '',
                 trackRental() {
                     if (!this.contractNo.trim()) {
                         this.error = 'Masukkan Nomor Kontrak / Invoice Sewa Anda terlebih dahulu.';
                         return;
                     }
                     this.error = '';
                     this.loading = true;
                     this.status = null;
                     setTimeout(() => {
                         const msg = encodeURIComponent('Halo LKTech, saya ingin mengecek status sewa dengan Nomor Kontrak: ' + this.contractNo.trim());
                         window.open('https://wa.me/628567354046?text=' + msg, '_blank');
                         this.loading = false;
                         this.status = {
                             kontrak: this.contractNo.trim(),
                             info: 'Permintaan pengecekan telah dikirim via WhatsApp. Tim LKTech akan membalas dan memberikan informasi status sewa Anda segera.'
                         };
                     }, 800);
                 }
             }">
            <div class="max-w-2xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 border border-white/30 text-white text-[11px] font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-widest">
                    <i class='bx bx-search-alt text-sm'></i> Cek Status Sewa
                </div>
                <h2 class="text-xl md:text-2xl font-black font-montserrat text-white mb-2">Tracking Nomor Kontrak Sewa</h2>
                <p class="text-emerald-100 text-xs md:text-sm mb-6">Masukkan Nomor Kontrak / Nomor Invoice Sewa Anda untuk mengecek status dan masa aktif sewa.</p>

                <!-- Input Form -->
                <div class="bg-white rounded-2xl shadow-xl p-5 md:p-6 text-left">
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nomor Kontrak / Invoice Sewa</label>
                    <div class="flex gap-2 sm:gap-3">
                        <input type="text"
                               x-model="contractNo"
                               @keyup.enter="trackRental()"
                               placeholder="Contoh: RNT-2026-0008 atau INV-SEWA-XXXX"
                               class="ticket-input flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-emerald-500 text-sm font-semibold text-gray-800 placeholder-gray-400 transition-all">
                        <button @click="trackRental()"
                                :disabled="loading"
                                class="shrink-0 px-5 py-3 bg-emerald-500 hover:bg-emerald-600 disabled:opacity-60 text-white font-bold rounded-xl transition-all text-sm flex items-center gap-2 shadow-md hover:shadow-lg">
                            <i class='bx bx-search text-lg' x-show="!loading"></i>
                            <i class='bx bx-loader-alt animate-spin text-lg' x-show="loading" x-cloak></i>
                            <span x-show="!loading">Cek Status</span>
                            <span x-show="loading" x-cloak>Mengecek...</span>
                        </button>
                    </div>

                    <!-- Error -->
                    <p x-show="error" x-cloak class="text-red-500 text-xs font-semibold mt-2 flex items-center gap-1">
                        <i class='bx bx-error-circle'></i> <span x-text="error"></span>
                    </p>

                    <!-- Status Result -->
                    <div x-show="status" x-cloak class="mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl fade-in-up">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center shrink-0">
                                <i class='bx bx-message-check text-white text-lg'></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">Kontrak: <span class="text-emerald-600" x-text="status && status.kontrak"></span></p>
                                <p class="text-gray-600 text-xs mt-1" x-text="status && status.info"></p>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-400 text-[10px] mt-3 text-center">Nomor kontrak terdapat pada surat perjanjian sewa atau email konfirmasi dari LKTech.</p>
                </div>
            </div>
        </div>

        <!-- Status Alur Sewa (Visual) -->
        <div class="bg-white py-8 px-4 sm:px-6 lg:px-8 border-b border-gray-100">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-center text-sm font-black text-gray-400 uppercase tracking-widest mb-6">Alur Status Kontrak Sewa</h3>
                <div class="relative">
                    <div class="hidden sm:block absolute top-5 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-emerald-100 via-emerald-300 to-teal-300 z-0"></div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 relative z-10">
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-yellow-400 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-hourglass text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-yellow-600">Menunggu Konfirmasi</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Pengajuan diverifikasi</p>
                        </div>
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-box text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-blue-600">Persiapan Unit</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Perangkat disiapkan</p>
                        </div>
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-check-circle text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-emerald-600">Aktif / Berjalan</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Masa sewa berjalan</p>
                        </div>
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-gray-400 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-flag text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-gray-500">Selesai</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Perangkat dikembalikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keuntungan Sewa -->
        <div class="bg-gradient-to-br from-emerald-50 via-white to-teal-50/40 py-12 px-4 sm:px-6 lg:px-8 border-b border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-8">
                    <span class="inline-block bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-emerald-100 mb-3">Kenapa Sewa?</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Keuntungan Sewa Laptop &amp; PC di LKTech</h2>
                    <p class="text-gray-500 text-sm max-w-2xl mx-auto">Manfaat yang tidak akan Anda dapatkan jika membeli perangkat baru sendiri.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- Benefit 1 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <i class='bx bx-money'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Hemat Biaya Modal</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Tidak perlu keluar biaya besar di awal</p>
                    </div>
                    <!-- Benefit 2 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <i class='bx bx-up-arrow-circle'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Bebas Upgrade Spek</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Ganti spesifikasi kapan saja sesuai kebutuhan</p>
                    </div>
                    <!-- Benefit 3 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <i class='bx bx-wrench'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Maintenance Gratis</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Biaya perawatan ditanggung LKTech</p>
                    </div>
                    <!-- Benefit 4 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                            <i class='bx bx-buildings'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Bebas Depresiasi</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Tidak ada kerugian penyusutan aset</p>
                    </div>
                    <!-- Benefit 5 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                            <i class='bx bx-headphone'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Support 24 Jam</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Tim siap membantu kapan pun Anda butuh</p>
                    </div>
                    <!-- Benefit 6 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                            <i class='bx bx-calendar-event'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Fleksibel Durasi</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Harian, mingguan, hingga tahunan</p>
                    </div>
                    <!-- Benefit 7 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-teal-500 group-hover:text-white transition-colors">
                            <i class='bx bx-slider-alt'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Custom Spesifikasi</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Pilih merk dan spek sesuai kebutuhan</p>
                    </div>
                    <!-- Benefit 8 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-green-500 group-hover:text-white transition-colors">
                            <i class='bx bx-gift'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Setup &amp; Instalasi Gratis</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Sudah siap pakai saat tiba di lokasi</p>
                    </div>
                    <!-- Benefit 9 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                            <i class='bx bx-group'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Tanpa Minimum Unit</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Sewa 1 unit pun bisa, tanpa minimum</p>
                    </div>
                    <!-- Benefit 10 -->
                    <div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">
                        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            <i class='bx bx-car'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-xs leading-tight">Antar ke Lokasi</h4>
                        <p class="text-[10px] text-gray-400 mt-1 leading-snug">Pengiriman langsung ke kantor atau lokasi acara</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paket Sewa -->
        <div class="bg-white py-12 px-4 sm:px-6 lg:px-8 border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <span class="inline-block bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-emerald-100 mb-3">Pilihan Paket</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Paket Sewa PC &amp; Laptop</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Harga terjangkau, spesifikasi tinggi, siap untuk berbagai kebutuhan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                    <!-- Paket Harian -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 p-8 flex flex-col h-full group">
                        <div class="w-14 h-14 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-3xl mb-5 group-hover:bg-sky-500 group-hover:text-white transition-colors group-hover:scale-110 duration-300">
                            <i class='bx bx-sun'></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1 font-montserrat">Paket Harian</h3>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-5">1 – 7 Hari</p>
                        <div class="mb-6">
                            <span class="text-3xl font-black text-gray-900">Mulai Rp 100.000</span>
                            <span class="text-gray-400 text-sm">/hari</span>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-600 font-medium flex-1 mb-6">
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> Laptop Office / Core i5+</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> RAM minimal 8GB</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> OS Windows Original</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> Cocok untuk acara &amp; training</li>
                            <li class="flex items-center gap-2"><i class='bx bx-x-circle text-gray-300 text-lg'></i> Antar-jemput (biaya tambahan)</li>
                        </ul>
                        <div class="mt-auto">
                            <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin info Sewa Laptop Paket Harian.') }}" target="_blank"
                               class="w-full block text-center px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-800 font-bold rounded-xl transition-colors border border-gray-200 text-sm">
                                Pilih Paket Harian
                            </a>
                        </div>
                    </div>

                    <!-- Paket Mingguan (Popular) -->
                    <div class="bg-white rounded-3xl border-2 border-emerald-500 shadow-2xl transition-all duration-300 p-8 flex flex-col h-full relative z-10 md:-translate-y-4 transform">
                        <div class="absolute top-0 right-0 bg-emerald-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest shadow-sm">Populer</div>
                        <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/50 to-transparent rounded-3xl pointer-events-none"></div>
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-3xl mb-5 relative z-10">
                            <i class='bx bx-calendar-week'></i>
                        </div>
                        <h3 class="text-xl font-bold text-emerald-600 mb-1 font-montserrat relative z-10">Paket Mingguan</h3>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-5 relative z-10">1 – 4 Minggu</p>
                        <div class="mb-6 relative z-10">
                            <span class="text-3xl font-black text-gray-900">Mulai Rp 550.000</span>
                            <span class="text-gray-400 text-sm">/minggu</span>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-700 font-semibold flex-1 mb-6 relative z-10">
                            <li class="flex items-center gap-2"><i class='bx bxs-check-circle text-emerald-500 text-lg'></i> Laptop Core i5 / i7 / Ryzen</li>
                            <li class="flex items-center gap-2"><i class='bx bxs-check-circle text-emerald-500 text-lg'></i> RAM 8–16GB, SSD 256GB+</li>
                            <li class="flex items-center gap-2"><i class='bx bxs-check-circle text-emerald-500 text-lg'></i> OS Windows Original + Office</li>
                            <li class="flex items-center gap-2"><i class='bx bxs-check-circle text-emerald-500 text-lg'></i> Antar ke lokasi (area tertentu)</li>
                            <li class="flex items-center gap-2"><i class='bx bxs-check-circle text-emerald-500 text-lg'></i> Support &amp; Maintenance</li>
                        </ul>
                        <div class="mt-auto relative z-10">
                            <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin info Sewa Laptop Paket Mingguan.') }}" target="_blank"
                               class="w-full block text-center px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-sm">
                                Pilih Paket Populer Ini
                            </a>
                        </div>
                    </div>

                    <!-- Paket Bulanan -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 p-8 flex flex-col h-full group">
                        <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-3xl mb-5 group-hover:bg-purple-500 group-hover:text-white transition-colors group-hover:scale-110 duration-300">
                            <i class='bx bx-calendar-star'></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1 font-montserrat">Paket Bulanan</h3>
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-5">1 Bulan ke atas</p>
                        <div class="mb-6">
                            <span class="text-3xl font-black text-gray-900">Mulai Rp 1.500.000</span>
                            <span class="text-gray-400 text-sm">/bulan</span>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-600 font-medium flex-1 mb-6">
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> Laptop / PC pilihan bebas spek</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> RAM 16–32GB, SSD NVMe</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> Full Setup &amp; Instalasi Software</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> Antar-jemput gratis (area tertentu)</li>
                            <li class="flex items-center gap-2"><i class='bx bx-check-circle text-emerald-500 text-lg'></i> Maintenance &amp; Penggantian Unit</li>
                        </ul>
                        <div class="mt-auto">
                            <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin info Sewa Laptop/PC Paket Bulanan.') }}" target="_blank"
                               class="w-full block text-center px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-800 font-bold rounded-xl transition-colors border border-gray-200 text-sm">
                                Pilih Paket Bulanan
                            </a>
                        </div>
                    </div>
                </div>

                <p class="text-center text-xs text-gray-400 mt-6">* Harga bersifat estimasi dan dapat berubah tergantung spesifikasi, durasi, dan lokasi. Hubungi kami untuk penawaran terbaik.</p>
            </div>
        </div>

        <!-- Cara Sewa -->
        <div id="cara-sewa" class="bg-gradient-to-br from-gray-50 via-white to-emerald-50/30 py-12 border-t border-gray-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNGM0Y0RjYiLz48L3N2Zz4=')] opacity-60"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-10">
                    <span class="text-emerald-600 font-bold tracking-wider uppercase text-[10px] mb-2 block bg-emerald-50 inline-block px-3 py-1 rounded-full border border-emerald-100">Step By Step</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Cara Sewa PC &amp; Laptop di LKTech</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Proses mudah dan cepat. Perangkat siap pakai langsung sampai di lokasi Anda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 relative">
                    <!-- Connecting Line (Desktop) -->
                    <div class="hidden lg:block absolute top-12 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-emerald-100 via-emerald-300 to-emerald-100 z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 p-6 text-center group hover:-translate-y-1">
                        <div class="w-14 h-14 mx-auto bg-white border-4 border-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl font-black shadow-sm mb-4 group-hover:bg-emerald-500 group-hover:border-emerald-200 group-hover:text-white transition-all">
                            1
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2 text-sm font-montserrat">Pilih Perangkat &amp; Durasi</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Konsultasikan kebutuhan spesifikasi, jumlah unit, dan durasi sewa yang Anda inginkan via WhatsApp.</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="relative z-10 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 p-6 text-center group hover:-translate-y-1">
                        <div class="w-14 h-14 mx-auto bg-white border-4 border-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl font-black shadow-sm mb-4 group-hover:bg-emerald-500 group-hover:border-emerald-200 group-hover:text-white transition-all">
                            2
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2 text-sm font-montserrat">Lengkapi Dokumen</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Siapkan KTP/identitas dan tanda tangan surat perjanjian sewa. Proses administrasi singkat dan mudah.</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="relative z-10 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 p-6 text-center group hover:-translate-y-1">
                        <div class="w-14 h-14 mx-auto bg-white border-4 border-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl font-black shadow-sm mb-4 group-hover:bg-emerald-500 group-hover:border-emerald-200 group-hover:text-white transition-all">
                            3
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2 text-sm font-montserrat">Bayar Deposit &amp; Sewa</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Lakukan pembayaran deposit jaminan dan biaya sewa pertama. Transfer bank / tunai / e-wallet tersedia.</p>
                    </div>
                    <!-- Step 4 -->
                    <div class="relative z-10 bg-emerald-50 rounded-2xl border border-emerald-100 shadow-sm hover:shadow-lg transition-all duration-300 p-6 text-center group hover:-translate-y-1">
                        <div class="w-14 h-14 mx-auto bg-emerald-500 border-4 border-emerald-200 text-white rounded-full flex items-center justify-center text-3xl font-black shadow-[0_0_20px_rgba(16,185,129,0.3)] mb-4">
                            <i class='bx bx-check'></i>
                        </div>
                        <h4 class="font-bold text-emerald-700 mb-2 text-sm font-montserrat">Perangkat Dikirim ✅</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Perangkat diantar ke alamat operasional Anda, sudah setup dan siap digunakan langsung.</p>
                    </div>
                </div>

                <!-- CTA Banner -->
                <div class="mt-14 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl p-8 md:p-10 text-center shadow-xl relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-teal-400/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10">
                        <span class="inline-block bg-white/20 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-white/30 mb-4">Mulai Sewa Sekarang</span>
                        <h3 class="text-xl md:text-2xl font-black text-white font-montserrat mb-3">Butuh PC / Laptop untuk Event, Kantor, atau Proyek?</h3>
                        <p class="text-emerald-100 text-sm leading-relaxed max-w-xl mx-auto mb-6">Kami siap menyediakan perangkat sesuai kebutuhan Anda — dari 1 unit untuk personal hingga puluhan unit untuk perusahaan dan event besar.</p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin konsultasi Sewa PC/Laptop.') }}" target="_blank"
                               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-emerald-600 font-bold rounded-xl hover:bg-emerald-50 transition shadow-md text-sm">
                                <i class='bx bxl-whatsapp text-xl text-green-500'></i> Konsultasi via WhatsApp
                            </a>
                            <a href="tel:+628567354046"
                               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white/20 border border-white/40 text-white font-bold rounded-xl hover:bg-white/30 transition text-sm">
                                <i class='bx bx-phone text-xl'></i> Hubungi Kami
                            </a>
                        </div>
                    </div>
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
