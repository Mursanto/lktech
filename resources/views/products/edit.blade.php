<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product: {{ $product->brand }} {{ $product->model_series }}
            </h2>
            <a href="{{ route('catalog.edit', $product->id) }}" class="bg-fuchsia-600 hover:bg-fuchsia-700 text-white px-3 py-1.5 rounded-lg font-bold text-xs shadow flex items-center gap-1.5">
                <i class='bx bx-images text-sm'></i> Editor Katalog
            </a>
        </div>
    </x-slot>

    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <div class="py-6 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                
                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-full" id="product-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex-grow flex flex-col md:flex-row overflow-hidden">
                        
                        <!-- Left Panel: Tech & Pricing -->
                        <div class="w-full md:w-1/2 p-4 md:p-5 overflow-y-auto border-r border-gray-100 scrollbar-hide">
                            <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1">Data Utama</h3>
                            
                            <!-- Kategori & Basic Info -->
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Kategori *</label>
                                    <select name="category_id" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                                        <option value="">Pilih Kategori</option>
                                        @foreach(\App\Models\Category::whereNull('parent_id')->with('children')->get() as $parentCat)
                                            <optgroup label="{{ $parentCat->name }}">
                                                @foreach($parentCat->children as $childCat)
                                                    <option value="{{ $childCat->id }}" data-type="{{ $childCat->type_category }}" {{ $product->category_id == $childCat->id ? 'selected' : '' }}>
                                                        {{ $childCat->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Serial Number *</label>
                                    <input type="text" name="serial_number" value="{{ $product->serial_number }}" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Brand *</label>
                                    <input type="text" name="brand" value="{{ $product->brand }}" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Model Series *</label>
                                    <input type="text" name="model_series" value="{{ $product->model_series }}" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                            </div>

                            <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1 mt-4">Spesifikasi Teknis</h3>
                            <!-- Spesifikasi (4 Cols) -->
                            <div id="spesifikasi-teknis-section" class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                <div class="col-span-2">
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Processor</label>
                                    <input type="text" name="processor" value="{{ $product->processor }}" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">RAM</label>
                                    <input type="text" name="ram" value="{{ $product->ram }}" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Storage</label>
                                    <input type="text" name="storage" value="{{ $product->storage }}" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Layar (Inch)</label>
                                    <input type="number" step="0.1" name="screen_size" value="{{ $product->screen_size }}" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Daya Tahan Baterai (Jam)</label>
                                    <input type="number" step="0.1" name="battery_runtime" value="{{ $product->battery_runtime }}" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Kondisi *</label>
                                    <select name="condition" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                        <option value="Baru" {{ $product->condition == 'Baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="Bekas" {{ $product->condition == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                                        <option value="Mulus" {{ $product->condition == 'Mulus' ? 'selected' : '' }}>Mulus</option>
                                    </select>
                                </div>
                            </div>

                            <div id="inventaris-harga-section">
                                <h3 class="text-sm font-bold text-brand-700 uppercase tracking-wider mb-3 border-b pb-1 mt-4">Inventaris & Harga</h3>

                                {{-- Tipe Stok: Ready Stock / Open Order --}}
                                <div class="mb-3">
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Tipe Stok *</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2 border-2 rounded cursor-pointer transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50 border-gray-200">
                                            <input type="radio" name="tipe_stok" value="ready_stock" {{ ($product->tipe_stok ?? 'ready_stock') == 'ready_stock' ? 'checked' : '' }} class="accent-emerald-500">
                                            <div>
                                                <p class="text-[11px] font-bold text-gray-700">Ready Stock</p>
                                                <p class="text-[9px] text-gray-400">Stok tersedia fisik</p>
                                            </div>
                                        </label>
                                        <label class="flex items-center gap-2 p-2 border-2 rounded cursor-pointer transition-all has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 border-gray-200">
                                            <input type="radio" name="tipe_stok" value="open_order" {{ ($product->tipe_stok ?? '') == 'open_order' ? 'checked' : '' }} class="accent-orange-500">
                                            <div>
                                                <p class="text-[11px] font-bold text-gray-700">Open Order</p>
                                                <p class="text-[9px] text-gray-400">Pre-order / indent</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-4 gap-3">
                                    <div id="stock-qty-container">
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Stok QTY *</label>
                                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500 font-bold text-brand-700">
                                    <input type="hidden" name="status" value="{{ $product->status }}">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Harga Beli *</label>
                                    <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500 text-red-600 font-bold">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Harga Jual *</label>
                                    <input type="number" name="selling_price" value="{{ $product->selling_price }}" required class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500 text-emerald-600 font-bold">
                                </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-600 mb-1">Biaya Ops.</label>
                                        <input type="number" name="operational_cost" value="{{ $product->operational_cost ?? 0 }}" class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-brand-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Catalog Visuals -->
                        <div class="w-full md:w-1/2 p-4 md:p-5 overflow-y-auto bg-gray-50 scrollbar-hide">
                            <h3 class="text-sm font-bold text-fuchsia-700 uppercase tracking-wider mb-3 border-b border-fuchsia-200 pb-1">Visual Katalog</h3>
                            
                            <div class="flex gap-4 mb-4">
                                <!-- Main Image Preview -->
                                <div class="w-1/3">
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Ganti Foto Utama</label>
                                    <div class="relative w-full aspect-square bg-white rounded border-2 border-dashed border-gray-300 overflow-hidden flex items-center justify-center group h-[120px]" id="image-preview-container">
                                        <div class="text-center z-10 p-2 {{ $product->image_path ? 'hidden' : '' }}" id="placeholder-text">
                                            <i class='bx bx-image-add text-2xl text-gray-400'></i>
                                            <p class="text-[9px] text-gray-500 mt-1">Klik Unggah</p>
                                        </div>
                                        <img src="{{ $product->image_path ? Storage::url($product->image_path) : '' }}" id="image-preview" class="absolute inset-0 w-full h-full object-cover {{ $product->image_path ? '' : 'hidden' }}">
                                        <input type="file" id="image-upload" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                </div>
                                
                                <!-- Gallery Images Preview -->
                                <div class="w-2/3">
                                    <label class="block text-[11px] font-bold text-gray-600 mb-1">Tambah Galeri (Maks. 9)</label>
                                    <div class="grid grid-cols-4 gap-1.5 h-[120px] overflow-y-auto" id="gallery-preview-container">
                                        @if(is_array($product->gallery_images))
                                            @foreach($product->gallery_images as $img)
                                            <div class="gallery-item relative w-full aspect-square bg-gray-100 rounded overflow-hidden border border-gray-200 group">
                                                <img src="{{ Storage::url($img) }}" class="absolute inset-0 w-full h-full object-cover">
                                                <button type="button" onclick="removeExistingGalleryImage(this, '{{ $img }}')" class="absolute top-1 right-1 bg-red-600 text-white rounded p-0.5 opacity-0 group-hover:opacity-100 transition shadow hover:bg-red-700">
                                                    <i class='bx bx-trash text-[10px]'></i>
                                                </button>
                                            </div>
                                            @endforeach
                                        @endif
                                        <label for="gallery-upload" class="relative w-full aspect-square bg-white rounded overflow-hidden border-2 border-dashed border-gray-300 hover:bg-gray-100 cursor-pointer flex flex-col items-center justify-center text-gray-400 transition" id="gallery-add-btn">
                                            <i class='bx bx-plus text-xl'></i>
                                            <input type='file' id="gallery-upload" name="gallery_images[]" class="hidden" accept="image/*" multiple onchange="previewGallery(event)" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 mb-1">Deskripsi Pemasaran</label>
                                <input type="hidden" name="description" id="description-input">
                                <div class="bg-white border border-gray-300 rounded overflow-hidden">
                                    <div id="editor" class="h-[150px] md:h-[200px] text-sm">{!! old('description', $product->description) !!}</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Footer / Submit -->
                    <div class="bg-gray-100 border-t border-gray-200 p-3 flex justify-end gap-3 flex-shrink-0">
                        <a href="{{ route('products.index') }}" class="px-4 py-1.5 bg-white border border-gray-300 rounded text-sm font-semibold text-gray-600 hover:bg-gray-50">Batal</a>
                        <button type="submit" class="px-5 py-1.5 bg-brand-600 border border-brand-600 text-white rounded text-sm font-bold shadow hover:bg-brand-700 flex items-center gap-2">
                            <i class='bx bx-save'></i> Perbarui Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.querySelector('select[name="category_id"]');
    const specSection = document.getElementById('spesifikasi-teknis-section');
    const stockContainer = document.getElementById('stock-qty-container');
    const snLabel = document.querySelector('input[name="serial_number"]').previousElementSibling;
    const modelLabel = document.querySelector('input[name="model_series"]').previousElementSibling;
    const condCol = document.querySelector('select[name="condition"]').parentElement;

    function toggleSpecs() {
        if (!categorySelect || !specSection) return;
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        const categoryType = selectedOption ? (selectedOption.getAttribute('data-type') || 'hardware') : 'hardware';

        if (categoryType === 'hardware') {
            specSection.style.display = 'grid';
            if(stockContainer) stockContainer.style.display = 'block';
            snLabel.textContent = 'Serial Number *';
            modelLabel.textContent = 'Model Series *';
            condCol.style.display = 'block';
        } else if (categoryType === 'peripheral') {
            specSection.style.display = 'none';
            if(stockContainer) stockContainer.style.display = 'block';
            snLabel.textContent = 'Serial Number / P/N *';
            modelLabel.textContent = 'Model Series *';
            condCol.style.display = 'none';
        } else if (categoryType === 'software') {
            specSection.style.display = 'none';
            if(stockContainer) stockContainer.style.display = 'block';
            snLabel.textContent = 'Kode Lisensi *';
            modelLabel.textContent = 'Tipe Lisensi *';
            condCol.style.display = 'none';
        } else if (categoryType === 'service') {
            specSection.style.display = 'none';
            if(stockContainer) stockContainer.style.display = 'none';
            snLabel.textContent = 'Kode / Ref *';
            modelLabel.textContent = 'Tipe Jasa *';
            condCol.style.display = 'none';
        } else {
            specSection.style.display = 'grid';
            if(stockContainer) stockContainer.style.display = 'block';
            snLabel.textContent = 'Serial Number *';
            modelLabel.textContent = 'Model Series *';
            condCol.style.display = 'block';
        }
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', () => {
            toggleSpecs();
            calculateSellingPrice();
        });
        toggleSpecs(); 
    }

    const purchasePriceInput = document.querySelector('input[name="purchase_price"]');
    const sellingPriceInput = document.querySelector('input[name="selling_price"]');

    function calculateSellingPrice() {
        if (!categorySelect || !purchasePriceInput || !sellingPriceInput) return;
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        if (!selectedOption || !selectedOption.value) return;

        const categoryName = selectedOption.text.trim().toLowerCase();
        const categoryType = selectedOption.getAttribute('data-type');
        let purchasePrice = parseFloat(purchasePriceInput.value) || 0;
        let sellingPrice = 0;

        if (categoryType === 'service') {
            purchasePriceInput.value = 0;
            if (categoryName.includes('instalasi')) {
                sellingPrice = 150000;
            } else if (categoryName.includes('perbaikan') || categoryName.includes('service')) {
                sellingPrice = 200000;
            } else if (categoryName.includes('website')) {
                sellingPrice = 500000;
            } else if (categoryName.includes('aplikasi')) {
                sellingPrice = 1000000;
            }
        } else if (categoryType === 'software') {
            sellingPrice = purchasePrice * 1.5;
        } else {
            if (purchasePrice <= 1999999) {
                sellingPrice = purchasePrice * 1.4;
            } else if (purchasePrice <= 2999999) {
                sellingPrice = purchasePrice * 1.35;
            } else if (purchasePrice <= 3999999) {
                sellingPrice = purchasePrice * 1.3;
            } else if (purchasePrice <= 4999999) {
                sellingPrice = purchasePrice * 1.25;
            } else {
                sellingPrice = purchasePrice * 1.2;
            }
        }

        sellingPriceInput.value = Math.round(sellingPrice);
    }

    if (purchasePriceInput) {
        purchasePriceInput.addEventListener('input', calculateSellingPrice);
    }

    // Quill Minimalist Initialization
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Fitur unggulan...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'bullet' }]
            ]
        }
    });

    document.getElementById('product-form').onsubmit = function() {
        document.getElementById('description-input').value = quill.root.innerHTML;
    };
});

// Image Live Preview
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const placeholder = document.getElementById('placeholder-text');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function previewGallery(event) {
    const files = event.target.files;
    const container = document.getElementById('gallery-preview-container');
    const addBtn = document.getElementById('gallery-add-btn');
    
    // Do NOT clear old previews to allow append visualization
    // However, for newly selected files, we append them
    if (files) {
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'gallery-item relative w-full aspect-square bg-gray-100 rounded overflow-hidden border border-gray-200';
                div.innerHTML = `<img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">
                                 <div class="absolute inset-0 bg-black bg-opacity-10 pointer-events-none"></div>
                                 <div class="absolute bottom-1 right-1 bg-emerald-500 text-white text-[8px] px-1 rounded">Baru</div>`;
                container.insertBefore(div, addBtn);
            }
            reader.readAsDataURL(file);
        });
    }
}

function removeExistingGalleryImage(btn, path) {
    btn.closest('.gallery-item').remove();
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_gallery[]';
    input.value = path;
    document.getElementById('product-form').appendChild(input);
}
</script>
</x-app-layout>
