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

    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen" x-data="{ loginModalOpen: {{ $errors->any() || session('showLoginPopup') ? 'true' : 'false' }} }" :class="loginModalOpen ? 'overflow-hidden' : ''">

    <!-- Top Navbar (Tokopedia Style) -->

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full max-md:pb-24">
        
        <!-- Hero Section -->
        <!-- Hero Section -->
        @if(!request()->has('search'))
        <div class="bg-gradient-to-br from-white via-brand-50 to-cyan-50 text-gray-900 border-b border-gray-200 relative overflow-hidden">
            <!-- Subtle abstract shapes -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-cyan-200 opacity-40 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-brand-200 opacity-40 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 relative z-10 w-full">
                <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-6 lg:gap-8">
                    
                    <!-- Left: Text (60%) -->
                    <div class="md:col-span-7 space-y-4">
                        <h1 class="text-3xl lg:text-4xl font-montserrat font-black leading-tight tracking-tight text-blue-900 drop-shadow-sm">
                            Solusi IT Terlengkap & Tepercaya untuk Anda
                        </h1>
                        <div class="space-y-2">
                            <p class="text-gray-600 text-base md:text-lg font-medium">
                                Dari pengadaan laptop premium, rakit PC custom, servis bergaransi, hingga pembuatan website profesional. LKtech siap mendukung produktivitas harian dan pertumbuhan bisnis Anda.
                            </p>
                            <!-- Informasi Layanan Tambahan -->
                            <div class="inline-flex items-center bg-white/60 backdrop-blur-sm border border-brand-100 rounded-lg px-3 py-2 mt-2 shadow-sm">
                                <p class="text-sm md:text-base text-gray-800 font-bold whitespace-normal sm:whitespace-nowrap">
                                    ✅ Laptop Premium | Servis & Sewa | Rakit PC | Jasa Website
                                </p>
                            </div>
                        </div>
                        <div class="pt-2 flex flex-row w-full gap-2 sm:gap-4">
                            <a href="{{ route('katalog.index') }}" class="flex-1 justify-center text-center px-2 sm:px-4 py-2 sm:py-3 bg-brand-600 border border-brand-600 text-white font-extrabold rounded-lg shadow-md hover:bg-brand-700 transition text-sm sm:text-base flex items-center gap-1 sm:gap-2">
                                Lihat Katalog
                            </a>
                            <button type="button" x-data @click="$dispatch('open-contact-modal')" class="flex-1 justify-center text-center px-2 sm:px-4 py-2 sm:py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg shadow-sm hover:bg-gray-50 transition flex items-center gap-1 sm:gap-2 text-sm sm:text-base">
                                <i class='bx bx-envelope text-lg text-gray-500 hidden sm:inline-block'></i> Hubungi Kami
                            </button>
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
                            <div class="relative w-4/5 max-w-sm mx-auto group"
                                 x-data="{ 
                                    activeSlide: 0, 
                                    slides: {{ count($promoBanners) }},
                                    init() {
                                        if(this.slides > 1) {
                                            setInterval(() => {
                                                this.activeSlide = this.activeSlide === this.slides - 1 ? 0 : this.activeSlide + 1
                                            }, 4000);
                                        }
                                    }
                                 }">
                                 
                                <div class="relative overflow-hidden rounded-3xl shadow-2xl transform hover:scale-105 transition duration-500 aspect-[4/3] bg-white">
                                    @foreach($promoBanners as $index => $banner)
                                        <div x-show="activeSlide === {{ $index }}" 
                                             x-transition:enter="transition ease-in-out duration-500"
                                             x-transition:enter-start="opacity-0 translate-x-8"
                                             x-transition:enter-end="opacity-100 translate-x-0"
                                             x-transition:leave="transition ease-in-out duration-500 absolute inset-0"
                                             x-transition:leave-start="opacity-100 translate-x-0"
                                             x-transition:leave-end="opacity-0 -translate-x-8"
                                             class="absolute inset-0 w-full h-full flex items-center justify-center">
                                            @if(!empty($banner['link']))
                                                <a href="{{ $banner['link'] }}" class="block w-full h-full">
                                                    <img src="{{ asset('storage/' . $banner['image']) }}" alt="Promo Banner {{ $index + 1 }}" class="w-full h-full object-contain">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $banner['image']) }}" alt="Promo Banner {{ $index + 1 }}" class="w-full h-full object-contain">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if(count($promoBanners) > 1)
                                    <!-- Dots Indicators -->
                                    <div class="absolute -bottom-6 left-0 right-0 flex justify-center gap-2">
                                        @foreach($promoBanners as $index => $banner)
                                            <button @click="activeSlide = {{ $index }}" 
                                                    class="w-2 h-2 rounded-full transition-all duration-300"
                                                    :class="activeSlide === {{ $index }} ? 'bg-brand-600 w-4' : 'bg-brand-300 hover:bg-brand-400'"></button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Placeholder jika belum ada promo -->
                            <div class="aspect-[4/3] w-4/5 max-w-sm mx-auto rounded-3xl overflow-hidden shadow-2xl border border-gray-200 bg-white transform rotate-2 hover:rotate-0 transition duration-500 hover:scale-105">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <x-info-cards />
        </div>
        @endif

        <!-- Product Grid Section -->
        <div id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8 flex-shrink-0">
            
            <div class="mb-4 flex flex-wrap justify-between items-end gap-4">
                <div>
                    @if(request()->has('search') && request()->search != '')
                        <h2 class="text-xl font-bold text-gray-800">Hasil Pencarian: "{{ request()->search }}"</h2>
                        <p class="text-gray-500 text-xs mt-1">Menampilkan {{ $products->total() }} produk yang sesuai.</p>
                    @else
                        <h2 class="text-xl font-bold text-gray-800">Rekomendasi Pilihan</h2>
                        <p class="text-gray-500 text-xs mt-1">Daftar stok produk premium terbaru pilihan kami yang siap dipinang.</p>
                    @endif
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <form action="{{ route('home') }}" method="GET" class="relative">
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <select name="sort" onchange="this.form.submit()" class="appearance-none bg-white border border-gray-200 text-gray-700 py-1.5 pl-3 pr-8 rounded-lg text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm">
                            <option value="terbaru" {{ request('sort') == 'terbaru' || !request()->has('sort') ? 'selected' : '' }}>Urutkan: Paling Sesuai</option>
                            <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Urutkan: Harga Tertinggi</option>
                            <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Urutkan: Harga Terendah</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <i class='bx bx-chevron-down text-sm'></i>
                        </div>
                    </form>

                    @if(request()->has('search'))
                        <a href="{{ route('home') }}" class="text-brand-600 text-xs font-semibold hover:underline">Lihat Semua</a>
                    @else
                        <a href="{{ route('katalog.index') }}" class="text-brand-600 text-xs font-bold hover:text-brand-700 bg-brand-50 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">Lihat Semua Katalog <i class='bx bx-right-arrow-alt'></i></a>
                    @endif
                </div>
            </div>

            <!-- Precision Grid (Compact Design) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
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
        <!-- Blog & Panduan Section -->
        @if(isset($latestPosts) && $latestPosts->count() > 0 && !request()->has('search'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 font-montserrat tracking-tight mb-2">Artikel & Panduan</h2>
                    <p class="text-gray-500">Tips, trik, dan edukasi seputar dunia IT untuk Anda.</p>
                </div>
                <a href="{{ route('blog.index') }}" class="hidden sm:flex items-center gap-1 text-brand-600 font-bold hover:text-brand-700 transition-colors">
                    Lihat Semua <i class='bx bx-right-arrow-alt text-xl'></i>
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
            <div class="mt-6 text-center sm:hidden">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-brand-600 font-bold hover:text-brand-700 bg-brand-50 px-6 py-2.5 rounded-xl">
                    Lihat Semua Artikel <i class='bx bx-right-arrow-alt'></i>
                </a>
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

</body>
</html>
