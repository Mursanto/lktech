<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Video Promo') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Video Promo Baru</h3>
            <form action="{{ route('admin.promo-video.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul Promo</label>
                        <input type="text" name="title" required placeholder="Contoh: Promo Diskon Laptop X1 Carbon" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Link Target / Katalog (Opsional)</label>
                        <input type="url" name="target_url" placeholder="https://lktech.online/katalog" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">File Video (MP4)</label>
                    <input type="file" name="video" accept="video/mp4,video/webm" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Maksimal 20MB. Rekomendasi rasio vertikal (9:16 atau 4:5), durasi singkat (10-15 detik).</p>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                    + Unggah & Simpan Video
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Daftar Video Promo</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-xs uppercase font-semibold">
                            <th class="p-4">Pratinjau (Pause)</th>
                            <th class="p-4">Judul & Link</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($videos as $video)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-4 w-44">
                                <video class="w-36 h-24 object-contain rounded-lg bg-black border" controls preload="metadata">
                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                </video>
                            </td>
                            
                            <td class="p-4">
                                <p class="font-bold text-gray-800">{{ $video->title }}</p>
                                <a href="{{ $video->target_url ?? '#' }}" target="_blank" class="text-xs text-blue-600 hover:underline block mt-1 truncate max-w-xs">
                                    {{ $video->target_url ?? 'Tidak ada link' }} ↗
                                </a>
                            </td>

                            <td class="p-4">
                                @if($video->is_active)
                                    <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        ● Tampil di Web
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="p-4 text-center space-x-2">
                                <button onclick="openEditModal({{ $video }})" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                    ✏️ Edit
                                </button>
                                
                                <form action="{{ route('admin.promo-video.destroy', $video->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-400">Belum ada video promo yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-lg w-full p-6 shadow-2xl relative space-y-4">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-bold text-gray-800">Edit Video Promo</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 font-bold">&times;</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul Promo</label>
                    <input type="text" id="edit_title" name="title" required class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Link Target</label>
                    <input type="url" id="edit_target_url" name="target_url" class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ganti File Video (Biarkan kosong jika tidak ingin mengganti video)</label>
                    <input type="file" name="video" accept="video/mp4,video/webm" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Maksimal 20MB. Rekomendasi rasio vertikal (9:16 atau 4:5), durasi singkat (10-15 detik).</p>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="edit_is_active" class="text-sm font-medium text-gray-700">Aktifkan Video Ini di Landing Page</label>
                </div>

                <div class="flex justify-end space-x-2 border-t pt-4">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 font-semibold">Simpan Perubahan</button>
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
