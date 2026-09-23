@props(['product'])
@php $isPromo = !empty($product->is_active_promo); @endphp

<div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col group relative min-w-0 sm:min-w-[150px] border-2 {{ $isPromo ? 'border-orange-500' : 'border-gray-200' }}">
    
    <!-- Clickable Area to Detail Page -->
    <a href="{{ route('katalog.show', $product->id) }}" class="flex flex-col cursor-pointer">
        <!-- Image & Video Area — Full Bleed -->
        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
            @if(!empty($product->video_url))
                <!-- Play Icon Badge -->
                <div class="absolute bottom-1.5 left-1.5 sm:bottom-2 sm:left-2 z-20 bg-black/60 backdrop-blur-sm text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center shadow-lg pointer-events-none">
                    <i class='bx bx-play text-xs sm:text-sm ml-0.5'></i>
                </div>
                
                <!-- Video Element (Lazy loaded via IntersectionObserver) -->
                <video 
                    class="absolute inset-0 w-full h-full object-cover z-10 transition-opacity duration-700 opacity-0 group-hover:opacity-100 product-video-preview"
                    muted loop playsinline preload="none" data-src="{{ $product->video_url }}">
                </video>
            @endif
            
            <img src="{{ $product->display_image ?: asset('images/LKtech.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/LKtech.png') }}';" alt="{{ $product->brand }} {{ $product->model_series }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 z-0">
            
            <!-- Badges Container -->
            <div class="absolute top-1.5 left-1.5 right-1.5 sm:top-2 sm:left-2 sm:right-2 flex justify-between items-start z-30 gap-1.5 pointer-events-none">
                {{-- Badge Views (Kiri Atas - Digeser jika ada video) --}}
                @php
                    // Menghasilkan start awal bervariasi antara 20 - 60 secara konsisten per produk
                    $baseViews = ($product->id * 17) % 41 + 20; 
                    $actualViews = $product->views_count ?? 0;
                    $totalViews = $baseViews + $actualViews;
                    $formattedViews = $totalViews >= 1000 ? round($totalViews/1000, 1) . 'k' : $totalViews;
                @endphp
                <div class="flex items-center gap-0.5 sm:gap-1 bg-gray-900/70 backdrop-blur-sm text-white px-1.5 sm:px-2 py-0.5 rounded-md text-[8px] sm:text-[9px] font-semibold shadow-sm border border-white/20 h-4 sm:h-5 shrink-0 pointer-events-auto overflow-hidden">
                    <i class='bx bx-show text-[9px] sm:text-[10px] shrink-0'></i> <span class="whitespace-nowrap">{{ $formattedViews }}</span>
                </div>

                <!-- Badges Area Status (Kanan Atas) -->
                <div class="flex flex-col gap-1 items-end shrink-0 pointer-events-auto">
                    {{-- Badge PROMO UTAMA --}}
                    @if($isPromo)
                    <div class="relative bg-gradient-to-r from-rose-500 via-red-500 to-amber-500 text-white px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[8px] sm:text-[10px] font-semibold shadow-sm flex items-center gap-0.5 sm:gap-1 group/badge overflow-hidden animate-[pulse_2s_ease-in-out_infinite] shrink-0">
                        <span class="animate-[bounce_2s_infinite]">🔥</span> <span class="whitespace-nowrap">Hot Promo</span>
                    </div>
                    @endif

                    {{-- Badge Stok Tersedia / Habis --}}
                    @if($product->stock <= 0 || $product->status === 'Sold')
                        <div class="bg-white/95 backdrop-blur-sm text-red-600 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[8px] sm:text-[10px] font-semibold shadow-sm border border-red-100 flex items-center gap-0.5 sm:gap-1 shrink-0 whitespace-nowrap">
                            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-red-500 shrink-0"></span> Terjual Habis
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Details -->
        <div class="px-1.5 pt-1.5 pb-1.5 sm:px-2 sm:pt-2 sm:pb-2 flex flex-col">
            <!-- Brand & Model -->
            <h3 class="text-[11px] sm:text-xs font-semibold text-gray-800 truncate leading-snug mb-0.5 group-hover:text-brand-600 transition-colors" title="{{ $product->brand }} {{ $product->model_series }}">
                {{ $product->brand }} {{ $product->model_series }}
            </h3>

            <!-- Price -->
            <div class="flex items-baseline gap-0.5 mb-1" title="Rp {{ number_format($product->selling_price, 0, ',', '.') }}">
                <span class="text-[9px] font-bold text-emerald-500">Rp</span>
                <span class="text-emerald-600 font-extrabold text-xs sm:text-sm leading-none">{{ number_format($product->selling_price, 0, ',', '.') }}</span>
            </div>

            <!-- Specs List (Compact) / Conditional Rendering -->
            @php
                $hasValidProcessor = !empty($product->processor) && !in_array(strtolower(trim($product->processor)), ['-', 'n/a', 'none', 'na', '']);
                $hasValidRam = !empty($product->ram) && !in_array(strtolower(trim($product->ram)), ['-', 'n/a', 'none', 'na', '']);
                $hasValidStorage = !empty($product->storage) && !in_array(strtolower(trim($product->storage)), ['-', 'n/a', 'none', 'na', '']);
                $hasValidScreen = !empty($product->screen_size) && $product->screen_size > 0;
                $showSpecs = $hasValidProcessor || $hasValidRam || $hasValidStorage;
            @endphp

            @if($showSpecs)
            <div class="text-[10px] text-gray-500 leading-snug line-clamp-2 overflow-hidden">
                @if($hasValidProcessor)<span class="inline-flex items-center gap-0.5 mr-1.5"><i class='bx bx-chip text-[9px]'></i>{{ $product->processor }}</span>@endif
                @if($hasValidRam)<span class="inline-flex items-center gap-0.5 mr-1.5"><i class='bx bx-memory-card text-[9px]'></i>{{ $product->ram }}</span>@endif
                @if($hasValidStorage)<span class="inline-flex items-center gap-0.5 mr-1.5"><i class='bx bx-hdd text-[9px]'></i>{{ $product->storage }}</span>@endif
                @if($hasValidScreen)<span class="inline-flex items-center gap-0.5"><i class='bx bx-desktop text-[9px]'></i>{{ $product->screen_size }}"</span>@endif
            </div>
            @else
            <div class="text-[10px] text-gray-400 leading-snug line-clamp-2">
                {{ $product->description ? Str::limit(strip_tags($product->description), 55) : ($product->category ? $product->category->name : 'Produk berkualitas') . '.' }}
            </div>
            @endif
        </div>
    </a>

    <!-- Action Button Container at Bottom -->
    <div class="px-1.5 pb-1.5 pt-1 sm:px-2 sm:pb-2" x-data="{
        adding: false,
        addToCart(productId) {
            this.adding = true;
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                this.adding = false;
                if(data.success) {
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart_count }));
                    
                    const toast = document.createElement('div');
                    toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-50 transform transition-all duration-300 translate-y-0 opacity-100 font-medium text-sm';
                    toast.innerHTML = `<i class='bx bx-check-circle text-emerald-400 text-xl'></i> <span>Berhasil ditambahkan ke keranjang</span>`;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.classList.add('translate-y-10', 'opacity-0');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                }
            })
            .catch(err => {
                this.adding = false;
                alert('Kesalahan koneksi sistem.');
            });
        }
    }">
        <div class="border-t border-gray-100 pt-1.5 flex gap-1">
            @php
                $shareUrl = route('katalog.show', $product->id);
                $isPreOrder = ($product->tipe_stok ?? 'ready_stock') === 'open_order' || $product->status === 'Pre-Order';
                $isSold = $product->stock <= 0 || $product->status === 'Sold';
            @endphp
            
            @if(!$isSold)
                @if($isPreOrder)
                    <button @click.prevent="addToCart({{ $product->id }})" :disabled="adding" class="flex-1 min-w-0 px-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 rounded text-[10px] transition-colors flex justify-center items-center gap-0.5 shadow-sm disabled:opacity-75">
                        <i class='bx bx-cart-add text-xs shrink-0'></i> <span class="truncate" x-text="adding ? 'Proses' : 'Pre-Order'"></span>
                    </button>
                @else
                    <button @click.prevent="addToCart({{ $product->id }})" :disabled="adding" class="flex-1 min-w-0 px-1 bg-brand-600 hover:bg-brand-700 text-white font-bold py-1 rounded text-[10px] transition-colors flex justify-center items-center gap-0.5 shadow-sm disabled:opacity-75">
                        <i class='bx bx-cart-add text-xs shrink-0'></i> <span class="truncate" x-text="adding ? 'Proses' : 'Keranjang'"></span>
                    </button>
                @endif
            @else
                <button disabled class="flex-1 min-w-0 px-1 bg-gray-200 text-gray-400 font-bold py-1 rounded text-[10px] flex justify-center items-center gap-0.5 cursor-not-allowed">
                    <span class="truncate">Stok Habis</span>
                </button>
            @endif

            <button type="button" @click.prevent="shareProduct('{{ $shareUrl }}')" class="flex-none shrink-0 w-7 flex justify-center items-center bg-gray-50 hover:bg-gray-100 text-gray-500 border border-gray-200 rounded transition-colors shadow-sm" title="Bagikan Produk">
                <i class='bx bx-share-alt text-xs'></i>
            </button>
        </div>
    </div>
    
</div>
