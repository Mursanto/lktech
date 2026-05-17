<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Katalog: {{ $product->brand }} {{ $product->model_series }}
        </h2>
    </x-slot>

    <!-- Quill Editor CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Manajemen Foto & Deskripsi Pemasaran</h3>
                    <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Batal & Kembali</a>
                </div>

                <div class="p-6">
                    <form action="{{ route('catalog.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="catalog-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Left: Image Upload -->
                            <div class="md:col-span-1 space-y-6">
                                
                                <!-- Main Image -->
                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-700">Foto Produk Utama</label>
                                    
                                    <!-- Image Preview Container -->
                                    <div class="relative w-full aspect-square bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 overflow-hidden flex items-center justify-center group" id="image-preview-container">
                                        @if($product->image_path)
                                            <img src="{{ Storage::url($product->image_path) }}" id="image-preview" class="absolute inset-0 w-full h-full object-cover">
                                        @else
                                            <!-- Fallback preview -->
                                            @php
                                                $searchQuery = urlencode($product->brand . ' ' . $product->model_series . ' laptop');
                                                $fallbackUrl = "https://source.unsplash.com/400x400/?{$searchQuery}";
                                            @endphp
                                            <img src="{{ $fallbackUrl }}" id="image-preview" class="absolute inset-0 w-full h-full object-cover opacity-50 grayscale">
                                            <div class="text-center z-10" id="placeholder-text">
                                                <i class='bx bx-image-add text-4xl text-gray-400'></i>
                                                <p class="text-xs text-gray-500 mt-2 font-medium px-4">Menggunakan Gambar Auto-Fetch.<br>Klik untuk unggah foto asli.</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Upload Button -->
                                    <div class="flex items-center justify-center w-full">
                                        <label for="image-upload" class="w-full flex flex-col items-center px-4 py-2 bg-white text-brand-600 rounded-lg shadow-sm border border-brand-200 tracking-wide uppercase cursor-pointer hover:bg-brand-50 hover:text-brand-700 transition">
                                            <span class="text-xs font-bold leading-normal flex items-center gap-2">
                                                <i class='bx bx-upload text-lg'></i> Pilih Foto Utama
                                            </span>
                                            <input type='file' id="image-upload" name="image" class="hidden" accept="image/*" onchange="previewImage(event)" />
                                        </label>
                                    </div>
                                    @error('image')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gallery Images -->
                                <div class="space-y-3 border-t border-gray-100 pt-5">
                                    <label class="block text-sm font-semibold text-gray-700">Tambah Galeri (Maks. 9)</label>
                                    
                                    <div class="grid grid-cols-3 gap-2" id="gallery-preview-container">
                                        @if($product->gallery_images && is_array($product->gallery_images))
                                            @foreach($product->gallery_images as $galleryImg)
                                                <div class="gallery-item relative w-full aspect-square bg-gray-100 rounded-md overflow-hidden border border-gray-200 shadow-sm group">
                                                    <img src="{{ Storage::url($galleryImg) }}" class="absolute inset-0 w-full h-full object-cover">
                                                    <button type="button" onclick="removeExistingGalleryImage(this, '{{ $galleryImg }}')" class="absolute top-1 right-1 bg-red-600 text-white rounded p-1 opacity-0 group-hover:opacity-100 transition shadow hover:bg-red-700">
                                                        <i class='bx bx-trash text-xs'></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                        <!-- Add More Button -->
                                        <label for="gallery-upload" class="relative w-full aspect-square bg-gray-50 rounded-md overflow-hidden border-2 border-dashed border-gray-300 hover:bg-gray-100 cursor-pointer flex flex-col items-center justify-center text-gray-400 hover:text-brand-600 transition" id="gallery-add-btn">
                                            <i class='bx bx-plus text-2xl'></i>
                                            <span class="text-[10px] font-medium mt-1">Tambah</span>
                                            <input type='file' id="gallery-upload" name="gallery_images[]" class="hidden" accept="image/*" multiple onchange="previewGallery(event)" />
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">Unggah foto detail lecet, port, atau kelengkapan.</p>
                                    @error('gallery_images.*')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <!-- Right: Description Editor -->
                            <div class="md:col-span-2 flex flex-col h-full">
                                <div class="mb-2 flex justify-between items-end">
                                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Pemasaran (Spesifikasi Lengkap)</label>
                                    <button type="button" onclick="insertTemplate()" class="text-xs text-brand-600 hover:text-brand-800 font-medium">Gunakan Template</button>
                                </div>
                                
                                <!-- Hidden input to hold the HTML content for submission -->
                                <input type="hidden" name="description" id="description-input">
                                
                                <!-- Quill Editor Container -->
                                <div class="flex-grow flex flex-col border border-gray-200 rounded-lg overflow-hidden bg-white">
                                    <div id="editor" class="min-h-[300px] text-gray-800 text-sm">{!! old('description', $product->description) !!}</div>
                                </div>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Save Button -->
                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg shadow-sm transition flex items-center gap-2">
                                        <i class='bx bx-save text-lg'></i> Simpan Katalog
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        // Initialize Quill Editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Tuliskan deskripsi lengkap, fitur unggulan, dan kondisi laptop di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden input before submit
        document.getElementById('catalog-form').onsubmit = function() {
            var descriptionInput = document.getElementById('description-input');
            descriptionInput.value = quill.root.innerHTML;
        };

        // Image Preview Logic
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('image-preview');
                if(!output) {
                    output = document.createElement('img');
                    output.id = 'image-preview';
                    output.className = 'absolute inset-0 w-full h-full object-cover';
                    document.getElementById('image-preview-container').appendChild(output);
                }
                output.src = reader.result;
                output.classList.remove('opacity-50', 'grayscale');
                
                var placeholder = document.getElementById('placeholder-text');
                if(placeholder) placeholder.style.display = 'none';
            };
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        // Gallery Preview Logic
        function previewGallery(event) {
            const container = document.getElementById('gallery-preview-container');
            const addBtn = document.getElementById('gallery-add-btn');
            
            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'gallery-item relative w-full aspect-square bg-gray-100 rounded-md overflow-hidden border border-gray-200 shadow-sm';
                        div.innerHTML = `<img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">
                                         <div class="absolute inset-0 bg-black bg-opacity-10 pointer-events-none"></div>
                                         <div class="absolute bottom-1 right-1 bg-emerald-500 text-white text-[10px] px-1.5 py-0.5 rounded font-bold">Baru</div>`;
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
            document.getElementById('catalog-form').appendChild(input);
        }

        // Insert Template
        function insertTemplate() {
            const template = `
                <h3>Spesifikasi Utama:</h3>
                <ul>
                    <li><strong>Prosesor:</strong> {{ $product->processor ?: '-' }}</li>
                    <li><strong>RAM:</strong> {{ $product->ram ?: '-' }}</li>
                    <li><strong>Penyimpanan:</strong> {{ $product->storage ?: '-' }}</li>
                    <li><strong>Layar:</strong> {{ $product->screen_size ? $product->screen_size . '"' : '-' }}</li>
                </ul>
                <p><br></p>
                <h3>Kondisi Unit:</h3>
                <ul>
                    <li>Fisik Mulus ({{ $product->condition ?: '95' }}%)</li>
                    <li>Baterai awet up to ±{{ $product->battery_runtime ?: '2-3' }} jam</li>
                    <li>Semua port dan fitur berfungsi normal</li>
                </ul>
                <p><br></p>
                <h3>Kelengkapan:</h3>
                <ul>
                    <li>Unit Laptop</li>
                    <li>Charger Adaptor Original</li>
                    <li>Tas/Softcase (Opsional)</li>
                </ul>
            `;
            quill.clipboard.dangerouslyPasteHTML(template);
        }
    </script>
</x-app-layout>
