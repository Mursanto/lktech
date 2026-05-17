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
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">No. Kontrak</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Penyewa</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Unit Laptop</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Batas Waktu</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($rentals as $rental)
                        <tr class="hover:bg-natural-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <p class="text-sm font-black text-natural-800">#{{ $rental->rental_number ?? 'RW-'.str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[10px] text-natural-500 font-medium">Tgl: {{ $rental->created_at->format('d/m/y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-natural-800 truncate w-32">{{ $rental->customer->name ?? 'Unknown' }}</p>
                                <p class="text-[9px] text-natural-500 font-medium">{{ $rental->customer->phone ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-natural-700">{{ $rental->product->brand ?? 'Unit' }} {{ $rental->product->model_series ?? '-' }}</p>
                                <p class="text-[9px] text-cyan-600 font-bold uppercase tracking-tight">S/N: {{ $rental->product->serial_number ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $isLate = $rental->status == 'active' && now() > $rental->return_date;
                                @endphp
                                <p class="text-sm font-black {{ $isLate ? 'text-red-600' : 'text-natural-800' }}">{{ $rental->return_date->format('d M Y') }}</p>
                                <p class="text-[9px] font-bold uppercase {{ $isLate ? 'text-red-400' : 'text-natural-400' }}">
                                    {{ $isLate ? 'Terlambat!' : 'Estimasi Kembali' }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('rentals.show', $rental->id) }}" class="p-2 text-natural-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Detail">
                                        <i class='bx bx-show text-lg'></i>
                                    </a>
                                    <a href="{{ route('rentals.edit', $rental->id) }}" class="p-2 text-natural-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Kembalikan / Update">
                                        <i class='bx bx-redo text-lg'></i>
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
