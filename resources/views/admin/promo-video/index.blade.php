<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-natural-800 leading-tight flex items-center gap-2">
                    <i class='bx bx-video text-brand-600'></i>
                    Kelola Video Promo Floating
                </h2>
                <p class="text-xs text-natural-500 mt-1">Unggah dan atur video promo melayang untuk pengunjung website.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class='bx bx-check-circle text-2xl text-teal-500'></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class='bx bx-error-circle text-2xl text-red-500'></i>
                        <ul class="list-disc pl-5 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Form Upload -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-natural-100">
                    <div class="p-6 bg-white border-b border-natural-100">
                        <h3 class="text-lg font-bold text-natural-800 mb-4">Upload Video Promo Baru</h3>
                        <form action="{{ route('admin.promo-video.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-natural-700 mb-1">Judul Promo</label>
                                <input type="text" name="title" required class="w-full rounded-xl border-natural-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="Contoh: Promo Akhir Tahun">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-natural-700 mb-1">Link Target (Opsional)</label>
                                <input type="url" name="target_url" class="w-full rounded-xl border-natural-200 focus:border-brand-500 focus:ring-brand-500 shadow-sm" placeholder="https://lktech.online/katalog">
                                <p class="text-xs text-natural-500 mt-1">Link yang dituju ketika video diklik oleh pengunjung.</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-natural-700 mb-1">File Video (MP4 / WebM)</label>
                                <input type="file" name="video" accept="video/mp4,video/webm" required class="block w-full text-sm text-natural-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                                <p class="text-xs text-natural-500 mt-1">Maksimal 20MB. Rekomendasi rasio vertikal 9:16 atau 4:5, durasi singkat (10-15 detik).</p>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                                    Simpan & Aktifkan Video
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Active Video Preview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-natural-100">
                    <div class="p-6 bg-white border-b border-natural-100">
                        <h3 class="text-lg font-bold text-natural-800 mb-4">Video Promo Aktif</h3>
                        
                        @if(isset($activeVideo) && $activeVideo)
                            <div class="flex flex-col items-center">
                                <div class="w-48 rounded-xl overflow-hidden shadow-lg border-2 border-brand-500 relative mb-4">
                                    <video class="w-full h-auto" controls preload="metadata">
                                        <source src="{{ asset('storage/' . $activeVideo->video_path) }}" type="video/mp4">
                                    </video>
                                    <div class="absolute top-2 right-2 bg-green-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow">
                                        AKTIF
                                    </div>
                                </div>
                                
                                <div class="w-full bg-natural-50 p-4 rounded-xl border border-natural-100">
                                    <div class="mb-2">
                                        <span class="text-xs text-natural-500 block">Judul:</span>
                                        <span class="font-semibold text-natural-800">{{ $activeVideo->title }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-xs text-natural-500 block">Target URL:</span>
                                        @if($activeVideo->target_url)
                                            <a href="{{ $activeVideo->target_url }}" target="_blank" class="text-brand-600 hover:underline text-sm truncate block">{{ $activeVideo->target_url }}</a>
                                        @else
                                            <span class="text-sm text-natural-600">-</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-xs text-natural-500 block">Terakhir Diperbarui:</span>
                                        <span class="text-sm text-natural-600">{{ $activeVideo->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center py-10 text-center">
                                <div class="w-16 h-16 bg-natural-100 rounded-full flex items-center justify-center mb-3">
                                    <i class='bx bx-video-off text-3xl text-natural-400'></i>
                                </div>
                                <h4 class="text-natural-800 font-medium">Belum ada promo aktif</h4>
                                <p class="text-sm text-natural-500 mt-1">Silakan unggah video promo baru menggunakan form di samping.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
