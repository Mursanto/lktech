<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-base text-natural-900 leading-tight">
                Manajemen Paket Jasa Website
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('jasa-website-admin.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-3 py-1.5 rounded-lg font-bold text-[11px] shadow flex items-center gap-1.5 transition-colors">
                    <i class='bx bx-plus text-base'></i> Tambah Paket
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 h-[calc(100vh-65px)] overflow-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full flex flex-col">
            
            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class='bx bx-check-circle text-xl'></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 flex-grow flex flex-col overflow-hidden">
                <div class="flex-grow overflow-y-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-400 font-bold text-[10px] uppercase tracking-wider sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-4 py-2 border-b">Nama Paket</th>
                                <th class="px-4 py-2 border-b">Harga Mulai</th>
                                <th class="px-4 py-2 border-b">Badge</th>
                                <th class="px-4 py-2 border-b text-center">Status</th>
                                <th class="px-4 py-2 border-b text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($packages as $package)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2">
                                    <div class="font-semibold text-[11px] text-gray-800 line-clamp-1 max-w-xs">{{ $package->nama_paket }}</div>
                                </td>
                                <td class="px-4 py-2 text-[11px] text-gray-800 font-bold">
                                    Rp {{ number_format($package->harga_mulai, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-[11px] text-gray-800 font-medium">
                                    {{ $package->badge ?: '-' }}
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if($package->is_active)
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[8px] font-bold">AKTIF</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 border border-gray-200 rounded text-[8px] font-bold">NONAKTIF</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('jasa-website-admin.edit', $package) }}" class="text-blue-600 hover:text-blue-800 transition-colors p-1 bg-blue-50 hover:bg-blue-100 rounded transition-all" title="Edit">
                                            <i class='bx bx-edit-alt text-sm'></i>
                                        </a>
                                        <form action="{{ route('jasa-website-admin.destroy', $package) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-1 bg-red-50 hover:bg-red-100 rounded transition-all" title="Hapus">
                                                <i class='bx bx-trash text-sm'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                    <i class='bx bx-code-alt text-4xl mb-2 text-gray-300'></i>
                                    <p>Belum ada paket Jasa Website.</p>
                                    <a href="{{ route('jasa-website-admin.create') }}" class="text-brand-600 hover:underline text-sm font-bold mt-2 inline-block">Tambah Paket Baru</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
