<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-base text-natural-900 leading-tight">
            {{ __('Kelola Video Promo') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 h-[calc(100vh-65px)] overflow-hidden flex flex-col space-y-4">
        
        <div class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50">
            <h3 class="text-sm font-bold text-natural-800 mb-3">Tambah Video Promo Baru</h3>
            <form action="{{ route('admin.promo-video.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-natural-700">Judul Promo</label>
                        <input type="text" name="title" required placeholder="Contoh: Promo Diskon Laptop X1 Carbon" class="mt-1 w-full rounded-xl border-natural-200 text-[11px] shadow-sm focus:border-brand-500 focus:ring-brand-500 px-3 py-1.5 bg-natural-50">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-natural-700">Link Target / Katalog (Opsional)</label>
                        <input type="url" name="target_url" placeholder="https://lktech.online/katalog" class="mt-1 w-full rounded-xl border-natural-200 text-[11px] shadow-sm focus:border-brand-500 focus:ring-brand-500 px-3 py-1.5 bg-natural-50">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-natural-700">File Video (MP4)</label>
                    <input type="file" name="video" accept="video/mp4,video/webm" required class="mt-1 block w-full text-[11px] text-natural-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    <p class="mt-1 text-[9px] text-natural-500 font-medium">Maksimal 20MB. Rekomendasi rasio vertikal (9:16 atau 4:5), durasi singkat (10-15 detik).</p>
                </div>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold px-4 py-2 rounded-xl text-[11px] transition shadow-sm">
                    + Unggah & Simpan Video
                </button>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 flex-grow flex flex-col overflow-hidden">
            <div class="p-4 border-b border-natural-100 bg-natural-50/50">
                <h3 class="text-xs font-bold text-natural-800">Daftar Video Promo</h3>
            </div>
            
            <div class="flex-grow overflow-y-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="sticky top-0 z-10 bg-natural-50/80 text-natural-400 text-[10px] uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-4 py-2 border-b border-natural-100">Pratinjau (Pause)</th>
                            <th class="px-4 py-2 border-b border-natural-100">Judul & Link</th>
                            <th class="px-4 py-2 border-b border-natural-100 text-center">Status</th>
                            <th class="px-4 py-2 border-b border-natural-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($videos as $video)
                        <tr class="hover:bg-natural-50/50 transition-colors group">
                            <td class="px-4 py-2 w-32 align-middle">
                                <video class="w-24 h-16 object-cover rounded-lg bg-black border border-natural-200" controls preload="metadata">
                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                </video>
                            </td>
                            
                            <td class="px-4 py-2 align-middle">
                                <p class="font-bold text-[11px] text-natural-800">{{ $video->title }}</p>
                                <a href="{{ $video->target_url ?? '#' }}" target="_blank" class="text-[9px] text-brand-600 hover:underline block mt-0.5 truncate max-w-[200px]">
                                    {{ $video->target_url ?? 'Tidak ada link' }} ↗
                                </a>
                            </td>

                            <td class="px-4 py-2 align-middle text-center">
                                @if($video->is_active)
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-[9px] font-bold">
                                        ● Tampil di Web
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 border border-gray-200 px-2 py-0.5 rounded text-[9px] font-bold">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-2 align-middle text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="openEditModal({{ $video }})" class="inline-flex items-center justify-center w-6 h-6 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded transition" title="Edit">
                                        <i class='bx bx-edit text-sm'></i>
                                    </button>
                                    
                                    <form action="{{ route('admin.promo-video.destroy', $video->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-6 h-6 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded transition" title="Hapus">
                                            <i class='bx bx-trash text-sm'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-natural-400 italic text-[11px]">Belum ada video promo yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-natural-900/50 hidden items-center justify-center z-50 p-4 backdrop-blur-sm">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative space-y-4">
            <div class="flex justify-between items-center border-b border-natural-100 pb-3">
                <h3 class="text-base font-bold text-natural-800">Edit Video Promo</h3>
                <button onclick="closeEditModal()" class="text-natural-400 hover:text-natural-600 font-bold">&times;</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-[11px] font-bold text-natural-700">Judul Promo</label>
                    <input type="text" id="edit_title" name="title" required class="mt-1 w-full rounded-xl border-natural-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-[11px] py-1.5">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-natural-700">Link Target</label>
                    <input type="url" id="edit_target_url" name="target_url" class="mt-1 w-full rounded-xl border-natural-200 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-[11px] py-1.5">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-natural-700">Ganti File Video (Biarkan kosong jika tidak ingin mengganti)</label>
                    <input type="file" name="video" accept="video/mp4,video/webm" class="mt-1 block w-full text-[11px] text-natural-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    <p class="mt-1 text-[9px] text-natural-500 font-medium">Maksimal 20MB. Rekomendasi rasio vertikal (9:16 atau 4:5), durasi singkat (10-15 detik).</p>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="rounded border-natural-300 text-brand-600 focus:ring-brand-500">
                    <label for="edit_is_active" class="text-[11px] font-bold text-natural-700">Aktifkan Video Ini di Landing Page</label>
                </div>

                <div class="flex justify-end gap-2 border-t border-natural-100 pt-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-natural-600 rounded-xl text-[11px] font-bold hover:bg-natural-50 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-xl text-[11px] hover:bg-brand-700 font-bold shadow-sm transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(video) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            
            // Set action URL form
            form.action = `/promo-video/${video.id}`; // Default route without admin prefix
            
            // Isi input dengan data lama
            document.getElementById('edit_title').value = video.title;
            document.getElementById('edit_target_url').value = video.target_url ?? '';
            document.getElementById('edit_is_active').checked = video.is_active == 1;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
