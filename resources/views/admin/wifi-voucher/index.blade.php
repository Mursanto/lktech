<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Paket WiFi Voucher
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('wifi-voucher-admin.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-lg font-bold text-sm shadow flex items-center gap-2 transition-colors">
                    <i class='bx bx-plus'></i> Tambah Paket
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
                        <thead class="bg-gray-50 text-gray-600 font-semibold text-[11px] uppercase tracking-wider sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-4 py-3 border-b">Nama Paket</th>
                                <th class="px-4 py-3 border-b">Harga</th>
                                <th class="px-4 py-3 border-b">Badge</th>
                                <th class="px-4 py-3 border-b">Status</th>
                                <th class="px-4 py-3 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($packages as $package)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-800 line-clamp-1 max-w-xs">{{ $package->nama_paket }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-800 font-medium">
                                    Rp {{ number_format($package->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-gray-800 font-medium">
                                    {{ $package->badge ?: '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($package->is_active)
                                        <span class="px-2 py-1 bg-green-50 text-green-700 rounded text-[10px] font-bold">AKTIF</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold">NONAKTIF</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('wifi-voucher-admin.edit', $package) }}" class="text-blue-600 hover:text-blue-800 transition-colors p-1.5 bg-blue-50 rounded-lg" title="Edit">
                                            <i class='bx bx-edit-alt'></i>
                                        </a>
                                        <form action="{{ route('wifi-voucher-admin.destroy', $package) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-1.5 bg-red-50 rounded-lg" title="Hapus">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                    <i class='bx bx-wifi text-4xl mb-2 text-gray-300'></i>
                                    <p>Belum ada paket WiFi Voucher.</p>
                                    <a href="{{ route('wifi-voucher-admin.create') }}" class="text-brand-600 hover:underline text-sm font-bold mt-2 inline-block">Tambah Paket Baru</a>
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
