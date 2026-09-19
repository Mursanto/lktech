<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Rakit PC - LKTech TN SEREAL</title>
    
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
    <main class="flex-grow w-full pb-10 md:pb-0">
        <!-- Hero Section (Lebih compact & modern) -->
        <div class="relative bg-gradient-to-br from-blue-50 via-indigo-50/50 to-cyan-50 pt-6 pb-4 px-4 sm:px-6 lg:px-8 text-center border-b border-blue-100/70 w-full overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiM2MEE1RkEiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] opacity-60"></div>
            
            <div class="relative z-10">
                <h1 class="text-xl md:text-4xl font-black font-montserrat text-gray-900 mb-1 md:mb-2 tracking-tight">
                    Rakit PC <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Impian Anda</span>
                </h1>
                <p class="text-[11px] md:text-sm text-gray-500 max-w-2xl mx-auto leading-relaxed mt-1 md:mt-2">
                    Mulai dari PC Office hingga PC Gaming & Rendering kelas atas. Perakitan profesional oleh LKTech, 100% kompatibel dan sesuai budget.
                </p>
                
                <!-- Stats Bar -->
                <div class="flex flex-wrap justify-center items-center gap-x-2 gap-y-1 mt-3 md:mt-5 text-[10px] sm:text-sm text-gray-700 sm:text-gray-600 font-semibold max-w-lg mx-auto">
                    <div class="flex items-center gap-1">
                        <i class='bx bx-check-shield text-blue-600 text-sm sm:text-base'></i> Garansi Resmi
                    </div>
                    <span class="text-blue-200">|</span>
                    <div class="flex items-center gap-1">
                        <i class='bx bx-cable text-blue-600 text-sm sm:text-base'></i> Cable Management Rapi
                    </div>
                    <span class="text-blue-200">|</span>
                    <div class="flex items-center gap-1">
                        <i class='bx bx-chip text-blue-600 text-sm sm:text-base'></i> Stress Test (QC)
                    </div>
                </div>
            </div>
        </div>

        <!-- Alur Kerja (Horizontal, Hemat Tempat) -->
        <div class="bg-white py-8 px-4 sm:px-6 lg:px-8 border-b border-gray-100">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-center text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Alur Perakitan Kami</h3>
                
                <style>
                    .snake-h { background: repeating-linear-gradient(90deg, #93c5fd 0px, #93c5fd 8px, transparent 8px, transparent 16px); animation: snake-h-anim 1s linear infinite; }
                    .snake-h-rev { background: repeating-linear-gradient(270deg, #93c5fd 0px, #93c5fd 8px, transparent 8px, transparent 16px); animation: snake-h-rev-anim 1s linear infinite; }
                    .snake-v { background: repeating-linear-gradient(180deg, #93c5fd 0px, #93c5fd 8px, transparent 8px, transparent 16px); animation: snake-v-anim 1s linear infinite; }
                    @keyframes snake-h-anim { from { background-position: 0 0; } to { background-position: 16px 0; } }
                    @keyframes snake-h-rev-anim { from { background-position: 0 0; } to { background-position: -16px 0; } }
                    @keyframes snake-v-anim { from { background-position: 0 0; } to { background-position: 0 16px; } }
                </style>

                <div class="relative px-2 sm:px-0">
                    <div class="grid grid-cols-3 md:grid-cols-5 gap-y-8 md:gap-y-4 gap-x-2 md:gap-x-4 text-center relative z-10">
                        
                        <!-- Connecting Line Desktop (Single continuous line) -->
                        <div class="hidden md:block absolute top-[18px] left-[10%] right-[10%] h-[4px] snake-h z-0"></div>

                        <!-- Step 1 -->
                        <div class="relative z-10 flex flex-col items-center text-center group col-start-1 row-start-1 md:col-auto md:row-auto">
                            <!-- Connecting Line Mobile -->
                            <div class="absolute top-[18px] left-1/2 w-1/2 h-[4px] snake-h z-0 md:hidden"></div>

                            <div class="relative z-10 w-10 h-10 rounded-full bg-white border-2 border-blue-200 text-blue-600 flex items-center justify-center font-black text-sm shadow-sm mb-2 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all">
                                1
                            </div>
                            <p class="text-xs font-bold text-gray-800">Konsultasi</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-tight">Diskusikan spek & harga</p>
                        </div>
                        
                        <!-- Step 2 -->
                        <div class="relative z-10 flex flex-col items-center text-center group col-start-2 row-start-1 md:col-auto md:row-auto">
                            <!-- Connecting Line Mobile -->
                            <div class="absolute top-[18px] left-0 w-full h-[4px] snake-h z-0 md:hidden"></div>

                            <div class="relative z-10 w-10 h-10 rounded-full bg-white border-2 border-blue-200 text-blue-600 flex items-center justify-center font-black text-sm shadow-sm mb-2 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all">
                                2
                            </div>
                            <p class="text-xs font-bold text-gray-800">DP / Bayar</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-tight">Konfirmasi pesanan</p>
                        </div>
                        
                        <!-- Step 3 -->
                        <div class="relative z-10 flex flex-col items-center text-center group col-start-3 row-start-1 md:col-auto md:row-auto">
                            <!-- Connecting Line Mobile -->
                            <div class="absolute top-[18px] left-0 w-1/2 h-[4px] snake-h z-0 md:hidden"></div>
                            <!-- Drop down line to Row 2 (Step 4) -->
                            <div class="absolute top-[18px] left-[calc(50%-2px)] w-[4px] h-[calc(100%+32px)] snake-v z-0 md:hidden"></div>

                            <div class="relative z-10 w-10 h-10 rounded-full bg-white border-2 border-blue-200 text-blue-600 flex items-center justify-center font-black text-sm shadow-sm mb-2 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all">
                                3
                            </div>
                            <p class="text-xs font-bold text-gray-800">Perakitan</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-tight">Instalasi & cable management</p>
                        </div>
                        
                        <!-- Step 4 -->
                        <div class="relative z-10 flex flex-col items-center text-center group col-start-3 row-start-2 md:col-auto md:row-auto">
                            <!-- Connecting Line Mobile (Flows Right to Left) -->
                            <div class="absolute top-[18px] left-0 w-1/2 h-[4px] snake-h-rev z-0 md:hidden"></div>

                            <div class="relative z-10 w-10 h-10 rounded-full bg-white border-2 border-blue-200 text-blue-600 flex items-center justify-center font-black text-sm shadow-sm mb-2 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all">
                                4
                            </div>
                            <p class="text-xs font-bold text-gray-800">Quality Control</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-tight">OS, driver & stress test</p>
                        </div>
                        
                        <!-- Step 5 -->
                        <div class="relative z-10 flex flex-col items-center text-center group col-start-2 row-start-2 md:col-auto md:row-auto">
                            <!-- Connecting Line Mobile (Receives from Right) -->
                            <div class="absolute top-[18px] right-0 w-1/2 h-[4px] snake-h-rev z-0 md:hidden"></div>

                            <div class="relative z-10 w-10 h-10 rounded-full bg-emerald-500 border-2 border-emerald-500 text-white flex items-center justify-center font-black text-lg shadow-sm mb-2 group-hover:scale-110 transition-all z-10">
                                <i class='bx bx-check'></i>
                            </div>
                            <p class="text-xs font-bold text-emerald-600">Selesai</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-tight">PC siap diambil/kirim</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Grid -->
        <div id="paket" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            @if($packages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
                @foreach($packages as $index => $package)
                @php
                    $isMid      = ($index % 3 == 1);
                    $checkColor = 'text-blue-500';
                    $priceColor = $isMid ? 'text-blue-600' : 'text-gray-900';
                    $textColor  = 'text-gray-900';
                    $descColor  = 'text-gray-500';
                    $specColor  = 'text-gray-600';
                    $iconBg     = $isMid ? 'bg-blue-50' : 'bg-slate-50';
                    $iconText   = $isMid ? 'text-blue-600' : 'text-slate-500';
                    $cardBg     = 'bg-white';
                    $cardBorder = $isMid ? 'border-2 border-blue-400' : 'border border-gray-200';
                    $cardExtra  = $isMid ? 'shadow-lg md:-translate-y-2 z-10' : 'shadow-sm';
                    $btnClass   = 'w-full mt-4 inline-flex justify-center items-center gap-1.5 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl transition shadow-sm';
                    $waText     = urlencode('Halo LKTech, saya ingin memesan paket ' . $package->nama_paket);
                @endphp
                <div class="{{ $cardBg }} rounded-2xl {{ $cardBorder }} p-5 hover:shadow-xl transition-all duration-300 flex flex-col h-full relative overflow-hidden group {{ $cardExtra }}">
                    <div class="flex-grow">
                        @if($package->foto)
                            <div class="w-full h-40 mb-4 rounded-xl overflow-hidden bg-gray-50 p-1 border border-gray-100">
                                <img src="{{ Storage::url($package->foto) }}" alt="{{ $package->nama_paket }}" class="w-full h-full object-contain hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="w-12 h-12 {{ $iconBg }} {{ $iconText }} rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-all duration-300">
                                <i class='bx bx-desktop'></i>
                            </div>
                        @endif
                        
                        <h3 class="text-lg font-black {{ $textColor }} mb-1 font-montserrat tracking-tight">{{ $package->nama_paket }}</h3>
                        
                        @if(!empty($package->deskripsi))
                        <p class="text-[11px] {{ $descColor }} mb-4 leading-relaxed">{{ $package->deskripsi }}</p>
                        @endif

                        @if($package->spesifikasi_singkat)
                        <div class="bg-gray-50/50 p-3 rounded-xl border border-gray-100 mb-4">
                            <ul class="space-y-1.5 text-[11px] {{ $specColor }} font-medium">
                                @foreach(explode("\n", str_replace("\r", "", $package->spesifikasi_singkat)) as $spec)
                                    @if(trim($spec) != '')
                                        <li class="flex items-start gap-1.5">
                                            <i class='bx bx-check {{ $checkColor }} mt-0.5 text-sm shrink-0'></i>
                                            <span class="leading-snug">{!! nl2br(e($spec)) !!}</span>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <div class="mt-auto pt-3 border-t border-gray-100">
                        <p class="text-[9px] uppercase tracking-wider text-gray-400 font-bold mb-0.5">Mulai dari</p>
                        <div class="flex items-baseline gap-1 mb-2">
                            <span class="text-xs font-bold {{ $priceColor }}">Rp</span>
                            <span class="text-2xl sm:text-3xl font-black {{ $priceColor }} tracking-tight">{{ number_format($package->harga_estimasi, 0, ',', '.') }}</span>
                        </div>
                        <a href="https://wa.me/628567354046?text={{ $waText }}" target="_blank" class="{{ $btnClass }}">
                            <i class='bx bxl-whatsapp text-base'></i> Pesan Paket Ini
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <i class='bx bx-desktop text-5xl text-gray-300 mb-3'></i>
                <p class="text-gray-500 font-bold text-sm">Belum ada paket Rakit PC yang tersedia.</p>
                <p class="text-xs text-gray-400 mt-1">Silakan hubungi kami untuk konsultasi rakitan custom.</p>
            </div>
            @endif
        </div>

        {{-- Consultation Banner (Hemat tempat) --}}
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-lg relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="text-center md:text-left relative z-10 flex-grow">
                    <span class="inline-block bg-white/20 text-white text-[9px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded-full border border-white/30 mb-2">Spek Custom</span>
                    <h3 class="text-lg md:text-xl font-black text-white font-montserrat mb-1.5">Tidak Ada Paket yang Cocok?</h3>
                    <p class="text-blue-100 text-xs leading-relaxed max-w-md">Ceritakan kebutuhan game, software, dan budget Anda. Teknisi LKTech akan meracikkan PC yang 100% sesuai untuk Anda.</p>
                </div>
                
                <div class="relative z-10 shrink-0">
                    <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin konsultasi rakit PC custom.') }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-6 py-3 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition shadow-sm text-xs whitespace-nowrap">
                        <i class='bx bxl-whatsapp text-lg text-green-500'></i> Konsultasi WhatsApp
                    </a>
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
