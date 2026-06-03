<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Katalog Produk</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Media pemasaran visual untuk presentasi ke pelanggan.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-natural-200 rounded-xl text-natural-600 text-xs font-bold hover:bg-natural-50 transition-all shadow-sm">
                    <i class='bx bx-left-arrow-alt text-lg'></i>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-grow max-w-md">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-natural-400 text-xl'></i>
                <input type="text" placeholder="Cari di katalog..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-natural-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all">
            </div>
            <div class="flex items-center gap-2">
                <button class="bg-brand-50 text-brand-700 px-4 py-2.5 rounded-2xl text-sm font-bold flex items-center gap-2 border border-brand-100 transition-all hover:bg-brand-100">
                    <i class='bx bx-filter-alt'></i> Filter Lanjut
                </button>
            </div>
        </div>

        <!-- Catalog Grid Container -->
        <div class="flex-grow overflow-y-auto pr-1 custom-scrollbar">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($products as $product)
                <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden group hover:shadow-md transition-all duration-300">
                    <!-- Image Thumbnail -->
                    <div class="h-32 bg-white relative overflow-hidden flex items-center justify-center border-b border-natural-100/50">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . str_replace('public/', '', $product->image_path)) }}" alt="{{ $product->model_series }}" class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">
                        @else
                            <i class='bx bx-image text-4xl text-natural-300 group-hover:scale-110 transition-transform duration-500'></i>
                        @endif

                        <div class="absolute top-2 left-2">
                            <span class="px-2 py-0.5 rounded-lg bg-white/90 backdrop-blur-md text-natural-800 text-[8px] font-black uppercase tracking-widest shadow-sm border border-gray-100">
                                {{ $product->brand }}
                            </span>
                        </div>
                        <div class="absolute bottom-2 left-2">
                            <span class="text-white text-[8px] font-bold px-2 py-0.5 rounded-full bg-brand-500 shadow-sm">
                                {{ $product->category->name ?? 'Device' }}
                            </span>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-4 flex flex-col gap-2">
                        <div class="min-h-[40px]">
                            <h3 class="text-sm font-black text-natural-900 group-hover:text-brand-600 transition-colors line-clamp-2 leading-tight">
                                {{ $product->model_series }}
                            </h3>
                        </div>
                        
                        <div class="flex items-end justify-between mt-1">
                            <div>
                                <p class="text-[9px] text-natural-400 font-bold uppercase tracking-wider">Harga Promo</p>
                                @php
                                    $finalPrice = $product->selling_price > 0 ? $product->selling_price : ($product->purchase_price + $product->operational_cost);
                                @endphp
                                <div class="flex items-center gap-2 mt-1">
                                    <p class="text-base font-black text-brand-600 leading-none">Rp {{ number_format((float) $finalPrice, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="text-right pb-0.5">
                                <p class="text-[9px] text-natural-400 font-bold uppercase tracking-wider">Tersedia</p>
                                <p class="text-xs font-black text-natural-800 leading-none mt-1">{{ $product->stock }} <span class="text-[10px] font-bold text-natural-400">Unit</span></p>
                            </div>
                        </div>

                        <!-- Action button removed based on user request to simplify the view -->
                    </div>
                </div>
                @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-natural-400">
                    <i class='bx bx-search-alt text-6xl opacity-20 mb-3'></i>
                    <p class="font-bold">Produk tidak ditemukan di katalog.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</x-app-layout>
