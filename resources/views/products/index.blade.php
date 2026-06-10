<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Inventaris Produk</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Kelola stok laptop, part, dan aksesoris sistem.</p>
            </div>
            <div class="flex items-center gap-2">
                @role('Admin')
                <a href="{{ route('products.export') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-natural-200 rounded-xl text-natural-600 text-xs font-bold hover:bg-natural-50 transition-all shadow-sm">
                    <i class='bx bx-export text-lg'></i>
                    Export Excel
                </a>
                @endrole
                @role('Admin')
                <a href="{{ route('products.create') }}" class="flex items-center gap-2 px-4 py-2 bg-brand-600 rounded-xl text-white text-xs font-bold hover:bg-brand-700 transition-all shadow-md">
                    <i class='bx bx-plus text-lg'></i>
                    Tambah Produk
                </a>
                @endrole
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Search & Filter Bar -->
        <form id="filterForm" action="{{ route('products.index') }}" method="GET" class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-grow max-w-md">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-natural-400 text-xl'></i>
                <input type="text" name="search" value="{{ request('search') }}" id="productSearch" oninput="debounceSubmit()" placeholder="Cari nama laptop, brand, atau kode..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-natural-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all">
            </div>
            <div class="flex items-center gap-2">
                <select name="category_id" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $parentCat)
                        <option value="{{ $parentCat->id }}" class="font-bold" {{ request('category_id') == $parentCat->id ? 'selected' : '' }}>{{ $parentCat->name }}</option>
                        @foreach($parentCat->children as $childCat)
                            <option value="{{ $childCat->id }}" {{ request('category_id') == $childCat->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;-- {{ $childCat->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                <select name="tipe_stok" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium">
                    <option value="">Semua Tipe Stok</option>
                    <option value="ready_stock" {{ request('tipe_stok') == 'ready_stock' ? 'selected' : '' }}>Ready Stock</option>
                    <option value="open_order" {{ request('tipe_stok') == 'open_order' ? 'selected' : '' }}>Open Order</option>
                </select>
                <select name="status" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="available" {{ request('status', 'available') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Habis (Terjual)</option>
                </select>
            </div>
        </form>

        <!-- Inventory Table Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto bg-white rounded-xl border-0">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">Info Produk</th>
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-left">Kategori</th>
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Stok</th>
                            @hasanyrole('Admin|Owner')
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Harga Beli</th>
                            @endhasanyrole
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Harga Jual</th>
                            @hasanyrole('Admin|Owner')
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Persentase</th>
                            @endhasanyrole
                            <th class="px-6 py-4 bg-gray-50/80 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50 text-sm">
                        @forelse($products as $product)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-brand-100 group-hover:text-brand-700 transition-colors">
                                        <i class='bx bx-laptop text-lg'></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 whitespace-normal line-clamp-2">{{ $product->brand }} {{ $product->model_series }}</p>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <p class="text-xs text-gray-400 font-medium tracking-tight">ID: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</p>
                                            {{-- Badge Tipe Stok --}}
                                            @if(($product->tipe_stok ?? 'ready_stock') === 'ready_stock')
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 uppercase tracking-wider border border-emerald-100">Ready</span>
                                            @else
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-orange-50 text-orange-700 uppercase tracking-wider border border-orange-100">Open Order</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 whitespace-nowrap">
                                <span class="px-2 py-1 rounded border border-gray-200 bg-white text-gray-600 text-[11px] font-medium whitespace-nowrap">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                <span class="text-sm font-medium {{ $product->stock <= 2 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $product->stock }}
                                </span>
                                <span class="text-[10px] font-medium text-gray-400 uppercase ml-0.5">Unit</span>
                            </td>
                            @php
                                $finalPrice = $product->selling_price > 0 ? $product->selling_price : ($product->purchase_price + $product->operational_cost);
                                $beli = $product->purchase_price ?: 1; 
                                $margin = (($finalPrice - $product->purchase_price) / $beli) * 100;
                            @endphp
                            @hasanyrole('Admin|Owner')
                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-700">Rp {{ number_format((float) $product->purchase_price, 0, ',', '.') }}</p>
                            </td>
                            @endhasanyrole
                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-700">Rp {{ number_format((float) $finalPrice, 0, ',', '.') }}</p>
                            </td>
                            @hasanyrole('Admin|Owner')
                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                <span class="px-1.5 py-0.5 rounded-md text-xs font-bold border {{ $margin >= 30 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                    {{ round($margin, 1) }}%
                                </span>
                            </td>
                            @endhasanyrole

                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('products.show', $product->id) }}" class="p-1.5 text-sm text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Detail">
                                        <i class='bx bx-show text-lg'></i>
                                    </a>
                                    @role('Admin')
                                    <a href="{{ route('products.edit', $product->id) }}" class="p-1.5 text-sm text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <i class='bx bx-edit-alt text-lg'></i>
                                    </a>
                                    @endrole
                                    @role('Admin')
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-sm text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </form>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-natural-400">
                                    <i class='bx bx-package text-5xl mb-2 opacity-20'></i>
                                    <p class="text-sm font-medium italic">Tidak ada produk ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination (Simplified) -->
            <div class="mt-auto px-6 py-4 bg-natural-50/30 border-t border-natural-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
