<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('investors.index') }}" class="p-1.5 hover:bg-natural-100 rounded-lg transition-colors text-natural-500">
                <i class='bx bx-arrow-back text-base'></i>
            </a>
            <div>
                <h2 class="text-base font-bold text-natural-900 tracking-tight leading-none">Tambah Investor Baru</h2>
                <p class="text-natural-500 text-[9px] mt-1">Daftarkan pemodal baru ke sistem LKTech</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('investors.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-2xl border border-natural-100 shadow-sm p-6 space-y-5">

                {{-- Nama --}}
                <div>
                    <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Nama Investor <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Nama lengkap investor/pemodal"
                           class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email & Phone --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="email@example.com"
                               class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors @error('email') border-red-400 @enderror">
                        @error('email') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors">
                    </div>
                </div>

                {{-- Persentase Bagi Hasil --}}
                <div x-data="{ pct: {{ old('share_percentage', 30) }} }">
                    <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">
                        Persentase Bagi Hasil <span class="text-red-500">*</span>
                        <span class="text-brand-600 ml-1" x-text="pct + '%'"></span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="range" name="share_percentage" min="0" max="100" step="0.5"
                               x-model="pct"
                               class="flex-1 h-2 rounded-full appearance-none bg-natural-200 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:bg-brand-600 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:cursor-pointer">
                        <input type="number" x-model="pct" min="0" max="100" step="0.5"
                               class="w-20 px-3 py-2 border-2 border-natural-200 rounded-xl text-sm text-center font-bold focus:border-brand-500 focus:outline-none">
                    </div>
                    <p class="text-natural-400 text-[11px] mt-1">
                        Misal: Investor mendapat <span class="font-bold text-violet-600" x-text="pct + '%'"></span> dari setiap profit penjualan produknya. 
                        LKTech mendapat sisanya <span class="font-bold text-brand-600" x-text="(100 - pct).toFixed(1) + '%'"></span>.
                    </p>
                    @error('share_percentage') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Catatan Kesepakatan --}}
                <div>
                    <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Catatan Kesepakatan</label>
                    <textarea name="notes" rows="3"
                              placeholder="Tuliskan detail perjanjian, syarat khusus, atau informasi tambahan tentang investor ini..."
                              class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors resize-none">{{ old('notes') }}</textarea>
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-3 p-4 bg-natural-50 rounded-xl border border-natural-100">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-natural-300 text-brand-600 focus:ring-brand-500">
                    <label for="is_active" class="text-sm font-semibold text-natural-700 cursor-pointer">
                        Investor Aktif
                        <span class="text-natural-400 font-normal text-xs ml-1">(produk investor aktif akan masuk laporan konsolidasi)</span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-2 border-t border-natural-100">
                    <button type="submit"
                            class="flex-1 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all text-sm shadow-sm hover:shadow-md">
                        <i class='bx bx-save mr-1.5'></i> Simpan Investor
                    </button>
                    <a href="{{ route('investors.index') }}"
                       class="px-5 py-2.5 bg-natural-100 hover:bg-natural-200 text-natural-700 font-bold rounded-xl transition-all text-sm">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>
