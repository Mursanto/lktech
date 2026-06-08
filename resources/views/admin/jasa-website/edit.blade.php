<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('jasa-website-admin.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-arrow-back text-xl'></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Paket Jasa Website
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <form action="{{ route('jasa-website-admin.update', $package) }}" method="POST" class="p-6 md:p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Kolom Utama -->
                        <div class="md:col-span-2 space-y-6">
                            
                            <div>
                                <label for="nama_paket" class="block text-sm font-bold text-gray-700 mb-1">Nama Paket <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_paket" id="nama_paket" value="{{ old('nama_paket', $package->nama_paket) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                       placeholder="Contoh: Paket Starter">
                                @error('nama_paket') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="harga_mulai" class="block text-sm font-bold text-gray-700 mb-1">Harga Mulai (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="harga_mulai" id="harga_mulai" value="{{ old('harga_mulai', $package->harga_mulai) }}" required min="0" step="1000"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                       placeholder="Contoh: 1499000">
                                @error('harga_mulai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="deskripsi_singkat" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat / Kategori (Opsional)</label>
                                <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                          placeholder="Contoh: Landing Page / UMKM">{{ old('deskripsi_singkat', $package->deskripsi_singkat) }}</textarea>
                                @error('deskripsi_singkat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="fitur_list" class="block text-sm font-bold text-gray-700 mb-1">Fitur Utama (Opsional)</label>
                                <textarea name="fitur_list" id="fitur_list" rows="5"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                          placeholder="Contoh: 1 Halaman Landing Page Panjang&#10;Desain Modern (Template Premium)&#10;Gratis Domain (.com/.id) & Hosting 1 Thn">{{ old('fitur_list', $package->fitur_list) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Gunakan enter (baris baru) untuk setiap poin (bullet point).</p>
                                @error('fitur_list') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>

                        <!-- Kolom Samping -->
                        <div class="space-y-6">
                            
                            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Status & Badge</h3>

                                <div class="mb-6">
                                    <label for="badge" class="block text-sm font-bold text-gray-700 mb-1">Badge Spesial (Opsional)</label>
                                    <input type="text" name="badge" id="badge" value="{{ old('badge', $package->badge) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                                           placeholder="Contoh: Best Seller">
                                    <p class="text-[10px] text-gray-500 mt-1 block">Tampil mencolok pada kartu paket.</p>
                                    @error('badge') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                
                                <label class="flex items-center gap-3 cursor-pointer mb-6">
                                    <div class="relative">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                        <div class="block bg-gray-300 w-10 h-6 rounded-full transition-colors toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 font-bold toggle-label">{{ old('is_active', $package->is_active) ? 'Aktif (Tampil)' : 'Nonaktif (Sembunyikan)' }}</span>
                                </label>

                                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-lg shadow-sm transition-colors">
                                    Perbarui Paket
                                </button>
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
        
        // Initialize state on load
        if(!checkbox.checked) {
            toggleLabel.classList.remove('text-gray-700');
            toggleLabel.classList.add('text-gray-400');
        }
    </script>
</x-app-layout>
