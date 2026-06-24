@props(['product'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col group relative min-w-[160px] h-full">
    
    <!-- Clickable Area to Detail Page -->
    <a href="{{ route('katalog.show', $product->id) }}" class="flex flex-col flex-grow cursor-pointer">
        <!-- Image Area -->
        <div class="relative w-full h-40 md:h-48 bg-gray-100 overflow-hidden border-b border-gray-100">
            <img src="{{ $product->display_image }}" alt="{{ $product->brand }} {{ $product->model_series }}" loading="lazy" class="w-full h-full object-cover bg-white p-2 group-hover:scale-105 transition-transform duration-500">
            
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

                {{-- Removed Top-Right Pre-Order Badge to avoid duplication --}}
            </div>

            {{-- Label Tipe Stok di kiri bawah gambar --}}
            @if(($product->tipe_stok ?? 'ready_stock') === 'ready_stock')
                <div class="absolute bottom-1.5 left-1.5">
                    <span class="bg-emerald-500/90 backdrop-blur text-white px-1.5 py-0.5 rounded text-[9px] font-bold shadow-sm">
                        ✓ Ready Stock
                    </span>
                </div>
            @else
                <div class="absolute bottom-1.5 left-1.5">
                    <span class="bg-orange-400/90 backdrop-blur text-white px-1.5 py-0.5 rounded text-[9px] font-bold shadow-sm">
                        ⏱ Open Order
                    </span>
                </div>
            @endif
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
    <div class="p-1.5 sm:p-2 pt-0 mt-auto" x-data="{
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
        <div class="pt-2 border-t border-gray-100 flex gap-1.5">
            @php
                $shareUrl = route('katalog.show', $product->id);
                $isPreOrder = ($product->tipe_stok ?? 'ready_stock') === 'open_order' || $product->status === 'Pre-Order';
                $isSold = $product->stock <= 0 || $product->status === 'Sold';
            @endphp
            
            @if(!$isSold)
                @if($isPreOrder)
                    <button @click.prevent="addToCart({{ $product->id }})" :disabled="adding" class="flex-grow bg-orange-500 hover:bg-orange-600 text-white font-bold py-1.5 rounded-md text-[11px] transition-colors flex justify-center items-center gap-1 shadow-sm disabled:opacity-75">
                        <i class='bx bx-cart-add text-sm'></i> <span x-text="adding ? 'Proses...' : 'Pre-Order'"></span>
                    </button>
                @else
                    <button @click.prevent="addToCart({{ $product->id }})" :disabled="adding" class="flex-grow bg-brand-600 hover:bg-brand-700 text-white font-bold py-1.5 rounded-md text-[11px] transition-colors flex justify-center items-center gap-1 shadow-sm disabled:opacity-75">
                        <i class='bx bx-cart-add text-sm'></i> <span x-text="adding ? 'Proses...' : '+ Keranjang'"></span>
                    </button>
                @endif
            @else
                <button disabled class="flex-grow bg-gray-300 text-gray-500 font-bold py-1.5 rounded-md text-[11px] flex justify-center items-center gap-1 cursor-not-allowed">
                    Stok Habis
                </button>
            @endif

            <button type="button" @click.prevent="shareProduct('{{ $shareUrl }}')" class="flex-none w-8 flex justify-center items-center bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200 rounded-md transition-colors shadow-sm" title="Bagikan Produk">
                <i class='bx bx-share-alt text-sm'></i>
            </button>
        </div>
    </div>
    
</div>
