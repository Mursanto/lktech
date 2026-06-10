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

    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full max-md:pb-24">
        
        <x-inner-page-header title="Katalog Produk & Layanan" subtitle="Jelajahi berbagai perangkat keras premium, paket perakitan, dan solusi IT terbaik dari LKtech." />

        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pb-8 flex flex-col md:flex-row gap-8">
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
            @if(isset($selectedCategoryId))
            <div class="mb-6 flex justify-end">
                <a href="{{ route('katalog.index') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 bg-brand-50 px-4 py-2 rounded-lg">
                    Lihat Semua Kategori
                </a>
            </div>
            @endif

            <!-- Info Cards Section (Hidden on Mobile) -->
            <div class="hidden md:block mb-10">
                <x-info-cards />
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
                        @elseif(method_exists($category->all_products, 'links'))
                            <div class="mt-8">
                                {{ $category->all_products->links() }}
                            </div>
                        @endif
                    </section>
                    @endif
                @endforeach
            </div>
        </div>

        </div> <!-- End of flex container -->
    </main>

    <!-- Modal Form Hubungi Kami -->
    <x-contact-modal />

    <!-- Footer -->
    <x-footer />
    
    <!-- Mobile Bottom Navigation -->
    <x-mobile-bottom-nav />
    
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
