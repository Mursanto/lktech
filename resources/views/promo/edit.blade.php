<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-base font-bold text-natural-900 tracking-tight leading-none">Banner & Produk Promo 🖼️🔥</h2>
                <p class="text-natural-500 text-[9px] mt-1">Kelola banner promo & produk promo di halaman utama.</p>
            </div>
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-6 w-full max-w-5xl mx-auto space-y-8">

        <!-- Alert Success/Error -->
        @if(session('success'))
            <div class="px-3 py-2 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-2">
                <i class='bx bx-check-circle text-base'></i>
                <span class="text-[11px] font-bold">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="px-3 py-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 flex items-center gap-2">
                <i class='bx bx-error-circle text-base'></i>
                <span class="text-[11px] font-bold">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('promo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @php
                $promoBanners = $setting->promo_banners ?? [];
                if (empty($promoBanners) && $setting->promo_image_path) {
                    $promoBanners[0] = [
                        'image' => $setting->promo_image_path,
                        'link'  => $setting->promo_link
                    ];
                }
                $promoProductLinks = $setting->promo_product_links ?? [];
            @endphp

            {{-- ================================================================
                 BAGIAN 1: PENGATURAN BANNER PROMO (Slot 1–4)
                 ================================================================ --}}
            <div class="bg-white rounded-3xl shadow-sm border border-natural-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-natural-100 bg-gradient-to-r from-blue-50 to-white flex items-center gap-2">
                    <div class="w-7 h-7 bg-blue-500 rounded-lg flex items-center justify-center shrink-0">
                        <i class='bx bx-image text-white text-base'></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-natural-900 tracking-tight">Pengaturan Banner Promo</h3>
                        <p class="text-[10px] text-natural-400 mt-0.5">Gambar banner yang tampil di slider Hero halaman utama.</p>
                    </div>
                </div>

                <div class="p-5 space-y-6">
                    @for($i = 0; $i < 4; $i++)
                        @php $banner = $promoBanners[$i] ?? null; @endphp
                        <div class="p-5 border border-natural-200 rounded-2xl bg-natural-50/50 relative">
                            <h4 class="text-xs font-black text-blue-600 mb-3 uppercase tracking-wider">Slot Banner {{ $i + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kiri: Form Input -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[11px] font-bold text-natural-900 mb-1">Gambar Banner Promo</label>
                                        <input type="file" name="banners[{{ $i }}][image]" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full bg-white border border-natural-200 text-natural-900 text-[11px] rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                                        @if($i == 0)
                                            <p class="text-[9px] text-natural-500 mt-1.5 leading-relaxed">Format: JPG, PNG, WEBP. Maks 5MB. Rekomendasi: 1200 × 675 px (Rasio 16:9).</p>
                                        @endif
                                        @error("banners.{$i}.image")
                                            <p class="text-rose-500 text-[9px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-natural-900 mb-1">Tautan / Link Banner (Opsional)</label>
                                        <input type="url" name="banners[{{ $i }}][link]" value="{{ old("banners.{$i}.link", $banner['link'] ?? '') }}" class="w-full bg-white border border-natural-200 text-natural-900 text-[11px] rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 transition-colors" placeholder="https://contoh.com/promo">
                                        @error("banners.{$i}.link")
                                            <p class="text-rose-500 text-[9px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @if($banner && isset($banner['image']))
                                    <div class="pt-1">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="banners[{{ $i }}][delete]" value="1" class="rounded border-natural-300 text-rose-600 shadow-sm focus:ring-rose-500">
                                            <span class="ml-2 text-[11px] font-bold text-rose-600 hover:text-rose-700">Hapus Banner Ini</span>
                                        </label>
                                    </div>
                                    @endif
                                </div>

                                <!-- Kanan: Preview -->
                                <div>
                                    <label class="block text-[11px] font-bold text-natural-900 mb-1">Preview Saat Ini</label>
                                    <div class="border-2 border-dashed border-natural-200 rounded-2xl flex items-center justify-center bg-white p-2 aspect-[21/9] overflow-hidden">
                                        @if($banner && isset($banner['image']))
                                            <img src="{{ asset('storage/' . $banner['image']) }}" alt="Banner Promo {{ $i + 1 }}" class="max-w-full max-h-full object-contain rounded-lg shadow-sm">
                                        @else
                                            <div class="text-center text-natural-400">
                                                <i class='bx bx-image text-3xl mb-1'></i>
                                                <p class="text-[10px] font-medium">Belum ada gambar.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- ================================================================
                 BAGIAN 2: PENGATURAN PRODUK PROMO (Slot 1–3)
                 ================================================================ --}}
            <div class="bg-white rounded-3xl shadow-sm border border-natural-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-natural-100 bg-gradient-to-r from-orange-50 to-white flex items-center gap-2">
                    <div class="w-7 h-7 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg flex items-center justify-center shrink-0">
                        <i class='bx bxs-hot text-white text-base'></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-natural-900 tracking-tight">Pengaturan Produk Promo</h3>
                        <p class="text-[10px] text-natural-400 mt-0.5">Link produk yang tampil di section "🔥 Produk Promo" halaman utama (di bawah banner).</p>
                    </div>
                </div>

                <div class="p-5 space-y-4">
                    <div class="p-3 bg-orange-50 border border-orange-200 rounded-xl flex items-start gap-2">
                        <i class='bx bx-info-circle text-orange-500 text-sm mt-0.5 shrink-0'></i>
                        <p class="text-[10px] text-orange-700 leading-relaxed">
                            Masukkan link produk dari katalog (contoh: <code class="bg-orange-100 px-1 rounded">https://lktech.online/katalog/49</code>). 
                            Produk tersebut akan tampil dengan badge <strong>🔥 PROMO UTAMA</strong> di section khusus bawah banner.
                            Kosongkan kolom untuk menonaktifkan promo.
                        </p>
                    </div>

                    @for($j = 0; $j < 3; $j++)
                    <div class="p-4 border border-natural-200 rounded-2xl bg-natural-50/50">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-6 h-6 bg-gradient-to-br from-orange-500 to-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center">{{ $j + 1 }}</span>
                            <h4 class="text-xs font-black text-orange-600 uppercase tracking-wider">Produk Promo {{ $j + 1 }}</h4>
                        </div>
                        <label class="block text-[11px] font-bold text-natural-900 mb-1">Link Produk (URL Katalog)</label>
                        <input type="url" 
                               name="promo_product_links[{{ $j }}]" 
                               value="{{ old("promo_product_links.{$j}", $promoProductLinks[$j] ?? '') }}" 
                               class="w-full bg-white border border-natural-200 text-natural-900 text-[11px] rounded-xl focus:ring-orange-500 focus:border-orange-500 block p-2.5 transition-colors" 
                               placeholder="https://lktech.online/katalog/ID_PRODUK">
                        @error("promo_product_links.{$j}")
                            <p class="text-rose-500 text-[9px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endfor
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-[11px] transition-all shadow-sm shadow-brand-500/30 flex items-center gap-1.5 group">
                    <i class='bx bx-save text-base group-hover:-translate-y-0.5 transition-transform'></i> Simpan Semua Perubahan
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
