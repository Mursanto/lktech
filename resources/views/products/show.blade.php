<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Produk: {{ $product->brand }} {{ $product->model_series }}
            </h2>
            <div class="flex space-x-2">
                @role('Admin')
                <a href="{{ route('products.edit', $product) }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-1.5 rounded-lg font-bold text-xs shadow flex items-center gap-1.5">
                    <i class='bx bx-edit text-sm'></i> Edit Data
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg font-bold text-xs shadow flex items-center gap-1.5">
                        <i class='bx bx-trash text-sm'></i>
                    </button>
                </form>
                @endrole
            </div>
        </div>
    </x-slot>

    <!-- Tailwind Typography for Prose -->
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>

    <div class="py-6 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                
                <div class="flex-grow flex flex-col md:flex-row overflow-hidden">
                    
                    <!-- Left Panel: Tech & Pricing (Read Only) -->
                    <div class="w-full md:w-1/2 p-4 md:p-5 overflow-y-auto border-r border-gray-100 scrollbar-hide">
                        <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1">Data Utama</h3>
                        
                        <!-- Kategori & Basic Info -->
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Kategori</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->category->name ?? '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Serial Number</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->serial_number ?: '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Brand</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->brand ?: '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Model Series</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->model_series ?: '-' }}</div>
                            </div>
                        </div>

                        <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1 mt-5">Spesifikasi Teknis</h3>
                        <!-- Spesifikasi (3 Cols) -->
                        <div class="grid grid-cols-3 gap-3 mb-3">
                            <div class="col-span-3 bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Processor</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->processor ?: '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">RAM</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->ram ?: '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Storage</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->storage ?: '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Layar (Inch)</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->screen_size ?: '-' }}</div>
                            </div>
                            <div class="bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Daya Tahan Baterai</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->battery_runtime ? '±'.$product->battery_runtime.' Jam' : '-' }}</div>
                            </div>
                            <div class="col-span-2 bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Kondisi</label>
                                <div class="text-xs font-semibold text-gray-900 mt-1">{{ $product->condition ?: '-' }}</div>
                            </div>
                        </div>

                        <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1 mt-5">Inventaris & Harga</h3>
                        <div class="grid grid-cols-4 gap-3">
                            <div class="bg-brand-50 p-2 rounded border border-brand-100">
                                <label class="block text-[10px] font-bold text-brand-600 uppercase">Status</label>
                                <div class="text-xs font-bold mt-1 
                                    {{ $product->status === 'available' ? 'text-green-600' : ($product->status === 'sold' ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ strtoupper($product->status) }}
                                </div>
                            </div>
                            <div class="bg-brand-50 p-2 rounded border border-brand-100">
                                <label class="block text-[10px] font-bold text-brand-600 uppercase">Stok</label>
                                <div class="text-xs font-black text-brand-800 mt-1">{{ $product->stock }} Unit</div>
                            </div>
                            <div class="col-span-2 bg-emerald-50 p-2 rounded border border-emerald-100">
                                <label class="block text-[10px] font-bold text-emerald-600 uppercase">Estimasi Laba</label>
                                <div class="text-xs font-black text-emerald-700 mt-1">
                                    Rp {{ number_format(($product->selling_price - $product->purchase_price) - ($product->operational_cost ?? 0), 0, ',', '.') }}
                                </div>
                            </div>
                            
                            <div class="col-span-2 bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Harga Beli</label>
                                <div class="text-sm font-black text-red-600 mt-1">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-span-2 bg-gray-50 p-2 rounded border border-gray-100">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase">Harga Jual</label>
                                <div class="text-sm font-black text-emerald-600 mt-1">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel: Catalog Visuals (Read Only) -->
                    <div class="w-full md:w-1/2 p-4 md:p-5 overflow-y-auto bg-gray-50 scrollbar-hide">
                        <div class="flex justify-between items-center mb-3 border-b border-fuchsia-200 pb-1">
                            <h3 class="text-sm font-bold text-fuchsia-700 uppercase tracking-wider">Visual Katalog</h3>
                            <a href="{{ route('katalog.show', $product->id) }}" target="_blank" class="text-[10px] font-bold text-fuchsia-600 hover:text-fuchsia-800 flex items-center gap-1">
                                Lihat di Katalog <i class='bx bx-link-external'></i>
                            </a>
                        </div>
                        
                        <div class="flex gap-4 mb-4">
                            <!-- Main Image Preview -->
                            <div class="w-1/3">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Foto Utama</label>
                                <div class="relative w-full aspect-square bg-white rounded border border-gray-300 overflow-hidden flex items-center justify-center">
                                    @if($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" class="absolute inset-0 w-full h-full object-contain bg-white sm:bg-gray-50 p-2">
                                    @else
                                        <div class="text-center p-2 text-gray-400">
                                            <i class='bx bx-image text-3xl'></i>
                                            <p class="text-[9px] mt-1 font-medium">Auto-Fetch Image</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Gallery Images Preview -->
                            <div class="w-2/3">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Galeri ({{ is_array($product->gallery_images) ? count($product->gallery_images) : 0 }}/9)</label>
                                <div class="grid grid-cols-4 gap-1.5 h-[120px] overflow-y-auto">
                                    @if(is_array($product->gallery_images) && count($product->gallery_images) > 0)
                                        @foreach($product->gallery_images as $img)
                                        <div class="relative w-full aspect-square bg-white rounded overflow-hidden border border-gray-200">
                                            <img src="{{ Storage::url($img) }}" class="absolute inset-0 w-full h-full object-contain bg-white sm:bg-gray-50 p-2">
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-span-4 flex items-center justify-center h-full border-2 border-dashed border-gray-200 rounded text-gray-400 text-xs font-medium bg-white">
                                            Belum ada foto galeri
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Deskripsi Pemasaran</label>
                            <div class="bg-white border border-gray-200 rounded p-4 h-[150px] md:h-[220px] overflow-y-auto">
                                @if($product->description)
                                    <div class="prose prose-sm max-w-none prose-p:my-1 prose-ul:my-1 text-gray-700 text-xs">
                                        {!! $product->description !!}
                                    </div>
                                @else
                                    <div class="text-center text-gray-400 mt-10">
                                        <i class='bx bx-text text-3xl mb-1'></i>
                                        <p class="text-xs">Belum ada deskripsi pemasaran (Menggunakan Fallback Spec di Katalog)</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer / Navigate Back -->
                <div class="bg-gray-100 border-t border-gray-200 p-3 flex justify-start flex-shrink-0">
                    <a href="{{ route('products.index') }}" class="px-4 py-1.5 bg-white border border-gray-300 rounded text-sm font-semibold text-gray-600 hover:bg-gray-50 flex items-center gap-2 shadow-sm">
                        <i class='bx bx-arrow-back'></i> Kembali ke Inventaris
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
