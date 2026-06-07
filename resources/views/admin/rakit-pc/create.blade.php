<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('rakit-pc-admin.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-arrow-back text-xl'></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Paket Rakit PC
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('rakit-pc-admin.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Kolom Utama -->
                        <div class="md:col-span-2 space-y-6">
                            
                            <div>
                                <label for="nama_paket" class="block text-sm font-bold text-gray-700 mb-1">Nama Paket <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                       placeholder="Contoh: Gaming & Editing Standard">
                                @error('nama_paket') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="harga_estimasi" class="block text-sm font-bold text-gray-700 mb-1">Harga Estimasi (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="harga_estimasi" id="harga_estimasi" value="{{ old('harga_estimasi') }}" required min="0" step="1000"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                       placeholder="Contoh: 7500000">
                                @error('harga_estimasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat (Opsional)</label>
                                <textarea name="deskripsi" id="deskripsi" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                          placeholder="Contoh: Lancar bermain game e-sports & editing video 1080p...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="spesifikasi_singkat" class="block text-sm font-bold text-gray-700 mb-1">Spesifikasi Detail (Opsional)</label>
                                <textarea name="spesifikasi_singkat" id="spesifikasi_singkat" rows="5"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                          placeholder="Contoh: CPU: Core i5 / Ryzen 5&#10;RAM: 16GB DDR4&#10;Storage: 512GB SSD NVMe">{{ old('spesifikasi_singkat') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Gunakan enter (baris baru) untuk memisahkan setiap komponen agar tampil rapi sebagai list.</p>
                                @error('spesifikasi_singkat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <!-- Kolom Samping -->
                        <div class="space-y-6">
                            
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Status & Simpan</h3>
                                
                                <label class="flex items-center gap-3 cursor-pointer mb-6">
                                    <div class="relative">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <div class="block bg-gray-300 w-10 h-6 rounded-full transition-colors toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 font-bold toggle-label">Aktif (Tampil)</span>
                                </label>

                                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors">
                                    Simpan Paket
                                </button>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Foto Paket (Opsional)</h3>
                                
                                <label for="foto" class="relative cursor-pointer block mt-1 px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-white group overflow-hidden hover:border-brand-500 transition-colors text-center" id="foto-preview-container">
                                    <input id="foto" name="foto" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewImage(event)">
                                    
                                    <div class="space-y-1 relative z-10 transition-opacity duration-300" id="foto-upload-text">
                                        <i class='bx bx-image-add text-4xl text-gray-400 group-hover:text-brand-500 transition-colors'></i>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="font-bold text-brand-600 group-hover:text-brand-500">Upload/Ganti Foto</span>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                    </div>

                                    <img id="foto-preview" src="#" alt="Preview" class="hidden absolute inset-0 w-full h-full object-contain bg-white sm:bg-gray-50 p-2 group-hover:opacity-40 transition-opacity duration-300">
                                    
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 pointer-events-none" id="foto-hover-overlay">
                                        <span class="bg-black/70 text-white px-3 py-1.5 rounded-lg text-sm font-bold flex items-center gap-1 shadow-lg"><i class='bx bx-edit'></i> Ganti Foto</span>
                                    </div>
                                </label>
                                @error('foto') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        input:checked ~ .toggle-bg { background-color: #2563eb; }
        input:checked ~ .dot { transform: translateX(100%); }
    </style>

    <script>
        // Toggle Label Logic
        const checkbox = document.querySelector('input[name="is_active"]');
        const toggleLabel = document.querySelector('.toggle-label');
        
        checkbox.addEventListener('change', function() {
            if(this.checked) {
                toggleLabel.textContent = 'Aktif (Tampil)';
                toggleLabel.classList.add('text-gray-700');
                toggleLabel.classList.remove('text-gray-400');
            } else {
                toggleLabel.textContent = 'Nonaktif (Sembunyikan)';
                toggleLabel.classList.remove('text-gray-700');
                toggleLabel.classList.add('text-gray-400');
            }
        });

        // Image Preview
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('foto-preview');
                var uploadText = document.getElementById('foto-upload-text');
                var overlay = document.getElementById('foto-hover-overlay');
                
                output.src = reader.result;
                output.classList.remove('hidden');
                uploadText.classList.add('opacity-0'); 
                
                // Show hover overlay functionality after image is uploaded
                document.getElementById('foto-preview-container').addEventListener('mouseenter', function() {
                    overlay.classList.remove('opacity-0');
                });
                document.getElementById('foto-preview-container').addEventListener('mouseleave', function() {
                    overlay.classList.add('opacity-0');
                });
            }
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>
