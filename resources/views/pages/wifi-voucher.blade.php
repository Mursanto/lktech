<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WiFi Voucher Starlink - LKTech TN SEREAL</title>
    
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
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header -->

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full pb-20 md:pb-0">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white min-h-[70vh] flex items-center pt-24 pb-12 overflow-hidden"
                 x-data="{ topologyModal: false }">
            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-[130px] opacity-20" style="background:#2563eb;"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 rounded-full blur-[100px] opacity-15" style="background:#1d4ed8;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    {{-- Text content --}}
                    <div class="lg:col-span-7">
                        <div class="inline-flex flex-wrap items-center gap-2 px-3.5 py-1.5 rounded-full border border-white/10 bg-white/5 backdrop-blur-sm mb-4 text-[10px] font-bold text-brand-300 uppercase tracking-widest">
                            <span>🛰️ Internet Satelit Desa & Wisata</span>
                        </div>

                        <h1 class="text-3xl md:text-5xl font-black font-montserrat text-white leading-tight mb-3 tracking-tight">
                            Solusi WiFi Voucher <span class="bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">Starlink</span>
                        </h1>

                        <p class="text-gray-300 text-xs sm:text-sm leading-relaxed mb-6 max-w-xl">
                            LKtech menghadirkan konektivitas internet satelit Starlink berkecepatan tinggi tanpa batas untuk desa, kawasan wisata, dan wilayah blankspot. Dilengkapi sistem voucher pintar yang mudah dikelola.
                        </p>

                        {{-- Action buttons --}}
                        <div class="grid grid-cols-2 gap-3 max-w-sm mb-6">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20konsultasi%20mengenai%20WiFi%20Voucher%20Starlink." target="_blank"
                               class="flex items-center justify-center gap-2 py-3 px-4 bg-green-500 hover:bg-green-400 text-white font-bold rounded-xl transition-all shadow-md text-xs">
                                <i class='bx bxl-whatsapp text-base'></i> Konsultasi WA
                            </a>
                            <a href="#omzet"
                               class="flex items-center justify-center gap-2 py-3 px-4 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl transition-all shadow-md text-xs">
                                <i class='bx bx-line-chart text-base'></i> Cek Omzet
                            </a>
                        </div>
                    </div>

                    {{-- Image topologi diagram --}}
                    <div class="lg:col-span-5">
                        <div class="relative group cursor-pointer" @click="topologyModal = true">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl blur opacity-25 group-hover:opacity-40 transition duration-500"></div>
                            <div class="relative bg-slate-950/80 border border-white/10 rounded-2xl p-2 shadow-2xl">
                                <img src="{{ asset('images/wifi_voucer.webp') }}" alt="Diagram Topologi WiFi Voucher Starlink" class="w-full h-auto rounded-xl">
                                <div class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-xs font-bold text-white flex items-center gap-1.5 shadow-lg">
                                        <i class='bx bx-zoom-in text-base animate-pulse'></i> Perbesar Topologi
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Interactive Lightbox Modal for Topology Diagram --}}
            <div x-show="topologyModal" class="fixed inset-0 bg-black/95 z-[9999] flex items-center justify-center p-4"
                 @click.self="topologyModal = false" @keydown.escape.window="topologyModal = false" x-cloak>
                <div class="relative max-w-4xl w-full max-h-[90vh] bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl p-3 flex flex-col items-center justify-center">
                    <button @click="topologyModal = false" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/60 hover:bg-black/80 flex items-center justify-center text-white transition-all shadow-md z-10">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                    <img src="{{ asset('images/wifi_voucer.webp') }}" alt="Topologi Jaringan Starlink" class="max-w-full max-h-[80vh] object-contain rounded-2xl">
                    <p class="text-gray-400 text-xs mt-3 text-center">Diagram Topologi Jaringan WiFi Voucher Starlink LKTech</p>
                </div>
            </div>
        </section>

        <!-- Latar Belakang -->
        <div class="bg-white py-12 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-[10px] mb-2 inline-block bg-brand-50 px-3 py-1 rounded-full border border-brand-100">Latar Belakang</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Mengapa WiFi Voucher Dibutuhkan?</h2>
                    <p class="text-gray-500 text-xs sm:text-sm max-w-2xl mx-auto">Solusi internet cepat untuk daerah yang tidak terjangkau jaringan kabel konvensional.</p>
                </div>
                
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    {{-- Card 1 --}}
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-red-100 text-red-650 rounded-xl flex items-center justify-center text-xl mb-3 shadow-sm group-hover:scale-105 transition-transform shrink-0">
                            <i class='bx bx-wifi-off'></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-gray-900 mb-1 font-montserrat leading-snug">Sinyal GSM Lemah</h3>
                        <p class="text-[11px] text-gray-500 leading-normal">Banyak daerah pedesaan dan wisata terisolasi dari sinyal GSM.</p>
                    </div>
                    
                    {{-- Card 2 --}}
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-blue-100 text-blue-650 rounded-xl flex items-center justify-center text-xl mb-3 shadow-sm group-hover:scale-105 transition-transform shrink-0">
                            <i class='bx bx-message-rounded-dots'></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-gray-900 mb-1 font-montserrat leading-snug">Kebutuhan Komunikasi</h3>
                        <p class="text-[11px] text-gray-500 leading-normal">Kebutuhan penting untuk transaksi digital dan komunikasi sehari-hari.</p>
                    </div>
                    
                    {{-- Card 3 --}}
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-orange-100 text-orange-650 rounded-xl flex items-center justify-center text-xl mb-3 shadow-sm group-hover:scale-105 transition-transform shrink-0">
                            <i class='bx bx-git-branch'></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-gray-900 mb-1 font-montserrat leading-snug">Infrastruktur Terbatas</h3>
                        <p class="text-[11px] text-gray-500 leading-normal">Penarikan kabel fiber optik ke daerah pelosok sangat mahal & lambat.</p>
                    </div>

                    {{-- Card 4 --}}
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-green-100 text-green-650 rounded-xl flex items-center justify-center text-xl mb-3 shadow-sm group-hover:scale-105 transition-transform shrink-0">
                            <i class='bx bx-line-chart'></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-gray-900 mb-1 font-montserrat leading-snug">Peluang Revenue</h3>
                        <p class="text-[11px] text-gray-500 leading-normal">Hasilkan profit tambahan dari penjualan voucher WiFi di lokasi Anda.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cara Kerja & Manfaat -->
        <div class="bg-gray-900 py-20 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-900/40 to-transparent pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="text-brand-400 font-bold tracking-wider uppercase text-[10px] mb-2 inline-block bg-brand-900/50 px-3 py-1 rounded-full border border-brand-800">Cara Kerja</span>
                        <h2 class="text-3xl font-black font-montserrat mb-6 tracking-tight">Konektivitas via Satelit Starlink</h2>
                        <p class="text-gray-300 text-sm mb-8 leading-relaxed">
                            Kami menghadirkan internet cepat langsung dari satelit ke perangkat Anda. Sistem cloud hotspot kami memungkinkan pengelolaan voucher yang efisien dan akses nonstop 24/7.
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                                <div class="text-brand-400 text-3xl font-black mb-1">~250</div>
                                <div class="text-xs text-gray-400">User Online Bersamaan</div>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                                <div class="text-brand-400 text-3xl font-black mb-1">300<span class="text-sm">Mbps</span></div>
                                <div class="text-xs text-gray-400">Kecepatan Download</div>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                                <div class="text-brand-400 text-3xl font-black mb-1">40<span class="text-sm">Mbps</span></div>
                                <div class="text-xs text-gray-400">Kecepatan Upload</div>
                            </div>
                            <div class="bg-white/5 p-4 rounded-2xl border border-white/10">
                                <div class="text-brand-400 text-3xl font-black mb-1">24/7</div>
                                <div class="text-xs text-gray-400">Akses Nonstop</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2"><i class='bx bxs-check-circle text-brand-500'></i> Bagi Pengelola Wisata</h3>
                            <ul class="space-y-3 text-sm text-gray-300">
                                <li><strong>Revenue Langsung:</strong> Penjualan voucher di lokasi ramai bisa mencapai 50-200 voucher/hari.</li>
                                <li><strong>Viral Marketing:</strong> Pengunjung dapat upload konten real-time, mendatangkan promosi organik.</li>
                                <li><strong>Daya Saing:</strong> Menjadi pembeda dari kompetitor yang masih blankspot.</li>
                                <li><strong>Koordinasi Efisien:</strong> Komunikasi tim pengelola via WhatsApp/VoIP jadi lancar.</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2"><i class='bx bxs-check-circle text-brand-500'></i> Bagi Pengunjung</h3>
                            <ul class="space-y-3 text-sm text-gray-300">
                                <li><strong>Keamanan & Darurat:</strong> Bisa menghubungi tim SAR atau keluarga saat kondisi darurat.</li>
                                <li><strong>Berbagi Momen:</strong> Upload foto/video langsung ke sosmed.</li>
                                <li><strong>Pembayaran Digital:</strong> Transaksi QRIS, e-wallet, dan transfer bisa dilakukan tanpa macet.</li>
                                <li><strong>Work From Anywhere:</strong> Pekerja bisa tetap produktif sambil menikmati alam.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Grid -->
        <div id="paket" class="bg-gray-50 py-20 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Pilihan Skema Kerjasama</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Mulai usaha WiFi Voucher Anda. Jadikan lokasi wisata bebas blankspot dan hasilkan keuntungan.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(max($packages->count(), 1), 3) }} gap-8 items-stretch justify-center max-w-5xl mx-auto">
                    
                    @forelse($packages as $package)
                    @php
                        $isHighlighted = !empty($package->badge);
                    @endphp
                    <div class="bg-white rounded-3xl {{ $isHighlighted ? 'shadow-2xl border-2 border-brand-500 z-10 md:-translate-y-4 transform' : 'shadow-sm border border-gray-100 hover:shadow-xl' }} p-8 transition-all flex flex-col h-full relative group w-full">
                        @if($isHighlighted)
                        <div class="absolute top-0 right-0 bg-brand-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest shadow-sm">
                            {{ $package->badge }}
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-b from-brand-50/50 to-transparent rounded-3xl pointer-events-none"></div>
                        @endif
                        
                        <div class="flex-grow relative z-10">
                            <h3 class="{{ $isHighlighted ? 'text-2xl font-bold text-brand-600' : 'text-xl font-bold text-gray-900' }} mb-1 font-montserrat">{{ $package->nama_paket }}</h3>
                            <p class="text-xs {{ $isHighlighted ? 'text-gray-500' : 'text-brand-600' }} font-bold uppercase tracking-wider mb-6">{{ $package->deskripsi_singkat ?? 'Paket WiFi Voucher' }}</p>
                            
                            <div class="mb-8">
                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Investasi / Harga</p>
                                <span class="{{ $isHighlighted ? 'text-2xl sm:text-3xl md:text-4xl' : 'text-xl sm:text-2xl md:text-3xl' }} font-black text-gray-900 whitespace-nowrap">Rp {{ number_format($package->harga, 0, ',', '.') }}</span>
                            </div>
                            
                            <ul class="space-y-4 mb-8 text-sm {{ $isHighlighted ? 'text-gray-700 font-semibold' : 'text-gray-600 font-medium' }}">
                                @if($package->fitur_list)
                                    @foreach(explode("\n", $package->fitur_list) as $fitur)
                                        @if(trim($fitur))
                                        <li class="flex items-start gap-3"><i class='bx {{ $isHighlighted ? 'bxs-check-circle text-brand-600' : 'bx-check-circle text-brand-500' }} text-xl'></i> <span>{{ trim($fitur) }}</span></li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="mt-auto pt-6 border-t {{ $isHighlighted ? 'border-brand-100' : 'border-gray-100' }} relative z-10">
                            @php
                                $waText = urlencode("Halo LKtech, saya ingin konsultasi mengenai layanan WiFi Voucher Starlink (".$package->nama_paket.").");
                            @endphp
                            <a href="https://wa.me/628567354046?text={{ $waText }}" target="_blank" class="w-full block text-center {{ $isHighlighted ? 'px-6 py-3.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5' : 'px-6 py-3 bg-gray-50 hover:bg-gray-100 text-gray-800 font-bold rounded-xl transition-colors border border-gray-200' }}">
                                {{ $isHighlighted ? 'Mulai Sekarang' : 'Konsultasi Paket' }}
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 md:col-span-2 text-center py-12 text-gray-500 w-full">
                        <i class='bx bx-info-circle text-4xl mb-3 text-gray-400'></i>
                        <p>Skema Kerjasama WiFi Voucher belum tersedia saat ini. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>

        <!-- Estimasi Pendapatan -->
        <div id="omzet" class="bg-white py-16 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-[10px] mb-2 inline-block bg-brand-50 px-3 py-1 rounded-full border border-brand-100">Simulasi Omzet</span>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 font-montserrat mb-2 tracking-tight">Estimasi Omzet Penjualan</h2>
                    <p class="text-gray-500 text-xs sm:text-sm">Simulasi potensi pendapatan harian dari penjualan voucher WiFi di lokasi Anda.</p>
                </div>

                <!-- Mobile Card Stack View (< 640px) -->
                <div class="block sm:hidden space-y-4">
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-150 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-bold text-gray-900 text-sm flex items-center gap-1.5"><i class='bx bx-cloud text-gray-400 text-base'></i> Hari Biasa (Sepi)</span>
                            <span class="bg-gray-100 text-gray-700 text-[10px] font-black px-2 py-0.5 rounded-full">20 User</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-600 border-t border-gray-100 pt-3">
                            <div class="flex justify-between"><span>Voucher Rp10.500 (6 Jam):</span> <span class="font-semibold text-gray-900">Rp 147.000 <span class="text-[10px] text-gray-400 font-normal">(14 user)</span></span></div>
                            <div class="flex justify-between"><span>Voucher Rp15.750 (12 Jam):</span> <span class="font-semibold text-gray-900">Rp 94.500 <span class="text-[10px] text-gray-400 font-normal">(6 user)</span></span></div>
                            <div class="flex justify-between font-bold text-gray-900 border-t border-dashed border-gray-200 pt-2 text-sm">
                                <span>Potensi Omzet:</span>
                                <span class="text-brand-600">Rp 241.500 / hari</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-white rounded-2xl p-5 border border-gray-150 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-bold text-gray-900 text-sm flex items-center gap-1.5"><i class='bx bx-sun text-orange-400 text-base'></i> Hari Biasa (Ramai)</span>
                            <span class="bg-gray-100 text-gray-700 text-[10px] font-black px-2 py-0.5 rounded-full">50 User</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-600 border-t border-gray-100 pt-3">
                            <div class="flex justify-between"><span>Voucher Rp10.500 (6 Jam):</span> <span class="font-semibold text-gray-900">Rp 367.500 <span class="text-[10px] text-gray-400 font-normal">(35 user)</span></span></div>
                            <div class="flex justify-between"><span>Voucher Rp15.750 (12 Jam):</span> <span class="font-semibold text-gray-900">Rp 236.250 <span class="text-[10px] text-gray-400 font-normal">(15 user)</span></span></div>
                            <div class="flex justify-between font-bold text-gray-900 border-t border-dashed border-gray-200 pt-2 text-sm">
                                <span>Potensi Omzet:</span>
                                <span class="text-brand-600">Rp 603.750 / hari</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-brand-50/50 rounded-2xl p-5 border border-brand-100 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-bold text-brand-900 text-sm flex items-center gap-1.5"><i class='bx bxs-hot text-red-500 text-base'></i> Hari Libur / Weekend</span>
                            <span class="bg-brand-100 text-brand-700 text-[10px] font-black px-2 py-0.5 rounded-full">100 User</span>
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-600 border-t border-brand-100 pt-3">
                            <div class="flex justify-between"><span>Voucher Rp10.500 (6 Jam):</span> <span class="font-semibold text-gray-900">Rp 735.000 <span class="text-[10px] text-gray-400 font-normal">(70 user)</span></span></div>
                            <div class="flex justify-between"><span>Voucher Rp15.750 (12 Jam):</span> <span class="font-semibold text-gray-900">Rp 472.500 <span class="text-[10px] text-gray-400 font-normal">(30 user)</span></span></div>
                            <div class="flex justify-between font-bold text-gray-905 border-t border-dashed border-brand-200 pt-2 text-sm">
                                <span>Potensi Omzet:</span>
                                <span class="text-brand-700">Rp 1.207.500 / hari</span>
                            </div>
                        </div>
                    </div>

                    {{-- Total Card --}}
                    <div class="bg-slate-900 text-white rounded-2xl p-5 border border-slate-800 shadow-md">
                        <div class="text-center">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Estimasi Total Omzet / Bulan</p>
                            <p class="text-xl font-black text-brand-400">± Rp 18.957.750</p>
                            <p class="text-[10px] text-slate-400 mt-2 font-medium">Asumsi: 22 hari biasa + 8 hari weekend</p>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View (>= 640px) -->
                <div class="hidden sm:block overflow-x-auto bg-white rounded-3xl shadow-xl border border-gray-100">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gradient-to-r from-brand-600 to-brand-700 text-white font-bold uppercase text-[11px]">
                            <tr>
                                <th class="px-6 py-5 whitespace-nowrap rounded-tl-3xl">Skenario Harian</th>
                                <th class="px-6 py-5 text-center whitespace-nowrap">User (Asumsi)</th>
                                <th class="px-6 py-5 text-right whitespace-nowrap">Voucher Rp10.500 <span class="font-normal text-brand-200 lowercase">(6 Jam)</span></th>
                                <th class="px-6 py-5 text-right whitespace-nowrap">Voucher Rp15.750 <span class="font-normal text-brand-200 lowercase">(12 Jam)</span></th>
                                <th class="px-6 py-5 text-right text-brand-200 font-black whitespace-nowrap rounded-tr-3xl">Total / Hari</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-brand-50/50 transition-colors group">
                                <td class="px-6 py-5 font-semibold text-gray-900 flex items-center gap-2"><i class='bx bx-cloud text-gray-400 group-hover:text-brand-500 text-lg'></i> Hari Biasa (Sepi)</td>
                                <td class="px-6 py-5 text-center text-gray-500 font-medium"><span class="bg-gray-100 px-3 py-1 rounded-full text-xs group-hover:bg-white group-hover:shadow-sm transition-all">20 User</span></td>
                                <td class="px-6 py-5 text-right text-gray-600">Rp 147.000 <br><span class="text-[10px] text-gray-400">(14 user)</span></td>
                                <td class="px-6 py-5 text-right text-gray-600">Rp 94.500 <br><span class="text-[10px] text-gray-400">(6 user)</span></td>
                                <td class="px-6 py-5 text-right font-bold text-gray-900 group-hover:text-brand-600 transition-colors whitespace-nowrap">Rp 241.500</td>
                            </tr>
                            <tr class="hover:bg-brand-50/50 transition-colors group">
                                <td class="px-6 py-5 font-semibold text-gray-900 flex items-center gap-2"><i class='bx bx-sun text-orange-400 group-hover:scale-110 transition-transform text-lg'></i> Hari Biasa (Ramai)</td>
                                <td class="px-6 py-5 text-center text-gray-500 font-medium"><span class="bg-gray-100 px-3 py-1 rounded-full text-xs group-hover:bg-white group-hover:shadow-sm transition-all">50 User</span></td>
                                <td class="px-6 py-5 text-right text-gray-600">Rp 367.500 <br><span class="text-[10px] text-gray-400">(35 user)</span></td>
                                <td class="px-6 py-5 text-right text-gray-600">Rp 236.250 <br><span class="text-[10px] text-gray-400">(15 user)</span></td>
                                <td class="px-6 py-5 text-right font-bold text-gray-900 group-hover:text-brand-600 transition-colors whitespace-nowrap">Rp 603.750</td>
                            </tr>
                            <tr class="bg-gradient-to-r from-brand-50 to-transparent hover:from-brand-100 hover:to-brand-50 transition-colors group">
                                <td class="px-6 py-6 font-bold text-brand-700 flex items-center gap-2"><i class='bx bxs-hot text-red-500 group-hover:animate-pulse text-xl'></i> Hari Libur / Weekend</td>
                                <td class="px-6 py-6 text-center font-bold text-brand-700"><span class="bg-brand-100 px-3 py-1.5 rounded-full text-xs group-hover:bg-white group-hover:shadow-sm transition-all">100 User</span></td>
                                <td class="px-6 py-6 text-right text-brand-700 font-medium">Rp 735.000 <br><span class="text-[10px] text-brand-500">(70 user)</span></td>
                                <td class="px-6 py-6 text-right text-brand-700 font-medium">Rp 472.500 <br><span class="text-[10px] text-brand-500">(30 user)</span></td>
                                <td class="px-6 py-6 text-right font-black text-brand-700 text-lg whitespace-nowrap">Rp 1.207.500</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-900 text-white relative">
                            <!-- Border atas sebagai aksen -->
                            <tr>
                                <td colspan="5" class="p-0"><div class="h-1 w-full bg-gradient-to-r from-brand-400 via-brand-500 to-brand-600"></div></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-right font-bold text-gray-300">Estimasi Total Omzet / Bulan <span class="font-normal text-gray-400 text-[11px] ml-1">(±22 hari biasa + 8 weekend):</span></td>
                                <td class="px-6 py-6 text-right font-black text-brand-400 text-xl whitespace-nowrap">± Rp 18.957.750</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Penjelasan Keuntungan Bersih -->
                <div class="mt-8 bg-brand-50 rounded-3xl p-8 border border-brand-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                        <i class='bx bx-line-chart text-9xl'></i>
                    </div>
                    <h3 class="text-xl font-bold text-brand-900 mb-6 font-montserrat flex items-center gap-2">
                        <i class='bx bx-wallet text-brand-600'></i> Simulasi Keuntungan Bersih (Net Profit)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-brand-100">
                            <h4 class="font-bold text-gray-900 mb-2 border-b border-gray-100 pb-2">Skema 1: Beli Putus</h4>
                            <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                <li class="flex justify-between"><span>Total Omzet:</span> <span class="font-medium text-gray-900">Rp 18.957.750</span></li>
                                <li class="flex justify-between text-red-500"><span>Biaya Bulanan:</span> <span>- Rp 2.362.500</span></li>
                                <li class="flex justify-between border-t border-gray-100 pt-2 font-bold text-brand-600 text-base"><span>Profit Owner:</span> <span>± Rp 16.595.250 / bln</span></li>
                            </ul>
                            <div class="bg-green-50 text-green-700 text-xs px-3 py-2 rounded-lg flex items-start gap-2">
                                <i class='bx bxs-check-circle mt-0.5 text-base'></i>
                                <span>Investasi awal Rp18,9 Juta diproyeksikan <strong>kembali modal (BEP) hanya dalam ~1,1 bulan!</strong></span>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-brand-100">
                            <h4 class="font-bold text-gray-900 mb-2 border-b border-gray-100 pb-2">Skema 2: Sharing Revenue</h4>
                            <p class="text-xs text-gray-500 mb-3">Dari bagi hasil margin voucher per user (tanpa modal awal & biaya bulanan):</p>
                            <ul class="text-sm text-gray-600 space-y-2 mb-4">
                                <li class="flex justify-between"><span>1.100 user (6 Jam) x Rp 2.100:</span> <span class="font-medium text-gray-900">Rp 2.310.000</span></li>
                                <li class="flex justify-between"><span>470 user (12 Jam) x Rp 5.250:</span> <span class="font-medium text-gray-900">Rp 2.467.500</span></li>
                                <li class="flex justify-between border-t border-gray-100 pt-2 font-bold text-brand-600 text-base"><span>Profit Owner:</span> <span>± Rp 4.777.500 / bln</span></li>
                            </ul>
                            <div class="bg-blue-50 text-blue-700 text-xs px-3 py-2 rounded-lg flex items-start gap-2">
                                <i class='bx bxs-info-circle mt-0.5 text-base'></i>
                                <span>Mendapatkan passive income murni <strong>tanpa risiko & investasi modal di awal.</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-[11px] text-gray-400 mt-6 text-center">*Asumsi rasio penjualan dihitung dari perpaduan hari biasa dan libur. Hasil bersih aktual bergantung pada traffic lokasi wisata.</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-brand-600 py-20 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white font-montserrat mb-6 tracking-tight leading-tight">Ubah Blankspot Jadi Peluang Usaha</h2>
                <p class="text-brand-100 text-lg mb-10 max-w-2xl mx-auto">
                    Hubungi kami sekarang untuk konsultasi pemasangan jaringan satelit Starlink di lokasi wisata atau desa Anda.
                </p>
                <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20tertarik%20dengan%20layanan%20WiFi%20Voucher%20Starlink." target="_blank" class="inline-flex items-center gap-2 px-10 py-4 bg-white text-brand-600 hover:bg-gray-50 hover:text-brand-700 rounded-full font-black text-lg transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    <i class='bx bxl-whatsapp text-2xl'></i> Konsultasi via WhatsApp
                </a>
            </div>
        </div>
    </main>



    <!-- Footer -->
    <x-footer />

    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

</body>
</html>
