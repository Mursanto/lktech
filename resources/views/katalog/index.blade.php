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

        /* Badge Promo Utama - Warna Merah Crimson */
        .badge-promo-live {
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #ffffff;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.04em;
            padding: 3px 8px 3px 6px;
            border-bottom-right-radius: 10px;
            border-top-left-radius: 11px;
            z-index: 20;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            white-space: nowrap;
            animation: badgeGlow 1.5s infinite;
        }

        @keyframes badgeGlow {
            0%   { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
            50%  { box-shadow: 0 0 10px 2px rgba(220, 38, 38, 0.7); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
        }

        /* Radar / pulsing ring effect on promo card wrapper */
        @keyframes radarPulse {
            0%   { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6); }
            50%  { box-shadow: 0 0 0 12px rgba(239, 68, 68, 0.0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.0); }
        }

        /* Border Kartu Promo Merah Halus */
        .promo-card-radar {
            border: 2px solid #ef4444 !important;
            border-radius: 12px;
            animation: radarPulse 2.2s ease-out infinite;
        }

        .promo-card-radar:hover {
            animation-play-state: paused;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Top Navbar -->
    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full">
        
        <div class="max-w-[1400px] mx-auto px-1.5 sm:px-6 lg:px-8 pt-3 md:pt-8 pb-6 md:pb-8 flex flex-col md:flex-row gap-8">
        
        {{-- ============================================================ --}}
        {{-- SIDEBAR DESKTOP (Categories + Filter Brand + Harga)          --}}
        {{-- ============================================================ --}}
        <aside class="w-full md:w-64 flex-shrink-0 hidden md:block">
            <div class="sticky top-20 space-y-4">
                
                {{-- Category List --}}
                <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-2 mb-2">Kategori Produk</h3>
                    <ul class="space-y-0.5">
                        @foreach($mainCategories as $category)
                            @if($category->total_count > 0)
                            <li>
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" 
                                   class="flex justify-between items-center px-2 py-1.5 text-[13px] {{ (isset($selectedCategoryId) && $selectedCategoryId == $category->id) ? 'text-brand-600 bg-brand-50 font-bold' : 'text-gray-600 font-medium hover:text-brand-600 hover:bg-brand-50' }} rounded-lg transition-colors group">
                                    <span class="truncate">{{ $category->name }}</span>
                                    <span class="bg-gray-100 text-gray-500 group-hover:bg-brand-100 group-hover:text-brand-600 flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[10px] font-bold">
                                        {{ $category->total_count }}
                                    </span>
                                </a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                {{-- Filter: Merek --}}
                @if(count($availableBrands) > 0)
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200" 
                     x-data="{ 
                        expanded: true,
                        selectedBrands: {{ json_encode($selectedBrands) }},
                        toggleParent(parent, children) {
                            if (this.selectedBrands.includes(parent)) {
                                children.forEach(child => {
                                    if (!this.selectedBrands.includes(child)) this.selectedBrands.push(child);
                                });
                            } else {
                                this.selectedBrands = this.selectedBrands.filter(b => !children.includes(b));
                            }
                            $refs.brandForm.submit();
                        },
                        submitForm() {
                            $refs.brandForm.submit();
                        }
                     }">
                    <button @click="expanded = !expanded" class="flex justify-between items-center w-full font-bold text-gray-800 text-sm border-b border-gray-100 pb-2 mb-3">
                        <span>Filter Merek</span>
                        <i class='bx text-gray-400 text-base' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <form x-ref="brandForm" method="GET" action="{{ route('katalog.index') }}" x-show="expanded">
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
                        
                        <div class="max-h-72 overflow-y-auto custom-scrollbar pr-2 py-1 space-y-1.5">
                            @foreach($availableBrands as $parentBrand => $childBrands)
                            <div class="flex flex-col gap-1" x-data="{ open: true }">
                                <div class="flex items-center justify-between">
                                    <label class="flex items-center gap-2 cursor-pointer group flex-1 py-0.5">
                                        <input type="checkbox" name="brands[]" value="{{ $parentBrand }}" 
                                               x-model="selectedBrands"
                                               @change="toggleParent('{{ $parentBrand }}', {{ json_encode($childBrands) }})"
                                               class="w-3.5 h-3.5 text-brand-600 rounded border border-gray-300 focus:ring-brand-500 cursor-pointer">
                                        <span class="text-[13px] font-medium text-gray-700 group-hover:text-brand-600 transition-colors truncate">{{ $parentBrand }}</span>
                                    </label>
                                    @if(count($childBrands) > 0)
                                    <button type="button" @click="open = !open" class="text-gray-400 hover:text-brand-600 p-0.5">
                                        <i class='bx text-base' :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                    </button>
                                    @endif
                                </div>
                                
                                @if(count($childBrands) > 0)
                                <div x-show="open" class="flex flex-col gap-1 pl-4 ml-1.5 border-l border-gray-200">
                                    @foreach($childBrands as $childBrand)
                                    <label class="flex items-center gap-2 cursor-pointer group py-0.5">
                                        <input type="checkbox" name="brands[]" value="{{ $childBrand }}" 
                                               x-model="selectedBrands"
                                               @change="submitForm()"
                                               class="w-3.5 h-3.5 text-brand-500 rounded border border-gray-300 focus:ring-brand-500 cursor-pointer">
                                        <span class="text-[11px] font-normal text-gray-600 group-hover:text-brand-600 transition-colors truncate">{{ $childBrand }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @if(!empty($selectedBrands))
                        <a href="{{ request()->url() . '?' . http_build_query(array_merge(request()->except('brands'), [])) }}" 
                           class="mt-3 inline-block text-xs text-red-500 hover:text-red-600 font-medium">
                            × Hapus filter merek
                        </a>
                        @endif
                    </form>
                </div>
                @endif

                {{-- Filter: Harga --}}
                <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-200" x-data="{ expanded: true }">
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
                        <div class="flex items-center gap-2 mb-2">
                            <input type="number" name="price_min" value="{{ $priceMin }}" placeholder="Rp Min"
                                class="w-full border border-gray-200 rounded-lg px-2.5 h-8 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <span class="text-gray-400 font-medium">-</span>
                            <input type="number" name="price_max" value="{{ $priceMax }}" placeholder="Rp Max"
                                class="w-full border border-gray-200 rounded-lg px-2.5 h-8 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-medium h-8 rounded-lg transition-colors">
                            Terapkan
                        </button>
                            @if($priceMin || $priceMax)
                            <a href="{{ request()->url() . '?' . http_build_query(request()->except(['price_min', 'price_max'])) }}"
                               class="block text-center text-xs text-red-500 hover:text-red-600 font-medium mt-1">
                                × Hapus filter harga
                            </a>
                            @endif
                    </form>
                </div>

            </div>
        </aside>

        {{-- ============================================================ --}}
        {{-- PRODUCT SECTIONS (Main Content)                              --}}
        {{-- ============================================================ --}}
        <div class="flex-1 min-w-0">

            {{-- Mobile Filter & Sort has been moved to the first category header --}}

            <div class="space-y-8">
                @foreach($displayCategories as $category)
                    @if($category->all_products->count() > 0)
                    <section id="kategori-{{ $category->id }}" class="scroll-mt-20">
                        {{-- Category Header --}}
                        <div class="flex items-start sm:items-center justify-between mb-3 pb-2 border-b-2 border-gray-100">
                            <div class="flex flex-col flex-1 min-w-0 pr-2">
                                <h2 class="text-[13px] sm:text-base font-semibold text-gray-800 min-w-0 truncate">
                                    <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="flex items-center gap-1.5 hover:text-brand-600 transition-colors">
                                        <i class='bx bx-category text-brand-500 text-base sm:text-lg shrink-0'></i>
                                        <span class="truncate">{{ $category->name }}</span>
                                    </a>
                                </h2>
                                
                                @if(!isset($selectedCategoryId) && !request()->has('search') && empty($selectedBrands) && !$priceMin && !$priceMax)
                                    {{-- Preview mode: Lihat Semua on the right --}}
                                    <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}"
                                       class="shrink-0 text-[10px] sm:text-[13px] font-medium text-brand-600 hover:text-brand-700 transition-colors whitespace-nowrap mt-0.5">
                                        Lihat Semua ({{ $category->total_count }}) &rarr;
                                    </a>
                                @endif
                            </div>

                            @if($loop->first)
                            {{-- Mobile Filter & Sort (Sejajar dengan Judul Kategori) --}}
                            <div class="flex items-center gap-1 md:hidden shrink-0 mt-0.5">
                                {{-- Filter Button --}}
                                <button type="button" @click="$dispatch('open-filter-modal')"
                                        class="flex items-center gap-0.5 px-1.5 py-1 border border-gray-200 bg-white rounded text-[10px] font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors cursor-pointer shrink-0">
                                    <i class='bx bx-filter-alt text-brand-500 text-[11px]'></i>
                                    Filter
                                    @if(!empty($selectedBrands) || $priceMin || $priceMax)
                                        <span class="bg-brand-600 text-white rounded-full text-[8px] font-bold w-3 h-3 flex items-center justify-center">
                                            {{ count($selectedBrands ?? []) + ($priceMin || $priceMax ? 1 : 0) }}
                                        </span>
                                    @endif
                                </button>

                                {{-- Sort Dropdown --}}
                                <form method="GET" action="{{ route('katalog.index') }}" class="relative shrink-0">
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
                                            class="appearance-none bg-white border border-gray-200 text-gray-700 py-1 pl-1.5 pr-4 rounded text-[10px] font-semibold focus:outline-none focus:ring-1 focus:ring-brand-500 shadow-sm cursor-pointer">
                                        <option value="terbaru"  {{ request('sort', 'terbaru') == 'terbaru'  ? 'selected' : '' }}>Paling Sesuai</option>
                                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                                        <option value="terbaru_saja" {{ request('sort') == 'terbaru_saja' ? 'selected' : '' }}>Terbaru</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-400">
                                        <i class='bx bx-chevron-down text-[10px]'></i>
                                    </div>
                                </form>
                            </div>
                            @endif

                            @if(isset($selectedCategoryId))
                            {{-- Detail/Filter mode --}}
                            {{-- Mobile: show "← Semua" link --}}
                            <div class="flex items-center gap-1 shrink-0 ml-1 md:hidden mt-0.5">
                                <a href="{{ route('katalog.index') }}"
                                   class="text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-1 rounded whitespace-nowrap">
                                    &larr; Semua
                                </a>
                            </div>
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
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-1.5 sm:gap-2">
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
                @if(count($availableBrands) > 0)
                <div class="py-4 border-b border-gray-100" x-data="{
                    selectedBrands: {{ json_encode($selectedBrands) }},
                    toggleParent(parent, children) {
                        if (this.selectedBrands.includes(parent)) {
                            children.forEach(child => {
                                if (!this.selectedBrands.includes(child)) this.selectedBrands.push(child);
                            });
                        } else {
                            this.selectedBrands = this.selectedBrands.filter(b => !children.includes(b));
                        }
                    }
                }">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Filter Merek</h4>
                    <div class="space-y-1.5 py-1">
                        @foreach($availableBrands as $parentBrand => $childBrands)
                        <div class="flex flex-col gap-1" x-data="{ open: false }">
                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 cursor-pointer flex-1 py-0.5">
                                    <input type="checkbox" name="brands[]" value="{{ $parentBrand }}" 
                                           x-model="selectedBrands"
                                           @change="toggleParent('{{ $parentBrand }}', {{ json_encode($childBrands) }})"
                                           class="w-3.5 h-3.5 text-brand-600 rounded border border-gray-300">
                                    <span class="text-[13px] font-medium text-gray-700 truncate">{{ $parentBrand }}</span>
                                </label>
                                @if(count($childBrands) > 0)
                                <button type="button" @click="open = !open" class="text-gray-400 p-0.5">
                                    <i class='bx text-base' :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                </button>
                                @endif
                            </div>
                            @if(count($childBrands) > 0)
                            <div x-show="open" class="flex flex-col gap-1 pl-4 ml-1.5 border-l border-gray-200">
                                @foreach($childBrands as $childBrand)
                                <label class="flex items-center gap-2 cursor-pointer py-0.5">
                                    <input type="checkbox" name="brands[]" value="{{ $childBrand }}" 
                                           x-model="selectedBrands"
                                           class="w-3.5 h-3.5 text-brand-500 rounded border border-gray-300">
                                    <span class="text-[11px] font-normal text-gray-600 truncate">{{ $childBrand }}</span>
                                </label>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Price Range --}}
                <div class="py-3">
                    <h4 class="text-sm font-bold text-gray-700 mb-2">Rentang Harga</h4>
                    <div class="flex items-center gap-2">
                        <input type="number" name="price_min" value="{{ $priceMin }}" placeholder="Rp Min"
                            class="w-full border border-gray-200 rounded-lg px-2.5 h-8 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <span class="text-gray-400 font-medium">-</span>
                        <input type="number" name="price_max" value="{{ $priceMax }}" placeholder="Rp Max"
                            class="w-full border border-gray-200 rounded-lg px-2.5 h-8 text-xs focus:outline-none focus:ring-2 focus:ring-brand-500">
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            const video = entry.target;
            if (entry.isIntersecting) {
                if (!video.src && video.dataset.src) {
                    video.src = video.dataset.src;
                    video.load();
                }
                video.play().catch(e => console.log('Autoplay blocked:', e));
            } else {
                video.pause();
            }
        });
    }, { rootMargin: '0px', threshold: 0.5 });

    document.querySelectorAll('.product-video-preview').forEach(v => videoObserver.observe(v));
});
</script>




