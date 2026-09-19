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
        <div class="relative bg-gradient-to-br from-amber-50 via-orange-50/70 to-yellow-50 pt-6 pb-4 px-4 sm:px-6 lg:px-8 text-center border-b border-amber-100/70 w-full overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-amber-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-orange-200/20 rounded-full blur-3xl pointer-events-none"></div>

            <h1 class="text-xl md:text-4xl font-black font-montserrat text-gray-900 mb-1 md:mb-2 tracking-tight">
                Service <span class="text-shimmer-amber">PC &amp; Laptop</span>
            </h1>
            <p class="text-gray-600 text-[11px] md:text-sm max-w-2xl mx-auto leading-relaxed mt-1 md:mt-2">
                Perbaikan profesional oleh teknisi berpengalaman. Diagnosa cepat, sparepart original, dan garansi pengerjaan resmi dari LKTech.
            </p>

            <!-- Stats Bar -->
            <div class="flex flex-wrap justify-center items-center gap-x-2 gap-y-1 mt-3 md:mt-5 text-[10px] sm:text-sm text-gray-700 sm:text-gray-600 font-semibold max-w-lg mx-auto">
                <div class="flex items-center gap-1">
                    <i class='bx bx-check-shield text-amber-600 text-sm sm:text-base'></i> Garansi 30 Hari
                </div>
                <span class="text-amber-200">|</span>
                <div class="flex items-center gap-1">
                    <i class='bx bx-time text-amber-600 text-sm sm:text-base'></i> Pengerjaan 1-3 Hari
                </div>
                <span class="text-amber-200">|</span>
                <div class="flex items-center gap-1">
                    <i class='bx bx-chip text-amber-600 text-sm sm:text-base'></i> Sparepart Original
                </div>
            </div>
        </div>

        <!-- ===================================================================== -->
        <div class="bg-gradient-to-r from-amber-600 to-orange-500 pt-4 pb-6 px-4 sm:px-6 lg:px-8"
             x-data="{
                 ticketNo: '',
                 result: null,
                 loading: false,
                 error: '',
                 async trackService() {
                     if (!this.ticketNo.trim()) { this.error = 'Masukkan Nomor Tiket Service Anda terlebih dahulu.'; return; }
                     this.error = ''; this.loading = true; this.result = null;
                     try {
                         const res = await fetch('/api/track-service?q=' + encodeURIComponent(this.ticketNo.trim()));
                         const data = await res.json();
                         if (data.found) { this.result = data; } else { this.error = data.message; }
                     } catch(e) { this.error = 'Gagal menghubungi server. Coba lagi.'; }
                     this.loading = false;
                 }
             }">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-baseline gap-2.5 justify-center mb-2 md:mb-3">
                    <h2 class="text-sm md:text-lg font-black font-montserrat text-white flex items-center gap-1.5">
                        <i class='bx bx-search-alt text-sm md:text-base'></i> Tracking Nomor Tiket Service
                    </h2>
                    <p class="text-amber-200 text-xs truncate hidden sm:block">Masukkan nomor tiket untuk cek status pengerjaan.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-3 md:p-4 text-left">
                    <label class="block text-[9px] md:text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Nomor Tiket / Invoice Service</label>
                    <div class="flex flex-row gap-2">
                        <input type="text" x-model="ticketNo" @keyup.enter="trackService()"
                               placeholder="SVC-2026-0012"
                               class="ticket-input flex-1 px-3 h-10 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-amber-500 text-[11px] sm:text-sm font-semibold text-gray-800 placeholder-gray-400 transition-all">
                        <button @click="trackService()" :disabled="loading"
                                class="shrink-0 px-3 md:px-4 h-10 justify-center bg-amber-500 hover:bg-amber-600 disabled:opacity-60 text-white font-bold rounded-lg transition-all text-[11px] sm:text-sm flex items-center gap-1 md:gap-1.5 shadow-md">
                            <i class='bx bx-search text-sm md:text-base' x-show="!loading"></i>
                            <i class='bx bx-loader-alt animate-spin text-sm md:text-base' x-show="loading" x-cloak></i>
                            <span x-show="!loading">Cek</span>
                            <span x-show="loading" x-cloak>Cek...</span>
                        </button>
                    </div>
                    <p x-show="error" x-text="error" x-cloak class="text-red-500 text-xs font-semibold mt-1.5"></p>
                    <div x-show="result" x-cloak class="mt-3 border rounded-xl overflow-hidden fade-in-up">
                        <div class="px-4 py-3 flex items-center justify-between border-b"
                             :class="{'bg-yellow-50 border-yellow-200':result&&result.status==='pending','bg-blue-50 border-blue-200':result&&result.status==='process','bg-green-50 border-green-200':result&&result.status==='done','bg-red-50 border-red-200':result&&result.status==='cancelled'}">
                            <div>
                                <p class="font-black text-gray-900 text-sm" x-text="result&&result.ticket_no"></p>
                                <p class="text-gray-500 text-xs" x-text="result&&('Masuk: '+result.created_at)"></p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-black"
                                  :class="{'bg-yellow-100 text-yellow-800':result&&result.status==='pending','bg-blue-100 text-blue-800':result&&result.status==='process','bg-green-100 text-green-800':result&&result.status==='done','bg-red-100 text-red-800':result&&result.status==='cancelled'}"
                                  x-text="result&&(result.status_icon+' '+result.status_label)"></span>
                        </div>
                        <div class="bg-white px-4 py-3 grid grid-cols-2 gap-x-6 gap-y-2 text-xs">
                            <div><p class="text-gray-400 font-bold uppercase text-[10px]">Pelanggan</p><p class="font-semibold text-gray-800" x-text="result&&result.customer_name"></p></div>
                            <div><p class="text-gray-400 font-bold uppercase text-[10px]">Teknisi</p><p class="font-semibold text-gray-800" x-text="result&&result.technician"></p></div>
                            <div><p class="text-gray-400 font-bold uppercase text-[10px]">Status Bayar</p><p class="font-semibold" :class="result&&result.payment_status==='success'?'text-green-600':'text-orange-500'" x-text="result&&(result.payment_status==='success'?'Lunas':'Belum Lunas')"></p></div>
                            <div><p class="text-gray-400 font-bold uppercase text-[10px]">Total Biaya</p><p class="font-black text-amber-600" x-text="result&&('Rp '+result.total)"></p></div>
                        </div>
                    </div>
                    <p class="text-gray-400 text-[10px] mt-2 text-center">Nomor tiket ada di struk service atau email konfirmasi dari LKTech. Contoh: SVC-2026-0012</p>
                </div>
            </div>
        </div>



        <!-- Jenis Kerusakan -->
        <div class="bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-8">
                    <span class="inline-block bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-amber-100 mb-3">Jenis Layanan</span>
                    <h2 class="text-base sm:text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Apa Masalah PC/Laptop Anda?</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Kami menangani berbagai kerusakan perangkat keras maupun perangkat lunak.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
                    <!-- Masalah 1 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Performa Lambat / Lemot') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <i class='bx bx-trending-down text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Performa Lambat</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Lemot, loading lama, lag saat multitasking</p>
                        </div>
                    </a>
                    <!-- Masalah 2 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Suka Hang / Mati Sendiri') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-red-50 text-red-500 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-red-500 group-hover:text-white transition-colors">
                            <i class='bx bx-power-off text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Hang / Mati Sendiri</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Restart tiba-tiba, freeze, blue screen (BSOD)</p>
                        </div>
                    </a>
                    <!-- Masalah 3 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Cepat Panas / Overheat') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-orange-50 text-orange-500 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            <i class='bx bx-droplet-half text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Cepat Panas (Overheat)</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Fan kencang, suhu tinggi, thermal paste kering</p>
                        </div>
                    </a>
                    <!-- Masalah 4 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Layar Rusak / LCD Bermasalah') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <i class='bx bx-window-close text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Layar / LCD Rusak</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Retak, blank, bergaris, flickering, backlight mati</p>
                        </div>
                    </a>
                    <!-- Masalah 5 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Keyboard / Touchpad Bermasalah') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-purple-50 text-purple-500 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                            <i class='bx bx-keyboard text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Keyboard / Touchpad</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Tombol macet, tidak responsif, touchpad error</p>
                        </div>
                    </a>
                    <!-- Masalah 6 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Baterai / Charger Bermasalah') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                            <i class='bx bx-battery text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Baterai / Charger</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Baterai drop, tidak charge, charger konslet</p>
                        </div>
                    </a>
                    <!-- Masalah 7 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Tidak Bisa Konek WiFi / LAN') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-sky-50 text-sky-500 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                            <i class='bx bx-wifi-off text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Koneksi WiFi / LAN</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Tidak terdeteksi, sering putus, kecepatan rendah</p>
                        </div>
                    </a>
                    <!-- Masalah 8 -->
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin service laptop dengan masalah: Casing / Engsel Rusak') }}" target="_blank"
                       class="group bg-white rounded-xl border border-gray-100 p-2.5 sm:p-3.5 hover:border-amber-300 hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3 cursor-pointer">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gray-100 text-gray-500 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-gray-500 group-hover:text-white transition-colors">
                            <i class='bx bx-wrench text-lg'></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800 text-[12px] sm:text-sm group-hover:text-amber-600 transition-colors leading-tight sm:leading-normal">Casing / Engsel Rusak</h4>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 leading-snug line-clamp-2 sm:truncate mt-0.5 sm:mt-0">Engsel patah, casing retak, port USB longgar</p>
                        </div>
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
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <div class="group bg-gray-50 rounded-2xl p-3 sm:p-4 border border-gray-100 hover:border-amber-200 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center sm:items-start sm:text-left">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-lg sm:text-xl mb-2 sm:mb-3 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                            <i class='bx bx-user-check'></i>
                        </div>
                        <h3 class="text-[13px] sm:text-sm font-bold text-gray-900 mb-1 font-montserrat">Teknisi Berpengalaman</h3>
                        <p class="text-[11px] sm:text-[12px] text-gray-500 leading-relaxed">Ditangani teknisi bersertifikat dengan pengalaman lebih dari 5 tahun di bidang hardware dan software.</p>
                    </div>
                    <div class="group bg-gray-50 rounded-2xl p-3 sm:p-4 border border-gray-100 hover:border-amber-200 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center sm:items-start sm:text-left">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-lg sm:text-xl mb-2 sm:mb-3 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                            <i class='bx bx-chip'></i>
                        </div>
                        <h3 class="text-[13px] sm:text-sm font-bold text-gray-900 mb-1 font-montserrat">Sparepart Original</h3>
                        <p class="text-[11px] sm:text-[12px] text-gray-500 leading-relaxed">Hanya menggunakan sparepart original bergaransi resmi. Tidak ada komponen KW yang membahayakan perangkat.</p>
                    </div>
                    <div class="group bg-gray-50 rounded-2xl p-3 sm:p-4 border border-gray-100 hover:border-amber-200 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center sm:items-start sm:text-left">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-lg sm:text-xl mb-2 sm:mb-3 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                            <i class='bx bx-check-shield'></i>
                        </div>
                        <h3 class="text-[13px] sm:text-sm font-bold text-gray-900 mb-1 font-montserrat">Garansi Service 30 Hari</h3>
                        <p class="text-[11px] sm:text-[12px] text-gray-500 leading-relaxed">Setiap pengerjaan dijamin garansi 30 hari. Masalah yang sama muncul kembali, kami perbaiki gratis.</p>
                    </div>
                    <div class="group bg-gray-50 rounded-2xl p-3 sm:p-4 border border-gray-100 hover:border-amber-200 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col items-center text-center sm:items-start sm:text-left">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-lg sm:text-xl mb-2 sm:mb-3 group-hover:bg-purple-500 group-hover:text-white transition-colors duration-300">
                            <i class='bx bx-time-five'></i>
                        </div>
                        <h3 class="text-[13px] sm:text-sm font-bold text-gray-900 mb-1 font-montserrat">Pengerjaan 1-3 Hari</h3>
                        <p class="text-[11px] sm:text-[12px] text-gray-500 leading-relaxed">Diagnosa di hari yang sama, mayoritas pengerjaan selesai dalam 1-3 hari kerja.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alur Service -->
        <div class="bg-gradient-to-br from-gray-50 via-white to-amber-50/30 py-8 border-t border-gray-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNGM0Y0RjYiLz48L3N2Zz4=')] opacity-60"></div>
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-6">
                    <span class="text-amber-600 font-bold tracking-wider uppercase text-[10px] mb-2 block bg-amber-50 inline-block px-3 py-1 rounded-full border border-amber-100">Step By Step</span>
                    <h2 class="text-xl md:text-2xl font-black text-gray-900 font-montserrat mb-1 tracking-tight">Alur Service di LKTech</h2>
                    <p class="text-gray-500 text-xs max-w-xl mx-auto">Proses transparan dan mudah. Anda akan mendapat update setiap tahapnya.</p>
                </div>

                {{-- Horizontal 4-step stepper --}}
                <div class="relative">
                    {{-- Connecting line (desktop) --}}
                    <div class="hidden sm:block absolute top-7 left-[12.5%] right-[12.5%] h-0.5 bg-gradient-to-r from-amber-200 via-orange-300 to-emerald-200 z-0"></div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 relative z-10">
                        {{-- Step 1 --}}
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-14 h-14 rounded-full bg-white border-4 border-amber-200 text-amber-600 flex items-center justify-center shadow-md mb-3 group-hover:bg-amber-500 group-hover:border-amber-300 group-hover:text-white transition-all duration-300">
                                <i class='bx bx-store text-2xl'></i>
                            </div>
                            <span class="text-[10px] font-black text-amber-500 uppercase tracking-wider bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100 mb-1">Langkah 1</span>
                            <h4 class="text-sm font-bold text-gray-800 font-montserrat mb-1">Bawa Perangkat</h4>
                            <p class="text-[11px] text-gray-400 leading-snug">Antar ke toko atau hubungi untuk layanan jemput.</p>
                        </div>
                        {{-- Step 2 --}}
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-14 h-14 rounded-full bg-white border-4 border-blue-200 text-blue-600 flex items-center justify-center shadow-md mb-3 group-hover:bg-blue-500 group-hover:border-blue-300 group-hover:text-white transition-all duration-300">
                                <i class='bx bx-analyse text-2xl'></i>
                            </div>
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100 mb-1">Langkah 2</span>
                            <h4 class="text-sm font-bold text-gray-800 font-montserrat mb-1">Diagnosa & Estimasi</h4>
                            <p class="text-[11px] text-gray-400 leading-snug">Teknisi diagnosa & beri estimasi biaya transparan.</p>
                        </div>
                        {{-- Step 3 --}}
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-14 h-14 rounded-full bg-white border-4 border-orange-200 text-orange-500 flex items-center justify-center shadow-md mb-3 group-hover:bg-orange-500 group-hover:border-orange-300 group-hover:text-white transition-all duration-300">
                                <i class='bx bx-cog text-2xl'></i>
                            </div>
                            <span class="text-[10px] font-black text-orange-500 uppercase tracking-wider bg-orange-50 px-2 py-0.5 rounded-full border border-orange-100 mb-1">Langkah 3</span>
                            <h4 class="text-sm font-bold text-gray-800 font-montserrat mb-1">Pengerjaan</h4>
                            <p class="text-[11px] text-gray-400 leading-snug">Perbaikan profesional, update status via WhatsApp.</p>
                        </div>
                        {{-- Step 4 --}}
                        <div class="flex flex-col items-center text-center group">
                            <div class="w-14 h-14 rounded-full bg-emerald-500 border-4 border-emerald-200 text-white flex items-center justify-center shadow-md mb-3">
                                <i class='bx bx-check text-3xl'></i>
                            </div>
                            <span class="text-[10px] font-black text-emerald-600 uppercase tracking-wider bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100 mb-1">Langkah 4</span>
                            <h4 class="text-sm font-bold text-emerald-700 font-montserrat mb-1">Serah Terima ✅</h4>
                            <p class="text-[11px] text-gray-400 leading-snug">Perangkat selesai + struk resmi & garansi 30 hari.</p>
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

