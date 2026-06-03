@props(['product'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group relative min-w-[160px]">
    
    <!-- Clickable Area to Detail Page -->
    <a href="{{ route('katalog.show', $product->id) }}" class="flex flex-col flex-grow cursor-pointer">
        <!-- Image Area -->
        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden border-b border-gray-100">
            <img src="{{ $product->display_image }}" alt="{{ $product->brand }} {{ $product->model_series }}" class="absolute inset-0 w-full h-full object-contain bg-white p-2 group-hover:scale-105 transition-transform duration-500">
            
            <!-- Badges -->
            <div class="absolute top-1.5 right-1.5 flex flex-col gap-1 items-end">
                @if($product->stock > 0 && $product->status !== 'Sold')
                    <span class="bg-white/95 backdrop-blur text-brand-600 px-1.5 py-0.5 rounded text-[9px] font-bold shadow-sm border border-brand-100 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-500"></span> Ready ({{ $product->stock }})
                    </span>
                @else
                    <span class="bg-white/95 backdrop-blur text-red-600 px-1.5 py-0.5 rounded text-[9px] font-bold shadow-sm border border-red-100 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Terjual Habis
                    </span>
                @endif
            </div>
        </div>

        <!-- Content Details -->
        <div class="p-2 flex flex-col flex-grow">
            <!-- Brand & Model -->
            <h3 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug mb-1 group-hover:text-brand-600 transition-colors" title="{{ $product->brand }} {{ $product->model_series }}">
                {{ $product->brand }} {{ $product->model_series }}
            </h3>

            <!-- Price -->
            <div class="text-emerald-600 font-extrabold text-base mb-1.5">
                Rp {{ number_format($product->selling_price, 0, ',', '.') }}
            </div>

            <!-- Specs List (Compact) / Conditional Rendering -->
            @php
                $isUnitDevice = $product->category && strtolower($product->category->name) === 'unit device';
                $isLaptop = $product->category && str_contains(strtolower($product->category->name), 'laptop');
                $isUltrabook = $product->category && str_contains(strtolower($product->category->name), 'ultrabook');
                $isPC = $product->category && str_contains(strtolower($product->category->name), 'pc');
                $showSpecs = $isUnitDevice || $isLaptop || $isUltrabook || $isPC;
            @endphp

            @if($showSpecs)
            <div class="text-[9px] text-gray-500 flex flex-wrap gap-x-2 gap-y-0.5 leading-tight flex-grow">
                <span class="flex items-center gap-0.5 whitespace-nowrap"><i class='bx bx-chip'></i>{{ $product->processor ?: 'N/A' }}</span>
                <span class="flex items-center gap-0.5 whitespace-nowrap"><i class='bx bx-memory-card'></i>{{ $product->ram ?: 'N/A' }}</span>
                <span class="flex items-center gap-0.5 whitespace-nowrap"><i class='bx bx-hdd'></i>{{ $product->storage ?: 'N/A' }}</span>
            </div>
            @else
            <div class="text-[10px] text-gray-500 leading-tight flex-grow line-clamp-2">
                {{ $product->description ? Str::limit(strip_tags($product->description), 50) : 'Produk ' . ($product->category ? $product->category->name : 'berkualitas') . ' dengan penawaran harga terbaik.' }}
            </div>
            @endif
        </div>
    </a>

    <!-- Separated Action Button Container at Bottom -->
    <div class="p-1.5 sm:p-2 pt-0 mt-auto">
        <div class="pt-2 border-t border-gray-100 flex gap-1.5">
            @php
                $waText = urlencode("Halo LKTech, saya tertarik dengan produk *{$product->brand} {$product->model_series}* (Rp " . number_format($product->selling_price, 0, ',', '.') . "). Apakah stok masih tersedia?");
                $shareUrl = route('katalog.show', $product->id);
            @endphp
            <a href="https://wa.me/628567354046?text={{ $waText }}" target="_blank" class="flex-grow bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold py-1.5 rounded-md text-[11px] transition-colors flex justify-center items-center gap-1 shadow-sm">
                <i class='bx bxl-whatsapp text-sm'></i> Hubungi Admin
            </a>
            <button type="button" onclick="shareProduct('{{ $shareUrl }}')" class="flex-none w-8 flex justify-center items-center bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200 rounded-md transition-colors shadow-sm" title="Bagikan Produk">
                <i class='bx bx-share-alt text-sm'></i>
            </button>
        </div>
    </div>
    
</div>
