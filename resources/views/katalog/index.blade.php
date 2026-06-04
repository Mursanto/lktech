<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semua Katalog - LKTech TN SEREAL</title>
    
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

        /* Hide scrollbar for horizontal scrolling */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Top Navbar (Tokopedia Style) -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 gap-4">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 w-auto">
                        <span class="font-montserrat font-black text-xl tracking-tight text-blue-900 hidden sm:block">LKTech</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl px-4 lg:px-12">
                    <form action="{{ route('home') }}" method="GET" class="relative flex items-center w-full">
                        <input type="text" name="search" placeholder="Cari laptop, merk, atau prosesor..." 
                               class="w-full pl-4 pr-10 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all shadow-sm">
                        <button type="submit" class="absolute right-0 top-0 h-full px-3 flex items-center justify-center text-gray-400 hover:text-brand-600 bg-gray-50 rounded-r-lg border-l border-gray-300">
                            <i class='bx bx-search text-lg'></i>
                        </button>
                    </form>
                </div>

                <!-- Auth Navigation -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600 hidden sm:block">Dashboard</a>
                        <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 px-3 py-1.5 bg-brand-50 text-brand-700 rounded-lg font-bold text-sm hover:bg-brand-100 transition shadow-sm border border-brand-200">
                            <i class='bx bx-user-circle text-lg'></i> Profil
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-1.5 bg-white text-brand-600 border border-brand-600 rounded-lg font-bold text-sm hover:bg-brand-50 transition shadow-sm">
                            Masuk
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col md:flex-row gap-8">
        
        <!-- Sidebar Navigation (Categories) -->
        <aside class="w-full md:w-64 flex-shrink-0 hidden md:block">
            <div class="sticky top-20 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-gray-800 text-lg border-b border-gray-100 pb-2 mb-3">Kategori Produk</h3>
                <ul class="space-y-1">
                    @foreach($mainCategories as $category)
                        @if($category->total_count > 0)
                        <li>
                            <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="flex justify-between items-center px-3 py-2 text-sm {{ (isset($selectedCategoryId) && $selectedCategoryId == $category->id) ? 'text-brand-600 bg-brand-50 font-bold' : 'text-gray-600 hover:text-brand-600 hover:bg-brand-50' }} rounded-lg transition-colors group">
                                <span class="truncate">{{ $category->name }}</span>
                                <span class="bg-gray-100 text-gray-500 group-hover:bg-brand-100 group-hover:text-brand-600 px-2 py-0.5 rounded-full text-[10px] font-bold">
                                    {{ $category->total_count }}
                                </span>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Product Sections -->
        <div class="flex-1 min-w-0">
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-black text-gray-900 font-montserrat">
                        {{ isset($selectedCategoryId) ? 'Kategori: ' . $displayCategories->first()->name : 'Katalog Produk' }}
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Jelajahi berbagai kategori produk pilihan yang siap memenuhi kebutuhan Anda.</p>
                </div>
                @if(isset($selectedCategoryId))
                    <a href="{{ route('katalog.index') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 bg-brand-50 px-4 py-2 rounded-lg">
                        Lihat Semua Kategori
                    </a>
                @endif
            </div>

            <!-- 4 Info Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                <!-- Kartu 1: Penjualan -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                        <i class='bx bx-laptop text-2xl'></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Penjualan Laptop Second Berkualitas</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Temukan laptop second berkualitas premium dengan harga bersahabat. Setiap unit telah melewati Quality Control yang ketat dan dilengkapi garansi after-sales terpercaya demi kenyamanan Anda.</p>
                </div>
                
                <!-- Kartu 2: Servis & Maintenance -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4">
                        <i class='bx bx-wrench text-2xl'></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Servis & Maintenance Profesional</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Solusi perbaikan dan perawatan berkala untuk laptop maupun komputer instansi Anda. Dikerjakan langsung oleh teknisi ahli secara cepat, tepat, dan bergaransi penuh.</p>
                </div>
                
                <!-- Kartu 3: Sewa Perangkat IT -->
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                        <i class='bx bx-calendar text-2xl'></i>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Sewa Laptop & Komputer</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Dukung kelancaran operasional acara dan bisnis Anda dengan layanan sewa perangkat IT harian, bulanan, hingga tahunan. Spesifikasi tangguh dengan penawaran harga yang sangat kompetitif.</p>
                </div>

                <!-- Kartu 4: Kemitraan (Clickable) -->
                <button x-data @click="$dispatch('open-contact-modal')" type="button" class="text-left w-full bg-brand-50 border border-brand-100 rounded-2xl p-5 shadow-sm hover:bg-brand-100 hover:shadow-md transition-all group">
                    <div class="w-12 h-12 bg-white text-brand-600 rounded-xl flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition-transform">
                        <i class='bx bx-support text-2xl'></i>
                    </div>
                    <h3 class="font-bold text-brand-900 text-base mb-2 group-hover:text-brand-700 transition-colors">Kemitraan & Pembelian Partai Besar</h3>
                    <p class="text-sm text-brand-700 leading-relaxed mb-4">Butuh pengadaan unit dalam jumlah banyak atau kontrak maintenance untuk instansi? Klik di sini untuk penawaran khusus!</p>
                    <div class="flex items-center text-sm font-bold text-brand-600 gap-1 group-hover:gap-2 transition-all mt-auto">
                        Hubungi Kami <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </button>
            </div>

            <div class="space-y-12">
                @foreach($displayCategories as $category)
                    @if($category->all_products->count() > 0)
                    <section id="kategori-{{ $category->id }}" class="scroll-mt-20">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b-2 border-gray-100">
                            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="hover:text-brand-600 transition-colors">
                                    <i class='bx bx-category text-brand-500'></i> {{ $category->name }}
                                </a>
                            </h2>
                            <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-1 rounded-md">{{ $category->total_count }} Produk</span>
                        </div>

                        <!-- CSS Grid for 5 items -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            @foreach($category->all_products as $product)
                                <div class="w-full">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                        
                        @if(!isset($selectedCategoryId) && !request()->has('search') && $category->total_count > 5)
                            <div class="mt-4 text-right">
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="text-sm font-bold text-brand-600 hover:text-brand-700">
                                    Lihat Semua {{ $category->name }} ({{ $category->total_count }}) &rarr;
                                </a>
                            </div>
                        @endif
                    </section>
                    @endif
                @endforeach
            </div>
        </div>

    </main>

    <!-- Modal Form Hubungi Kami -->
    <div x-data="{ showContactModal: false }" 
         @open-contact-modal.window="showContactModal = true"
         x-show="showContactModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4" x-cloak>
        <div x-show="showContactModal"
             @click.outside="showContactModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-full">
             
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 flex-shrink-0">
                <h3 class="font-black text-lg text-gray-800 font-montserrat">Hubungi Kami</h3>
                <button @click="showContactModal = false" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('katalog.contact') }}" method="POST" class="p-6 space-y-4 overflow-y-auto">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow" placeholder="Masukkan nama Anda">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Harap masukkan format email yang valid dengan domain yang benar" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow" placeholder="contoh@email.com">
                    <p class="text-[10px] text-gray-500 mt-1">* Pastikan email valid (misal: @gmail.com) agar kami dapat membalas pesan Anda.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Pesan & Kebutuhan <span class="text-red-500">*</span></label>
                    <textarea name="message" required rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow resize-none" placeholder="Ceritakan kebutuhan pengadaan, servis, atau pertanyaan Anda di sini..."></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-brand-600 text-white font-bold py-3 rounded-lg hover:bg-brand-700 transition-colors shadow-sm flex justify-center items-center gap-2">
                        <i class='bx bx-send'></i> Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center md:text-right">
                <div class="text-sm text-gray-500 font-medium">
                    &copy; {{ date('Y') }} LKTech TN SEREAL. All rights reserved.<br>
                    Villa Mutiara 1 Sektor 2 BLOK i-18 No.03, Bogor 16168
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Mobile Bottom Navigation & Bottom Sheet -->
    <div x-data="{ 
            lastScrollTop: window.pageYOffset,
            isVisible: true,
            isSheetOpen: false,
            onScroll() {
                let st = window.pageYOffset || document.documentElement.scrollTop;
                if (st > this.lastScrollTop && st > 50) {
                    this.isVisible = false; // scroll down
                } else {
                    this.isVisible = true; // scroll up
                }
                this.lastScrollTop = st <= 0 ? 0 : st;
            }
         }"
         @scroll.window="onScroll"
         class="md:hidden"
    >
        <!-- Bottom Nav Bar -->
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 transition-transform duration-300 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]"
             :class="isVisible ? 'translate-y-0' : 'translate-y-full'">
            <div class="flex justify-around items-center h-16">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 text-gray-500 hover:text-brand-600 transition-colors w-1/3">
                    <i class='bx bx-home-alt text-2xl'></i>
                    <span class="text-[10px] font-bold">Beranda</span>
                </a>
                <button @click="isSheetOpen = true" class="flex flex-col items-center gap-1 text-brand-600 hover:text-brand-700 transition-colors w-1/3">
                    <i class='bx bx-category text-2xl'></i>
                    <span class="text-[10px] font-bold">Kategori</span>
                </button>
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="flex flex-col items-center gap-1 text-gray-500 hover:text-brand-600 transition-colors w-1/3">
                    <i class='bx bx-up-arrow-alt text-2xl'></i>
                    <span class="text-[10px] font-bold">Ke Atas</span>
                </button>
            </div>
        </div>

        <!-- Bottom Sheet Overlay & Modal -->
        <div x-show="isSheetOpen" class="fixed inset-0 z-50 flex items-end bg-gray-900/40 backdrop-blur-sm" x-cloak>
            <div x-show="isSheetOpen" 
                 @click.outside="isSheetOpen = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="w-full bg-white rounded-t-3xl shadow-2xl max-h-[85vh] flex flex-col overflow-hidden relative">
                
                <!-- Drag Handle Indicator -->
                <div class="w-full flex justify-center pt-3 pb-1" @click="isSheetOpen = false">
                    <div class="w-12 h-1.5 bg-gray-300 rounded-full"></div>
                </div>

                <!-- Header -->
                <div class="px-6 py-3 flex justify-between items-center border-b border-gray-100">
                    <h3 class="font-black text-lg font-montserrat text-gray-800">Pilih Kategori</h3>
                    <button @click="isSheetOpen = false" class="text-gray-400 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-full p-1 transition-colors">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
                
                <!-- Body / Category List -->
                <div class="p-4 overflow-y-auto pb-8">
                    <div class="space-y-3">
                        @foreach($mainCategories as $category)
                            @if($category->total_count > 0)
                            <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-2xl hover:border-brand-500 hover:bg-brand-50 transition-all active:scale-[0.98]">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-brand-600 shadow-sm">
                                        <i class='bx bx-laptop text-xl'></i>
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $category->name }}</span>
                                </div>
                                <span class="bg-white border border-gray-200 text-gray-600 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                    {{ $category->total_count }} Produk
                                </span>
                            </a>
                            @endif
                        @endforeach
                    </div>
                    
                    <a href="{{ route('katalog.index') }}" class="mt-4 block w-full text-center py-3 text-sm font-bold text-brand-600 hover:text-brand-700 bg-brand-50 rounded-xl transition-colors">
                        Lihat Semua Katalog &rarr;
                    </a>
                </div>
            </div>
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
</body>
</html>
