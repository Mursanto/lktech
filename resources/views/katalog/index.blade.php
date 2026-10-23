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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        {{-- ============================================================ --}}
        {{-- SIDEBAR DESKTOP (Promo + Categories + Filter Brand + Harga)  --}}
        {{-- ============================================================ --}}
        <aside class="w-full md:w-64 flex-shrink-0 hidden md:block">
            <div class="sticky top-20 space-y-4">
                
                {{-- Filter Promo & Diskon Spesial --}}
                <div class="bg-gradient-to-br from-rose-50 via-white to-amber-50 p-3.5 rounded-xl shadow-xs border border-rose-200/80">
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-1.5 font-extrabold text-gray-800 text-sm">
                            <span class="text-base animate-pulse">🔥</span>
                            <span>Promo &amp; Diskon</span>
                        </div>
                        @if($totalPromoCount > 0)
                            <span class="bg-rose-500 text-white text-[10px] font-extrabold px-1.5 py-0.5 rounded-full">
                                {{ $totalPromoCount }}
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] text-gray-500 mb-2.5">Produk berlabel Hot Promo &amp; potongan harga spesial.</p>

                    <form method="GET" action="{{ route('katalog.index') }}">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @foreach($selectedBrands ?? [] as $b)
                            <input type="hidden" name="brands[]" value="{{ $b }}">
                        @endforeach
                        @if($priceMin)<input type="hidden" name="price_min" value="{{ $priceMin }}">@endif
                        @if($priceMax)<input type="hidden" name="price_max" value="{{ $priceMax }}">@endif
                        
                        <label class="flex items-center justify-between p-2 rounded-lg cursor-pointer bg-white border {{ $isPromoFilter ? 'border-rose-400 ring-2 ring-rose-200 bg-rose-50/50' : 'border-gray-200 hover:border-rose-300' }} transition-all">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="promo" value="1" onchange="this.form.submit()" {{ $isPromoFilter ? 'checked' : '' }} class="w-4 h-4 text-rose-600 rounded border-gray-300 focus:ring-rose-500 cursor-pointer">
                                <span class="text-xs font-bold {{ $isPromoFilter ? 'text-rose-700' : 'text-gray-700' }}">Hot Promo / Diskon</span>
                            </div>
                            @if($isPromoFilter)
                                <span class="text-[10px] font-bold text-rose-600 bg-rose-100 px-1.5 py-0.5 rounded">Aktif</span>
                            @endif
                        </label>
                        @if($isPromoFilter)
                            <a href="{{ request()->url() . '?' . http_build_query(request()->except('promo')) }}" class="mt-2 inline-block text-[11px] text-rose-600 hover:text-rose-700 font-bold">
                                &times; Nonaktifkan filter promo
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Category List --}}
                <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-200" x-data="{ expanded: true }">
                    <button type="button" @click="expanded = !expanded" class="flex justify-between items-center w-full font-bold text-gray-800 text-sm cursor-pointer" :class="expanded ? 'border-b border-gray-100 pb-2 mb-2' : ''">
                        <span>Kategori Produk</span>
                        <i class='bx text-gray-400 text-base transition-transform' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <ul class="space-y-0.5" x-show="expanded">
                        @foreach($mainCategories as $category)
                            @if($category->total_count > 0)
                            <li>
                                <a href="{{ route('katalog.index', array_merge(request()->all(), ['category_id' => $category->id])) }}" 
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
                <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-200" 
                     x-data="{ 
                        expanded: {{ !empty($selectedBrands) ? 'true' : 'false' }},
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
                    <button type="button" @click="expanded = !expanded" class="flex justify-between items-center w-full font-bold text-gray-800 text-sm cursor-pointer" :class="expanded ? 'border-b border-gray-100 pb-2 mb-3' : ''">
                        <span>Filter Merek</span>
                        <i class='bx text-gray-400 text-base transition-transform' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <form x-ref="brandForm" method="GET" action="{{ route('katalog.index') }}" x-show="expanded">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if($isPromoFilter)
                            <input type="hidden" name="promo" value="1">
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
                <div class="bg-white p-3.5 rounded-xl shadow-sm border border-gray-200" x-data="{ expanded: {{ ($priceMin || $priceMax) ? 'true' : 'false' }} }">
                    <button type="button" @click="expanded = !expanded" class="flex justify-between items-center w-full font-bold text-gray-800 text-sm cursor-pointer" :class="expanded ? 'border-b border-gray-100 pb-2 mb-3' : ''">
                        <span>Rentang Harga</span>
                        <i class='bx text-gray-400 text-base transition-transform' :class="expanded ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <form method="GET" action="{{ route('katalog.index') }}" x-show="expanded">
                        @if(request()->has('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request()->has('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request()->has('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if($isPromoFilter)
                            <input type="hidden" name="promo" value="1">
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
                        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-medium h-8 rounded-lg transition-colors cursor-pointer">
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

            {{-- ============================================================ --}}
            {{-- MOBILE TOP BAR (Tepat di Bawah Kolom Pencarian Utama)          --}}
            {{-- ============================================================ --}}
            <div class="flex items-center gap-2 mb-2.5 md:hidden">
                {{-- Tombol Filter --}}
                <button type="button" @click="$dispatch('open-filter-drawer')"
                        class="flex items-center justify-center gap-1.5 px-3.5 py-2 border border-gray-200 bg-white rounded-lg text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 active:scale-95 transition-all cursor-pointer shrink-0">
                    <i class='bx bx-filter-alt text-brand-600 text-sm'></i>
                    <span>Filter</span>
                    @php
                        $activeCount = count($selectedBrands ?? []) + ($priceMin || $priceMax ? 1 : 0) + ($isPromoFilter ? 1 : 0);
                    @endphp
                    @if($activeCount > 0)
                        <span class="bg-brand-600 text-white rounded-full text-[9px] font-extrabold w-4 h-4 flex items-center justify-center">
                            {{ $activeCount }}
                        </span>
                    @endif
                </button>

                {{-- Dropdown Urutkan Berdampingan Rapi --}}
                <form method="GET" action="{{ route('katalog.index') }}" class="flex-1 relative">
                    @if(request()->has('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    @endif
                    @if(request()->has('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if($isPromoFilter)
                        <input type="hidden" name="promo" value="1">
                    @endif
                    @foreach($selectedBrands ?? [] as $b)
                        <input type="hidden" name="brands[]" value="{{ $b }}">
                    @endforeach
                    @if($priceMin)<input type="hidden" name="price_min" value="{{ $priceMin }}">@endif
                    @if($priceMax)<input type="hidden" name="price_max" value="{{ $priceMax }}">@endif
                    
                    <select name="sort" onchange="this.form.submit()"
                            style="background-image: none !important;"
                            class="w-full appearance-none bg-none bg-white border border-brand-500 hover:border-brand-600 text-gray-800 py-2 pl-3 pr-8 rounded-lg text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500 shadow-xs cursor-pointer transition-all">
                        <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Paling Sesuai</option>
                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="terbaru_saja" {{ request('sort') == 'terbaru_saja' ? 'selected' : '' }}>Produk Terbaru</option>
                        <option value="diskon_terbesar" {{ request('sort') == 'diskon_terbesar' ? 'selected' : '' }}>Diskon Terbesar</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-brand-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </form>
            </div>

            {{-- ============================================================ --}}
            {{-- PRODUCT CATEGORIES & GRIDS                                   --}}
            {{-- ============================================================ --}}
            @php
                $totalProductsRendered = $displayCategories->sum(fn($c) => $c->all_products->count());
            @endphp

            @if($totalProductsRendered === 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center my-6">
                    <div class="w-16 h-16 mx-auto bg-gray-100 text-gray-400 rounded-full flex items-center justify-center text-3xl mb-3">
                        <i class='bx bx-search-alt'></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-800 mb-1">Tidak ada produk yang cocok</h3>
                    <p class="text-xs text-gray-500 mb-4 max-w-sm mx-auto">Coba ubah kata kunci pencarian, kurangi filter merek/harga, atau nonaktifkan filter promo.</p>
                    <a href="{{ route('katalog.index') }}" class="inline-flex items-center gap-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-colors shadow-xs">
                        <i class='bx bx-refresh text-base'></i>
                        <span>Reset Semua Filter</span>
                    </a>
                </div>
            @endif

            <div class="space-y-5 md:space-y-8">
                @foreach($displayCategories as $category)
                    @if($category->all_products->count() > 0)
                    <section id="kategori-{{ $category->id }}" class="scroll-mt-20">
                        {{-- Category Header --}}
                        <div class="flex items-center justify-between mb-2 md:mb-3 pb-1.5 md:pb-2 border-b-2 border-gray-100">
                            <h2 class="text-xs md:text-sm font-bold text-gray-800 min-w-0 truncate">
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}" class="flex items-center gap-1.5 hover:text-brand-600 transition-colors">
                                    <i class='bx bx-category text-brand-500 text-sm md:text-base shrink-0'></i>
                                    <span class="truncate">{{ $category->name }}</span>
                                </a>
                            </h2>

                            {{-- Mobile: show "← Semua" link on right of category header --}}
                            <div class="flex items-center gap-2 md:hidden shrink-0 ml-2">
                                @if(isset($selectedCategoryId))
                                <a href="{{ route('katalog.index') }}"
                                   class="text-xs font-bold text-brand-600 bg-brand-50 px-2.5 py-1.5 rounded-lg whitespace-nowrap">
                                    &larr; Semua
                                </a>
                                @elseif(!request()->has('search') && empty($selectedBrands) && !$priceMin && !$priceMax && !$isPromoFilter && request('sort', 'terbaru') == 'terbaru')
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}"
                                   class="text-[10px] font-semibold text-brand-600 hover:text-brand-700 transition-colors whitespace-nowrap">
                                    Lihat Semua ({{ $category->total_count }}) &rarr;
                                </a>
                                @endif
                                <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-1 rounded-md whitespace-nowrap">
                                    {{ method_exists($category->all_products, 'total') ? $category->all_products->total() : $category->all_products->count() }} Produk
                                </span>
                            </div>

                            {{-- Desktop: Action buttons on right (Lihat Semua Kategori, Dropdown Urutkan Pojok Kanan Atas, Total Produk) --}}
                            <div class="hidden md:flex items-center gap-2 shrink-0 ml-3">
                                @if(isset($selectedCategoryId))
                                <a href="{{ route('katalog.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 bg-brand-50 hover:bg-brand-100 px-3 py-1.5 rounded-lg transition-colors border border-brand-100/50 whitespace-nowrap">
                                    &larr; Lihat Semua Kategori
                                </a>
                                @elseif(!request()->has('search') && empty($selectedBrands) && !$priceMin && !$priceMax && !$isPromoFilter && request('sort', 'terbaru') == 'terbaru')
                                <a href="{{ route('katalog.index', ['category_id' => $category->id]) }}"
                                   class="text-[10px] md:text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors whitespace-nowrap mr-1">
                                    Lihat Semua ({{ $category->total_count }}) &rarr;
                                </a>
                                @endif
                                
                                @if($loop->first)
                                <form action="{{ route('katalog.index') }}" method="GET" class="relative">
                                    @if(request()->has('category_id'))
                                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                                    @endif
                                    @if(request()->has('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if($isPromoFilter)
                                        <input type="hidden" name="promo" value="1">
                                    @endif
                                    @foreach($selectedBrands ?? [] as $b)
                                        <input type="hidden" name="brands[]" value="{{ $b }}">
                                    @endforeach
                                    @if($priceMin)<input type="hidden" name="price_min" value="{{ $priceMin }}">@endif
                                    @if($priceMax)<input type="hidden" name="price_max" value="{{ $priceMax }}">@endif
                                    <select name="sort" onchange="this.form.submit()"
                                            style="background-image: none !important;"
                                            class="appearance-none bg-none bg-white border border-gray-200 text-gray-700 py-1.5 pl-3 pr-8 rounded-lg text-xs font-bold focus:outline-none focus:ring-2 focus:ring-brand-500 cursor-pointer hover:bg-gray-50 transition-colors shadow-sm">
                                        <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Paling Sesuai</option>
                                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                                        <option value="terbaru_saja" {{ request('sort') == 'terbaru_saja' ? 'selected' : '' }}>Produk Terbaru</option>
                                        <option value="diskon_terbesar" {{ request('sort') == 'diskon_terbesar' ? 'selected' : '' }}>Diskon Terbesar</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </div>
                                </form>
                                @endif

                                <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-1 rounded-md">{{ method_exists($category->all_products, 'total') ? $category->all_products->total() : $category->all_products->count() }} Produk</span>
                            </div>
                        </div>

                        {{-- Product Grid --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-1.5 sm:gap-2">
                            @foreach($category->all_products as $product)
                                <div class="w-full">
                                    <x-product-card :product="$product" :loop-index="$loop->index" :is-lcp="$loop->first" />
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
    {{-- RESPONSIVE SLIDEOVER / DRAWER FILTER (Mobile & Tablet)           --}}
    {{-- ================================================================ --}}
    <div x-data="{ openDrawer: false }" 
         @open-filter-drawer.window="openDrawer = true" 
         @open-filter-modal.window="openDrawer = true" 
         @keydown.window.escape="openDrawer = false" 
         x-cloak>
        {{-- Backdrop Overlay --}}
        <div x-show="openDrawer"
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="openDrawer = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-xs z-[220]">
        </div>

        {{-- Slideover Drawer Panel --}}
        <div x-show="openDrawer"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 z-[230] w-full max-w-[340px] sm:max-w-md bg-white shadow-2xl flex flex-col justify-between">
            
            {{-- Drawer Header --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0 bg-white">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center text-brand-600">
                        <i class='bx bx-slider-alt text-lg'></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-sm">Filter &amp; Pengurutan</h3>
                        <p class="text-[11px] text-gray-400">Atur kriteria produk sesuai kebutuhan</p>
                    </div>
                </div>
                <button type="button" @click="openDrawer = false" class="w-8 h-8 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-700 flex items-center justify-center transition-colors cursor-pointer">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            {{-- Drawer Scrollable Content --}}
            <form id="drawer-filter-form" method="GET" action="{{ route('katalog.index') }}" class="flex-1 overflow-y-auto px-5 py-4 space-y-5 custom-scrollbar">
                @if(request()->has('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                @if(request()->has('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Filter Promo Card --}}
                <div class="p-3 bg-gradient-to-r from-rose-50 via-white to-amber-50 rounded-xl border border-rose-200 shadow-xs">
                    <label class="flex items-center justify-between cursor-pointer">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl">🔥</span>
                            <div>
                                <div class="text-xs font-extrabold text-gray-900">Hot Promo &amp; Diskon</div>
                                <div class="text-[10px] text-gray-500">Tampilkan hanya produk berdiskon/promo</div>
                            </div>
                        </div>
                        <input type="checkbox" name="promo" value="1" {{ $isPromoFilter ? 'checked' : '' }} class="w-4 h-4 text-rose-600 rounded border-gray-300 focus:ring-rose-500 cursor-pointer">
                    </label>
                </div>

                {{-- Opsi Pengurutan (5 Opsi) --}}
                <div>
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                        <i class='bx bx-sort-alt-2 text-brand-500'></i>
                        <span>Urutkan Produk</span>
                    </h4>
                    <div class="grid grid-cols-1 gap-1.5">
                        @php
                            $sortOptions = [
                                'terbaru'         => ['label' => 'Paling Sesuai', 'desc' => 'Rekomendasi promo & relevansi produk'],
                                'terendah'        => ['label' => 'Harga Terendah', 'desc' => 'Harga termurah ke termahal'],
                                'tertinggi'       => ['label' => 'Harga Tertinggi', 'desc' => 'Harga termahal ke termurah'],
                                'terbaru_saja'    => ['label' => 'Produk Terbaru', 'desc' => 'Unit yang baru ditambahkan'],
                                'diskon_terbesar' => ['label' => 'Diskon Terbesar', 'desc' => 'Potongan harga paling maksimal'],
                            ];
                        @endphp
                        @foreach($sortOptions as $val => $opt)
                        <label class="flex items-center justify-between p-2.5 rounded-lg border cursor-pointer transition-all {{ request('sort', 'terbaru') == $val ? 'border-brand-500 bg-brand-50/70 text-brand-700 font-bold' : 'border-gray-200 hover:border-gray-300 text-gray-700 font-medium' }}">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="sort" value="{{ $val }}" {{ request('sort', 'terbaru') == $val ? 'checked' : '' }} class="w-3.5 h-3.5 text-brand-600 focus:ring-brand-500 cursor-pointer">
                                <div>
                                    <div class="text-xs">{{ $opt['label'] }}</div>
                                    <div class="text-[10px] font-normal text-gray-500">{{ $opt['desc'] }}</div>
                                </div>
                            </div>
                            @if(request('sort', 'terbaru') == $val)
                                <i class='bx bx-check text-brand-600 text-base'></i>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Kategori --}}
                <div>
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class='bx bx-category-alt text-brand-500'></i>
                        <span>Kategori Produk</span>
                    </h4>
                    <div class="flex flex-wrap gap-1.5">
                        <a href="{{ route('katalog.index', request()->except('category_id')) }}" 
                           class="px-2.5 py-1 rounded-lg text-xs font-semibold border {{ !isset($selectedCategoryId) ? 'bg-brand-600 text-white border-brand-700' : 'bg-gray-50 text-gray-700 border-gray-200' }}">
                            Semua
                        </a>
                        @foreach($mainCategories as $cat)
                            @if($cat->total_count > 0)
                                <a href="{{ route('katalog.index', array_merge(request()->all(), ['category_id' => $cat->id])) }}"
                                   class="px-2.5 py-1 rounded-lg text-xs font-semibold border {{ (isset($selectedCategoryId) && $selectedCategoryId == $cat->id) ? 'bg-brand-600 text-white border-brand-700' : 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                    {{ $cat->name }} ({{ $cat->total_count }})
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Filter Merek --}}
                @if(count($availableBrands) > 0)
                <div x-data="{
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
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class='bx bx-purchase-tag-alt text-brand-500'></i>
                        <span>Filter Merek</span>
                    </h4>
                    <div class="space-y-1.5 max-h-56 overflow-y-auto custom-scrollbar pr-1">
                        @foreach($availableBrands as $parentBrand => $childBrands)
                        <div class="flex flex-col gap-1 border-b border-gray-50 pb-1" x-data="{ openBrand: false }">
                            <div class="flex items-center justify-between">
                                <label class="flex items-center gap-2 cursor-pointer flex-1 py-0.5">
                                    <input type="checkbox" name="brands[]" value="{{ $parentBrand }}" 
                                           x-model="selectedBrands"
                                           @change="toggleParent('{{ $parentBrand }}', {{ json_encode($childBrands) }})"
                                           class="w-3.5 h-3.5 text-brand-600 rounded border-gray-300">
                                    <span class="text-xs font-semibold text-gray-700 truncate">{{ $parentBrand }}</span>
                                </label>
                                @if(count($childBrands) > 0)
                                <button type="button" @click="openBrand = !openBrand" class="text-gray-400 hover:text-brand-600 p-0.5 cursor-pointer">
                                    <i class='bx text-sm' :class="openBrand ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                </button>
                                @endif
                            </div>
                            @if(count($childBrands) > 0)
                            <div x-show="openBrand" class="flex flex-col gap-1 pl-4 ml-1.5 border-l border-gray-200">
                                @foreach($childBrands as $childBrand)
                                <label class="flex items-center gap-2 cursor-pointer py-0.5">
                                    <input type="checkbox" name="brands[]" value="{{ $childBrand }}" 
                                           x-model="selectedBrands"
                                           class="w-3.5 h-3.5 text-brand-500 rounded border-gray-300">
                                    <span class="text-[11px] text-gray-600 truncate">{{ $childBrand }}</span>
                                </label>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Filter Harga --}}
                <div>
                    <h4 class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class='bx bx-money text-brand-500'></i>
                        <span>Rentang Harga</span>
                    </h4>
                    <div class="flex items-center gap-2">
                        <input type="number" name="price_min" value="{{ $priceMin }}" placeholder="Rp Min"
                               class="w-full border border-gray-200 rounded-lg px-2.5 h-9 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <span class="text-gray-400 font-bold">-</span>
                        <input type="number" name="price_max" value="{{ $priceMax }}" placeholder="Rp Max"
                               class="w-full border border-gray-200 rounded-lg px-2.5 h-9 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                </div>
            </form>

            {{-- Drawer Footer --}}
            <div class="p-4 border-t border-gray-100 bg-white flex gap-3 shrink-0 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
                <a href="{{ route('katalog.index', request()->only('category_id', 'search')) }}"
                   class="flex-1 text-center border border-gray-200 hover:bg-gray-50 rounded-xl py-2.5 text-xs font-bold text-gray-700 transition-colors">
                    Reset Filter
                </a>
                <button type="submit" form="drawer-filter-form"
                        class="flex-1 bg-brand-600 hover:bg-brand-700 text-white rounded-xl py-2.5 text-xs font-bold shadow-md shadow-brand-500/20 transition-all cursor-pointer">
                    Terapkan
                </button>
            </div>
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




