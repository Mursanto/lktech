@props(['product'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col group relative min-w-0 sm:min-w-[150px] h-full">
    
    <!-- Clickable Area to Detail Page -->
    <a href="{{ route('katalog.show', $product->id) }}" class="flex flex-col flex-grow cursor-pointer">
        <!-- Image Area — Full Bleed -->
        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
            <img src="{{ $product->display_image ?: asset('images/LKtech.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/LKtech.png') }}';" alt="{{ $product->brand }} {{ $product->model_series }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            
            <!-- Badges Area (top-right) -->
            <div class="absolute top-1.5 right-1.5 flex flex-col gap-1 items-end">
                {{-- Badge Stok Tersedia / Habis --}}
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
        <div class="px-2 pt-2 pb-1 flex flex-col flex-grow">
            <!-- Brand & Model -->
            <h3 class="text-[11px] sm:text-xs font-semibold text-gray-800 line-clamp-2 leading-snug mb-1 group-hover:text-brand-600 transition-colors" title="{{ $product->brand }} {{ $product->model_series }}">
                {{ $product->brand }} {{ $product->model_series }}
            </h3>

            <!-- Price -->
            <div class="flex items-start gap-0.5 mb-1" title="Rp {{ number_format($product->selling_price, 0, ',', '.') }}">
                <span class="text-[9px] sm:text-[10px] font-bold text-emerald-500 mt-0.5">Rp</span>
                <span class="text-emerald-600 font-extrabold text-xs sm:text-sm leading-none">{{ number_format($product->selling_price, 0, ',', '.') }}</span>
            </div>

            <!-- Specs List (Compact) / Conditional Rendering -->
            @php
                $hasValidProcessor = !empty($product->processor) && !in_array(strtolower(trim($product->processor)), ['-', 'n/a', 'none', 'na', '']);
                $hasValidRam = !empty($product->ram) && !in_array(strtolower(trim($product->ram)), ['-', 'n/a', 'none', 'na', '']);
                $hasValidStorage = !empty($product->storage) && !in_array(strtolower(trim($product->storage)), ['-', 'n/a', 'none', 'na', '']);
                $showSpecs = $hasValidProcessor || $hasValidRam || $hasValidStorage;
            @endphp

            @if($showSpecs)
            <div class="text-[9px] text-gray-500 flex flex-wrap gap-x-1.5 gap-y-0.5 leading-tight flex-grow">
                @if($hasValidProcessor)<span class="flex items-center gap-0.5 whitespace-nowrap"><i class='bx bx-chip'></i>{{ $product->processor }}</span>@endif
                @if($hasValidRam)<span class="flex items-center gap-0.5 whitespace-nowrap"><i class='bx bx-memory-card'></i>{{ $product->ram }}</span>@endif
                @if($hasValidStorage)<span class="flex items-center gap-0.5 whitespace-nowrap"><i class='bx bx-hdd'></i>{{ $product->storage }}</span>@endif
            </div>
            @else
            <div class="text-[9px] text-gray-400 leading-tight flex-grow line-clamp-2">
                {{ $product->description ? Str::limit(strip_tags($product->description), 45) : 'Produk ' . ($product->category ? $product->category->name : 'berkualitas') . '.' }}
            </div>
            @endif
        </div>
    </a>

    <!-- Action Button Container at Bottom -->
    <div class="px-2 pb-2 pt-1 mt-auto" x-data="{
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
