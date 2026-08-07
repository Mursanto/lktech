@props(['products'])

@if(isset($products) && $products->count() > 0)
<div class="mt-8 border-t border-gray-100 pt-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-bold text-gray-800 text-sm md:text-base tracking-tight">Rekomendasi Produk Terlaris</h2>
        <a href="{{ route('katalog.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">Lihat Semua →</a>
    </div>
    <div class="flex overflow-x-auto snap-x snap-mandatory gap-3 pb-4 scrollbar-none" style="scrollbar-width: none; -ms-overflow-style: none;">
        @foreach($products as $prod)
            <div class="w-[160px] md:w-[180px] shrink-0 snap-start h-full">
                <x-product-card :product="$prod" />
            </div>
        @endforeach
    </div>
</div>
<style>
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
</style>
@endif
