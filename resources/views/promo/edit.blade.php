<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Pengaturan Banner Promo 🖼️</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Kelola banner promo dinamis di halaman utama.</p>
            </div>
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">

        <!-- Alert Success/Error -->
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
                <i class='bx bx-check-circle text-xl'></i>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 flex items-center gap-3">
                <i class='bx bx-error-circle text-xl'></i>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-natural-200 overflow-hidden">
            
            <form action="{{ route('promo.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                @php
                    $promoBanners = $setting->promo_banners ?? [];
                    if (empty($promoBanners) && $setting->promo_image_path) {
                        $promoBanners[0] = [
                            'image' => $setting->promo_image_path,
                            'link' => $setting->promo_link
                        ];
                    }
                @endphp

                <div class="space-y-8">
                    @for($i = 0; $i < 7; $i++)
                        @php
                            $banner = $promoBanners[$i] ?? null;
                        @endphp
                        <div class="p-6 border border-natural-200 rounded-2xl bg-natural-50/50 relative">
                            <h3 class="text-sm font-black text-brand-600 mb-4 uppercase tracking-wider">Slot Banner {{ $i + 1 }}</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Kiri: Form Input -->
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-bold text-natural-900 mb-1.5">Gambar Banner Promo</label>
                                        <input type="file" name="banners[{{ $i }}][image]" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full bg-white border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 transition-colors">
                                        @if($i == 0)
                                            <p class="text-[11px] text-natural-500 mt-2">Format: JPG, PNG, WEBP. Maks 5MB. Otomatis di-resize max 1200px.</p>
                                        @endif
                                        @error("banners.{$i}.image")
                                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-natural-900 mb-1.5">Tautan / Link Promo (Opsional)</label>
                                        <input type="url" name="banners[{{ $i }}][link]" value="{{ old("banners.{$i}.link", $banner['link'] ?? '') }}" class="w-full bg-white border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-2.5 transition-colors" placeholder="https://contoh.com/promo">
                                        @error("banners.{$i}.link")
                                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    @if($banner && isset($banner['image']))
                                    <div class="pt-2">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="banners[{{ $i }}][delete]" value="1" class="rounded border-natural-300 text-rose-600 shadow-sm focus:ring-rose-500">
                                            <span class="ml-2 text-sm font-bold text-rose-600 hover:text-rose-700">Hapus Banner Ini</span>
                                        </label>
                                    </div>
                                    @endif
                                </div>

                                <!-- Kanan: Preview -->
                                <div>
                                    <label class="block text-sm font-bold text-natural-900 mb-1.5">Preview Saat Ini</label>
                                    <div class="border-2 border-dashed border-natural-200 rounded-2xl flex items-center justify-center bg-white p-3 aspect-[21/9] overflow-hidden">
                                        @if($banner && isset($banner['image']))
                                            <img src="{{ asset('storage/' . $banner['image']) }}" alt="Banner Promo {{ $i + 1 }}" class="max-w-full max-h-full object-contain rounded-lg shadow-sm">
                                        @else
                                            <div class="text-center text-natural-400">
                                                <i class='bx bx-image text-4xl mb-1'></i>
                                                <p class="text-xs font-medium">Belum ada gambar.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="mt-8 pt-6 border-t border-natural-200 flex justify-end gap-3">
                    <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm shadow-brand-500/30 flex items-center gap-2 group">
                        <i class='bx bx-upload text-lg group-hover:-translate-y-1 transition-transform'></i> Upload & Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
