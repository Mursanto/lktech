<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Data Sewa Laptop</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Kelola penyewaan unit laptop untuk instansi atau personal.</p>
            </div>
            <div class="flex items-center gap-2">
                @role('Admin')
                <a href="{{ route('rentals.export') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-natural-200 rounded-xl text-natural-600 text-xs font-bold hover:bg-natural-50 transition-all shadow-sm">
                    <i class='bx bx-export text-lg'></i>
                    Export Excel
                </a>
                @endrole
                <a href="{{ route('rentals.create') }}" class="flex items-center gap-2 px-4 py-2 bg-cyan-600 rounded-xl text-white text-xs font-bold hover:bg-cyan-700 transition-all shadow-md">
                    <i class='bx bx-plus text-lg'></i>
                    Input Sewa Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Dashboard Sewa Mini -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 shrink-0">
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl">
                    <i class='bx bx-laptop'></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Unit Disewa</p>
                    <p class="text-xl font-black text-natural-800">{{ $rentals->where('status', 'active')->count() }} <span class="text-xs font-medium text-natural-400">Aktif</span></p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
                    <i class='bx bx-calendar-exclamation'></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Mendekati Deadline</p>
                    <p class="text-xl font-black text-natural-800">0 <span class="text-xs font-medium text-natural-400">Unit</span></p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                    <i class='bx bx-check-double'></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Selesai Hari Ini</p>
                    <p class="text-xl font-black text-natural-800">0 <span class="text-xs font-medium text-natural-400">Unit</span></p>
                </div>
            </div>
        </div>

        <!-- Rental Table Container -->
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Kontrak</th>
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Penyewa</th>
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Unit</th>
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Tgl Kembali</th>
                            <th class="px-4 py-2 bg-gray-50 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50 text-sm">
                        @forelse($rentals as $rental)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/40 transition-colors group">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <p class="text-xs font-semibold text-gray-900">#{{ $rental->rental_number ?? 'RW-'.str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[10px] text-gray-500 font-medium">Tgl: {{ $rental->created_at->format('d/m/y') }}</p>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <p class="text-xs font-semibold text-gray-900 whitespace-normal line-clamp-2 max-w-[150px] truncate" title="{{ $rental->customer->name ?? 'Unknown' }}">{{ $rental->customer->name ?? 'Unknown' }}</p>
                                <p class="text-[10px] text-gray-500 font-medium">{{ $rental->customer->phone ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div>
                                    <p class="text-xs font-semibold text-gray-900 whitespace-normal line-clamp-2 max-w-[150px] truncate" title="{{ $rental->product ? $rental->product->brand . ' ' . $rental->product->model_series : ($rental->laptop_name ?? 'Unit Tidak Diketahui') }}">
                                        {{ $rental->product ? $rental->product->brand . ' ' . $rental->product->model_series : ($rental->laptop_name ?? 'Unit Tidak Diketahui') }}
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <p class="text-[10px] text-gray-500 font-medium tracking-tight">
                                            ID: {{ $rental->product ? '#' . str_pad($rental->product->id, 5, '0', STR_PAD_LEFT) : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @php
                                    $isLate = ($rental->status == 'active' && now()->startOfDay() > $rental->return_date) || $rental->status == 'overdue';
                                    $isDone = $rental->status == 'completed';
                                @endphp
                                <p class="text-xs font-semibold {{ $isLate ? 'text-red-600' : ($isDone ? 'text-emerald-600' : 'text-gray-900') }}">{{ $rental->return_date->format('d M Y') }}</p>
                                <p class="text-[9px] font-medium uppercase {{ $isLate ? 'text-red-400' : ($isDone ? 'text-emerald-400' : 'text-gray-500') }}">
                                    {{ $isLate ? 'Terlambat!' : ($isDone ? 'Selesai' : 'Estimasi Kembali') }}
                                </p>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('rentals.show', $rental->id) }}" class="p-1 text-xs text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Detail">
                                        <i class='bx bx-show text-base'></i>
                                    </a>
                                    <a href="{{ route('rentals.edit', $rental->id) }}" class="p-1 text-xs text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Kembalikan / Update">
                                        <i class='bx bx-redo text-base'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-natural-400">
                                    <i class='bx bx-laptop text-5xl mb-2 opacity-20'></i>
                                    <p class="text-sm font-medium italic">Belum ada data penyewaan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-auto px-6 py-4 bg-natural-50/30 border-t border-natural-100">
                {{ $rentals->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
