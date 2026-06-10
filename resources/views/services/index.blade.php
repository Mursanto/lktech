<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Riwayat Servis</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Pantau status perbaikan perangkat pelanggan secara real-time.</p>
            </div>
            <div class="flex items-center gap-2">
                @role('Admin')
                <a href="{{ route('services.export') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-natural-200 rounded-xl text-natural-600 text-xs font-bold hover:bg-natural-50 transition-all shadow-sm">
                    <i class='bx bx-export text-lg'></i>
                    Export Excel
                </a>
                @endrole
                @hasanyrole('Admin|Teknisi')
                <a href="{{ route('services.create') }}" class="flex items-center gap-2 px-4 py-2 bg-amber-500 rounded-xl text-white text-xs font-bold hover:bg-amber-600 transition-all shadow-md">
                    <i class='bx bx-plus text-lg'></i>
                    Input Servis Baru
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Status Filter Bar -->
        <form id="filterForm" action="{{ route('services.index') }}" method="GET" class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50 flex flex-wrap items-center justify-between gap-4">
            <input type="hidden" name="status" id="statusInput" value="{{ request('status', 'all') }}">
            <div class="flex items-center gap-2">
                <button type="button" onclick="document.getElementById('statusInput').value='all'; this.form.submit()" class="px-4 py-2 rounded-2xl text-xs font-bold transition-all border {{ request('status', 'all') == 'all' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-natural-50 text-natural-500 border-natural-100 hover:bg-natural-100' }}">Semua</button>
                <button type="button" onclick="document.getElementById('statusInput').value='pending'; this.form.submit()" class="px-4 py-2 rounded-2xl text-xs font-bold transition-all border {{ request('status') == 'pending' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-natural-50 text-natural-500 border-natural-100 hover:bg-natural-100' }}">Pending</button>
                <button type="button" onclick="document.getElementById('statusInput').value='process'; this.form.submit()" class="px-4 py-2 rounded-2xl text-xs font-bold transition-all border {{ request('status') == 'process' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-natural-50 text-natural-500 border-natural-100 hover:bg-natural-100' }}">Proses</button>
                <button type="button" onclick="document.getElementById('statusInput').value='done'; this.form.submit()" class="px-4 py-2 rounded-2xl text-xs font-bold transition-all border {{ request('status') == 'done' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-natural-50 text-natural-500 border-natural-100 hover:bg-natural-100' }}">Selesai</button>
            </div>
            <div class="relative flex-grow max-w-xs">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-natural-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" oninput="debounceSubmit()" placeholder="Cari Nota / Perangkat / Pelanggan..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-natural-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all">
            </div>
        </form>

        <!-- Service Table Container -->
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">No. Nota & Tgl</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Perangkat</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50 text-sm">
                        @forelse($services as $service)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/40 transition-colors group">
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900">#{{ $service->service_number ?? str_pad($service->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $service->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900 whitespace-normal line-clamp-2">{{ $service->customer->name ?? 'Unknown' }}</p>
                                <p class="text-xs text-gray-500 font-medium">{{ $service->customer->phone ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900 whitespace-normal line-clamp-2">{{ $service->device_name }}</p>
                                <p class="text-[10px] text-amber-600 font-medium uppercase tracking-tighter">{{ $service->problem_type ?? 'Hardware' }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap text-center">
                                @php
                                    $statusClass = match($service->status) {
                                        'pending' => 'bg-slate-50 text-slate-700',
                                        'process' => 'bg-amber-50 text-amber-700',
                                        'done' => 'bg-emerald-50 text-emerald-700',
                                        'cancelled' => 'bg-red-50 text-red-700',
                                        default => 'bg-gray-50 text-gray-700'
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full {{ $statusClass }} text-[10px] font-semibold uppercase tracking-wider">
                                    {{ $service->status }}
                                </span>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('services.show', $service->id) }}" class="p-1 text-sm text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Detail">
                                        <i class='bx bx-show text-lg'></i>
                                    </a>
                                    @hasanyrole('Admin|Teknisi')
                                    <a href="{{ route('services.edit', $service->id) }}" class="p-1 text-sm text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Update Status">
                                        <i class='bx bx-refresh text-lg'></i>
                                    </a>
                                    @endhasanyrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-natural-400">
                                    <i class='bx bx-wrench text-5xl mb-2 opacity-20'></i>
                                    <p class="text-sm font-medium italic">Belum ada antrian servis.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-auto px-6 py-4 bg-natural-50/30 border-t border-natural-100">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
