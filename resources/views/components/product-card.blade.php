@props(['product', 'loopIndex' => 0])
@php 
    $isPromo = !empty($product->is_active_promo); 
    $isPreOrder = ($product->tipe_stok ?? 'ready_stock') === 'open_order' || $product->status === 'Pre-Order';
    // Selang-seling: genap = Blue Flame (#00B0FF), ganjil = Orange Flame (#FF5722)
    $isEven = ($loopIndex % 2 === 0);
    $fireIcon = '🔥'; // Selalu pakai emoji api, warna dikontrol via CSS filter
    $badgeGlow = $isEven
        ? 'shadow-[0_0_8px_2px_rgba(255,87,34,0.5)]'   // orange glow
        : 'shadow-[0_0_8px_2px_rgba(0,176,255,0.5)]';  // blue glow
    $fireStyle = $isEven
        ? 'filter: drop-shadow(0 0 3px #FF5722);'                                          // Orange fire
        : 'filter: hue-rotate(200deg) saturate(3) brightness(1.2) drop-shadow(0 0 4px #00B0FF);'; // Blue fire
@endphp
<div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex flex-col group relative min-w-0 sm:min-w-[150px] h-full border border-gray-200">
    
    <!-- Clickable Area to Detail Page -->
    <a href="{{ route('katalog.show', $product->id) }}" class="flex flex-col flex-grow cursor-pointer">
        <!-- Image & Video Area — Full Bleed -->
        <div class="relative w-full aspect-square bg-gray-100 overflow-hidden">
            @php
                $videoSrc = $product->video_path ? asset('storage/' . $product->video_path) : $product->video_url;
            @endphp
            @if(!empty($videoSrc))
                <!-- Play Icon Badge -->
                <div class="absolute bottom-1.5 left-1.5 sm:bottom-2 sm:left-2 z-20 bg-black/60 backdrop-blur-sm text-white rounded-full w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center shadow-lg pointer-events-none">
                    <i class='bx bx-play text-xs sm:text-sm ml-0.5'></i>
                </div>
                
                <!-- Video Element (Lazy loaded via IntersectionObserver) -->
                <video 
                    class="absolute inset-0 w-full h-full object-cover z-10 transition-opacity duration-700 opacity-0 group-hover:opacity-100 product-video-preview"
                    muted loop playsinline preload="none" data-src="{{ $videoSrc }}">
                </video>
            @endif
            
            <img src="{{ $product->display_image ?: asset('images/LKtech.png') }}" onerror="this.onerror=null; this.src='{{ asset('images/LKtech.png') }}';" alt="{{ $product->brand }} {{ $product->model_series }}" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 z-0">
            
            <!-- Badges Container: View top-left, Hot Promo top-right -->
            <div class="absolute top-1.5 left-1.5 right-1.5 sm:top-2 sm:left-2 sm:right-2 z-30 pointer-events-none flex justify-between items-start gap-1">

                {{-- Left: Badge Views --}}
                @php
                    $baseViews = ($product->id * 17) % 41 + 20; 
                    $actualViews = $product->views_count ?? 0;
                    $totalViews = $baseViews + $actualViews;
                    $formattedViews = $totalViews >= 1000 ? round($totalViews/1000, 1) . 'k' : $totalViews;
                @endphp
                <div class="flex items-center gap-0.5 sm:gap-1 bg-gray-900/70 backdrop-blur-sm text-white px-1.5 sm:px-2 py-0.5 rounded-md text-[8px] sm:text-[9px] font-semibold shadow-sm border border-white/20 h-4 sm:h-5 shrink-0 pointer-events-auto">
                    <i class='bx bx-show text-[9px] sm:text-[10px] shrink-0'></i>
                    <span class="whitespace-nowrap">{{ $formattedViews }}</span>
                </div>

                {{-- Right: Hot Promo or Sold Out --}}
                <div class="flex flex-row items-start gap-0.5 sm:gap-1 pointer-events-auto shrink-0">
                    {{-- Badge HOT PROMO --}}
                    @if($isPromo)
                    <div class="bg-gradient-to-r from-rose-500 via-red-500 to-amber-500 text-white px-1.5 sm:px-2 py-0.5 rounded-md text-[8px] sm:text-[9px] font-semibold flex items-center gap-0.5 h-4 sm:h-5 whitespace-nowrap animate-[pulse_2s_ease-in-out_infinite] {{ $badgeGlow }}">
                        <span style="{{ $fireStyle }}">{{ $fireIcon }}</span>
                        <span>Hot Promo</span>
                    </div>
                    @endif

                    {{-- Badge Terjual Habis --}}
                    @if($product->stock <= 0 || $product->status === 'Sold')
                    <div class="bg-white/95 backdrop-blur-sm text-red-600 px-1.5 sm:px-2 py-0.5 rounded-md text-[8px] sm:text-[9px] font-semibold shadow-sm border border-red-100 flex items-center gap-0.5 h-4 sm:h-5 whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                        <span>Habis</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Details -->
        <div class="p-1.5 sm:p-2 flex flex-col">
            <!-- Brand & Model -->
            <h3 class="text-[11px] sm:text-xs font-semibold text-gray-800 truncate leading-snug mb-0.5 group-hover:text-brand-600 transition-colors" title="{{ $product->brand }} {{ $product->model_series }}">
                {{ $product->brand }} {{ $product->model_series }}
            </h3>

            <!-- Price -->
            <div class="flex items-baseline gap-0.5 mb-1" title="Rp {{ number_format($product->selling_price, 0, ',', '.') }}">
                <span class="text-[9px] font-bold text-emerald-500">Rp</span>
                <span class="text-emerald-600 font-extrabold text-xs sm:text-sm leading-none">{{ number_format($product->selling_price, 0, ',', '.') }}</span>
                @if($isPromo)
                    @php
                        $crossedPrice = $product->original_price ?? ($product->selling_price * 1.15);
                    @endphp
                    <span class="text-gray-600 text-[8px] sm:text-[9px] line-through ml-1">Rp {{ number_format($crossedPrice, 0, ',', '.') }}</span>
                @endif
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
            {{-- max-h forces exactly 3 lines: 10px font × 1.375 leading × 3 = 41.25px → 4.125em --}}
            <div class="text-[10px] text-gray-500 leading-snug overflow-hidden" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;max-height:4.125em">
                @if($hasValidProcessor)<span class="mr-1.5">Processor {{ $product->processor }}</span>@endif
                @if($hasValidRam)<span class="mr-1.5">RAM {{ $product->ram }}</span>@endif
                @if($hasValidStorage)<span class="mr-1.5">Storage {{ $product->storage }}</span>@endif
                @if($hasValidScreen)<span>Layar {{ $product->screen_size }} Inci</span>@endif
            </div>
            @else
            <div class="text-[10px] text-gray-400 leading-snug overflow-hidden" style="display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;max-height:4.125em">
                {{ $product->description ? Str::limit(strip_tags($product->description), 80) : ($product->category ? $product->category->name : 'Produk berkualitas') . '.' }}
            </div>
            @endif
        </div>
    </a>
</div>
