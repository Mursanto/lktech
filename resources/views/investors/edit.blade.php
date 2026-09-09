<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('investors.index') }}" class="p-1.5 hover:bg-natural-100 rounded-lg transition-colors text-natural-500">
                <i class='bx bx-arrow-back text-base'></i>
            </a>
            <div>
                <h2 class="text-base font-bold text-natural-900 tracking-tight leading-none">Edit Investor: {{ $investor->name }}</h2>
                <p class="text-natural-500 text-[9px] mt-1">Perbarui data dan persentase bagi hasil</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <form action="{{ route('investors.update', $investor) }}" method="POST">
            @csrf @method('PUT')

            <div class="bg-white rounded-2xl border border-natural-100 shadow-sm p-6 space-y-5">

                {{-- Nama --}}
                <div>
                    <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Nama Investor <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $investor->name) }}" required
                           class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email & Phone --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" value="{{ old('email', $investor->email) }}"
                               class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors">
                        <p class="text-natural-400 text-[10px] mt-1">Email digunakan untuk login akun Investor (jika ada)</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Nomor Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $investor->phone) }}"
                               class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors">
                    </div>
                </div>

                {{-- Persentase Bagi Hasil --}}
                <div x-data="{ pct: {{ old('share_percentage', $investor->share_percentage) }} }">
                    <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">
                        Persentase Bagi Hasil <span class="text-red-500">*</span>
                        <span class="text-brand-600 ml-1" x-text="parseFloat(pct).toFixed(1) + '%'"></span>
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="range" name="share_percentage" min="0" max="100" step="0.5"
                               x-model="pct"
                               class="flex-1 h-2 rounded-full appearance-none bg-natural-200 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:bg-brand-600 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:cursor-pointer">
                        <input type="number" x-model="pct" min="0" max="100" step="0.5"
                               class="w-20 px-3 py-2 border-2 border-natural-200 rounded-xl text-sm text-center font-bold focus:border-brand-500 focus:outline-none">
                    </div>
                    <p class="text-natural-400 text-[11px] mt-1">
                        Investor mendapat <span class="font-bold text-violet-600" x-text="parseFloat(pct).toFixed(1) + '%'"></span> — 
                        LKTech mendapat <span class="font-bold text-brand-600" x-text="(100 - parseFloat(pct)).toFixed(1) + '%'"></span> dari setiap profit produknya.
                    </p>
                    @error('share_percentage') <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-xs font-bold text-natural-700 mb-1.5 uppercase tracking-wider">Catatan Kesepakatan</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-2.5 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none transition-colors resize-none">{{ old('notes', $investor->notes) }}</textarea>
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-3 p-4 bg-natural-50 rounded-xl border border-natural-100">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', $investor->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-natural-300 text-brand-600 focus:ring-brand-500">
                    <label for="is_active" class="text-sm font-semibold text-natural-700 cursor-pointer">
                        Investor Aktif
                    </label>
                </div>

                {{-- Info produk terkait --}}
                @if($investor->products->count() > 0)
                <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-xl">
                    <div class="flex items-center gap-2 text-indigo-700 font-semibold text-sm mb-1">
                        <i class='bx bx-info-circle'></i>
                        {{ $investor->products->count() }} produk terkait dengan investor ini
                    </div>
                    <p class="text-indigo-600 text-xs">Perubahan persentase bagi hasil akan langsung berlaku untuk semua kalkulasi ke depan. Transaksi lama menggunakan snapshot profit yang sudah tersimpan.</p>
                </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-2 border-t border-natural-100">
                    <button type="submit"
                            class="flex-1 px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all text-sm shadow-sm hover:shadow-md">
                        <i class='bx bx-save mr-1.5'></i> Simpan Perubahan
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
