<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Riwayat Penjualan</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Pantau seluruh transaksi keluar dan performa penjualan.</p>
            </div>
            <div class="flex items-center gap-2">
                @role('Admin')
                <a href="{{ route('sales.export') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-natural-200 rounded-xl text-natural-600 text-xs font-bold hover:bg-natural-50 transition-all shadow-sm">
                    <i class='bx bx-export text-lg'></i>
                    Export Excel
                </a>
                @endrole
                @hasanyrole('Admin|Staff')
                <a href="{{ route('sales.create') }}" class="flex items-center gap-2 px-4 py-2 bg-emerald-600 rounded-xl text-white text-xs font-bold hover:bg-emerald-700 transition-all shadow-md">
                    <i class='bx bx-plus text-lg'></i>
                    Input Penjualan
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Filter Bar -->
        <form id="filterForm" action="{{ route('sales.index') }}" method="GET" class="bg-white p-4 rounded-3xl shadow-sm border border-natural-100/50 flex flex-wrap items-center justify-between gap-4">
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
            </div>
            <div class="relative flex-grow max-w-xs">
                <i class='bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-natural-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" oninput="debounceSubmit()" placeholder="Cari No. Faktur atau Pelanggan..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-natural-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-brand-500/20 transition-all">
            </div>
        </form>

        <!-- Sales Table Container -->
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Faktur & Tanggal</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Total Transaksi</th>
                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50 text-sm">
                        @forelse($sales as $sale)
                        <tr class="border-b border-gray-100 hover:bg-gray-50/40 transition-colors group">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900 leading-none">#{{ $sale->invoice_number ?? 'INV-'.str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $sale->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-sm font-bold">
                                        {{ substr($sale->customer->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 whitespace-normal line-clamp-2 leading-tight">{{ $sale->customer->name ?? 'Guest Customer' }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $sale->customer->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full uppercase tracking-wider {{ strtolower($sale->payment_method) == 'cash' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $sale->payment_method ?? 'Cash' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $sale->saleDetails->sum('quantity') }} Item Terjual</p>
                            </td>

                            <td class="px-6 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('sales.show', $sale->id) }}" class="p-1.5 text-sm text-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Detail">
                                        <i class='bx bx-show text-lg'></i>
                                    </a>
                                    @hasanyrole('Admin|Staff')
                                    <a href="{{ route('sales.edit', $sale->id) }}" class="p-1.5 text-sm text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <i class='bx bx-edit-alt text-lg'></i>
                                    </a>
                                    @endhasanyrole
                                    @role('Admin')
                                    <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-sm text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </form>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-natural-400">
                                    <i class='bx bx-receipt text-5xl mb-2 opacity-20'></i>
                                    <p class="text-sm font-medium italic">Belum ada riwayat penjualan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-auto px-6 py-4 bg-natural-50/30 border-t border-natural-100">
                {{ $sales->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
