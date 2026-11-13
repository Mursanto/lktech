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

        {{-- Kelola Mutasi & Setoran Modal Pokok --}}
        <div class="bg-white rounded-2xl border border-natural-100 shadow-sm p-6 mt-6">
            <div class="flex items-center justify-between pb-4 border-b border-natural-100">
                <div>
                    <h3 class="text-sm font-bold text-natural-900">Buku Kas Setoran Modal Pokok</h3>
                    <p class="text-[10px] text-natural-500 mt-0.5">Catat setoran modal baru (Top Up) atau penarikan modal</p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] text-natural-400 uppercase tracking-wider font-semibold">Total Modal Pokok</p>
                    <p class="text-lg font-black text-blue-700 leading-none">Rp {{ number_format($investor->totalCapital(), 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Form Tambah Setoran Modal --}}
            <div x-data="{ openForm: false }" class="mt-4">
                <button type="button" @click="openForm = !openForm" class="px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl text-xs transition-colors flex items-center gap-1.5 shadow-sm">
                    <i class='bx' :class="openForm ? 'bx-x' : 'bx-plus-circle'"></i>
                    <span x-text="openForm ? 'Tutup Form' : '+ Tambah Setoran / Penarikan Modal'"></span>
                </button>

                <div x-show="openForm" x-cloak class="mt-3 p-4 bg-natural-50 rounded-xl border border-natural-200">
                    <form action="{{ route('investors.deposits.store', $investor) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[10px] font-bold text-natural-600 mb-1 uppercase tracking-wider">Tipe Mutasi</label>
                                <select name="type" required class="w-full px-3 py-2 border border-natural-300 rounded-lg text-xs focus:border-brand-500 focus:outline-none bg-white">
                                    <option value="deposit">Setoran Modal (Top Up +)</option>
                                    <option value="withdrawal">Penarikan Modal (-)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-natural-600 mb-1 uppercase tracking-wider">Nominal (Rp)</label>
                                <input type="number" name="amount" min="1" step="1000" placeholder="Contoh: 5000000" required class="w-full px-3 py-2 border border-natural-300 rounded-lg text-xs focus:border-brand-500 focus:outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-natural-600 mb-1 uppercase tracking-wider">Tanggal</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-natural-300 rounded-lg text-xs focus:border-brand-500 focus:outline-none bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-natural-600 mb-1 uppercase tracking-wider">Keterangan / Catatan</label>
                            <input type="text" name="notes" placeholder="Contoh: Setoran modal tambahan ekspansi 2 unit" class="w-full px-3 py-2 border border-natural-300 rounded-lg text-xs focus:border-brand-500 focus:outline-none bg-white">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-natural-600 mb-1 uppercase tracking-wider">Lampiran Bukti Transfer (Opsional)</label>
                            <input type="file" name="proof_attachment" accept="image/*,.pdf" class="w-full text-xs text-natural-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-natural-200 file:text-natural-700 hover:file:bg-natural-300">
                        </div>

                        <div class="flex justify-end pt-1">
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-xs transition-colors shadow-sm">
                                Simpan Catatan Modal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel Riwayat Mutasi Modal --}}
            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-natural-50 border-b border-natural-100 text-natural-500 font-bold uppercase text-[9px]">
                            <th class="text-left px-2.5 py-2">Tanggal</th>
                            <th class="text-left px-2.5 py-2">Tipe</th>
                            <th class="text-left px-2.5 py-2">Keterangan</th>
                            <th class="text-right px-2.5 py-2">Nominal</th>
                            <th class="text-center px-2.5 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($deposits as $dep)
                        <tr class="hover:bg-natural-50/50">
                            <td class="px-2.5 py-2 text-natural-600 font-medium whitespace-nowrap">
                                {{ $dep->date ? \Carbon\Carbon::parse($dep->date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-2.5 py-2 whitespace-nowrap">
                                @if($dep->type === 'deposit')
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Setoran (+)</span>
                                @else
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Tarik (-)</span>
                                @endif
                            </td>
                            <td class="px-2.5 py-2 text-natural-700">
                                {{ $dep->notes ?? '-' }}
                            </td>
                            <td class="px-2.5 py-2 text-right font-bold whitespace-nowrap {{ $dep->type === 'deposit' ? 'text-blue-700' : 'text-amber-700' }}">
                                {{ $dep->type === 'deposit' ? '+' : '-' }}Rp {{ number_format($dep->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-2.5 py-2 text-center whitespace-nowrap">
                                <form action="{{ route('investors.deposits.destroy', $dep) }}" method="POST" onsubmit="return confirm('Hapus mutasi modal ini?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus">
                                        <i class='bx bx-trash text-sm'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-2.5 py-4 text-center text-natural-400">
                                Belum ada catatan mutasi setoran modal
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
