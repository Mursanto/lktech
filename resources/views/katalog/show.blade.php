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

    <!-- Fancybox v5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css"/>
    
    <!-- Tailwind CSS & Alpine.js -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
        [x-cloak] { display: none !important; }
        /* Prose styles for Quill output */
        .prose h1, .prose h2, .prose h3 { font-weight: 700; color: #1f2937; margin-top: 1em; margin-bottom: 0.3em; }
        .prose p { margin-bottom: 0.5em; color: #4b5563; line-height: 1.5; }
        .prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 0.5em; color: #4b5563; }
        .prose ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 0.5em; color: #4b5563; }
        @media (max-width: 639px) {
            .prose p { font-size: 0.8rem; line-height: 1.4; margin-bottom: 0.3em; }
            .prose ul, .prose ol { font-size: 0.8rem; margin-bottom: 0.3em; }
            .prose h1, .prose h2, .prose h3 { margin-top: 0.5em; margin-bottom: 0.2em; font-size: 0.9rem; }
        }

        /* ─── Main Image Container ─── */
        .zoom-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
            cursor: zoom-in;          /* tetap zoom-in cursor agar user tahu bisa diklik */
        }
        /* Hilangkan hover-scale lama; Fancybox akan handle zoom fullscreen */
        .zoom-image {
            transition: transform 0.3s ease;
        }

        /* Gentle brightness lift on hover → hint that image is clickable */
        .fancybox-main-link:hover .zoom-image {
            transform: scale(1.03);
            filter: brightness(1.04);
        }

        /* ─── Fancybox Overrides ─── */
        /* Thumbnail strip di bawah Fancybox */
        .fancybox__thumbs .carousel__slide .f-thumbs__slide__button {
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            transition: border-color 0.2s;
        }
        .fancybox__thumbs .carousel__slide.is-selected .f-thumbs__slide__button {
            border-color: #3b82f6;
        }

        /* Pastikan container gambar tidak overflow ke bawah thumbnail lokal */
        .gallery-main-wrap {
            position: relative;
        }

        /* ─── Fancybox Mobile Tweaks ─── */
        @media (max-width: 639px) {
            .f-button {
                width: 32px !important;
                height: 32px !important;
            }
            .f-button svg {
                width: 18px !important;
                height: 18px !important;
            }
            .fancybox__toolbar {
                padding: 4px !important;
            }
            .fancybox__toolbar__items {
                gap: 2px !important;
            }
        }
    </style>
</head>
<body class="font-sans bg-white text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Header (Simple Tokopedia Style) -->

    <x-navbar />

    <!-- Main Product Layout (Tokopedia Style 3 Columns / Mobile Optimized) -->
    <div x-data="{
        images: {{ json_encode($product->all_images) }},
        currentIndex: 0,
        get activeImage() { return this.images[this.currentIndex]; },
        zoomActive: false,
        prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length; },
        next() { this.currentIndex = (this.currentIndex + 1) % this.images.length; },
        goTo(idx) { this.currentIndex = idx; },
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
                        toast.className = 'fixed bottom-32 sm:bottom-24 right-4 bg-gray-900 text-white px-5 py-2.5 rounded-xl shadow-2xl flex items-center gap-2.5 z-50 transform transition-all duration-300 translate-y-0 opacity-100 font-medium text-xs sm:text-sm';
                        toast.innerHTML = `<i class='bx bx-check-circle text-emerald-400 text-lg'></i> <span>Berhasil ditambahkan ke keranjang</span>`;
                        document.body.appendChild(toast);
                        
                        setTimeout(() => {
                            toast.classList.add('translate-y-6', 'opacity-0');
                            setTimeout(() => toast.remove(), 300);
                        }, 2500);
                    }
                }
            })
            .catch(err => {
                if(buyNow) this.buyingNow = false; else this.adding = false;
                alert('Kesalahan koneksi sistem.');
            });
        }
    }" @keydown.arrow-left.window="prev()" @keydown.arrow-right.window="next()">
        
        <main class="flex-grow max-w-7xl mx-auto w-full px-2 sm:px-6 lg:px-8 py-1.5 sm:py-4">
            
            <!-- Breadcrumb Navigasi Compact -->
            <nav aria-label="breadcrumb" class="mb-1.5 sm:mb-3">
                <ol class="flex items-center text-[10px] sm:text-xs text-gray-500 font-medium overflow-x-auto whitespace-nowrap scrollbar-hide py-0.5" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <li class="flex items-center shrink-0">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 hover:text-brand-600 transition-colors">
                            <i class="bx bx-home-alt"></i> Home
                        </a>
                    </li>
                    <li class="flex items-center shrink-0">
                        <span class="mx-1.5 text-gray-300 text-xs">›</span>
                        <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors">Katalog</a>
                    </li>
                    <li class="flex items-center shrink-0">
                        <span class="mx-1.5 text-gray-300 text-xs">›</span>
                        <span class="text-gray-800 font-semibold truncate max-w-[140px] sm:max-w-[220px]" aria-current="page">{{ $product->brand }} {{ $product->model_series }}</span>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row gap-2.5 sm:gap-6 lg:gap-8">
                
                <!-- 1. Left: Gallery Column (Compressed Image & Thumbnails) -->
                <div class="w-full lg:w-[320px] xl:w-[360px] flex-shrink-0 flex flex-col gap-1.5 sm:gap-3">
                    
                    <div class="sticky top-20">

                        <!-- ─── Main Image + Prev/Next Arrows ─── -->
                        <div class="relative group gallery-main-wrap">

                            {{-- Fancybox Hidden Gallery Links --}}
                            <div id="fancybox-gallery-source" class="hidden">
                                @foreach($product->all_images as $idx => $img)
                                    <a href="{{ $img }}"
                                       data-fancybox="product-gallery"
                                       data-caption="{{ $product->brand }} {{ $product->model_series }} &mdash; Foto {{ $idx + 1 }} / {{ count($product->all_images) }}"
                                       id="fancybox-item-{{ $idx }}"
                                       aria-label="Buka foto {{ $idx + 1 }} fullscreen"
                                    ></a>
                                @endforeach
                            </div>

                            <!-- Main Image: max-h 280px & 4:3 ratio on mobile -->
                            <div class="zoom-container w-full h-[230px] sm:h-[280px] lg:h-[340px] max-h-[280px] lg:max-h-none aspect-[4/3] lg:aspect-square bg-white border border-gray-200 mb-1.5 rounded-lg sm:rounded-xl fancybox-main-link relative overflow-hidden"
                                 @click="document.getElementById('fancybox-item-' + currentIndex).click()"
                                 @mouseenter="zoomActive = true"
                                 @mouseleave="zoomActive = false"
                                 title="Klik untuk memperbesar foto"
                                 role="button"
                                 tabindex="0"
                                 @keydown.enter="document.getElementById('fancybox-item-' + currentIndex).click()"
                                 aria-label="Klik untuk membuka galeri foto fullscreen">
                                
                                <img :src="activeImage"
                                     alt="{{ $product->brand }} {{ $product->model_series }}"
                                     class="absolute inset-0 w-full h-full object-contain p-1.5 zoom-image bg-white transition-all duration-300"
                                     x-on:error="$event.target.src = 'https://placehold.co/400x300/f3f4f6/9ca3af?text=No+Image'">

                                <!-- Zoom Hint Icon di Kiri Atas (Menggantikan Teks Redundan) -->
                                <div class="absolute top-2 left-2 z-20 bg-black/40 backdrop-blur-sm text-white rounded-full w-6 h-6 flex items-center justify-center pointer-events-none shadow-sm" title="Klik untuk memperbesar">
                                    <i class="bx bx-search-alt text-xs"></i>
                                </div>

                                <!-- Image Counter Badge (Bottom Center) -->
                                <div x-show="images.length > 1"
                                     class="absolute bottom-2 left-1/2 -translate-x-1/2 z-20 bg-black/50 text-white text-[10px] sm:text-xs font-semibold
                                            px-2 sm:px-2.5 py-0.5 rounded-full pointer-events-none shadow-sm backdrop-blur-sm">
                                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                                </div>
                                
                                <!-- Status Badge (Top Right) -->
                                @php
                                    $isPreOrder = ($product->tipe_stok ?? 'ready_stock') === 'open_order' || $product->status === 'Pre-Order';
                                    $isHabis = $product->stock <= 0 || $product->status === 'Sold';
                                @endphp
                                <div class="absolute top-2 right-2 z-20 pointer-events-none">
                                    @if($isHabis)
                                    <div class="bg-red-600 text-white px-[10px] py-[4px] rounded-[6px] text-[10px] font-semibold shadow-sm flex items-center gap-1 whitespace-nowrap">
                                        <i class='bx bx-x-circle text-[11px]'></i> <span>Habis</span>
                                    </div>
                                    @elseif($isPreOrder)
                                    <div class="bg-[#374151] text-white px-[10px] py-[4px] rounded-[6px] text-[10px] font-semibold shadow-sm flex items-center gap-1 whitespace-nowrap">
                                        <i class='bx bx-time-five text-[11px]'></i> <span>Pre-Order ({{ $product->stock }})</span>
                                    </div>
                                    @else
                                    <div class="bg-[#16A34A] text-white px-[10px] py-[4px] rounded-[6px] text-[10px] font-semibold shadow-sm flex items-center gap-1 whitespace-nowrap">
                                        <i class='bx bx-check-circle text-[11px]'></i> <span>Ready Stock ({{ $product->stock }})</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- PREV Arrow -->
                            <button @click.stop="prev()"
                                    x-show="images.length > 1"
                                    class="absolute left-1.5 top-1/2 -translate-y-1/2 z-10
                                           w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center
                                           bg-white/90 hover:bg-white
                                           shadow-md rounded-full border border-gray-200
                                           text-gray-600 hover:text-brand-600
                                           opacity-0 group-hover:opacity-100
                                           transition-all duration-200 cursor-pointer
                                           focus:outline-none"
                                    title="Foto sebelumnya">
                                <i class="bx bx-chevron-left text-lg"></i>
                            </button>

                            <!-- NEXT Arrow -->
                            <button @click.stop="next()"
                                    x-show="images.length > 1"
                                    class="absolute right-1.5 top-1/2 -translate-y-1/2 z-10
                                           w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center
                                           bg-white/90 hover:bg-white
                                           shadow-md rounded-full border border-gray-200
                                           text-gray-600 hover:text-brand-600
                                           opacity-0 group-hover:opacity-100
                                           transition-all duration-200 cursor-pointer
                                           focus:outline-none"
                                    title="Foto selanjutnya">
                                <i class="bx bx-chevron-right text-lg"></i>
                            </button>
                        </div>

                        <!-- ─── Thumbnails Row (40x40px, border-radius 4px) ─── -->
                        <div class="flex gap-1.5 overflow-x-auto pb-0.5 pt-0.5 scrollbar-hide">
                            @foreach($product->all_images as $idx => $img)
                                <button @click.stop="goTo({{ $idx }}); document.getElementById('fancybox-item-{{ $idx }}').click()"
                                        class="relative w-10 h-10 flex-shrink-0 rounded-[4px] overflow-hidden border-2 transition-all duration-200 bg-white cursor-zoom-in p-0.5"
                                        :class="currentIndex === {{ $idx }} ? 'border-brand-600 ring-1 ring-brand-300 scale-105' : 'border-gray-200 hover:border-brand-300'"
                                        title="Buka foto {{ $idx + 1 }} fullscreen">
                                    <img src="{{ $img }}"
                                         class="absolute inset-0 w-full h-full object-contain p-0.5"
                                         x-on:error="$event.target.src = 'https://placehold.co/40x40/f3f4f6/9ca3af?text=?'">
                                </button>
                            @endforeach
                        </div>

                        <!-- Keyboard hint (desktop only) -->
                        <p class="text-center text-[10px] text-gray-400 mt-1 hidden sm:block" x-show="images.length > 1">
                            <i class="bx bx-keyboard"></i> Navigasi foto ← →
                        </p>

                        <!-- ─── Video Preview Section ─── -->
                        @php
                            $videoSrc = null;
                            $isYoutube = false;
                            if (!empty($product->video_path)) {
                                // Path stored without 'public/' prefix → use Storage::url() or asset('storage/...')
                                $vp = $product->video_path;
                                // Support legacy paths that still have 'public/' prefix
                                if (str_starts_with($vp, 'public/')) {
                                    $vp = substr($vp, 7); // strip 'public/'
                                }
                                $videoSrc = asset('storage/' . $vp);
                            } elseif (!empty($product->video_url)) {
                                // Convert YouTube watch URL → embed URL
                                $yt = $product->video_url;
                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $yt, $m)) {
                                    $videoSrc = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&rel=0';
                                    $isYoutube = true;
                                } else {
                                    $videoSrc = $yt;
                                }
                            }
                        @endphp
                        @if($videoSrc)
                        <div x-data="{ videoPlaying: false }" class="mt-2">
                            <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wide mb-1 flex items-center gap-1">
                                <i class='bx bx-video text-brand-600'></i> Video Preview
                            </p>
                            <div class="relative w-full rounded-xl overflow-hidden bg-black border border-gray-200 shadow-sm" style="aspect-ratio: 16/9">
                                <!-- Poster / Play Button (before video loads) -->
                                <div x-show="!videoPlaying"
                                     @click="videoPlaying = true"
                                     class="absolute inset-0 z-10 flex flex-col items-center justify-center cursor-pointer bg-gray-900/80 group">
                                    <img src="{{ $product->display_image ?: asset('images/LKtech.png') }}"
                                         class="absolute inset-0 w-full h-full object-cover opacity-40"
                                         alt="video thumbnail">
                                    <div class="relative z-10 w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/90 group-hover:bg-white flex items-center justify-center shadow-lg transition-transform group-hover:scale-110">
                                        <i class='bx bx-play text-2xl sm:text-3xl text-brand-600 ml-1'></i>
                                    </div>
                                    <span class="relative z-10 mt-2 text-white text-[10px] sm:text-xs font-semibold opacity-80">Klik untuk putar video</span>
                                </div>

                                <!-- Actual Video / Embed (lazy: only renders after click) -->
                                <template x-if="videoPlaying">
                                    @if($isYoutube)
                                    <iframe
                                        src="{{ $videoSrc }}"
                                        class="absolute inset-0 w-full h-full"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                    @else
                                    <video
                                        class="absolute inset-0 w-full h-full object-contain bg-black"
                                        src="{{ $videoSrc }}"
                                        controls
                                        autoplay
                                        playsinline
                                        preload="metadata">
                                        Browser Anda tidak mendukung pemutaran video.
                                    </video>
                                    @endif
                                </template>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                <!-- 2. Middle: Info, Price, & Specs Accordion -->
                <div class="flex-1 min-w-0 pb-2 sm:pb-8">
                    
                    <!-- Title & Condition Badge -->
                    <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                        <h1 class="text-base sm:text-xl lg:text-2xl font-bold text-gray-900 leading-snug">
                            {{ $product->brand }} {{ $product->model_series }}
                        </h1>
                        <span class="inline-flex items-center text-[10px] sm:text-xs font-semibold px-2 py-0.5 rounded bg-gray-100 text-gray-700 border border-gray-200">
                            {{ $product->condition ?: 'Bekas' }}
                        </span>
                        @if($product->category)
                        <span class="inline-flex items-center text-[10px] sm:text-xs font-medium px-2 py-0.5 rounded bg-blue-50 text-brand-600 border border-blue-100">
                            {{ $product->category->name }}
                        </span>
                        @endif
                    </div>

                    <!-- Prominent Price & Stock Row (Right Under Title) -->
                    <div class="mt-1.5 mb-2.5 flex items-center justify-start gap-2 p-2.5 sm:p-3 bg-gradient-to-r from-blue-50/70 via-gray-50/50 to-transparent rounded-xl border border-blue-100/70">
                        <div class="flex items-center flex-wrap gap-2 w-full">
                            <div class="flex items-baseline shrink-0">
                                <span class="text-xs sm:text-sm font-bold text-gray-900 mr-1">Rp</span>
                                <span class="text-[18px] sm:text-[20px] font-black text-gray-900 tracking-tight leading-none">
                                    {{ number_format($product->selling_price, 0, ',', '.') }}
                                </span>
                            </div>
                            @if(!empty($product->is_active_promo))
                                @php
                                    $crossedPriceDetail = $product->original_price ?? ($product->selling_price * 1.15);
                                @endphp
                                <span class="text-[#9CA3AF] text-[12px] sm:text-[14px] line-through leading-none shrink-0">
                                    Rp {{ number_format($crossedPriceDetail, 0, ',', '.') }}
                                </span>
                                <span class="bg-[#DC2626] text-white text-[10px] sm:text-[12px] font-bold px-[6px] py-[2px] rounded-[4px] leading-none uppercase shrink-0">Promo</span>
                            @endif
                        </div>
                    </div>

                    <!-- Accordion Spesifikasi & Detail Produk -->
                    @php
                        // Tampilkan Spesifikasi Teknis hanya untuk Kategori Laptop & Device
                        // (category_id: 1=Laptop & Device, 2=Laptop Gaming, 3=Laptop Office, 4=Ultrabook, 5=PC Desktop)
                        $laptopCategoryIds = [1, 2, 3, 4, 5];
                        $hasSpecs = in_array($product->category_id, $laptopCategoryIds);
                    @endphp
                    <div class="space-y-2 mt-2" x-data="{ openSpecs: true, openDesc: true }">
                        
                        <!-- Accordion 1: Spesifikasi Teknis (Hanya untuk Kategori Laptop & Device) -->
                        @if($hasSpecs)
                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-xs">
                            <button type="button" @click="openSpecs = !openSpecs" class="w-full flex items-center justify-between px-3.5 py-2.5 bg-gray-50/80 hover:bg-gray-100/70 transition-colors text-left font-bold text-xs sm:text-sm text-gray-800">
                                <span class="flex items-center gap-1.5">
                                    <i class='bx bx-chip text-brand-600 text-base'></i> Spesifikasi Teknis
                                </span>
                                <i class='bx bx-chevron-down text-lg text-gray-500 transition-transform duration-200' :class="openSpecs ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="openSpecs" x-transition.opacity.duration.150ms class="p-2.5 sm:p-3 border-t border-gray-100">
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    @if(!is_null($product->processor) && trim($product->processor) !== '' && trim($product->processor) !== '-')
                                    <div class="bg-gray-50/70 p-2 rounded-lg border border-gray-100">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">Processor</span>
                                        <span class="font-semibold text-gray-800 text-[11px] sm:text-xs">{{ $product->processor }}</span>
                                    </div>
                                    @endif
                                    @if(!is_null($product->ram) && trim($product->ram) !== '' && trim($product->ram) !== '-')
                                    <div class="bg-gray-50/70 p-2 rounded-lg border border-gray-100">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">RAM</span>
                                        <span class="font-semibold text-gray-800 text-[11px] sm:text-xs">{{ $product->ram }}</span>
                                    </div>
                                    @endif
                                    @if(!is_null($product->storage) && trim($product->storage) !== '' && trim($product->storage) !== '-')
                                    <div class="bg-gray-50/70 p-2 rounded-lg border border-gray-100">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">Penyimpanan</span>
                                        <span class="font-semibold text-gray-800 text-[11px] sm:text-xs">{{ $product->storage }}</span>
                                    </div>
                                    @endif
                                    @if($product->screen_size)
                                    <div class="bg-gray-50/70 p-2 rounded-lg border border-gray-100">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">Layar</span>
                                        <span class="font-semibold text-gray-800 text-[11px] sm:text-xs">{{ $product->screen_size }} Inch</span>
                                    </div>
                                    @endif
                                    @if($product->battery_runtime)
                                    <div class="bg-gray-50/70 p-2 rounded-lg border border-gray-100">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">Baterai</span>
                                        <span class="font-semibold text-gray-800 text-[11px] sm:text-xs">±{{ $product->battery_runtime }} Jam</span>
                                    </div>
                                    @endif
                                    <div class="bg-gray-50/70 p-2 rounded-lg border border-gray-100">
                                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider block">Kondisi Fisik</span>
                                        <span class="font-semibold text-gray-800 text-[11px] sm:text-xs">{{ $product->condition ?: 'Bekas Terawat' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Accordion 2: Deskripsi & Kelengkapan (Selalu Tampil) -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-xs">
                            <button type="button" @click="openDesc = !openDesc" class="w-full flex items-center justify-between px-3.5 py-2.5 bg-gray-50/80 hover:bg-gray-100/70 transition-colors text-left font-bold text-xs sm:text-sm text-gray-800">
                                <span class="flex items-center gap-1.5">
                                    <i class='bx bx-detail text-brand-600 text-base'></i> Deskripsi & Kelengkapan
                                </span>
                                <i class='bx bx-chevron-down text-lg text-gray-500 transition-transform duration-200' :class="openDesc ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="openDesc" x-transition.opacity.duration.150ms class="p-3 border-t border-gray-100">
                                @if($product->description)
                                <div class="prose max-w-none text-xs sm:text-sm text-gray-700">
                                    {!! $product->description !!}
                                </div>
                                @else
                                <p class="text-xs text-gray-400 italic">Belum ada deskripsi untuk produk ini.</p>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Sekunder & Trust Badges (Tampil di Mobile) -->
                    <div class="block lg:hidden mt-3 pt-2">
                        <!-- Tombol Sekunder 1 Baris Horizontal -->
                        <div class="grid grid-cols-3 gap-1.5">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20tertarik%20dengan%20produk:%20{{ urlencode($product->brand . ' ' . $product->model_series) }}" target="_blank" 
                               class="flex items-center justify-center gap-1 py-2 px-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors">
                                <i class='bx bxl-whatsapp text-sm'></i> <span>Tanya Admin</span>
                            </a>
                            <button type="button" onclick="alert('Fitur Wishlist akan segera hadir!')" 
                                    class="flex items-center justify-center gap-1 py-2 px-1 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-colors">
                                <i class='bx bx-heart text-sm text-rose-500'></i> <span>Wishlist</span>
                            </button>
                            <button type="button" @click.prevent="navigator.clipboard.writeText(window.location.href); alert('Tautan produk berhasil disalin!')" 
                                    class="flex items-center justify-center gap-1 py-2 px-1 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-colors">
                                <i class='bx bx-share-alt text-sm text-brand-600'></i> <span>Bagikan</span>
                            </button>
                        </div>

                        <!-- Trust Badges 1 Baris Horizontal -->
                        <div class="grid grid-cols-3 gap-2 mt-3 p-2.5 rounded-xl bg-gray-50/80 border border-gray-100 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-blue-100/70 text-brand-600 flex items-center justify-center text-sm mb-1">
                                    <i class='bx bx-shield-quarter'></i>
                                </div>
                                <span class="text-[10px] font-medium text-gray-700 leading-tight">Lulus QC</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-amber-100/70 text-amber-600 flex items-center justify-center text-sm mb-1">
                                    <i class='bx bx-medal'></i>
                                </div>
                                <span class="text-[10px] font-medium text-gray-700 leading-tight">Bergaransi</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-emerald-100/70 text-emerald-600 flex items-center justify-center text-sm mb-1">
                                    <i class='bx bx-wrench'></i>
                                </div>
                                <span class="text-[10px] font-medium text-gray-700 leading-tight">After-Sales</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3. Right: Desktop Action Panel (Without Heavy Card Box) -->
                <div class="w-full lg:w-[280px] xl:w-[320px] flex-shrink-0 hidden lg:block">
                    <div class="sticky top-20 space-y-3">
                        
                        <!-- CTA Buttons (Desktop) -->
                        @if($product->stock > 0 && $product->status !== 'Sold')
                            @if($product->status == 'Pre-Order')
                                <div class="flex flex-col gap-2">
                                    <button type="button" @click="addToCart({{ $product->id }}, true)" :disabled="adding || buyingNow" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-all shadow-sm flex justify-center items-center gap-1.5 cursor-pointer">
                                        <span x-text="buyingNow ? 'Proses...' : 'Beli Sekarang'"></span>
                                    </button>
                                    <button type="button" @click="addToCart({{ $product->id }}, false)" :disabled="adding || buyingNow" class="w-full bg-white hover:bg-orange-50 text-orange-600 border border-orange-500 font-bold py-2.5 px-4 rounded-xl text-sm transition-all flex justify-center items-center gap-1.5 cursor-pointer">
                                        <i class='bx bx-cart-add text-lg'></i> <span x-text="adding ? 'Proses...' : '+ Keranjang'"></span>
                                    </button>
                                </div>
                                <p class="text-[11px] text-orange-600 font-medium text-center">
                                    *Estimasi Pre-Order ±7 hari kerja.
                                </p>
                            @else
                                <div class="flex flex-col gap-2">
                                    <button type="button" @click="addToCart({{ $product->id }}, true)" :disabled="adding || buyingNow" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition-all shadow-sm flex justify-center items-center gap-1.5 cursor-pointer">
                                        <span x-text="buyingNow ? 'Proses...' : 'Beli Sekarang'"></span>
                                    </button>
                                    <button type="button" @click="addToCart({{ $product->id }}, false)" :disabled="adding || buyingNow" class="w-full bg-white hover:bg-brand-50 text-brand-600 border border-brand-600 font-bold py-2.5 px-4 rounded-xl text-sm transition-all flex justify-center items-center gap-1.5 cursor-pointer">
                                        <i class='bx bx-cart-add text-lg'></i> <span x-text="adding ? 'Proses...' : '+ Keranjang'"></span>
                                    </button>
                                </div>
                            @endif
                        @else
                            <button disabled class="w-full bg-gray-200 text-gray-500 font-bold py-2.5 px-4 rounded-xl text-sm cursor-not-allowed flex justify-center items-center">
                                Stok Habis
                            </button>
                        @endif

                        <!-- Tombol Sekunder (Desktop 1 Baris Horizontal) -->
                        <div class="grid grid-cols-3 gap-1.5 pt-1">
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20tertarik%20dengan%20produk:%20{{ urlencode($product->brand . ' ' . $product->model_series) }}" target="_blank" 
                               class="flex items-center justify-center gap-1 py-2 px-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors" title="Tanya Admin via WhatsApp">
                                <i class='bx bxl-whatsapp text-sm'></i> <span>Tanya</span>
                            </a>
                            <button type="button" onclick="alert('Fitur Wishlist akan segera hadir!')" 
                                    class="flex items-center justify-center gap-1 py-2 px-1 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-colors" title="Simpan ke Wishlist">
                                <i class='bx bx-heart text-sm text-rose-500'></i> <span>Wishlist</span>
                            </button>
                            <button type="button" @click.prevent="navigator.clipboard.writeText(window.location.href); alert('Tautan produk berhasil disalin!')" 
                                    class="flex items-center justify-center gap-1 py-2 px-1 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-lg text-xs font-semibold transition-colors" title="Salin Tautan">
                                <i class='bx bx-share-alt text-sm text-brand-600'></i> <span>Bagikan</span>
                            </button>
                        </div>

                        <!-- Trust Badges (Desktop 1 Baris Horizontal) -->
                        <div class="grid grid-cols-3 gap-1.5 pt-3 border-t border-gray-100 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-blue-50 text-brand-600 flex items-center justify-center text-sm mb-1">
                                    <i class='bx bx-shield-quarter'></i>
                                </div>
                                <span class="text-[10px] font-medium text-gray-700 leading-tight">Lulus QC</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-sm mb-1">
                                    <i class='bx bx-medal'></i>
                                </div>
                                <span class="text-[10px] font-medium text-gray-700 leading-tight">Bergaransi</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm mb-1">
                                    <i class='bx bx-wrench'></i>
                                </div>
                                <span class="text-[10px] font-medium text-gray-700 leading-tight">After-Sales</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>

        <!-- ─────────────────────────────────────────────
             Mobile Sticky CTA Bar (Menempel di Paling Bawah Layar)
        ───────────────────────────────────────────────── -->
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-gray-200 px-3 py-2 md:hidden shadow-[0_-4px_12px_rgba(0,0,0,0.06)]">
            <div class="flex items-center justify-between gap-2 max-w-lg mx-auto">
                <!-- Mini Harga -->
                <div class="flex flex-col shrink-0 min-w-0 pr-1">
                    <span class="text-[9px] text-gray-400 font-semibold uppercase leading-none">Harga</span>
                    <div class="text-xs sm:text-sm font-extrabold text-brand-600 truncate">
                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Tombol CTA Mobile -->
                @if($product->stock > 0 && $product->status !== 'Sold')
                    @if($product->status == 'Pre-Order')
                        <div class="flex items-center gap-1.5 flex-1 justify-end">
                            <button type="button" @click="addToCart({{ $product->id }}, false)" :disabled="adding || buyingNow" class="py-2 px-2.5 rounded-lg border border-orange-500 text-orange-600 font-bold text-xs flex items-center justify-center gap-1 bg-orange-50 active:bg-orange-100 transition-colors">
                                <i class='bx bx-cart-add text-sm'></i>
                                <span x-text="adding ? '...' : '+ Keranjang'"></span>
                            </button>
                            <button type="button" @click="addToCart({{ $product->id }}, true)" :disabled="adding || buyingNow" class="flex-1 max-w-[130px] py-2 px-2.5 rounded-lg bg-orange-500 active:bg-orange-600 text-white font-bold text-xs flex items-center justify-center gap-1 shadow-sm transition-colors">
                                <span x-text="buyingNow ? 'Proses...' : 'Beli Sekarang'"></span>
                            </button>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 flex-1 justify-end">
                            <button type="button" @click="addToCart({{ $product->id }}, false)" :disabled="adding || buyingNow" class="py-2 px-2.5 rounded-lg border border-brand-600 text-brand-600 font-bold text-xs flex items-center justify-center gap-1 bg-brand-50 active:bg-brand-100 transition-colors">
                                <i class='bx bx-cart-add text-sm'></i>
                                <span x-text="adding ? '...' : '+ Keranjang'"></span>
                            </button>
                            <button type="button" @click="addToCart({{ $product->id }}, true)" :disabled="adding || buyingNow" class="flex-1 max-w-[130px] py-2 px-2.5 rounded-lg bg-brand-600 active:bg-brand-700 text-white font-bold text-xs flex items-center justify-center gap-1 shadow-sm transition-colors">
                                <span x-text="buyingNow ? 'Proses...' : 'Beli Sekarang'"></span>
                            </button>
                        </div>
                    @endif
                @else
                    <button disabled class="flex-1 py-2 px-3 bg-gray-200 text-gray-500 font-bold text-xs rounded-lg cursor-not-allowed text-center">
                        Stok Habis
                    </button>
                @endif
            </div>
        </div>

    </div>

    <!-- Related Products / Cross-Selling Section (Efisiensi Ruang) -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section x-data class="max-w-7xl mx-auto w-full px-2 sm:px-6 lg:px-8 py-2 sm:py-3 mb-1 mt-1 border-t border-gray-100">
        <div class="flex items-center justify-between mb-2 md:mb-4 gap-2 overflow-hidden">
            <h3 class="text-xs sm:text-base font-bold text-gray-900 leading-snug truncate">
                Rekomendasi Produk Terkait
            </h3>
            
            <!-- Tombol Panah Navigasi Slider -->
            <div class="flex gap-1.5 shrink-0">
                <button type="button" id="btnSlideLeft" onclick="document.getElementById('productSlider').scrollBy({ left: -220, behavior: 'smooth' })" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-full shadow-xs transition-colors" aria-label="Slide Kiri">
                    <i class="bx bx-chevron-left text-base sm:text-lg"></i>
                </button>
                <button type="button" id="btnSlideRight" onclick="document.getElementById('productSlider').scrollBy({ left: 220, behavior: 'smooth' })" class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-white border border-gray-200 text-brand-600 hover:bg-brand-50 rounded-full shadow-xs transition-colors" aria-label="Slide Kanan">
                    <i class="bx bx-chevron-right text-base sm:text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Horizontal Scrollable Container (Compact Cards) -->
        <div id="productSlider" class="flex overflow-x-auto gap-2 sm:gap-3.5 pb-2 snap-x scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none; scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
            @foreach($relatedProducts as $rp)
                <div class="snap-start flex-shrink-0 w-[130px] sm:w-[155px] lg:w-[185px]">
                    <x-product-card :product="$rp" :loop-index="$loop->index" />
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
    <div class="hidden md:block">
        <x-footer />
    </div>
    
    <!-- Mobile Padding Fix to prevent overlap with sticky CTA bar -->
    <div class="md:hidden h-20 w-full"></div>

    <!-- ─────────────────────────────────────────────
         Fancybox v5 JS + Inisialisasi
    ───────────────────────────────────────────────── -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Fancybox.bind('[data-fancybox="product-gallery"]', {
                // ── Navigasi & Animasi ──
                animated: true,
                showClass: 'f-fadeIn',
                hideClass: 'f-fadeOut',

                // ── Thumbnail Strip di bawah ──
                Thumbs: {
                    type: 'classic',   // tampilkan thumbnail strip
                },

                // ── Toolbar (tombol zoom, fullscreen, download, tutup) ──
                Toolbar: {
                    display: {
                        left  : ['infobar'],
                        middle: ['zoomIn', 'zoomOut', 'toggle1to1', 'rotateCCW', 'rotateCW', 'flipX', 'flipY'],
                        right : ['slideshow', 'thumbs', 'close'],
                    },
                },

                // ── Zoom Plugin ──
                Images: {
                    zoom: true,
                },

                // ── Caption ──
                caption: function (fancybox, slide) {
                    return slide.el ? slide.el.dataset.caption : '';
                },

                // ── Sinkronisasi: saat Fancybox navigasi, update Alpine slider ──
                on: {
                    'Carousel.change': (fancybox, carousel) => {
                        // Cari Alpine component di parent wrapper
                        const mainEl = document.querySelector('[x-data]');
                        if (mainEl && mainEl._x_dataStack) {
                            // Alpine v3: ambil data via $data
                            const alpineData = Alpine.$data ? Alpine.$data(mainEl) : null;
                            if (alpineData && typeof alpineData.goTo === 'function') {
                                alpineData.goTo(carousel.page);
                            }
                        }
                    }
                },
            });
        });
    </script>

</body>
</html>
