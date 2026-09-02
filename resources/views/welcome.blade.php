<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog LKTech TN SEREAL</title>
    
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
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6', 
                            600: '#2563eb', 
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        [x-cloak] { display: none !important; }

        /* ==========================================
           PIANO WAVE ANIMATION UNTUK SERVICE CARDS
           ========================================== */
        @keyframes pianoWave {
          0%, 100% {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
          }
          50% {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.25);
            border-color: #93c5fd;
          }
        }

        .service-card {
          animation: pianoWave 4s infinite ease-in-out;
        }

        .service-card:nth-child(1) { animation-delay: 0.0s; }
        .service-card:nth-child(2) { animation-delay: 0.4s; }
        .service-card:nth-child(3) { animation-delay: 0.8s; }
        .service-card:nth-child(4) { animation-delay: 1.2s; }
        .service-card:nth-child(5) { animation-delay: 1.6s; }
        .service-card:nth-child(6) { animation-delay: 2.0s; }

        .service-card:hover {
          animation-play-state: paused;
        }

        /* ==========================================
           RESET CONTAINER UNTUK MENCEGAH SPACE KOSONG
           ========================================== */
        .hero-section,
        .hero-container,
        .hero-content {
          height: auto !important;
          min-height: 0 !important;
          padding-bottom: 0 !important;
        }

        /* Styling Judul Utama Baru */
        .hero-title {
          font-size: 2rem;
          line-weight: 800;
          text-transform: uppercase;
          letter-spacing: -0.02em;
          color: #0f172a;
          margin-top: 0;
          margin-bottom: 10px;
        }

        /* ==========================================
           PENYESUAIAN TAMPILAN WEB MOBILE (< 640px)
           ========================================== */
        @media (max-width: 639px) {
          .hero-section {
            padding: 12px 16px 8px 16px !important;
            background-color: #f0f9ff;
          }

          .hero-badge {
            font-size: 0.7rem !important;
            padding: 4px 10px !important;
            margin-bottom: 6px !important;
          }

          .hero-title {
            font-size: 1.35rem !important;
            line-height: 1.25 !important;
            margin-bottom: 8px !important;
          }

          .hero-description {
            font-size: 0.78rem !important;
            line-height: 1.35 !important;
            margin-bottom: 10px !important;
          }

          .hero-buttons {
            gap: 8px !important;
            margin-bottom: 10px !important;
          }

          .hero-buttons .btn {
            padding: 8px 12px !important;
            font-size: 0.8rem !important;
          }

          .hero-trust-bar {
            display: flex !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
            gap: 4px !important;
            font-size: 0.68rem !important;
            color: #475569 !important;
            padding-top: 6px !important;
            border-top: 1px solid rgba(0, 0, 0, 0.05) !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
          }

          .hero-trust-bar .divider {
            color: #cbd5e1 !important;
            margin: 0 2px !important;
          }

          .mp-label {
            font-weight: 500 !important;
          }

          .mp-icons img {
            height: 14px !important;
            width: auto !important;
          }
        }

    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen" x-data="{ loginModalOpen: {{ $errors->any() || session('showLoginPopup') ? 'true' : 'false' }} }" :class="loginModalOpen ? 'overflow-hidden' : ''">

    <!-- Top Navbar (Tokopedia Style) -->

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full">
        
        <!-- Hero Section -->
        @if(!request()->has('search'))
        <section class="hero-section bg-gradient-to-br from-white via-brand-50 to-cyan-50 text-gray-900 border-b border-gray-200 relative overflow-hidden">
            <!-- Subtle abstract shapes -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-cyan-200 opacity-40 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-200 opacity-40 blur-3xl"></div>
            
            <div class="hero-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 lg:py-5 relative z-10 w-full">
                <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-4 lg:gap-6">
                    
                    <!-- Left: Text (60%) -->
                    <div class="hero-content md:col-span-7 flex flex-col">
                        <!-- Judul & Deskripsi Ringkas -->
                        <h1 class="hero-title font-montserrat font-black leading-tight tracking-tight text-blue-900 drop-shadow-sm mb-3">Kalo bisa beli bekas berkualitas, kenapa musti beli baru? #mikir 🤔</h1>
                        <p class="hero-description text-gray-600 text-xs sm:text-sm md:text-base font-medium mb-4">
                            Spesialis laptop bekas premium lolos QC & bergaransi, didukung layanan rakit PC, sewa, service dan website untuk bisnis modern.
                        </p>

                        <!-- Tombol CTA -->
                        <div class="hero-buttons flex flex-row w-full gap-2 sm:gap-4 mb-4">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20Konsultasi%20Gratis." target="_blank" class="btn btn-primary flex-1 justify-center text-center px-2 sm:px-4 py-2 sm:py-2.5 bg-brand-600 border border-brand-600 text-white font-extrabold rounded-lg shadow-md hover:bg-brand-700 transition text-xs sm:text-sm flex items-center gap-1 sm:gap-2">Konsultasi Gratis</a>
                            <a href="{{ route('katalog.index') }}" class="btn btn-outline flex-1 justify-center text-center px-2 sm:px-4 py-2 sm:py-2.5 bg-transparent border-2 border-brand-600 text-brand-600 font-extrabold rounded-lg hover:bg-brand-50 transition text-xs sm:text-sm flex items-center gap-1 sm:gap-2">Lihat Katalog</a>
                        </div>

                        <!-- Marketplace & Rating Bar (Rapat & 1 Baris di Mobile) -->
                        <div class="hero-trust-bar flex flex-row items-center flex-nowrap overflow-x-auto gap-2 pt-1.5 text-[10px] sm:text-xs text-gray-500 border-t border-gray-150 mt-1 whitespace-nowrap w-full scrollbar-none">
                            <span class="rating-text flex items-center gap-0.5 font-bold text-gray-800 shrink-0">⭐ <strong>4.9</strong> <span class="font-normal text-gray-500 text-[9px] sm:text-[10px]">(Rating Toko)</span></span>
                            <span class="divider text-gray-300 shrink-0 hidden sm:inline">•</span>
                            <span class="mp-label font-semibold shrink-0 hidden sm:inline">Tersedia juga di Marketplace resmi kami:</span>
                            <div class="mp-icons flex items-center hover:opacity-90 transition-opacity duration-300 mix-blend-multiply shrink-0">
                                <img src="{{ asset('images/Logo-TokPed-TikTok-Shopee.png') }}" alt="Marketplace Resmi LKTech" class="h-4.5 sm:h-7 w-auto object-contain">
                            </div>
                        </div>



                    </div>
                    
                    <!-- Right: Dynamic Promo Banner (40%) -->
                    <div class="md:col-span-5 hidden md:block relative px-4 lg:px-8 flex justify-center">
                        @php
                            $promoBanners = [];
                            if (isset($setting)) {
                                $promoBanners = $setting->promo_banners ?? [];
                                if (empty($promoBanners) && $setting->promo_image_path) {
                                    $promoBanners[] = [
                                        'image' => $setting->promo_image_path,
                                        'link' => $setting->promo_link
                                    ];
                                }
                            }
                        @endphp
                        
                        @if(count($promoBanners) > 0)
                            <div class="relative w-full max-w-lg mx-auto group"
                                 x-data="{ 
                                    activeSlide: 0, 
                                    slides: {{ count($promoBanners) }},
                                    init() {
                                        if(this.slides > 1) {
                                            setInterval(() => {
                                                this.activeSlide = this.activeSlide === this.slides - 1 ? 0 : this.activeSlide + 1
                                            }, 8000);
                                        }
                                    }
                                 }">
                                 
                                <div class="relative overflow-hidden rounded-3xl shadow-2xl transform hover:scale-105 transition duration-700 aspect-[16/9] bg-transparent border border-white/20">
                                    @foreach($promoBanners as $index => $banner)
                                        <div x-show="activeSlide === {{ $index }}" 
                                             x-transition:enter="transition ease-out duration-700"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-700 absolute inset-0"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-105"
                                             class="absolute inset-0 w-full h-full flex items-center justify-center">
                                            @if(!empty($banner['link']))
                                                <a href="{{ $banner['link'] }}" class="block w-full h-full">
                                                    <img src="{{ asset('storage/' . $banner['image']) }}" alt="Promo Banner {{ $index + 1 }}" class="w-full h-full object-cover rounded-3xl">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $banner['image']) }}" alt="Promo Banner {{ $index + 1 }}" class="w-full h-full object-cover rounded-3xl">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if(count($promoBanners) > 1)
                                    <!-- Left/Right Arrow Buttons (Manual navigation) -->
                                    <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1" 
                                            class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/35 hover:bg-black/55 text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 z-20">
                                        <i class='bx bx-chevron-left text-xl'></i>
                                    </button>
                                    <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/35 hover:bg-black/55 text-white flex items-center justify-center transition-all opacity-0 group-hover:opacity-100 z-20">
                                        <i class='bx bx-chevron-right text-xl'></i>
                                    </button>

                                    <!-- Dots Indicators (Proper margin-top) -->
                                    <div class="flex justify-center gap-2 mt-4">
                                        @foreach($promoBanners as $index => $banner)
                                            <button @click="activeSlide = {{ $index }}" 
                                                    class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                                                    :class="activeSlide === {{ $index }} ? 'bg-brand-600 w-6' : 'bg-brand-300 hover:bg-brand-400'"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Placeholder jika belum ada promo -->
                            <div class="aspect-[16/9] w-full max-w-lg mx-auto rounded-3xl overflow-hidden shadow-2xl border border-white/20 bg-transparent transform rotate-1 hover:rotate-0 transition duration-700 hover:scale-105">
                                <img src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Laptop Premium" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @endif

        <!-- 4 Info Cards Section -->
        @if(!request()->has('search'))
        <div class="hidden md:block max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <x-info-cards />
        </div>
        @endif

        <!-- Product Grid Section -->
        <div id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-0 pb-6 lg:pt-2 lg:pb-8 flex-shrink-0">
            
            <div class="mb-2 flex flex-wrap justify-between items-center gap-4">
                @if(request()->has('search') && request()->search != '')
                <div class="flex items-center gap-4 w-full">
                    <div>
                        <h2 class="text-sm font-bold text-gray-800">Hasil Pencarian: "{{ request()->search }}"</h2>
                        <p class="text-gray-500 text-xs mt-1">Menampilkan {{ $products->total() }} produk yang sesuai.</p>
                    </div>
                    <a href="{{ route('home') }}" class="text-brand-600 text-xs font-semibold hover:underline bg-brand-50 px-3 py-1.5 rounded-lg border border-brand-100 ml-auto">Lihat Semua</a>
                </div>
                @else
                <div class="flex items-center gap-4 w-full mb-2">
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-gray-900 font-montserrat tracking-tight mb-0 flex items-center gap-2">
                            <i class='bx bx-laptop text-brand-500'></i> Produk & Device
                        </h2>
                        <p class="text-gray-500 text-[11px] sm:text-xs mt-0.5">Berbagai pilihan laptop dan device terbaik.</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Precision Grid (Compact Design) -->
            <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] sm:grid-cols-[repeat(auto-fit,minmax(190px,1fr))] gap-4">
                @forelse($products as $product)
                <x-product-card :product="$product" />
                @empty
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-white rounded-xl border border-gray-200">
                    <i class='bx bx-search-alt text-5xl text-gray-300 mb-3'></i>
                    <h3 class="text-base font-bold text-gray-800">Wah, produk tidak ditemukan!</h3>
                    <p class="text-gray-500 text-xs mt-1">Coba gunakan kata kunci lain untuk mencari produk idamanmu.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(method_exists($products, 'links'))
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
            
        </div>

        <!-- Produk Terlaris Section -->
        @if(!request()->has('search'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 lg:py-4">
            <div class="mb-5 border-b border-gray-100 pb-3">
                <h2 class="text-lg sm:text-xl font-black text-gray-900 font-montserrat tracking-tight mb-0 flex items-center gap-2">
                    <i class='bx bxs-hot text-orange-500'></i> Produk Terlaris
                </h2>
                <p class="text-gray-500 text-xs sm:text-sm mt-1">Lisensi software, aksesoris, dan sparepart terfavorit.</p>
            </div>

            @if(isset($softwareProducts) && $softwareProducts->count() > 0)
            <div class="mb-8">
                <div class="flex justify-between items-end mb-3">
                    <div class="min-w-0 flex-1 border-l-4 border-brand-500 pl-2">
                        <h3 class="text-sm sm:text-base font-bold text-gray-800 font-montserrat tracking-tight mb-0 flex items-center gap-2 truncate">
                            Lisensi & Software
                        </h3>
                    </div>
                </div>
                <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] sm:grid-cols-[repeat(auto-fit,minmax(190px,1fr))] gap-3 sm:gap-4">
                    @foreach($softwareProducts as $product)
                        <div class="w-full">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(isset($accessoriesProducts) && $accessoriesProducts->count() > 0)
            <div class="mb-8">
                <div class="flex justify-between items-end mb-3">
                    <div class="min-w-0 flex-1 border-l-4 border-amber-500 pl-2">
                        <h3 class="text-sm sm:text-base font-bold text-gray-800 font-montserrat tracking-tight mb-0 flex items-center gap-2 truncate">
                            Aksesoris
                        </h3>
                    </div>
                </div>
                <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] sm:grid-cols-[repeat(auto-fit,minmax(190px,1fr))] gap-3 sm:gap-4">
                    @foreach($accessoriesProducts as $product)
                        <div class="w-full">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(isset($sparepartProducts) && $sparepartProducts->count() > 0)
            <div class="mb-6">
                <div class="flex justify-between items-end mb-3">
                    <div class="min-w-0 flex-1 border-l-4 border-emerald-500 pl-2">
                        <h3 class="text-sm sm:text-base font-bold text-gray-800 font-montserrat tracking-tight mb-0 flex items-center gap-2 truncate">
                            Komponen & Sparepart
                        </h3>
                    </div>
                </div>
                <div class="grid grid-cols-[repeat(auto-fit,minmax(160px,1fr))] sm:grid-cols-[repeat(auto-fit,minmax(190px,1fr))] gap-3 sm:gap-4">
                    @foreach($sparepartProducts as $product)
                        <div class="w-full">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Cara Order Section -->
        @if(!request()->has('search'))
        <div class="bg-white py-3 lg:py-4 border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-3 min-w-0">
                    <div class="text-left min-w-0 flex-1">
                        <h2 class="text-base sm:text-lg font-black text-gray-900 font-montserrat tracking-tight mb-0 sm:mb-0.5 truncate">
                            Alur Pemesanan
                        </h2>
                        <p class="text-gray-500 text-[11px] sm:text-xs truncate mt-0.5">Sistem kami terintegrasi dengan email</p>
                    </div>
                    <!-- Geser Indicator (Mobile Only) -->
                    <div class="flex sm:hidden items-center gap-1 text-gray-400 text-[10px] font-bold shrink-0 ml-2 bg-gray-50 px-2 py-1 rounded-full animate-pulse">
                        <i class='bx bx-chevron-left'></i>
                        <span>Geser</span>
                        <i class='bx bx-chevron-right'></i>
                    </div>
                </div>

                <div class="flex overflow-x-auto sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 relative pb-4 pt-1 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] -mx-4 px-4 sm:mx-0 sm:px-0">
                    <!-- Garis Penghubung (Hanya Desktop) -->
                    <div class="hidden lg:block absolute top-10 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-gray-100 via-brand-200 to-gray-100 z-0"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-row items-start text-left group w-[85vw] sm:w-auto snap-center shrink-0 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm gap-3 sm:gap-4 transition-all hover:shadow-md hover:border-brand-100 h-full">
                        <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center shrink-0 relative group-hover:scale-105 transition-transform duration-300">
                            <i class='bx bx-cart-add text-2xl text-brand-500'></i>
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-brand-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-sm border border-white">1</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900 mb-1 text-[13px] sm:text-[14px]">Pilih &amp; Checkout</h3>
                            <p class="text-[11px] sm:text-xs text-gray-500 leading-snug whitespace-normal break-words">Pilih produk di katalog kami, masukkan ke keranjang, dan selesaikan form checkout.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-row items-start text-left group w-[85vw] sm:w-auto snap-center shrink-0 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm gap-3 sm:gap-4 transition-all hover:shadow-md hover:border-brand-100 h-full">
                        <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center shrink-0 relative group-hover:scale-105 transition-transform duration-300">
                            <i class='bx bx-envelope-open text-2xl text-brand-500'></i>
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-brand-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-sm border border-white">2</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900 mb-1 text-[13px] sm:text-[14px]">Proforma Invoice</h3>
                            <p class="text-[11px] sm:text-xs text-gray-500 leading-snug whitespace-normal break-words">Sistem otomatis mengirim tagihan awal beserta detail pesanan ke email Anda.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 flex flex-row items-start text-left group w-[85vw] sm:w-auto snap-center shrink-0 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm gap-3 sm:gap-4 transition-all hover:shadow-md hover:border-brand-100 h-full">
                        <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center shrink-0 relative group-hover:scale-105 transition-transform duration-300">
                            <i class='bx bxs-file-pdf text-2xl text-brand-500'></i>
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-brand-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-sm border border-white">3</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900 mb-1 text-[13px] sm:text-[14px]">Bayar &amp; Unduh Invoice</h3>
                            <p class="text-[11px] sm:text-xs text-gray-500 leading-snug whitespace-normal break-words">Setelah dibayar, Anda mendapat email lunas dan file <b>PDF Invoice</b> resmi.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative z-10 flex flex-row items-start text-left group w-[85vw] sm:w-auto snap-center shrink-0 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm gap-3 sm:gap-4 transition-all hover:shadow-md hover:border-brand-100 h-full">
                        <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center shrink-0 relative group-hover:scale-105 transition-transform duration-300">
                            <i class='bx bx-target-lock text-2xl text-brand-500'></i>
                            <div class="absolute -top-1 -right-1 w-5 h-5 bg-brand-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-sm border border-white">4</div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900 mb-1 text-[13px] sm:text-[14px]">Tracking Pesanan</h3>
                            <p class="text-[11px] sm:text-xs text-gray-500 leading-snug whitespace-normal break-words">Lacak status pesanan Anda dengan mudah menggunakan <b>Nomor Unik</b> dari email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Google Reviews Section -->
        @if(isset($googleReviews) && $googleReviews->count() > 0 && !request()->has('search'))
        <div id="google-reviews" class="bg-[#F8FAFC] py-3 lg:py-4 border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2 md:mb-3 gap-3 px-2 sm:px-3">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-base sm:text-lg font-black text-gray-900 font-montserrat tracking-tight mb-0 sm:mb-0.5 truncate">
                            Ulasan Pelanggan
                        </h2>
                        <p class="text-gray-500 text-[11px] sm:text-xs truncate mt-0.5">Ulasan asli langsung dari Google Maps bisnis LKTech</p>
                    </div>
                    
                    <div class="flex items-center bg-white p-3 rounded-2xl shadow-sm border border-gray-100 shrink-0">
                        <div class="flex flex-col mr-4">
                            <div class="flex items-center gap-1 text-yellow-400 text-lg">
                                <i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i><i class='bx bxs-star'></i>
                            </div>
                            <p class="text-xs font-bold text-gray-800 mt-1">4.9 / 5.0 Rata-rata</p>
                            <p class="text-[10px] text-gray-500">{{ $googleReviews->count() }}+ Ulasan Terverifikasi</p>
                        </div>
                        <a href="https://g.page/r/CaM75CZX1cbpEAI/review" target="_blank" class="btn btn-primary text-xs sm:text-sm bg-[#1E56A0] hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-xl shadow-sm flex items-center gap-2 transition-colors">
                            Tulis Ulasan <i class='bx bx-link-external'></i>
                        </a>
                    </div>
                </div>

                <!-- Carousel -->
                <div class="relative w-full group px-0 sm:px-2" 
                     x-data="{ 
                        activeSlide: 0, 
                        isHovered: false,
                        slides: {{ count($googleReviews) }},
                        itemsPerSlide: window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1),
                        get totalPages() { return Math.ceil(this.slides / this.itemsPerSlide); },
                        next() { this.activeSlide = this.activeSlide === this.totalPages - 1 ? 0 : this.activeSlide + 1; },
                        prev() { this.activeSlide = this.activeSlide === 0 ? this.totalPages - 1 : this.activeSlide - 1; },
                        init() {
                            window.addEventListener('resize', () => {
                                this.itemsPerSlide = window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1);
                                this.activeSlide = 0;
                            });
                            if(this.totalPages > 1) {
                                setInterval(() => {
                                    if(!this.isHovered) {
                                        this.next();
                                    }
                                }, 6000);
                            }
                        }
                     }"
                     @mouseenter="isHovered = true"
                     @mouseleave="isHovered = false">
                     
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-1000 ease-in-out" 
                             :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
                            
                            @foreach($googleReviews as $review)
                                <div class="w-full sm:w-1/2 lg:w-1/4 shrink-0 px-2 sm:px-2.5">
                                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 h-full flex flex-col hover:shadow-md transition-shadow">
                                        <!-- Header Card -->
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold overflow-hidden shrink-0 text-[11px]">
                                                    @if($review->reviewer_photo_url)
                                                        <img src="{{ $review->reviewer_photo_url }}" alt="{{ $review->reviewer_name }}" class="w-full h-full object-cover">
                                                    @else
                                                        {{ substr($review->reviewer_name, 0, 1) }}
                                                    @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-800 text-[13px] leading-tight">{{ $review->reviewer_name }}</h4>
                                                    <p class="text-[9px] text-gray-500 mt-0.5">
                                                        {{ $review->review_time_text ?? ($review->review_created_at ? $review->review_created_at->diffForHumans() : '') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="w-5 h-5 rounded-full bg-white shadow-sm border border-gray-100 flex items-center justify-center shrink-0">
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                                                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.15C3.26 21.3 7.31 24 12 24z"/>
                                                    <path fill="#FBBC05" d="M5.28 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.29c-.8 1.6-1.29 3.41-1.29 5.39s.49 3.79 1.29 5.39l3.99-3.15z"/>
                                                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.61l3.99 3.15c.95-2.85 3.6-4.96 6.72-4.96z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Rating -->
                                        <div class="flex text-yellow-400 text-xs mb-1.5">
                                            @for($i=1; $i<=5; $i++)
                                                @if($i <= $review->star_rating)
                                                    <i class='bx bxs-star'></i>
                                                @else
                                                    <i class='bx bx-star text-gray-300'></i>
                                                @endif
                                            @endfor
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="text-[12px] sm:text-[13px] text-gray-600 italic leading-relaxed line-clamp-3 flex-grow">
                                            "{{ $review->review_comment }}"
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>

                    <!-- Navigation Controls -->
                    <template x-if="totalPages >= 1">
                        <div>
                            <button @click="prev()" class="absolute top-1/2 -translate-y-1/2 -left-2 sm:-left-3 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white shadow-md border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-brand-600 flex items-center justify-center transition-all z-10 opacity-100 sm:flex">
                                <i class='bx bx-chevron-left text-xl sm:text-2xl'></i>
                            </button>
                            <button @click="next()" class="absolute top-1/2 -translate-y-1/2 -right-2 sm:-right-3 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white shadow-md border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-brand-600 flex items-center justify-center transition-all z-10 opacity-100 sm:flex">
                                <i class='bx bx-chevron-right text-xl sm:text-2xl'></i>
                            </button>
                        </div>
                    </template>
                </div>
                
            </div>
        </div>
        @endif

        <!-- Blog & Panduan Section -->
        @if(isset($latestPosts) && $latestPosts->count() > 0 && !request()->has('search'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 lg:py-4">
            <div class="flex items-center justify-between mb-3">
                <div class="min-w-0 flex-1">
                    <h2 class="text-base sm:text-lg font-black text-gray-900 font-montserrat tracking-tight mb-0 sm:mb-0.5 truncate">Artikel &amp; Panduan</h2>
                    <p class="text-gray-500 text-[11px] sm:text-xs truncate mt-0.5">Tips, trik, dan edukasi seputar dunia IT untuk Anda.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="flex items-center gap-1 text-brand-600 font-medium hover:text-brand-700 transition-colors text-xs sm:text-sm sm:font-bold whitespace-nowrap ml-3">
                    Lihat Semua <i class='bx bx-right-arrow-alt text-base sm:text-xl'></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($latestPosts->take(4) as $post)
                <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex items-center p-2 group">
                    <!-- Thumbnail (Kiri) -->
                    <a href="{{ route('blog.show', $post->slug) }}" class="block w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-lg overflow-hidden shrink-0 relative">
                        @if($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center text-gray-400 bg-gray-200">
                                <i class='bx bx-image text-2xl'></i>
                            </div>
                        @endif
                    </a>
                    <!-- Content (Kanan) -->
                    <div class="w-full pl-3 pr-1 flex flex-col justify-center">
                        <div class="text-[10px] text-brand-600 font-bold mb-1 flex items-center gap-1">
                            <i class='bx bx-calendar'></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                        </div>
                        <h3 class="line-clamp-2 text-xs font-bold text-gray-900 leading-snug group-hover:text-brand-600 transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
        @endif

    </main>

    <!-- Modal Form Hubungi Kami -->
    <x-contact-modal />

    <!-- Footer -->
    <x-footer />

    <!-- Login Modal (Pop-up Mode) -->
    <div x-show="loginModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 sm:p-0" x-cloak>
        <!-- Modal Backdrop -->
        <div class="fixed inset-0" @click="loginModalOpen = false"></div>
        
        <!-- Modal Content -->
        <div x-show="loginModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 overflow-hidden z-10 border border-brand-100">
             
            <!-- Decorative Blue/Cyan header bar -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-500 to-cyan-500"></div>
            
            <div class="absolute top-4 right-4">
                <button @click="loginModalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none p-1 rounded-full hover:bg-gray-100 transition">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <div class="text-center mb-8 mt-2">
                <img src="{{ asset('images/LKtech.png') }}" alt="LKTech" class="h-10 mx-auto mb-4">
                <h3 class="text-2xl font-black text-gray-800">Masuk ke Sistem</h3>
                <p class="text-sm text-gray-500 mt-1">Silakan masukkan kredensial Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-envelope text-gray-400 text-lg'></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('email') border-red-500 @enderror" placeholder="admin@lktech.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-lock-alt text-gray-400 text-lg'></i>
                        </div>
                        <input id="password" type="password" name="password" required
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('password') border-red-500 @enderror" placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-2">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-600 shadow-sm focus:border-brand-300 focus:ring focus:ring-brand-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-xs font-medium text-gray-600">Ingat Saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-brand-600 hover:text-brand-800" href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Global Toast using Alpine -->
    <div x-data="{ showToast: false, toastMessage: '' }" 
         x-init="@if(session('success')) setTimeout(() => { $dispatch('show-toast', { message: '{{ session('success') }}' }) }, 500); @endif"
         @show-toast.window="toastMessage = $event.detail.message; showToast = true; setTimeout(() => showToast = false, 3000)"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[110]" x-cloak>
        <div x-show="showToast"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="bg-gray-800 text-white px-4 py-2.5 rounded-full shadow-xl border border-gray-700 text-xs font-semibold flex items-center gap-2">
            <i class='bx bx-check-circle text-emerald-400 text-base'></i>
            <span x-text="toastMessage"></span>
        </div>
    </div>
    
    <script>
        function shareProduct(url) {
            if (navigator.share) {
                navigator.share({
                    title: 'Cek produk ini di LKTech!',
                    url: url
                }).catch(err => {
                    if (err.name !== 'AbortError') console.error(err);
                });
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Tautan produk berhasil disalin' } }));
                }).catch(console.error);
            }
        }
    </script>
    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />

    <!-- Floating Video Widget -->
    @php
        $activeVideo = \App\Models\PromoVideo::where('is_active', true)->latest()->first();
    @endphp

    @if($activeVideo)
    <div id="floatingVideoWidget" 
         class="fixed z-[9999] bg-black rounded-xl shadow-2xl overflow-hidden border-2 border-blue-600 pointer-events-none
                top-[65%] -translate-y-1/2 left-3 w-[140px] h-[180px] 
                sm:left-6 sm:w-[180px] sm:h-[190px] transition-all duration-300">
        
        <!-- Area Drag (Geser) -->
        <div id="dragHandle" class="absolute top-0 left-0 w-full h-10 z-20 cursor-move pointer-events-auto bg-gradient-to-b from-black/50 to-transparent" title="Geser Video">
            <div class="absolute top-0.5 left-1/2 -translate-x-1/2 w-8 h-1 bg-white/50 rounded-full"></div>
        </div>

        <div class="absolute top-2 left-1.5 right-1.5 flex justify-between items-center z-30 pointer-events-none gap-1">
            
            @if($activeVideo->target_url)
                <a href="{{ $activeVideo->target_url }}" 
                   target="_blank" 
                   title="{{ $activeVideo->title }}"
                   class="pointer-events-auto bg-red-600 hover:bg-red-700 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wide shadow flex items-center gap-1 max-w-[70%] transition">
                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="truncate">{{ $activeVideo->title }}</span>
                    <span class="text-[8px] sm:text-[9px] shrink-0">➔</span>
                </a>
            @else
                <div class="bg-red-600/90 text-white text-[8px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wide shadow flex items-center gap-1 max-w-[70%]">
                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="truncate">{{ $activeVideo->title }}</span>
                </div>
            @endif

            <button onclick="closeVideoWidget()" 
                    class="pointer-events-auto bg-black/60 hover:bg-red-600 text-white rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center text-[10px] sm:text-xs transition-colors shrink-0">
                ✕
            </button>
        </div>



        <video id="promoVideo" 
               class="w-full h-full object-cover bg-black pointer-events-auto" 
               controls 
               preload="metadata" 
               playsinline>
            <source src="{{ asset('storage/' . $activeVideo->video_path) }}" type="video/mp4">
        </video>
    </div>

    <script>
    // Fungsi Tutup Widget
    function closeVideoWidget() {
        const widget = document.getElementById('floatingVideoWidget');
        const promoVideo = document.getElementById('promoVideo');
        if (widget) {
            if (promoVideo) promoVideo.pause();
            widget.style.display = 'none';
            sessionStorage.setItem('promo_closed', 'true');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        if (sessionStorage.getItem('promo_closed') === 'true') {
            const widget = document.getElementById('floatingVideoWidget');
            if (widget) widget.style.display = 'none';
        }

        // Logika Drag Widget
        const widget = document.getElementById('floatingVideoWidget');
        const dragHandle = document.getElementById('dragHandle');

        if (widget && dragHandle) {
            let isDragging = false;
            let startX, startY, initialLeft, initialTop;

            const onDragStart = (e) => {
                if (e.target.closest('a') || e.target.closest('button')) return;
                isDragging = true;
                
                const rect = widget.getBoundingClientRect();
                
                // Hapus class tailwind yang bisa konflik dengan inline style
                widget.classList.remove('top-[65%]', '-translate-y-1/2', 'left-3', 'sm:left-6', 'transition-all');
                
                widget.style.left = rect.left + 'px';
                widget.style.top = rect.top + 'px';

                const clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                const clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;

                startX = clientX;
                startY = clientY;
                initialLeft = parseInt(widget.style.left || 0, 10);
                initialTop = parseInt(widget.style.top || 0, 10);

                document.addEventListener('mousemove', onDragMove);
                document.addEventListener('mouseup', onDragEnd);
                document.addEventListener('touchmove', onDragMove, { passive: false });
                document.addEventListener('touchend', onDragEnd);
            };

            const onDragMove = (e) => {
                if (!isDragging) return;
                e.preventDefault();

                const clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                const clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;

                const dx = clientX - startX;
                const dy = clientY - startY;

                let newLeft = initialLeft + dx;
                let newTop = initialTop + dy;

                const maxX = window.innerWidth - widget.offsetWidth;
                const maxY = window.innerHeight - widget.offsetHeight;

                if (newLeft < 0) newLeft = 0;
                if (newLeft > maxX) newLeft = maxX;
                if (newTop < 0) newTop = 0;
                if (newTop > maxY) newTop = maxY;

                widget.style.left = newLeft + 'px';
                widget.style.top = newTop + 'px';
            };

            const onDragEnd = () => {
                isDragging = false;
                document.removeEventListener('mousemove', onDragMove);
                document.removeEventListener('mouseup', onDragEnd);
                document.removeEventListener('touchmove', onDragMove);
                document.removeEventListener('touchend', onDragEnd);
            };

            dragHandle.addEventListener('mousedown', onDragStart);
            dragHandle.addEventListener('touchstart', onDragStart, { passive: false });
        }
    });
    </script>
    @endif
</body>
</html>
