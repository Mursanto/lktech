<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Log Aktivitas</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Audit trail sistem untuk memantau perubahan data dan aksi user.</p>
            </div>
            <div class="flex items-center gap-2">
                @role('Admin')
                <form action="{{ route('activity-logs.clear') }}" method="POST" onsubmit="return confirm('Hapus semua log aktivitas?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-rose-50 border border-rose-100 rounded-xl text-rose-600 text-xs font-bold hover:bg-rose-100 transition-all shadow-sm">
                        <i class='bx bx-trash text-lg'></i>
                        Bersihkan Log
                    </button>
                </form>
                @endrole
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Log Filter Bar -->
        <form id="filterForm" action="{{ route('activity-logs.index') }}" method="GET" class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-grow max-w-md">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-natural-400 text-xl'></i>
                <input type="text" name="search" value="{{ request('search') }}" oninput="debounceSubmit()" placeholder="Cari aksi, user, atau deskripsi..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-natural-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all">
            </div>
            <div class="flex items-center gap-2">
                <select name="module" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2.5 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium">
                    <option value="">Semua Modul</option>
                    <option value="Sale" {{ request('module') == 'Sale' ? 'selected' : '' }}>Penjualan</option>
                    <option value="Service" {{ request('module') == 'Service' ? 'selected' : '' }}>Servis</option>
                    <option value="Product" {{ request('module') == 'Product' ? 'selected' : '' }}>Inventaris</option>
                    <option value="Rental" {{ request('module') == 'Rental' ? 'selected' : '' }}>Sewa</option>
                </select>
            </div>
        </form>

        <!-- Activity Timeline Container -->
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Waktu & Tgl</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Pelaku (User)</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Aksi / Modul</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider">Keterangan Aktivitas</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-natural-500 uppercase tracking-wider text-right">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($logs as $log)
                        <tr class="hover:bg-natural-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-[12px] font-black text-natural-800 leading-none">{{ $log->created_at->format('H:i:s') }}</p>
                                <p class="text-[9px] text-natural-400 font-medium mt-1 tracking-tight">{{ $log->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-natural-100 flex items-center justify-center text-natural-600 text-[10px] font-black group-hover:bg-brand-600 group-hover:text-white transition-all">
                                        {{ substr($log->user->name ?? ($log->causer->name ?? 'S'), 0, 1) }}
                                    </div>
                                    <p class="text-[12px] font-bold text-natural-800">{{ $log->user->name ?? ($log->causer->name ?? 'System') }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $action = $log->action ?? $log->description;
                                    $actionColor = match($action) {
                                        'created', 'sale_created', 'product_created' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'updated', 'product_updated' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'deleted', 'sale_deleted', 'product_deleted' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        default => 'bg-blue-50 text-blue-600 border-blue-100'
                                    };
                                    $modelName = class_basename($log->model_type ?? $log->subject_type);
                                @endphp
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-lg border {{ $actionColor }} text-[8px] font-black uppercase tracking-widest w-fit">
                                        {{ str_replace('_', ' ', $action) }}
                                    </span>
                                    <span class="text-[9px] font-bold text-natural-400 uppercase tracking-tighter">{{ $modelName }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-[11px] text-natural-700 font-medium leading-relaxed">
                                    {{ $log->description ?? 'Melakukan perubahan pada data ' . $modelName }}
                                </p>
                                @if($log->properties && $log->properties != '[]')
                                    <p class="text-[9px] text-natural-400 italic mt-0.5 truncate max-w-xs" title="{{ is_array($log->properties) ? json_encode($log->properties) : $log->properties }}">
                                        Detail: {{ is_array($log->properties) ? json_encode($log->properties) : $log->properties }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <span class="text-[10px] font-mono text-natural-400 bg-natural-50 px-2 py-0.5 rounded border border-natural-100">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-natural-400 italic">
                                <div class="flex flex-col items-center gap-2">
                                    <i class='bx bx-history text-4xl opacity-20'></i>
                                    <p class="text-xs font-medium">Belum ada catatan aktivitas sistem.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-auto px-6 py-4 bg-natural-50/30 border-t border-natural-100">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
