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
        <!-- Filter Bar -->
        <form id="filterForm" action="{{ route('rentals.index') }}" method="GET" class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex flex-col">
                    <label class="text-[9px] font-bold text-natural-400 uppercase ml-1 mb-0.5">Filter Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium">
                </div>
                <div class="flex flex-col">
                    <label class="text-[9px] font-bold text-natural-400 uppercase ml-1 mb-0.5">Metode Bayar</label>
                    <select name="payment_method" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium min-w-[140px]">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai (Cash)</option>
                        <option value="transfer" {{ request('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS / E-Wallet</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <label class="text-[9px] font-bold text-natural-400 uppercase ml-1 mb-0.5">Status Pembayaran</label>
                    <select name="status" onchange="this.form.submit()" class="bg-natural-50 border-none rounded-2xl text-sm py-2 px-4 focus:ring-2 focus:ring-brand-500/20 transition-all text-natural-600 font-medium min-w-[140px]">
                        <option value="">Semua Status</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Lunas / Sukses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
            </div>
            <div class="relative flex-grow max-w-xs">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-natural-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" oninput="debounceSubmit()" placeholder="Cari No. Kontrak atau Pelanggan..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-natural-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all">
            </div>
        </form>

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
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Metode</th>
                            <th class="px-4 py-2 bg-gray-50 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Status Pembayaran</th>
                            <th class="px-4 py-2 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Tgl Kembali</th>
                            <th class="px-4 py-2 bg-gray-50 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50 text-sm">
                        @forelse($rentals as $rental)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/40 transition-colors group">
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center gap-1.5 mb-1">
                                    <p class="text-xs font-semibold text-gray-900">#{{ $rental->rental_number ?? 'RW-'.str_pad($rental->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    @if(strtolower($rental->payment_method) == 'cash' || $rental->payment_status === 'success')
                                        <span class="text-[8px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded border border-slate-200" title="Kasir POS Direct">🏪 Toko</span>
                                    @else
                                        <span class="text-[8px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-200" title="Pesanan dari website">🌐 Web</span>
                                    @endif
                                </div>
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
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded border uppercase tracking-wider {{ strtolower($rental->payment_method) == 'cash' ? 'bg-slate-50 text-slate-600 border-slate-200' : 'bg-indigo-50 text-indigo-600 border-indigo-200' }}">
                                    {{ $rental->payment_method ?? 'Cash' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-center">
                                @if($rental->payment_status === 'success')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                                        ✓ LUNAS
                                    </span>
                                @elseif($rental->payment_status === 'pending')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-wider">
                                        ⏳ PENDING
                                    </span>
                                @elseif($rental->payment_status === 'failed' || $rental->payment_status === 'cancelled')
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded bg-rose-50 text-rose-700 border border-rose-200 uppercase tracking-wider">
                                        🚫 BATAL
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded bg-slate-50 text-slate-600 border border-slate-200 uppercase tracking-wider">
                                        EXPIRED
                                    </span>
                                @endif
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
                                    
                                    <a href="{{ route('rentals.edit', $rental->id) }}" class="p-1 text-xs text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                        <i class='bx bx-edit-alt text-base'></i>
                                    </a>
                                    
                                    @if($rental->payment_status === 'success')
                                        <a href="{{ route('rentals.show', $rental->id) }}" class="p-1 text-xs text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Cetak Struk">
                                            <i class='bx bx-printer text-base'></i>
                                        </a>
                                    @endif
                                    
                                    @if($rental->status == 'active' && $rental->payment_status === 'success')
                                        <a href="{{ route('rentals.edit', $rental->id) }}" class="p-1 text-xs text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Kembalikan Unit">
                                            <i class='bx bx-redo text-base'></i>
                                        </a>
                                    @endif
                                    
                                    @role('Admin')
                                    @if($rental->payment_status === 'failed' || $rental->payment_status === 'cancelled')
                                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus penyewaan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1 text-xs text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <i class='bx bx-trash text-base'></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endrole
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
