<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Pengaturan Web ✨</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Kelola informasi toko, kontak, sosial media, dan konten halaman statis.</p>
            </div>
        </div>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
            <i class='bx bx-check-circle text-xl'></i>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-natural-200 overflow-hidden" x-data="{ tab: 'umum' }">
        
        <!-- Tabs -->
        <div class="border-b border-natural-200 flex flex-wrap bg-natural-50/50 p-2 gap-2">
            <button @click="tab = 'umum'" :class="{ 'bg-white text-brand-700 font-bold shadow-sm ring-1 ring-natural-200/50': tab === 'umum', 'text-natural-600 hover:text-natural-900 font-medium hover:bg-natural-100': tab !== 'umum' }" class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center gap-2">
                <i class='bx bx-store-alt text-lg' :class="{ 'text-brand-500': tab === 'umum' }"></i> Umum & Footer
            </button>
            <button @click="tab = 'tentang'" :class="{ 'bg-white text-brand-700 font-bold shadow-sm ring-1 ring-natural-200/50': tab === 'tentang', 'text-natural-600 hover:text-natural-900 font-medium hover:bg-natural-100': tab !== 'tentang' }" class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center gap-2">
                <i class='bx bx-info-circle text-lg' :class="{ 'text-brand-500': tab === 'tentang' }"></i> Tentang Kami
            </button>
            <button @click="tab = 'garansi'" :class="{ 'bg-white text-brand-700 font-bold shadow-sm ring-1 ring-natural-200/50': tab === 'garansi', 'text-natural-600 hover:text-natural-900 font-medium hover:bg-natural-100': tab !== 'garansi' }" class="px-5 py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center gap-2">
                <i class='bx bx-shield-quarter text-lg' :class="{ 'text-brand-500': tab === 'garansi' }"></i> Kebijakan Garansi
            </button>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- TAB: Umum & Footer -->
            <div x-show="tab === 'umum'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Info Toko -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-natural-900 border-b border-natural-200 pb-2">Informasi Utama</h3>
                        
                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Nama Toko <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_toko" value="{{ old('nama_toko', $setting->nama_toko) }}" required class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors" placeholder="Contoh: LKTech TN SEREAL">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Deskripsi Singkat Footer</label>
                            <textarea name="deskripsi_footer" rows="3" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors">{{ old('deskripsi_footer', $setting->deskripsi_footer) }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Jam Operasional</label>
                            <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $setting->jam_operasional) }}" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors" placeholder="Contoh: Senin - Sabtu: 09:00 - 17:00">
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-natural-900 border-b border-natural-200 pb-2">Kontak & Lokasi</h3>
                        
                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Telepon / WhatsApp</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $setting->telepon) }}" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors" placeholder="Contoh: +62 812-3456-7890">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Alamat Lengkap</label>
                            <textarea name="alamat" rows="3" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors">{{ old('alamat', $setting->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <!-- Sosial Media -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-natural-900 border-b border-natural-200 pb-2">Sosial Media</h3>
                        
                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors" placeholder="https://facebook.com/...">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors" placeholder="https://instagram.com/...">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">TikTok URL</label>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $setting->tiktok_url) }}" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors" placeholder="https://tiktok.com/@...">
                        </div>
                    </div>

                    <!-- Maps Iframe -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-natural-900 border-b border-natural-200 pb-2">Google Maps Embed</h3>
                        
                        <div>
                            <label class="block text-sm font-bold text-natural-900 mb-1.5">Iframe HTML</label>
                            <textarea name="maps_iframe" rows="6" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-3 transition-colors font-mono text-xs" placeholder='<iframe src="..."></iframe>'>{{ old('maps_iframe', $setting->maps_iframe) }}</textarea>
                            <p class="text-xs text-natural-500 mt-1">Paste HTML Iframe dari Google Maps. Ubah class w-full h-48 agar rapi di footer jika memungkinkan.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TAB: Tentang Kami -->
            <div x-show="tab === 'tentang'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-natural-900 mb-2">Konten Halaman Tentang Kami</label>
                    <textarea name="tentang_kami" id="editor-tentang" rows="15" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-4 transition-colors leading-relaxed font-mono">{{ old('tentang_kami', $setting->tentang_kami) }}</textarea>
                    <p class="text-xs text-natural-500 mt-2">Dukung penulisan HTML sederhana untuk penataan (misal: &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;). Jika tidak mengerti HTML, gunakan paragraf biasa dan tag &lt;br&gt; untuk enter.</p>
                </div>
            </div>

            <!-- TAB: Kebijakan Garansi -->
            <div x-show="tab === 'garansi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-natural-900 mb-2">Konten Kebijakan Garansi</label>
                    <textarea name="kebijakan_garansi" id="editor-garansi" rows="15" class="w-full bg-natural-50 border border-natural-200 text-natural-900 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 block p-4 transition-colors leading-relaxed font-mono">{{ old('kebijakan_garansi', $setting->kebijakan_garansi) }}</textarea>
                    <p class="text-xs text-natural-500 mt-2">Dukung penulisan HTML sederhana untuk penataan (misal: &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;li&gt;). Jika tidak mengerti HTML, gunakan paragraf biasa dan tag &lt;br&gt; untuk enter.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-natural-200 flex justify-end gap-3">
                <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm shadow-brand-500/30 flex items-center gap-2 group">
                    <i class='bx bx-save text-lg group-hover:scale-110 transition-transform'></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
