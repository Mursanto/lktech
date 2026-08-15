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
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Bottom sheet animation */
        .bottom-sheet-enter { transform: translateY(100%); }
        .bottom-sheet-enter-active { transition: transform 0.3s ease-out; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Top Navbar -->
    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full">
        
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-3 md:pt-8 pb-6 md:pb-8 flex flex-col md:flex-row gap-8">
        
        {{-- ============================================================ --}}
        {{-- SIDEBAR DESKTOP (Categories + Filter Brand + Harga)          --}}
        {{-- ============================================================ --}}
        <aside class="w-full md:w-64 flex-shrink-0 hidden md:block">
            <div class="sticky top-20 space-y-4">
                
                {{-- Category List --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-base border-b border-gray-100 pb-2 mb-3">Kategori Produk</h3>
                    <ul class="space-y-1">
                        @foreach($mainCategories as $category)
                            @if($category->total_count > 0)
                            <li>
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" 
                                   class="flex justify-between items-center px-3 py-2 text-sm {{ (isset($selectedCategoryId) && $selectedCategoryId == $category->id) ? 'text-brand-600 bg-brand-50 font-bold' : 'text-gray-600 hover:text-brand-600 hover:bg-brand-50' }} rounded-lg transition-colors group">
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

                {{-- Filter: Brand --}}
                @if($availableBrands->count() > 0)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200" x-data="{ expanded: true }">
                    <button @click="expanded = !expanded" class="flex justify-between items-center w-full font-bold text-gray-800 text-sm border-b border-gray-100 pb-2 mb-3">
                        <span>Filter Merek</span>
                        <i class='bx text-gray-400 text-base' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <form method="GET" action="{{ route('katalog.index') }}" x-show="expanded">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request()->has('price_min'))
                            <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                        @endif
                        @if(request()->has('price_max'))
                            <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                        @endif
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            @foreach($availableBrands->take(20) as $brand)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="brands[]" value="{{ $brand }}" 
                                    {{ in_array($brand, $selectedBrands ?? []) ? 'checked' : '' }}
                                    onchange="this.form.submit()"
                                    class="w-4 h-4 text-brand-600 rounded border-gray-300 focus:ring-brand-500 cursor-pointer">
                                <span class="text-sm text-gray-600 group-hover:text-brand-600 transition-colors truncate">{{ $brand }}</span>
                            </label>
                            @endforeach
                        </div>
                        @if(!empty($selectedBrands))
                        <a href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except('brands'), [])) }}" 
                           class="mt-2 inline-block text-xs text-red-500 hover:text-red-600 font-medium">
                            × Hapus filter merek
                        </a>
                        @endif
                    </form>
                </div>
                @endif

                {{-- Filter: Harga --}}
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200" x-data="{ expanded: true }">
                    <button @click="expanded = !expanded" class="flex justify-between items-center w-full font-bold text-gray-800 text-sm border-b border-gray-100 pb-2 mb-3">
                        <span>Rentang Harga</span>
                        <i class='bx text-gray-400 text-base' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <form method="GET" action="{{ route('katalog.index') }}" x-show="expanded">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @foreach($selectedBrands ?? [] as $b)
                            <input type="hidden" name="brands[]" value="{{ $b }}">
                        @endforeach
                        <div class="space-y-2">
                            <div>
                                <label class="text-xs text-gray-500 font-medium mb-1 block">Harga Minimum</label>
                                <input type="number" name="price_min" value="{{ $priceMin }}" placeholder="0"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 font-medium mb-1 block">Harga Maksimum</label>
                                <input type="number" name="price_max" value="{{ $priceMax }}" placeholder="99999999"
                                    class="w-full border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            </div>
                            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold py-2 rounded-lg transition-colors">
                                Terapkan
                            </button>
                            @if($priceMin || $priceMax)
                            <a href="{{ request()->url() . '?' . http_build_query(request()->except(['price_min', 'price_max'])) }}"
                               class="block text-center text-xs text-red-500 hover:text-red-600 font-medium mt-1">
                                × Hapus filter harga
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

            </div>
        </aside>

        {{-- ============================================================ --}}
        {{-- PRODUCT SECTIONS (Main Content)                              --}}
        {{-- ============================================================ --}}
        <div class="flex-1 min-w-0">

            {{-- Mobile Top Bar: Filter + Sort always visible side by side --}}
            <div class="flex items-center gap-2 mb-4 md:hidden" x-data="{ filterOpen: false }" @open-filter-modal.window="filterOpen = true">

                {{-- Filter Button --}}
                <button type="button" @click="filterOpen = true"
                        class="flex items-center gap-1.5 px-3 py-2 border border-gray-200 bg-white rounded-lg text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors cursor-pointer shrink-0">
                    <i class='bx bx-filter-alt text-brand-500'></i>
                    Filter
                    @if(!empty($selectedBrands) || $priceMin || $priceMax)
                        <span class="bg-brand-600 text-white rounded-full text-[9px] font-bold w-4 h-4 flex items-center justify-center">
                            {{ count($selectedBrands ?? []) + ($priceMin || $priceMax ? 1 : 0) }}
                        </span>
                    @endif
                </button>

                {{-- Sort Dropdown: always visible on mobile --}}
                <form method="GET" action="{{ route('katalog.index') }}" class="flex-1 relative">
                    @if(request()->has('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                    @if(request()->has('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @foreach($selectedBrands ?? [] as $b)
                        <input type="hidden" name="brands[]" value="{{ $b }}">
                    @endforeach
                    @if($priceMin)<input type="hidden" name="price_min" value="{{ $priceMin }}">@endif
                    @if($priceMax)<input type="hidden" name="price_max" value="{{ $priceMax }}">@endif
                    <select name="sort" onchange="this.form.submit()"
                            class="w-full appearance-none bg-white border border-gray-200 text-gray-700 py-2 pl-3 pr-8 rounded-lg text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 shadow-sm cursor-pointer">
                        <option value="terbaru"  {{ request('sort', 'terbaru') == 'terbaru'  ? 'selected' : '' }}>Paling Sesuai</option>
                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="terbaru_saja" {{ request('sort') == 'terbaru_saja' ? 'selected' : '' }}>Produk Terbaru</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <i class='bx bx-chevron-down text-sm'></i>
                    </div>
                </form>

                {{-- Bottom Sheet (inline Alpine scope) --}}
                <div x-show="filterOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="filterOpen = false"
                     class="fixed inset-0 bg-black/50 z-[200]" x-cloak>
                </div>
                <div x-show="filterOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="translate-y-full"
                     x-transition:enter-end="translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="translate-y-0"
                     x-transition:leave-end="translate-y-full"
                     class="fixed bottom-0 inset-x-0 z-[210] bg-white rounded-t-2xl shadow-2xl max-h-[85vh] overflow-y-auto" x-cloak>
                    <div class="flex justify-center pt-3 pb-1">
                        <div class="w-10 h-1 bg-gray-200 rounded-full"></div>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 text-base">Filter & Urutkan</h3>
                        <button @click="filterOpen = false" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors">
                            <i class='bx bx-x text-xl text-gray-500'></i>
                        </button>
                    </div>
                    <form method="GET" action="{{ route('katalog.index') }}" class="px-5 pb-28">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        {{-- Sort --}}
                        <div class="py-4 border-b border-gray-100">
                            <h4 class="text-sm font-bold text-gray-700 mb-3">Urutkan</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['terbaru' => 'Paling Sesuai', 'terendah' => 'Harga Terendah', 'tertinggi' => 'Harga Tertinggi', 'terbaru_saja' => 'Produk Terbaru'] as $val => $label)
                                <label class="flex items-center gap-2 border {{ request('sort', 'terbaru') == $val ? 'border-brand-500 bg-brand-50 text-brand-600' : 'border-gray-200 text-gray-600' }} rounded-lg px-3 py-2 cursor-pointer text-sm font-medium">
                                    <input type="radio" name="sort" value="{{ $val }}" {{ request('sort', 'terbaru') == $val ? 'checked' : '' }} class="w-3.5 h-3.5 text-brand-600">
                                    {{ $label }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        {{-- Brand Filter --}}
                        @if($availableBrands->count() > 0)
                        <div class="py-4 border-b border-gray-100">
                            <h4 class="text-sm font-bold text-gray-700 mb-3">Filter Merek</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($availableBrands->take(20) as $brand)
                                <label class="flex items-center gap-2 border {{ in_array($brand, $selectedBrands ?? []) ? 'border-brand-500 bg-brand-50 text-brand-600' : 'border-gray-200 text-gray-600' }} rounded-lg px-3 py-2 cursor-pointer text-sm">
                                    <input type="checkbox" name="brands[]" value="{{ $brand }}" {{ in_array($brand, $selectedBrands ?? []) ? 'checked' : '' }} class="w-4 h-4 text-brand-600 rounded border-gray-300">
                                    <span class="truncate">{{ $brand }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        {{-- Price Range --}}
                        <div class="py-4">
                            <h4 class="text-sm font-bold text-gray-700 mb-3">Rentang Harga</h4>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs text-gray-500 mb-1 block">Min (Rp)</label>
                                    <input type="number" name="price_min" value="{{ $priceMin }}" placeholder="0" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 mb-1 block">Max (Rp)</label>
                                    <input type="number" name="price_max" value="{{ $priceMax }}" placeholder="Semua" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                                </div>
                            </div>
                        </div>
                        {{-- Action Buttons --}}
                        <div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-100 px-5 py-3 flex gap-3">
                            <a href="{{ route('katalog.index', request()->only('category_id', 'search')) }}" class="flex-1 text-center border border-gray-200 rounded-xl py-3 text-sm font-bold text-gray-700">Reset</a>
                            <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white rounded-xl py-3 text-sm font-bold transition-colors">Terapkan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($displayCategories as $category)
                    @if($category->all_products->count() > 0)
                    <section id="kategori-{{ $category->id }}" class="scroll-mt-20">
                        {{-- Category Header --}}
                        <div class="flex items-center justify-between mb-3 pb-2 border-b-2 border-gray-100">
                            <h2 class="text-base font-semibold text-gray-800 min-w-0 truncate">
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="flex items-center gap-1.5 hover:text-brand-600 transition-colors">
                                    <i class='bx bx-category text-brand-500 text-lg shrink-0'></i>
                                    <span class="truncate">{{ $category->name }}</span>
                                </a>
                            </h2>

                            @if(!isset($selectedCategoryId) && !request()->has('search') && empty($selectedBrands) && !$priceMin && !$priceMax)
                                {{-- Preview mode: Lihat Semua on the right --}}
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}"
                                   class="shrink-0 ml-3 text-[13px] font-medium text-brand-600 hover:text-brand-700 transition-colors whitespace-nowrap">
                                    Lihat Semua ({{ $category->total_count }}) &rarr;
                                </a>
                            @else
                                {{-- Detail/Filter mode --}}
                                {{-- Mobile: show "← Semua" link on right of category header (Row 2) --}}
                                @if(isset($selectedCategoryId))
                                <a href="{{ route('katalog.index') }}"
                                   class="shrink-0 ml-3 text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-1.5 rounded-lg whitespace-nowrap md:hidden">
                                    &larr; Semua
                                </a>
                                @endif
                                {{-- Desktop: Action buttons on right --}}
                                <div class="hidden md:flex items-center gap-2 shrink-0 ml-3">
                                    @if(isset($selectedCategoryId))
                                    <a href="{{ route('katalog.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition-colors border border-brand-100/50 whitespace-nowrap">
                                        &larr; Lihat Semua Kategori
                                    </a>
                                    @endif
                                    
                                    <form action="{{ route('katalog.index') }}" method="GET" class="relative">
                                        @if(request()->has('category_id'))
                                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                        @endif
                                        @if(request()->has('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                        @endif
                                        @foreach($selectedBrands ?? [] as $b)
                                            <input type="hidden" name="brands[]" value="{{ $b }}">
                                        @endforeach
                                        @if($priceMin)<input type="hidden" name="price_min" value="{{ $priceMin }}">@endif
                                        @if($priceMax)<input type="hidden" name="price_max" value="{{ $priceMax }}">@endif
                                        <select name="sort" onchange="this.form.submit()"
                                                class="appearance-none bg-white border border-gray-200 text-gray-700 py-1.5 pl-3 pr-8 rounded-lg text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm">
                                            <option value="terbaru"      {{ request('sort', 'terbaru') == 'terbaru'  ? 'selected' : '' }}>Paling Sesuai</option>
                                            <option value="terendah"     {{ request('sort') == 'terendah'   ? 'selected' : '' }}>Harga Terendah</option>
                                            <option value="tertinggi"    {{ request('sort') == 'tertinggi'  ? 'selected' : '' }}>Harga Tertinggi</option>
                                            <option value="terbaru_saja" {{ request('sort') == 'terbaru_saja' ? 'selected' : '' }}>Produk Terbaru</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                            <i class='bx bx-chevron-down text-sm'></i>
                                        </div>
                                    </form>
                                    <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-1 rounded-md">{{ $category->total_count }} Produk</span>
                                </div>
                            @endif
                        </div>

                        {{-- Product Grid --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3">
                            @foreach($category->all_products as $product)
                                <div class="w-full">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination (simplePaginate) --}}
                        @if(method_exists($category->all_products, 'links'))
                            <div class="mt-6 flex justify-between items-center">
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

    {{-- ================================================================ --}}
    {{-- MOBILE BOTTOM SHEET FILTER MODAL                                 --}}
    {{-- ================================================================ --}}
    <div x-data="{ open: false }" @open-filter-modal.window="open = true" x-cloak>
        {{-- Backdrop --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="open = false"
             class="fixed inset-0 bg-black/50 z-[200] md:hidden">
        </div>

        {{-- Bottom Sheet Panel --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed bottom-0 inset-x-0 z-[210] bg-white rounded-t-2xl shadow-2xl md:hidden max-h-[85vh] overflow-y-auto">
            
            {{-- Handle --}}
            <div class="flex justify-center pt-3 pb-1">
                <div class="w-10 h-1 bg-gray-200 rounded-full"></div>
            </div>

            {{-- Header --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-base">Filter & Urutkan</h3>
                <button @click="open = false" class="p-1.5 rounded-full hover:bg-gray-100 transition-colors">
                    <i class='bx bx-x text-xl text-gray-500'></i>
                </button>
            </div>

            <form method="GET" action="{{ route('katalog.index') }}" class="px-5 pb-24">
                @if(request()->has('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                @if(request()->has('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Sort --}}
                <div class="py-4 border-b border-gray-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Urutkan</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach([
                            'terbaru'     => 'Paling Sesuai',
                            'terendah'    => 'Harga Terendah',
                            'tertinggi'   => 'Harga Tertinggi',
                            'paling_laris'=> 'Paling Laris',
                        ] as $val => $label)
                        <label class="flex items-center gap-2 border {{ request('sort', 'terbaru') == $val ? 'border-brand-500 bg-brand-50 text-brand-600' : 'border-gray-200 text-gray-600' }} rounded-lg px-3 py-2 cursor-pointer text-sm font-medium">
                            <input type="radio" name="sort" value="{{ $val }}" {{ request('sort', 'terbaru') == $val ? 'checked' : '' }} class="hidden">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Brand Filter --}}
                @if($availableBrands->count() > 0)
                <div class="py-4 border-b border-gray-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Filter Merek</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($availableBrands->take(20) as $brand)
                        <label class="flex items-center gap-2 border {{ in_array($brand, $selectedBrands ?? []) ? 'border-brand-500 bg-brand-50 text-brand-600' : 'border-gray-200 text-gray-600' }} rounded-lg px-3 py-2 cursor-pointer text-sm">
                            <input type="checkbox" name="brands[]" value="{{ $brand }}" 
                                {{ in_array($brand, $selectedBrands ?? []) ? 'checked' : '' }}
                                class="w-4 h-4 text-brand-600 rounded border-gray-300 focus:ring-brand-500">
                            <span class="truncate">{{ $brand }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Price Range --}}
                <div class="py-4">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Rentang Harga</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Min (Rp)</label>
                            <input type="number" name="price_min" value="{{ $priceMin }}" placeholder="0"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Max (Rp)</label>
                            <input type="number" name="price_max" value="{{ $priceMax }}" placeholder="Semua"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="fixed bottom-0 inset-x-0 bg-white border-t border-gray-100 px-5 py-3 flex gap-3">
                    <a href="{{ route('katalog.index', request()->only('category_id', 'search')) }}"
                       class="flex-1 text-center border border-gray-200 rounded-xl py-3 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                        Reset
                    </a>
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white rounded-xl py-3 text-sm font-bold transition-colors">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

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

        // Make sort radio buttons in bottom sheet behave visually
        document.querySelectorAll('input[name="sort"][type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('input[name="sort"][type="radio"]').forEach(r => {
                    r.closest('label').classList.remove('border-brand-500', 'bg-brand-50', 'text-brand-600');
                    r.closest('label').classList.add('border-gray-200', 'text-gray-600');
                });
                this.closest('label').classList.add('border-brand-500', 'bg-brand-50', 'text-brand-600');
                this.closest('label').classList.remove('border-gray-200', 'text-gray-600');
            });
        });
    </script>
</body>
</html>
