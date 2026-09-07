<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service PC &amp; Laptop - LKTech TN SEREAL</title>
    <meta name="description" content="Layanan service PC dan laptop profesional di LKTech. Teknisi berpengalaman, sparepart original, garansi service. Cek status servis dengan nomor tiket.">

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
        .text-shimmer-amber {
            background: linear-gradient(to right, #d97706 20%, #fbbf24 50%, #d97706 80%);
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
        .status-step { transition: all 0.4s ease; }
        .ticket-input:focus { box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header -->
    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full pb-20 md:pb-0">

        <!-- Hero Section -->
        <div class="relative bg-gradient-to-br from-amber-50 via-orange-50/70 to-yellow-50 py-10 px-4 sm:px-6 lg:px-8 text-center border-b border-amber-100/70 w-full overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-amber-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-orange-200/20 rounded-full blur-3xl pointer-events-none"></div>



            <h1 class="text-2xl md:text-4xl font-black font-montserrat text-gray-900 mb-2 tracking-tight">
                Service <span class="text-shimmer-amber">PC &amp; Laptop</span>
            </h1>
            <p class="text-gray-600 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed mt-2">
                Perbaikan profesional oleh teknisi berpengalaman. Diagnosa cepat, sparepart original, dan garansi pengerjaan resmi dari LKTech.
            </p>

            <!-- Stats Bar -->
            <div class="flex flex-wrap justify-center gap-6 mt-6">
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center text-amber-600"><i class='bx bx-check-shield text-base'></i></span>
                    Garansi Service 30 Hari
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center text-amber-600"><i class='bx bx-time text-base'></i></span>
                    Pengerjaan 1–3 Hari
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600 font-semibold">
                    <span class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center text-amber-600"><i class='bx bx-chip text-base'></i></span>
                    Sparepart Original
                </div>
            </div>
        </div>

        <!-- =====================================================================
             FITUR TRACKING STATUS SERVICE
             ===================================================================== -->
        <div class="bg-gradient-to-r from-amber-600 to-orange-500 py-10 px-4 sm:px-6 lg:px-8"
             x-data="{
                 ticketNo: '',
                 status: null,
                 loading: false,
                 error: '',
                 trackService() {
                     if (!this.ticketNo.trim()) {
                         this.error = 'Masukkan Nomor Tiket Service Anda terlebih dahulu.';
                         return;
                     }
                     this.error = '';
                     this.loading = true;
                     this.status = null;
                     // Redirect ke WhatsApp dengan nomor tiket
                     setTimeout(() => {
                         const msg = encodeURIComponent('Halo LKTech, saya ingin mengecek status service dengan Nomor Tiket: ' + this.ticketNo.trim());
                         window.open('https://wa.me/628567354046?text=' + msg, '_blank');
                         this.loading = false;
                         this.status = {
                             tiket: this.ticketNo.trim(),
                             info: 'Permintaan pengecekan telah dikirim via WhatsApp. Tim LKTech akan membalas segera.'
                         };
                     }, 800);
                 }
             }">
            <div class="max-w-2xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 border border-white/30 text-white text-[11px] font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-widest">
                    <i class='bx bx-search-alt text-sm'></i> Cek Status Service
                </div>
                <h2 class="text-xl md:text-2xl font-black font-montserrat text-white mb-2">Tracking Nomor Tiket Service</h2>
                <p class="text-amber-100 text-xs md:text-sm mb-6">Masukkan Nomor Tiket / Nomor Invoice Service Anda untuk mengecek status pengerjaan.</p>

                <!-- Input Form -->
                <div class="bg-white rounded-2xl shadow-xl p-5 md:p-6 text-left">
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Nomor Tiket / Invoice Service</label>
                    <div class="flex gap-2 sm:gap-3">
                        <input type="text"
                               x-model="ticketNo"
                               @keyup.enter="trackService()"
                               placeholder="Contoh: SVC-2026-0012 atau INV-XXXXXX"
                               class="ticket-input flex-1 px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-amber-500 text-sm font-semibold text-gray-800 placeholder-gray-400 transition-all">
                        <button @click="trackService()"
                                :disabled="loading"
                                class="shrink-0 px-5 py-3 bg-amber-500 hover:bg-amber-600 disabled:opacity-60 text-white font-bold rounded-xl transition-all text-sm flex items-center gap-2 shadow-md hover:shadow-lg">
                            <i class='bx bx-search text-lg' x-show="!loading"></i>
                            <i class='bx bx-loader-alt animate-spin text-lg' x-show="loading" x-cloak></i>
                            <span x-show="!loading">Cek Status</span>
                            <span x-show="loading" x-cloak>Mengecek...</span>
                        </button>
                    </div>

                    <!-- Error -->
                    <p x-show="error" x-text="error" x-cloak class="text-red-500 text-xs font-semibold mt-2 flex items-center gap-1"><i class='bx bx-error-circle'></i> <span x-text="error"></span></p>

                    <!-- Status Result -->
                    <div x-show="status" x-cloak class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl fade-in-up">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center shrink-0">
                                <i class='bx bx-message-check text-white text-lg'></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">Tiket: <span class="text-amber-600" x-text="status && status.tiket"></span></p>
                                <p class="text-gray-600 text-xs mt-1" x-text="status && status.info"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Help Text -->
                    <p class="text-gray-400 text-[10px] mt-3 text-center">Nomor tiket ada di nota/struk service atau email konfirmasi dari LKTech.</p>
                </div>
            </div>
        </div>

        <!-- Progress Steps (Visual Status Service) -->
        <div class="bg-white py-8 px-4 sm:px-6 lg:px-8 border-b border-gray-100">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-center text-sm font-black text-gray-400 uppercase tracking-widest mb-6">Alur Status Pengerjaan Service</h3>
                <div class="relative">
                    <!-- Connecting line -->
                    <div class="hidden sm:block absolute top-5 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-amber-100 via-amber-300 to-emerald-300 z-0"></div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 relative z-10">
                        <!-- Step 1 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-package text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-amber-600">Diterima</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Perangkat masuk & dicatat</p>
                        </div>
                        <!-- Step 2 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-analyse text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-blue-600">Diagnosa</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Identifikasi kerusakan</p>
                        </div>
                        <!-- Step 3 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-cog text-lg'></i>
                            </div>
                            <p class="text-xs font-bold text-orange-600">Pengerjaan</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Perbaikan oleh teknisi</p>
                        </div>
                        <!-- Step 4 -->
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-sm shadow-md mb-2 group-hover:scale-110 transition-transform">
                                <i class='bx bx-check text-xl'></i>
                            </div>
                            <p class="text-xs font-bold text-emerald-600">Selesai</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">Siap diambil / dikirim</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jenis Kerusakan -->
        <div class="bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-8">
                    <span class="inline-block bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-amber-100 mb-3">Jenis Layanan</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Apa Masalah PC / Laptop Anda?</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kami menangani berbagai kerusakan perangkat keras maupun perangkat lunak.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Masalah 1 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Performa Lambat / Lemot') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <i class='bx bx-trending-down text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Performa Lambat</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Lemot, loading lama, lag saat multitasking</p>
                    </a>
                    <!-- Masalah 2 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Suka Hang / Mati Sendiri') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center mb-3 group-hover:bg-red-500 group-hover:text-white transition-colors">
                            <i class='bx bx-power-off text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Hang / Mati Sendiri</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Restart tiba-tiba, freeze, blue screen (BSOD)</p>
                    </a>
                    <!-- Masalah 3 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Cepat Panas / Overheat') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center mb-3 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            <i class='bx bx-droplet-half text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Cepat Panas (Overheat)</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Fan kencang, suhu tinggi, thermal paste kering</p>
                    </a>
                    <!-- Masalah 4 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Layar Rusak / LCD Bermasalah') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <i class='bx bx-window-close text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Layar / LCD Rusak</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Retak, blank, bergaris, flickering, backlight mati</p>
                    </a>
                    <!-- Masalah 5 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Keyboard / Touchpad Bermasalah') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-purple-50 text-purple-500 rounded-xl flex items-center justify-center mb-3 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                            <i class='bx bx-keyboard text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Keyboard / Touchpad</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Tombol macet, tidak responsif, touchpad error</p>
                    </a>
                    <!-- Masalah 6 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Baterai / Charger Bermasalah') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center mb-3 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                            <i class='bx bx-battery text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Baterai / Charger</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Baterai drop, tidak charge, charger konslet</p>
                    </a>
                    <!-- Masalah 7 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Tidak Bisa Konek WiFi / LAN') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-sky-50 text-sky-500 rounded-xl flex items-center justify-center mb-3 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                            <i class='bx bx-wifi-off text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Koneksi WiFi / LAN</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Tidak terdeteksi, sering putus, kecepatan rendah</p>
                    </a>
                    <!-- Masalah 8 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Casing / Engsel Rusak') }}" target="_blank"
                       class="group bg-white rounded-2xl border border-gray-100 p-5 hover:border-amber-300 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 text-left cursor-pointer">
                        <div class="w-10 h-10 bg-gray-100 text-gray-500 rounded-xl flex items-center justify-center mb-3 group-hover:bg-gray-500 group-hover:text-white transition-colors">
                            <i class='bx bx-wrench text-xl'></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-amber-600 transition-colors">Casing / Engsel Rusak</h4>
                        <p class="text-[11px] text-gray-400 leading-snug">Engsel patah, casing retak, port USB longgar</p>
                    </a>
                </div>

                <!-- More -->
                <div class="text-center mt-6">
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin konsultasi masalah laptop/PC saya.') }}" target="_blank"
                       class="inline-flex items-center gap-2 text-sm font-bold text-amber-600 hover:text-amber-700 bg-amber-50 border border-amber-200 px-5 py-2.5 rounded-xl transition-all hover:bg-amber-100">
                        <i class='bx bxl-whatsapp text-lg text-green-500'></i> Masalah Lainnya? Konsultasi Gratis via WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Keunggulan Service -->
        <div class="bg-white py-10 px-4 sm:px-6 lg:px-8 border-t border-gray-100">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-8">
                    <span class="inline-block bg-brand-50 text-brand-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-brand-100 mb-3">Mengapa Memilih LKTech?</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Keunggulan Service Kami</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="group bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-amber-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-amber-500 group-hover:text-white transition-colors group-hover:scale-110 group-hover:rotate-3 duration-300">
                            <i class='bx bx-user-check'></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 font-montserrat">Teknisi Berpengalaman</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Ditangani langsung oleh teknisi bersertifikat dengan pengalaman lebih dari 5 tahun di bidang hardware dan software komputer.</p>
                    </div>
                    <div class="group bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-amber-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-blue-500 group-hover:text-white transition-colors group-hover:scale-110 group-hover:rotate-3 duration-300">
                            <i class='bx bx-chip'></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 font-montserrat">Sparepart Original</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Kami hanya menggunakan sparepart original dan bergaransi resmi. Tidak ada komponen KW yang bisa merusak perangkat Anda lebih parah.</p>
                    </div>
                    <div class="group bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-amber-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors group-hover:scale-110 group-hover:rotate-3 duration-300">
                            <i class='bx bx-check-shield'></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 font-montserrat">Garansi Service 30 Hari</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Setiap pengerjaan service dijamin dengan garansi 30 hari. Jika masalah yang sama muncul kembali, kami perbaiki tanpa biaya tambahan.</p>
                    </div>
                    <div class="group bg-gray-50 rounded-3xl p-5 border border-gray-100 hover:border-amber-200 hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:bg-purple-500 group-hover:text-white transition-colors group-hover:scale-110 group-hover:rotate-3 duration-300">
                            <i class='bx bx-time-five'></i>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 font-montserrat">Pengerjaan 1–3 Hari</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Diagnosa dilakukan di hari yang sama dan mayoritas pengerjaan bisa selesai dalam 1–3 hari kerja, tergantung ketersediaan sparepart.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alur Service -->
        <div class="bg-gradient-to-br from-gray-50 via-white to-amber-50/30 py-12 border-t border-gray-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNGM0Y0RjYiLz48L3N2Zz4=')] opacity-60"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-10">
                    <span class="text-amber-600 font-bold tracking-wider uppercase text-[10px] mb-2 block bg-amber-50 inline-block px-3 py-1 rounded-full border border-amber-100">Step By Step</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Alur Service di LKTech</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Proses transparan dan mudah. Anda akan mendapat update setiap tahapnya.</p>
                </div>

                <div class="relative">
                    <div class="absolute left-6 md:left-1/2 transform md:-translate-x-1/2 h-full w-0.5 bg-gradient-to-b from-amber-100 via-orange-200 to-emerald-100"></div>
                    <div class="space-y-0 relative">
                        <!-- Step 1 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-16 group">
                            <div class="order-2 md:order-1 ml-4 md:ml-0 md:w-5/12 text-left md:text-right">
                                <div class="bg-white/90 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <div class="flex items-center gap-2 md:justify-end mb-1">
                                        <span class="text-xs font-black text-amber-500 uppercase tracking-wider bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">Langkah 1</span>
                                    </div>
                                    <h4 class="text-base md:text-lg font-bold text-gray-900 mb-1 font-montserrat">Bawa / Antar Perangkat</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Bawa laptop atau PC Anda ke toko LKTech, atau hubungi kami untuk layanan antar-jemput di area tertentu.</p>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-amber-100 text-amber-600 font-black text-lg shadow-[0_0_15px_rgba(245,158,11,0.15)] group-hover:bg-amber-500 group-hover:border-amber-200 group-hover:text-white transition-all duration-300">
                                <i class='bx bx-store text-xl'></i>
                            </div>
                            <div class="hidden md:block order-3 md:w-5/12"></div>
                        </div>
                        <!-- Step 2 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-16 group">
                            <div class="hidden md:block order-1 md:w-5/12"></div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-blue-100 text-blue-600 font-black text-lg shadow-[0_0_15px_rgba(59,130,246,0.15)] group-hover:bg-blue-500 group-hover:border-blue-200 group-hover:text-white transition-all duration-300">
                                <i class='bx bx-analyse text-xl'></i>
                            </div>
                            <div class="order-2 md:order-3 ml-4 md:ml-0 md:w-5/12 text-left">
                                <div class="bg-white/90 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-black text-blue-500 uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">Langkah 2</span>
                                    </div>
                                    <h4 class="text-base md:text-lg font-bold text-gray-900 mb-1 font-montserrat">Diagnosa &amp; Estimasi Biaya</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Teknisi melakukan diagnosa mendalam dan memberikan estimasi biaya yang transparan. Anda bisa menyetujui atau membatalkan tanpa biaya.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Step 3 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-16 group">
                            <div class="order-2 md:order-1 ml-4 md:ml-0 md:w-5/12 text-left md:text-right">
                                <div class="bg-white/90 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <div class="flex items-center gap-2 md:justify-end mb-1">
                                        <span class="text-xs font-black text-orange-500 uppercase tracking-wider bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100">Langkah 3</span>
                                    </div>
                                    <h4 class="text-base md:text-lg font-bold text-gray-900 mb-1 font-montserrat">Pengerjaan Profesional</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Setelah disetujui, pengerjaan dimulai menggunakan sparepart original. Kami update status via WhatsApp selama proses berlangsung.</p>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-orange-100 text-orange-500 font-black text-lg shadow-[0_0_15px_rgba(249,115,22,0.15)] group-hover:bg-orange-500 group-hover:border-orange-200 group-hover:text-white transition-all duration-300">
                                <i class='bx bx-cog text-xl'></i>
                            </div>
                            <div class="hidden md:block order-3 md:w-5/12"></div>
                        </div>
                        <!-- Step 4 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between group">
                            <div class="hidden md:block order-1 md:w-5/12"></div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-emerald-500 border-4 border-emerald-100 text-white font-black text-xl shadow-[0_0_20px_rgba(16,185,129,0.3)]">
                                <i class='bx bx-check'></i>
                            </div>
                            <div class="order-2 md:order-3 ml-4 md:ml-0 md:w-5/12 text-left">
                                <div class="bg-emerald-50/80 p-5 rounded-2xl border border-emerald-100 shadow-sm hover:shadow-md transition">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-black text-emerald-600 uppercase tracking-wider bg-emerald-100 px-2 py-0.5 rounded-full">Langkah 4</span>
                                    </div>
                                    <h4 class="text-base md:text-lg font-bold text-emerald-700 mb-1 font-montserrat">Serah Terima &amp; Garansi ✅</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Perangkat selesai diperbaiki, dilengkapi struk resmi dan garansi 30 hari. Bisa diambil langsung atau dikirim ke alamat Anda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Banner -->
                <div class="mt-14 bg-gradient-to-r from-amber-500 to-orange-500 rounded-3xl p-8 md:p-10 text-center shadow-xl relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-orange-400/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10">
                        <span class="inline-block bg-white/20 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-white/30 mb-4">Siap Service Sekarang?</span>
                        <h3 class="text-xl md:text-2xl font-black text-white font-montserrat mb-3">Konsultasikan Masalah Perangkat Anda</h3>
                        <p class="text-amber-100 text-sm leading-relaxed max-w-xl mx-auto mb-6">Ceritakan gejala kerusakan yang Anda alami. Diagnosa awal gratis, tanpa dipungut biaya apapun sebelum Anda setuju dengan estimasi pengerjaan.</p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin konsultasi service PC/Laptop.') }}" target="_blank"
                               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-amber-600 font-bold rounded-xl hover:bg-amber-50 transition shadow-md text-sm">
                                <i class='bx bxl-whatsapp text-xl text-green-500'></i> Konsultasi via WhatsApp
                            </a>
                            <a href="tel:+628567354046"
                               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white/20 border border-white/40 text-white font-bold rounded-xl hover:bg-white/30 transition text-sm">
                                <i class='bx bx-phone text-xl'></i> Telepon Langsung
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
