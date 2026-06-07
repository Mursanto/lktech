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
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 gap-4">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 w-auto">
                        <span class="font-montserrat font-black text-xl tracking-tight text-blue-900 hidden sm:block">LKTech TN SEREAL</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-700">
                    <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors">Katalog</a>
                    <a href="{{ route('rakit-pc') }}" class="text-brand-600 hover:text-brand-700 transition-colors">Rakit PC</a>
                    <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors">Blog & Panduan</a>
                    <a href="{{ route('tentang-kami') }}" class="hover:text-brand-600 transition-colors">Tentang Kami</a>
                </div>
                <div class="flex-shrink-0 flex items-center gap-3 md:hidden">
                    <a href="{{ route('katalog.index') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600">Ke Katalog</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full">
        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-gray-900 to-blue-900 py-20 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-40"></div>
            <!-- Decorative blur -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full blur-[100px] opacity-30"></div>
            <div class="absolute bottom-0 left-10 w-64 h-64 bg-cyan-500 rounded-full blur-[100px] opacity-20"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <span class="inline-block px-3 py-1 bg-white/10 text-brand-300 border border-brand-400/30 rounded-full font-bold tracking-wider uppercase text-[10px] mb-4">Layanan Profesional LKTech</span>
                <h1 class="text-4xl md:text-6xl font-black text-white font-montserrat mb-6 drop-shadow-lg tracking-tight">Rakit PC Impian Anda</h1>
                <p class="text-lg text-gray-200 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Mulai dari PC Office hingga PC Gaming & Rendering kelas atas. Kami bantu pilih komponen terbaik, rakit dengan manajemen kabel super rapi, dan uji performa maksimal sesuai budget Anda.
                </p>
                <a href="#paket" class="inline-flex items-center gap-2 px-8 py-3.5 bg-brand-600 hover:bg-brand-500 text-white rounded-full font-bold transition-all shadow-[0_0_20px_rgba(37,99,235,0.4)] hover:shadow-[0_0_25px_rgba(37,99,235,0.6)] transform hover:-translate-y-1">
                    Lihat Paket Rekomendasi <i class='bx bx-down-arrow-alt text-xl'></i>
                </a>
            </div>
        </div>

        <!-- Packages Grid -->
        <div id="paket" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-black text-gray-900 font-montserrat mb-3 tracking-tight">Pilihan Paket Rakit PC</h2>
                <p class="text-gray-500 text-sm max-w-xl mx-auto">Tentukan standar performa yang Anda inginkan. Komponen di bawah adalah estimasi referensi yang bisa di-custom sesuai kebutuhan Anda.</p>
            </div>
            @if($packages->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($packages as $index => $package)
                @php
                    // Alternating styles for visual variety
                    $styles = [
                        0 => [
                            'bg' => 'bg-white', 'text' => 'text-gray-900', 'desc' => 'text-gray-500', 
                            'icon_bg' => 'bg-blue-50', 'icon_text' => 'text-blue-600', 'border' => 'border-gray-100',
                            'check' => 'text-brand-500', 'price' => 'text-gray-900', 'card_extra' => ''
                        ],
                        1 => [
                            'bg' => 'bg-white', 'text' => 'text-gray-900', 'desc' => 'text-gray-500', 
                            'icon_bg' => 'bg-brand-50', 'icon_text' => 'text-brand-600', 'border' => 'border-brand-200',
                            'check' => 'text-brand-500', 'price' => 'text-brand-600', 'card_extra' => 'shadow-2xl md:-translate-y-4 z-10'
                        ],
                        2 => [
                            'bg' => 'bg-gray-900', 'text' => 'text-white', 'desc' => 'text-gray-400', 
                            'icon_bg' => 'bg-gray-800', 'icon_text' => 'text-purple-400', 'border' => 'border-gray-800',
                            'check' => 'text-purple-400', 'price' => 'text-purple-400', 'card_extra' => ''
                        ]
                    ];
                    $style = $styles[$index % 3];
                @endphp
                <div class="{{ $style['bg'] }} rounded-3xl shadow-sm border {{ $style['border'] }} p-8 hover:shadow-xl transition-all flex flex-col relative overflow-hidden group {{ $style['card_extra'] }}">
                    @if($index % 3 == 1)
                    <div class="absolute top-0 right-0 bg-brand-600 text-white text-[10px] font-black px-4 py-1.5 rounded-bl-2xl uppercase tracking-widest shadow-sm z-20">
                        Paling Laris
                    </div>
                    @elseif($index % 3 == 2)
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-900/20 to-transparent"></div>
                    @endif
                    
                    <div class="w-14 h-14 {{ $style['icon_bg'] }} {{ $style['icon_text'] }} rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border {{ $style['border'] }} relative z-10">
                        @if($package->foto)
                            <img src="{{ Storage::url($package->foto) }}" alt="{{ $package->nama_paket }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <i class='bx bx-desktop'></i>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold {{ $style['text'] }} mb-2 font-montserrat relative z-10">{{ $package->nama_paket }}</h3>
                    <p class="text-sm {{ $style['desc'] }} mb-6 flex-grow leading-relaxed relative z-10">{{ $package->deskripsi }}</p>
                    
                    @if($package->spesifikasi_singkat)
                    <ul class="space-y-3 mb-8 text-[13px] {{ $index % 3 == 2 ? 'text-gray-300' : 'text-gray-600' }} font-medium relative z-10">
                        @foreach(explode("\n", str_replace("\r", "", $package->spesifikasi_singkat)) as $spec)
                            @if(trim($spec) != '')
                                <li class="flex items-start gap-2.5"><i class='bx bx-check {{ $style['check'] }} mt-0.5 text-lg'></i> <span>{!! nl2br(e($spec)) !!}</span></li>
                            @endif
                        @endforeach
                    </ul>
                    @endif
                    
                    <div class="pt-5 border-t {{ $index % 3 == 2 ? 'border-gray-800' : 'border-gray-100' }} relative z-10">
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Mulai dari</p>
                        <p class="text-3xl font-black {{ $style['price'] }}">Rp {{ number_format($package->harga_estimasi, 0, ',', '.') }}</p>
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
                    <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gradient-to-b from-brand-100 via-brand-200 to-emerald-100"></div>
                    
                    <div class="space-y-12 md:space-y-0 relative">
                        <!-- Step 1 -->
                        <div class="relative flex flex-col md:flex-row items-center justify-between md:mb-20 group">
                            <div class="order-2 md:order-1 md:w-5/12 text-center md:text-right pt-6 md:pt-0">
                                <h4 class="text-xl font-bold text-gray-900 mb-2 font-montserrat">Konsultasi Spek & Harga</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Diskusikan kebutuhan dan anggaran Anda. Teknisi kami akan meracik komponen terbaik yang 100% kompatibel tanpa ada bottleneck yang mubazir.</p>
                            </div>
                            <div class="order-1 md:order-2 z-10 flex items-center justify-center w-14 h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">1</div>
                            <div class="order-3 md:order-3 md:w-5/12"></div>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative flex flex-col md:flex-row items-center justify-between md:mb-20 group">
                            <div class="order-2 md:order-1 md:w-5/12 hidden md:block"></div>
                            <div class="order-1 md:order-2 z-10 flex items-center justify-center w-14 h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">2</div>
                            <div class="order-3 md:order-3 md:w-5/12 text-center md:text-left pt-6 md:pt-0">
                                <h4 class="text-xl font-bold text-gray-900 mb-2 font-montserrat">Pembayaran / DP</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Setelah *parts list* disepakati, Anda dapat melakukan pembayaran DP atau Full Payment sebagai tanda jadi agar komponen bisa langsung kami proses.</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative flex flex-col md:flex-row items-center justify-between md:mb-20 group">
                            <div class="order-2 md:order-1 md:w-5/12 text-center md:text-right pt-6 md:pt-0">
                                <h4 class="text-xl font-bold text-gray-900 mb-2 font-montserrat">Perakitan & Cable Management</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Komponen dirakit dengan sangat teliti. Kami menjamin *cable management* yang sangat rapi untuk estetika dan sirkulasi udara (airflow) casing yang maksimal.</p>
                            </div>
                            <div class="order-1 md:order-2 z-10 flex items-center justify-center w-14 h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">3</div>
                            <div class="order-3 md:order-3 md:w-5/12"></div>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative flex flex-col md:flex-row items-center justify-between md:mb-20 group">
                            <div class="order-2 md:order-1 md:w-5/12 hidden md:block"></div>
                            <div class="order-1 md:order-2 z-10 flex items-center justify-center w-14 h-14 rounded-full bg-white border-4 border-brand-100 text-brand-600 font-black text-xl shadow-[0_0_15px_rgba(37,99,235,0.1)] group-hover:bg-brand-600 group-hover:border-brand-200 group-hover:text-white transition-all duration-300">4</div>
                            <div class="order-3 md:order-3 md:w-5/12 text-center md:text-left pt-6 md:pt-0">
                                <h4 class="text-xl font-bold text-gray-900 mb-2 font-montserrat">Strict Stress Testing (QC)</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">Instalasi OS & Driver original. PC wajib melewati stress test ketat (Cinebench/Furmark) untuk memastikan tidak ada overheat dan kerusakan pabrik (defect).</p>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="relative flex flex-col md:flex-row items-center justify-between group">
                            <div class="order-2 md:order-1 md:w-5/12 text-center md:text-right pt-6 md:pt-0">
                                <h4 class="text-xl font-bold text-emerald-600 mb-2 font-montserrat">Penyerahan Unit Selesai</h4>
                                <p class="text-sm text-gray-500 leading-relaxed">PC impian Anda siap tempur! Silakan ambil langsung di toko LKTech, atau kami kirim ke alamat Anda dengan packing kayu super aman berasuransi.</p>
                            </div>
                            <div class="order-1 md:order-2 z-10 flex items-center justify-center w-14 h-14 rounded-full bg-emerald-500 border-4 border-emerald-100 text-white font-black text-2xl shadow-[0_0_20px_rgba(16,185,129,0.3)]"><i class='bx bx-check'></i></div>
                            <div class="order-3 md:order-3 md:w-5/12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Floating CTA (WhatsApp) -->
    <a href="https://wa.me/6281234567890?text=Halo%20LKTech,%20saya%20tertarik%20untuk%20konsultasi%20jasa%20Rakit%20PC." 
       target="_blank"
       class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white p-4 rounded-full shadow-2xl hover:bg-[#128C7E] hover:-translate-y-1 transition-all flex items-center gap-2 group border-2 border-white">
        <i class='bx bxl-whatsapp text-3xl'></i>
        <span class="font-bold text-sm max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out whitespace-nowrap hidden md:block">Konsultasi Rakit PC Sekarang</span>
    </a>

    <!-- Footer -->
    <x-footer />

</body>
</html>
