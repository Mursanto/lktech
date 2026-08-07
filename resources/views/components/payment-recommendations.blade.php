@props(['products'])

@if(isset($products) && $products->count() > 0)
<div class="mt-8 border-t border-gray-100 pt-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-bold text-gray-800 text-sm md:text-base tracking-tight">Rekomendasi Produk Terlaris</h2>
        <a href="{{ route('katalog.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">Lihat Semua →</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-2 gap-3 sm:gap-4 pb-4">
        @foreach($products as $prod)
            <x-product-card :product="$prod" />
        @endforeach
    </div>
</div>
@endif
