<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-natural-800 leading-tight flex items-center gap-2">
                    <i class='bx bx-star text-brand-600'></i>
                    Manajemen Ulasan Google
                </h2>
                <p class="text-xs text-natural-500 mt-1">Kelola dan sinkronisasi ulasan pelanggan dari Google Maps.</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="document.getElementById('modal-add-review').classList.remove('hidden')" class="btn btn-primary flex items-center gap-2 text-sm bg-white hover:bg-natural-50 text-natural-700 border border-natural-200 px-4 py-2 rounded-xl transition shadow-sm">
                    <i class='bx bx-plus'></i> Tambah Manual
                </button>
                <button onclick="alert('Fitur Sinkronisasi API Google sedang dalam pengembangan untuk production.')" class="btn btn-primary flex items-center gap-2 text-sm bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-xl transition shadow-sm">
                    <i class='bx bx-sync'></i> Direct Sync Google API
                </button>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Top Stats Bar -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-4 border border-natural-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shrink-0">
                    <i class='bx bx-message-square-detail'></i>
                </div>
                <div>
                    <p class="text-[11px] text-natural-500 font-medium mb-0.5">Total Ulasan</p>
                    <h4 class="text-xl font-black text-natural-800 leading-none">{{ $totalReviews }}</h4>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-4 border border-natural-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl shrink-0">
                    <i class='bx bxs-star'></i>
                </div>
                <div>
                    <p class="text-[11px] text-natural-500 font-medium mb-0.5">Rata-rata Rating</p>
                    <h4 class="text-xl font-black text-natural-800 leading-none">{{ number_format($avgRating, 1) }} ⭐</h4>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 border border-natural-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shrink-0">
                    <i class='bx bx-show'></i>
                </div>
                <div>
                    <p class="text-[11px] text-natural-500 font-medium mb-0.5">Tampil di Web</p>
                    <h4 class="text-xl font-black text-natural-800 leading-none">{{ $displayedReviews }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 border border-natural-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl shrink-0">
                    <i class='bx bx-message-rounded-x'></i>
                </div>
                <div>
                    <p class="text-[11px] text-natural-500 font-medium mb-0.5">Belum Dibalas</p>
                    <h4 class="text-xl font-black text-natural-800 leading-none">{{ $unrepliedReviews }}</h4>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-3xl border border-natural-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-natural-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-natural-50/50">
                <h3 class="font-bold text-natural-800 text-sm flex items-center gap-2">
                    <i class='bx bx-list-ul text-brand-500'></i> Daftar Ulasan
                </h3>
                
                <form action="{{ route('google-reviews.index') }}" method="GET" class="w-full sm:w-72">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengulas atau komentar..." 
                               class="w-full pl-9 pr-4 py-2 border border-natural-200 rounded-xl text-xs focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white shadow-sm">
                        <i class='bx bx-search text-natural-400 absolute left-3 top-1/2 -translate-y-1/2 text-base'></i>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="bg-natural-50/80 text-[10px] uppercase tracking-widest text-natural-500 border-b border-natural-100">
                            <th class="px-5 py-3 font-semibold">Pengulas</th>
                            <th class="px-5 py-3 font-semibold">Rating</th>
                            <th class="px-5 py-3 font-semibold">Komentar</th>
                            <th class="px-5 py-3 font-semibold">Tanggal</th>
                            <th class="px-5 py-3 font-semibold">Status Balasan</th>
                            <th class="px-5 py-3 font-semibold text-center">Tampil di Web</th>
                            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-natural-700 divide-y divide-natural-50">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-natural-50/50 transition-colors group">
                            <td class="px-5 py-3 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold shrink-0 overflow-hidden">
                                        @if($review->reviewer_photo_url)
                                            <img src="{{ $review->reviewer_photo_url }}" alt="{{ $review->reviewer_name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($review->reviewer_name, 0, 1) }}
                                        @endif
                                    </div>
                                    <span class="font-bold text-natural-800">{{ $review->reviewer_name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 align-top">
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $review->star_rating)
                                            <i class='bx bxs-star'></i>
                                        @else
                                            <i class='bx bx-star text-natural-300'></i>
                                        @endif
                                    @endfor
                                </div>
                            </td>
                            <td class="px-5 py-3 align-top max-w-xs">
                                <p class="text-natural-600 line-clamp-2" title="{{ $review->review_comment }}">
                                    {{ $review->review_comment ?: '-' }}
                                </p>
                            </td>
                            <td class="px-5 py-3 align-top whitespace-nowrap text-natural-500">
                                {{ $review->review_time_text ?? ($review->review_created_at ? $review->review_created_at->format('d M Y') : '-') }}
                            </td>
                            <td class="px-5 py-3 align-top">
                                @if($review->review_reply)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                        <i class='bx bx-check'></i> Dibalas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-100">
                                        <i class='bx bx-time'></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 align-top text-center">
                                <!-- Toggle Button Alpine Component -->
                                <div x-data="{ 
                                        isFeatured: {{ $review->is_featured ? 'true' : 'false' }}, 
                                        loading: false,
                                        toggle() {
                                            this.loading = true;
                                            fetch('{{ route('google-reviews.toggle', $review->id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                }
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if(data.success) {
                                                    this.isFeatured = data.is_featured;
                                                    window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: data.message } }));
                                                }
                                            })
                                            .finally(() => {
                                                this.loading = false;
                                            });
                                        }
                                    }">
                                    <button @click="toggle()" :disabled="loading" 
                                        class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none"
                                        :class="isFeatured ? 'bg-brand-500' : 'bg-natural-200'">
                                        <span class="inline-block h-3.5 w-3.5 transform rounded-full bg-white transition-transform"
                                              :class="isFeatured ? 'translate-x-4.5' : 'translate-x-1'"></span>
                                    </button>
                                </div>
                            </td>
                            <td class="px-5 py-3 align-top text-right whitespace-nowrap">
                                <button onclick="document.getElementById('modal-reply-{{ $review->id }}').classList.remove('hidden')" 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors tooltip-trigger" title="Balas Ulasan">
                                    <i class='bx bx-reply text-base'></i>
                                </button>
                                
                                <form action="{{ route('google-reviews.destroy', $review->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors tooltip-trigger" title="Hapus Ulasan">
                                        <i class='bx bx-trash text-base'></i>
                                    </button>
                                </form>

                                <!-- Reply Modal -->
                                <div id="modal-reply-{{ $review->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-natural-900/50 backdrop-blur-sm">
                                    <div class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-xl relative m-4 border border-brand-100 text-left">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="font-bold text-lg text-natural-800">Balas Ulasan Google</h3>
                                            <button onclick="document.getElementById('modal-reply-{{ $review->id }}').classList.add('hidden')" class="text-natural-400 hover:text-natural-600">
                                                <i class='bx bx-x text-2xl'></i>
                                            </button>
                                        </div>
                                        
                                        <div class="mb-4 bg-natural-50 p-3 rounded-lg border border-natural-100">
                                            <p class="text-xs text-natural-500 font-medium mb-1">Komentar dari <strong>{{ $review->reviewer_name }}</strong>:</p>
                                            <p class="text-sm text-natural-700 italic">"{{ $review->review_comment }}"</p>
                                        </div>

                                        <form action="{{ route('google-reviews.reply', $review->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="block text-xs font-bold text-natural-700 mb-1">Balasan Anda</label>
                                                <textarea name="reply" rows="4" class="w-full p-3 border border-natural-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white" placeholder="Tuliskan template balasan di sini...">{{ $review->review_reply }}</textarea>
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" onclick="document.getElementById('modal-reply-{{ $review->id }}').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-natural-600 hover:bg-natural-100 rounded-xl transition">Batal</button>
                                                <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 rounded-xl transition shadow-sm">Simpan Balasan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-natural-500">
                                <div class="flex flex-col items-center">
                                    <i class='bx bx-star text-4xl text-natural-300 mb-2'></i>
                                    <p class="text-sm">Belum ada data ulasan Google yang disinkronisasi.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($reviews->hasPages())
            <div class="p-4 border-t border-natural-100 bg-white">
                {{ $reviews->links() }}
            </div>
            @endif
        </div>

    </div>

    <!-- Modal Tambah Ulasan Manual -->
    <div id="modal-add-review" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-natural-900/50 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-xl relative text-left">
            <div class="flex justify-between items-center mb-6 border-b border-natural-100 pb-4">
                <h3 class="font-bold text-lg text-natural-800 flex items-center gap-2">
                    <i class='bx bx-plus-circle text-brand-600'></i> Tambah Ulasan Manual
                </h3>
                <button onclick="document.getElementById('modal-add-review').classList.add('hidden')" class="text-natural-400 hover:text-natural-600 w-8 h-8 flex items-center justify-center rounded-full hover:bg-natural-100 transition-colors">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            
            <form action="{{ route('google-reviews.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1">Nama Pengulas <span class="text-rose-500">*</span></label>
                        <input type="text" name="reviewer_name" required class="w-full p-2.5 border border-natural-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white" placeholder="Misal: Satria Merah">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1">Jumlah Bintang (Rating) <span class="text-rose-500">*</span></label>
                        <select name="star_rating" required class="w-full p-2.5 border border-natural-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white">
                            <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                            <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                            <option value="3">⭐⭐⭐ (3 Bintang)</option>
                            <option value="2">⭐⭐ (2 Bintang)</option>
                            <option value="1">⭐ (1 Bintang)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1">Teks Komentar / Ulasan</label>
                        <textarea name="review_comment" rows="4" class="w-full p-2.5 border border-natural-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white" placeholder="Tuliskan ulasan asli dari pelanggan di sini..."></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-natural-700 mb-1">Tanggal/Waktu Ulasan (Opsional)</label>
                        <input type="text" name="review_time_text" class="w-full p-2.5 border border-natural-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white" placeholder="Misal: 5 hari lalu, seminggu lalu, Agustus 2026">
                        <p class="text-[10px] text-natural-500 mt-1">Biarkan kosong untuk menggunakan waktu otomatis ("baru saja").</p>
                    </div>

                    <div class="flex items-center gap-2 bg-brand-50 p-3 rounded-xl border border-brand-100 mt-2">
                        <input type="checkbox" name="is_featured" value="1" checked id="is_featured_checkbox" class="w-4 h-4 text-brand-600 border-natural-300 rounded focus:ring-brand-500">
                        <label for="is_featured_checkbox" class="text-xs font-medium text-brand-800 cursor-pointer">Langsung tampilkan di Landing Page</label>
                    </div>
                </div>
                
                <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-natural-100">
                    <button type="button" onclick="document.getElementById('modal-add-review').classList.add('hidden')" class="px-5 py-2.5 text-sm font-medium text-natural-600 hover:bg-natural-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 rounded-xl transition shadow-sm flex items-center gap-2">
                        <i class='bx bx-save'></i> Simpan Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
