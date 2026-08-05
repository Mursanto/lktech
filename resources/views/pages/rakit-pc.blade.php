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
    <main class="flex-grow w-full pb-20 md:pb-0">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-50 via-cyan-50/70 to-emerald-50 py-10 px-4 sm:px-6 lg:px-8 text-center border-b border-cyan-100/70 w-full overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 bg-blue-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-emerald-200/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-200/60 text-blue-600 text-[11px] font-semibold px-4 py-1.5 rounded-full mb-3 select-none">
                <i class='bx bx-desktop text-sm'></i>
                Jasa Rakit PC — LKTech TN SEREAL
            </div>
            <h1 class="text-2xl md:text-3xl font-black font-montserrat text-blue-900 mb-2 tracking-tight">Rakit PC Impian Anda</h1>
            <p class="text-gray-600 text-xs md:text-sm max-w-2xl mx-auto leading-relaxed">Mulai dari PC Office hingga PC Gaming &amp; Rendering kelas atas. Perakitan profesional oleh LKTech, sesuai budget Anda.</p>
        </div>

        <!-- Packages Grid -->
        <div id="paket" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
            @if($packages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                @foreach($packages as $index => $package)
                @php
                    $isMid      = ($index % 3 == 1);
                    $checkColor = 'text-brand-500';
                    $priceColor = $isMid ? 'text-brand-600' : 'text-gray-900';
                    $textColor  = 'text-gray-900';
                    $descColor  = 'text-gray-500';
                    $specColor  = 'text-gray-600';
                    $iconBg     = $isMid ? 'bg-brand-50' : 'bg-blue-50';
                    $iconText   = $isMid ? 'text-brand-600' : 'text-blue-600';
                    $dividerClr = 'border-gray-100';
                    $cardBg     = 'bg-white';
                    $cardBorder = $isMid ? 'border-2 border-blue-500' : 'border border-slate-100';
                    $cardExtra  = $isMid ? 'shadow-xl lg:-translate-y-2 z-10' : 'shadow-sm';
                    $btnClass   = 'w-full mt-4 inline-flex justify-center items-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition';
                    $waText     = urlencode('Halo LKTech, saya ingin memesan paket ' . $package->nama_paket);
                @endphp
                <div class="{{ $cardBg }} rounded-3xl {{ $cardBorder }} p-6 sm:p-8 hover:shadow-xl transition-all duration-300 flex flex-col h-full relative overflow-hidden group {{ $cardExtra }}">
                    @if($isMid)
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-blue-600 text-white text-[10px] font-black px-4 py-1 rounded-full uppercase tracking-widest shadow-md z-20 whitespace-nowrap">
                        🔥 PALING LARIS
                    </div>
                    @endif

                    <div class="flex-grow">
                        @if($package->foto)
                            <div class="w-full h-48 mb-6 shadow-sm border {{ $dividerClr }} relative z-10 rounded-2xl overflow-hidden bg-gray-50 p-2">
                                <img src="{{ Storage::url($package->foto) }}" alt="{{ $package->nama_paket }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-14 h-14 {{ $iconBg }} {{ $iconText }} rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border {{ $dividerClr }} relative z-10 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                <i class='bx bx-desktop'></i>
                            </div>
                        @endif
                        <h3 class="text-xl font-bold {{ $textColor }} mb-2 font-montserrat relative z-10">{{ $package->nama_paket }}</h3>

                        @if(!empty($package->deskripsi))
                        <p class="text-sm {{ $descColor }} mb-5 leading-relaxed relative z-10">{{ $package->deskripsi }}</p>
                        @endif

                        @if($package->spesifikasi_singkat)
                        <ul class="space-y-2.5 mb-6 text-[13px] {{ $specColor }} font-medium relative z-10">
                            @foreach(explode("\n", str_replace("\r", "", $package->spesifikasi_singkat)) as $spec)
                                @if(trim($spec) != '')
                                    <li class="flex items-start gap-2.5">
                                        <i class='bx bx-check {{ $checkColor }} mt-0.5 text-lg shrink-0'></i>
                                        <span>{!! nl2br(e($spec)) !!}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        @endif
                    </div>

                    <div class="mt-auto pt-5 border-t {{ $dividerClr }} relative z-10">
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Mulai dari</p>
                        <p class="text-2xl sm:text-3xl font-black {{ $priceColor }} whitespace-nowrap mb-3">Rp {{ number_format($package->harga_estimasi, 0, ',', '.') }}</p>
                        <a href="https://wa.me/628567354046?text={{ $waText }}" target="_blank" class="{{ $btnClass }}">
                            <i class='bx bxl-whatsapp text-lg'></i> Pesan Paket Ini via WhatsApp
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <i class='bx bx-desktop text-6xl text-gray-300 mb-4'></i>
                <p class="text-gray-500 font-medium">Belum ada paket Rakit PC yang tersedia saat ini.</p>
                <p class="text-sm text-gray-400 mt-2">Silakan hubungi kami untuk konsultasi langsung.</p>
            </div>
            @endif
        </div>

        <!-- Assembly Workflow -->
        <div class="bg-white py-20 border-y border-gray-100 relative overflow-hidden">
            <!-- Decorative Background -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNFMkU4RjAiLz48L3N2Zz4=')] opacity-50"></div>
            
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-[10px] mb-2 block bg-brand-50 inline-block px-3 py-1 rounded-full border border-brand-100">Step By Step</span>
                    <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Alur Kerja Kami</h2>
                    <p class="text-gray-500 text-sm max-w-xl mx-auto">Transparan, rapi, dan diawasi dengan quality control (QC) ketat pada setiap tahap perakitannya.</p>
                </div>
                
                <div class="relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-6 md:left-1/2 transform md:-translate-x-1/2 h-full w-0.5 bg-gradient-to-b from-brand-100 via-brand-200 to-emerald-100"></div>
                    
                    <div class="space-y-0 relative">
                        <!-- Step 1 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-20 group">
                            <div class="order-2 md:order-1 ml-4 md:ml-0 md:w-5/12 text-left md:text-right">
                                <div class="bg-white/80 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <h4 class="text-base md:text-xl font-bold text-gray-900 mb-1 md:mb-2 font-montserrat">Konsultasi Spek &amp; Harga</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Diskusikan kebutuhan dan anggaran Anda. Teknisi kami akan meracik komponen terbaik yang 100% kompatibel tanpa ada <em>bottleneck</em> yang mubazir.</p>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-lg md:text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">1</div>
                            <div class="hidden md:block order-3 md:w-5/12"></div>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-20 group">
                            <div class="hidden md:block order-1 md:w-5/12"></div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-lg md:text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">2</div>
                            <div class="order-2 md:order-3 ml-4 md:ml-0 md:w-5/12 text-left">
                                <div class="bg-white/80 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <h4 class="text-base md:text-xl font-bold text-gray-900 mb-1 md:mb-2 font-montserrat">Pembayaran / DP</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Setelah <em>parts list</em> disepakati, Anda dapat melakukan pembayaran DP atau Full Payment sebagai tanda jadi agar komponen bisa langsung kami proses.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-20 group">
                            <div class="order-2 md:order-1 ml-4 md:ml-0 md:w-5/12 text-left md:text-right">
                                <div class="bg-white/80 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <h4 class="text-base md:text-xl font-bold text-gray-900 mb-1 md:mb-2 font-montserrat">Perakitan &amp; <em>Cable Management</em></h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Komponen dirakit dengan sangat teliti. Kami menjamin <em>cable management</em> yang sangat rapi untuk estetika dan sirkulasi udara (<em>airflow</em>) casing yang maksimal.</p>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-lg md:text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">3</div>
                            <div class="hidden md:block order-3 md:w-5/12"></div>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between mb-8 md:mb-20 group">
                            <div class="hidden md:block order-1 md:w-5/12"></div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-lg md:text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">4</div>
                            <div class="order-2 md:order-3 ml-4 md:ml-0 md:w-5/12 text-left">
                                <div class="bg-white/80 p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                                    <h4 class="text-base md:text-xl font-bold text-gray-900 mb-1 md:mb-2 font-montserrat">Strict Stress Testing (QC)</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Instalasi OS &amp; Driver original. PC wajib melewati <em>stress test</em> ketat (Cinebench/Furmark) untuk memastikan tidak ada <em>overheat</em> dan kerusakan pabrik (<em>defect</em>).</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="relative flex flex-row items-start md:items-center justify-between group mb-8 md:mb-0">
                            <div class="order-2 md:order-1 ml-4 md:ml-0 md:w-5/12 text-left md:text-right">
                                <div class="bg-emerald-50/80 p-5 rounded-2xl border border-emerald-100 shadow-sm hover:shadow-md transition">
                                    <h4 class="text-base md:text-xl font-bold text-emerald-600 mb-1 md:mb-2 font-montserrat">Penyerahan Unit Selesai ✅</h4>
                                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">PC impian Anda siap tempur! Silakan ambil langsung di toko LKTech, atau kami kirim ke alamat Anda dengan <em>packing</em> kayu super aman berasuransi.</p>
                                </div>
                            </div>
                            <div class="order-1 md:order-2 z-10 shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-emerald-500 border-4 border-emerald-100 text-white font-black text-xl md:text-2xl shadow-[0_0_20px_rgba(16,185,129,0.3)]"><i class='bx bx-check'></i></div>
                            <div class="hidden md:block order-3 md:w-5/12"></div>
                        </div>
                    </div>
                </div>

                {{-- ─── Consultation Banner ─────────── --}}
                <div class="mt-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 md:p-10 text-center shadow-xl relative overflow-hidden">
                    <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="relative z-10">
                        <span class="inline-block bg-white/20 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-white/30 mb-4">Butuh Spek Custom?</span>
                        <h3 class="text-xl md:text-2xl font-black text-white font-montserrat mb-3">Tidak Ada yang Cocok? Konsultasi Langsung!</h3>
                        <p class="text-blue-100 text-sm leading-relaxed max-w-xl mx-auto mb-6">Ceritakan kebutuhan Anda — game favorit, software, atau budget — dan teknisi LKTech akan meracikkan PC terbaik yang 100% sesuai untuk Anda.</p>
                        <a href="https://wa.me/628567354046?text={{ urlencode('Halo LKTech, saya ingin konsultasi rakit PC custom.') }}" target="_blank"
                           class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition shadow-md text-sm">
                            <i class='bx bxl-whatsapp text-xl text-green-500'></i> Konsultasi via WhatsApp
                        </a>
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
