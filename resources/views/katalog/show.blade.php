<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->brand }} {{ $product->model_series }} - Katalog LKTech</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Tailwind CSS & Alpine.js -->
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
        /* Prose styles for Quill output */
        .prose h1, .prose h2, .prose h3 { font-weight: 700; color: #1f2937; margin-top: 1.5em; margin-bottom: 0.5em; }
        .prose p { margin-bottom: 1em; color: #4b5563; line-height: 1.6; }
        .prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1em; color: #4b5563; }
        .prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1em; color: #4b5563; }
        
        /* Interactive Image Zoom */
        .zoom-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
            cursor: zoom-in;
        }
        .zoom-image {
            transition: transform 0.3s ease;
        }
        .zoom-container:hover .zoom-image {
            transform: scale(1.5);
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header (Simple Tokopedia Style) -->

    <x-navbar />

    <!-- Main Product Layout (Tokopedia Style 3 Columns) -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-4" x-data="{
        images: {{ json_encode($product->all_images) }},
        currentIndex: 0,
        get activeImage() { return this.images[this.currentIndex]; },
        zoomActive: false,
        zoomX: 50,
        zoomY: 50,
        prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length; },
        next() { this.currentIndex = (this.currentIndex + 1) % this.images.length; },
        goTo(idx) { this.currentIndex = idx; },
        updateZoom(e) {
            const rect = e.target.getBoundingClientRect();
            this.zoomX = ((e.clientX - rect.left) / rect.width) * 100;
            this.zoomY = ((e.clientY - rect.top) / rect.height) * 100;
        }
    }" @keydown.arrow-left.window="prev()" @keydown.arrow-right.window="next()">
        
        <!-- Breadcrumb Navigasi (Posisi Kiri) -->
        <nav aria-label="breadcrumb" class="mb-4 sm:mb-6">
            <ol class="flex items-center text-[13px] sm:text-sm text-gray-500 font-medium overflow-x-auto whitespace-nowrap scrollbar-hide pb-1" style="scrollbar-width: none; -ms-overflow-style: none;">
                <li class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1 hover:text-brand-600 hover:underline transition-colors">
                        <i class="bx bx-home-alt"></i> Home
                    </a>
                </li>
                <li class="flex items-center shrink-0">
                    <span class="mx-2 text-gray-400 text-lg leading-none">›</span>
                    <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 hover:underline transition-colors">Katalog</a>
                </li>
                <li class="flex items-center shrink-0">
                    <span class="mx-2 text-gray-400 text-lg leading-none">›</span>
                    <span class="text-gray-800 font-semibold truncate max-w-[150px] sm:max-w-[250px]" aria-current="page">{{ $product->brand }} {{ $product->model_series }}</span>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            
            <!-- 1. Left: Gallery Column -->
            <div class="w-full lg:w-[320px] xl:w-[360px] flex-shrink-0 flex flex-col gap-4">
                
                <!-- Main Sticky Wrapper to keep images in view while scrolling description -->
                <div class="sticky top-24">

                    <!-- ─── Main Image + Prev/Next Arrows ─── -->
                    <div class="relative group">

                        <!-- Main Image -->
                        <div class="zoom-container w-full aspect-square bg-white border border-gray-200 mb-3 rounded-xl"
                             @mousemove="updateZoom"
                             @mouseenter="zoomActive = true"
                             @mouseleave="zoomActive = false">
                            <img :src="activeImage"
                                 alt="{{ $product->brand }} {{ $product->model_series }}"
                                 class="absolute inset-0 w-full h-full object-contain p-4 zoom-image bg-white transition-opacity duration-300"
                                 :style="zoomActive ? `transform-origin: ${zoomX}% ${zoomY}%` : 'transform-origin: center center'"
                                 x-on:error="$event.target.src = 'https://placehold.co/400x400/f3f4f6/9ca3af?text=No+Image'">
                        </div>

                        <!-- PREV Arrow -->
                        <button @click="prev()"
                                x-show="images.length > 1"
                                class="absolute left-2 top-1/2 -translate-y-1/2 z-10
                                       w-9 h-9 flex items-center justify-center
                                       bg-white/90 hover:bg-white
                                       shadow-md rounded-full border border-gray-200
                                       text-gray-600 hover:text-brand-600
                                       opacity-0 group-hover:opacity-100
                                       transition-all duration-200 cursor-pointer
                                       focus:outline-none focus:ring-2 focus:ring-brand-400"
                                style="margin-top: -1.5rem;"
                                title="Foto sebelumnya">
                            <i class="bx bx-chevron-left text-xl"></i>
                        </button>

                        <!-- NEXT Arrow -->
                        <button @click="next()"
                                x-show="images.length > 1"
                                class="absolute right-2 top-1/2 -translate-y-1/2 z-10
                                       w-9 h-9 flex items-center justify-center
                                       bg-white/90 hover:bg-white
                                       shadow-md rounded-full border border-gray-200
                                       text-gray-600 hover:text-brand-600
                                       opacity-0 group-hover:opacity-100
                                       transition-all duration-200 cursor-pointer
                                       focus:outline-none focus:ring-2 focus:ring-brand-400"
                                style="margin-top: -1.5rem;"
                                title="Foto selanjutnya">
                            <i class="bx bx-chevron-right text-xl"></i>
                        </button>

                        <!-- Image Counter Badge -->
                        <div x-show="images.length > 1"
                             class="absolute bottom-4 right-4 bg-black/50 text-white text-xs font-semibold
                                    px-2 py-0.5 rounded-full pointer-events-none">
                            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                        </div>
                    </div>

                    <!-- ─── Thumbnails Row ─── -->
                    <div class="flex gap-2 overflow-x-auto pb-1 pt-1 scrollbar-hide">
                        @foreach($product->all_images as $idx => $img)
                            <button @click="goTo({{ $idx }})"
                                    class="relative w-16 h-16 xl:w-[70px] xl:h-[70px] flex-shrink-0 rounded-lg overflow-hidden border-2 transition-all duration-200 bg-white"
                                    :class="currentIndex === {{ $idx }} ? 'border-brand-500 ring-2 ring-brand-200 scale-105' : 'border-gray-200 hover:border-brand-300'"
                                    title="Foto {{ $idx + 1 }}">
                                <img src="{{ $img }}"
                                     class="absolute inset-0 w-full h-full object-contain p-1"
                                     x-on:error="$event.target.src = 'https://placehold.co/80x80/f3f4f6/9ca3af?text=?'">
                            </button>
                        @endforeach
                    </div>

                    <!-- Keyboard hint -->
                    <p class="text-center text-[10px] text-gray-400 mt-2" x-show="images.length > 1">
                        <i class="bx bx-keyboard"></i> Gunakan tombol ← → untuk navigasi foto
                    </p>

                </div>
            </div>

            <!-- 2. Middle: Info & Description Column -->
            <div class="flex-1 min-w-0 pb-12">
                <!-- Title -->
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-2">
                    {{ $product->brand }} {{ $product->model_series }}
                </h1>
                
                <!-- Stats Row -->
                <div class="flex items-center gap-4 text-sm text-gray-600 mb-4 pb-4 border-b border-gray-200">
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-gray-800">Kondisi:</span>
                        <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-700 font-medium">{{ $product->condition ?: 'Bekas' }}</span>
                    </div>
                    <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-gray-800">Kategori:</span>
                        <span>{{ $product->category ? $product->category->name : 'Laptop' }}</span>
                    </div>
                </div>

                <!-- Price (Mobile Only, hidden on Desktop since Desktop has right box) -->
                <div class="lg:hidden mb-6 pb-6 border-b border-gray-200">
                    <div class="text-3xl font-extrabold text-gray-900">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Description / Specifications -->
                <div class="mt-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-3 border-l-4 border-brand-500 pl-3">Spesifikasi & Detail Produk</h2>
                    
                    @if($product->description)
                        <div class="prose max-w-none text-sm text-gray-700">
                            {!! $product->description !!}
                        </div>
                    @else
                        <!-- Fallback Spec Output -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm text-gray-700 mb-8">
                            <div class="flex flex-col border-b border-gray-100 pb-2">
                                <span class="text-xs text-gray-400 font-semibold mb-1 uppercase tracking-wider">Processor</span>
                                <span class="font-medium">{{ $product->processor ?: 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col border-b border-gray-100 pb-2">
                                <span class="text-xs text-gray-400 font-semibold mb-1 uppercase tracking-wider">RAM</span>
                                <span class="font-medium">{{ $product->ram ?: 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col border-b border-gray-100 pb-2">
                                <span class="text-xs text-gray-400 font-semibold mb-1 uppercase tracking-wider">Penyimpanan</span>
                                <span class="font-medium">{{ $product->storage ?: 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col border-b border-gray-100 pb-2">
                                <span class="text-xs text-gray-400 font-semibold mb-1 uppercase tracking-wider">Layar</span>
                                <span class="font-medium">{{ $product->screen_size ? $product->screen_size . ' Inch' : 'N/A' }}</span>
                            </div>
                            <div class="flex flex-col border-b border-gray-100 pb-2">
                                <span class="text-xs text-gray-400 font-semibold mb-1 uppercase tracking-wider">Daya Tahan Baterai</span>
                                <span class="font-medium">±{{ $product->battery_runtime ?: 'N/A' }} Jam</span>
                            </div>
                        </div>
                        <p class="text-gray-500 italic text-sm bg-gray-50 p-3 rounded-lg mb-4">Admin belum menuliskan deskripsi panjang untuk unit ini. Namun, spesifikasi di atas sudah tervalidasi.</p>
                    @endif
                </div>

            </div>

            <!-- 3. Right: Sticky Action Box (Tokopedia Style "Atur Jumlah & Catatan") -->
            <div class="w-full lg:w-[280px] xl:w-[320px] flex-shrink-0">
                <div class="sticky top-24 border border-gray-200 rounded-2xl p-5 shadow-lg shadow-gray-100/50 bg-white">
                    <h3 class="font-bold text-gray-800 mb-4 text-lg">Transaksi</h3>
                    
                    <div class="mb-5 pb-5 border-b border-gray-100">
                        <span class="text-gray-500 text-xs font-semibold uppercase tracking-widest block mb-1">Harga Unit</span>
                        <div class="text-2xl xl:text-3xl font-black text-gray-900 tracking-tight">
                            Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 font-medium">Status Stok:</span>
                            @if($product->stock > 0 && $product->status !== 'Sold')
                                <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-1 rounded-md border border-emerald-200 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Sisa {{ $product->stock }} unit
                                </span>
                            @else
                                <span class="text-red-700 font-bold bg-red-50 px-2 py-1 rounded-md border border-red-200 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Kosong / Terjual
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-3" x-data="{
                        adding: false,
                        buyingNow: false,
                        addToCart(productId, buyNow = false) {
                            if(buyNow) this.buyingNow = true; else this.adding = true;
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
                                if(buyNow) this.buyingNow = false; else this.adding = false;
                                if(data.success) {
                                    if(buyNow) {
                                        window.location.href = '/checkout';
                                    } else {
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
                                }
                            })
                            .catch(err => {
                                if(buyNow) this.buyingNow = false; else this.adding = false;
                                alert('Kesalahan koneksi sistem.');
                            });
                        }
                    }">
                        @if($product->stock > 0 && $product->status !== 'Sold')
                            @if($product->status == 'Pre-Order')
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button @click="addToCart({{ $product->id }}, true)" :disabled="adding || buyingNow" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-3 rounded-lg text-sm transition-all shadow-sm flex justify-center items-center gap-1.5">
                                        <span x-text="buyingNow ? 'Memproses...' : 'Beli Sekarang'"></span>
                                    </button>
                                    <button @click="addToCart({{ $product->id }}, false)" :disabled="adding || buyingNow" class="flex-1 bg-white hover:bg-gray-50 text-orange-500 border border-orange-500 font-bold py-2.5 px-3 rounded-lg text-sm transition-all flex justify-center items-center gap-1.5 shadow-sm">
                                        <i class='bx bx-cart-add text-lg'></i> <span x-text="adding ? 'Memproses...' : '+ Keranjang'"></span>
                                    </button>
                                </div>
                                <p class="text-xs text-orange-600 font-medium leading-tight text-center">
                                    *Estimasi pengiriman Pre-Order ±7 hari.
                                </p>
                            @else
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button @click="addToCart({{ $product->id }}, true)" :disabled="adding || buyingNow" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-3 rounded-lg text-sm transition-all shadow-sm flex justify-center items-center gap-1.5">
                                        <span x-text="buyingNow ? 'Memproses...' : 'Beli Sekarang'"></span>
                                    </button>
                                    <button @click="addToCart({{ $product->id }}, false)" :disabled="adding || buyingNow" class="flex-1 bg-white hover:bg-gray-50 text-brand-600 border border-brand-600 font-bold py-2.5 px-3 rounded-lg text-sm transition-all flex justify-center items-center gap-1.5 shadow-sm">
                                        <i class='bx bx-cart-add text-lg'></i> <span x-text="adding ? 'Memproses...' : '+ Keranjang'"></span>
                                    </button>
                                </div>
                            @endif
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-3 px-4 rounded-xl cursor-not-allowed flex justify-center items-center gap-2">
                                Stok Habis
                            </button>
                        @endif

                        <div class="flex items-center justify-center gap-6 py-1 text-sm text-gray-500 font-medium">
                            <button type="button" onclick="alert('Fitur Wishlist akan segera hadir!')" class="flex items-center gap-1.5 hover:text-brand-600 transition-colors">
                                <i class='bx bx-heart text-lg'></i> Wishlist
                            </button>
                            <button type="button" @click.prevent="navigator.clipboard.writeText(window.location.href); alert('Tautan produk berhasil disalin!')" class="flex items-center gap-1.5 hover:text-brand-600 transition-colors">
                                <i class='bx bx-share-alt text-lg'></i> Bagikan
                            </button>
                        </div>

                        <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20tertarik%20dengan%20produk%20di%20Katalog%20Anda:%20{{ $product->brand }}%20{{ $product->model_series }}" target="_blank" 
                           class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 font-bold py-2.5 px-3 rounded-lg text-sm transition-colors flex justify-center items-center gap-2 shadow-sm">
                            <i class='bx bx-message-rounded-dots text-lg'></i> Tanya Admin
                        </a>
                    </div>
                    
                    <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400 font-medium bg-gray-50 py-2 rounded-lg">
                        <i class='bx bx-check-shield text-base text-emerald-500'></i> Transaksi Aman & Bergaransi
                    </div>

                    <!-- Trust Badge Section -->
                    <div class="mt-5 border-t border-gray-100 pt-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-shield-quarter text-lg'></i>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Lulus Quality Control</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-medal text-lg'></i>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Bergaransi Terpercaya</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-wrench text-lg'></i>
                            </div>
                            <span class="text-sm text-gray-700 font-medium">Layanan After-Sales</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Related Products / Cross-Selling Section -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section x-data class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 mb-4 mt-4 border-t border-gray-100">
        <div class="flex items-center justify-between mb-4 md:mb-6 gap-4 overflow-hidden">
            <h3 class="text-sm sm:text-lg font-medium text-gray-900 leading-snug truncate">
                Rekomendasi produk terkait
            </h3>
            
            <!-- Tombol Panah Navigasi Slider -->
            <div class="flex gap-2 shrink-0">
                <button type="button" id="btnSlideLeft" onclick="document.getElementById('productSlider').scrollBy({ left: -260, behavior: 'smooth' })" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-full shadow-sm transition-colors relative z-10" aria-label="Slide Kiri">
                    <i class="bx bx-chevron-left text-xl"></i>
                </button>
                <button type="button" id="btnSlideRight" onclick="document.getElementById('productSlider').scrollBy({ left: 260, behavior: 'smooth' })" class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 text-brand-600 hover:bg-brand-50 rounded-full shadow-sm transition-colors relative z-10" aria-label="Slide Kanan">
                    <i class="bx bx-chevron-right text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Horizontal Scrollable Container (Compact Cards) -->
        <div id="productSlider" class="flex overflow-x-auto gap-4 sm:gap-5 pb-4 snap-x scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            @foreach($relatedProducts as $rp)
                <div class="snap-start flex-shrink-0 w-[150px] sm:w-[180px] lg:w-[220px] bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition-shadow group flex flex-col relative">
                    
                    <!-- Foto Produk (1:1 Ratio) -->
                    <a href="{{ route('katalog.show', $rp->slug ?? $rp->id) }}" class="block relative aspect-square bg-white border-b border-gray-100 overflow-hidden">
                        <img src="{{ $rp->display_image }}" alt="{{ $rp->brand }} {{ $rp->model_series }}" class="absolute inset-0 w-full h-full object-contain p-3 group-hover:scale-105 transition-transform duration-300">
                    </a>

                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        <!-- Judul Produk -->
                        <a href="{{ route('katalog.show', $rp->slug ?? $rp->id) }}" class="font-semibold text-gray-800 text-xs sm:text-sm line-clamp-2 mb-2 group-hover:text-brand-600 transition-colors leading-snug" title="{{ $rp->brand }} {{ $rp->model_series }}">
                            {{ $rp->brand }} {{ $rp->model_series }}
                        </a>
                        
                        <div class="mt-auto pt-2">
                            <!-- Harga -->
                            <div class="font-bold text-gray-900 text-sm sm:text-base mb-3">
                                Rp {{ number_format($rp->selling_price, 0, ',', '.') }}
                            </div>

                            <!-- Tombol Aksi Cepat (+ Keranjang) -->
                            <div x-data="{
                                adding: false,
                                addRpCart() {
                                    this.adding = true;
                                    fetch('{{ route('cart.add') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({ product_id: {{ $rp->id }} })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        this.adding = false;
                                        if(data.success) {
                                            window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.cart_count }));
                                            const toast = document.createElement('div');
                                            toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 z-[9999] transform transition-all duration-300 translate-y-0 opacity-100 font-medium text-sm';
                                            toast.innerHTML = `<i class='bx bx-check-circle text-emerald-400 text-xl'></i> <span>Masuk Keranjang</span>`;
                                            document.body.appendChild(toast);
                                            setTimeout(() => {
                                                toast.classList.add('translate-y-10', 'opacity-0');
                                                setTimeout(() => toast.remove(), 300);
                                            }, 3000);
                                        }
                                    }).catch(() => { this.adding = false; });
                                }
                            }">
                                <button @click="addRpCart()" :disabled="adding" class="w-full bg-brand-50 hover:bg-brand-600 text-brand-700 hover:text-white border border-brand-200 font-bold py-1.5 sm:py-2 px-2 rounded-xl text-xs transition-all flex justify-center items-center gap-1 disabled:opacity-70 disabled:cursor-wait">
                                    <i class='bx bx-cart-add text-base'></i> <span x-text="adding ? '...' : '+ Keranjang'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <style>
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
        </style>
    </section>
    @endif


    <!-- Footer -->
    <x-footer />
    
</body>
</html>
