<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Informasi Laba & Rugi</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Rincian pendapatan dan modal transaksi secara real-time.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.profit-loss.export') ?? '#' }}" class="flex items-center gap-2 px-4 py-2 bg-rose-600 rounded-xl text-white text-xs font-bold hover:bg-rose-700 transition-all shadow-md">
                    <i class='bx bx-export text-lg'></i>
                    Export Laporan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col h-full space-y-4">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 shrink-0">
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                    <i class='bx bx-trending-up'></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-xl font-black text-natural-800">Rp {{ number_format($sales->sum('total_amount'), 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl">
                    <i class='bx bx-wallet'></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Total Modal Stok</p>
                    <p class="text-xl font-black text-natural-800">Rp {{ number_format($sales->sum('total_amount') - $sales->sum('profit_amount'), 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                    <i class='bx bx-medal'></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Total Keuntungan</p>
                    <p class="text-xl font-black text-brand-600">Rp {{ number_format($sales->sum('profit_amount'), 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Details Table Container -->
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-5 py-4 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Faktur & Tanggal</th>
                            <th class="px-5 py-4 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Informasi Produk</th>
                            <th class="px-5 py-4 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Metode</th>
                            <th class="px-5 py-4 text-[10px] font-bold text-natural-500 uppercase tracking-wider whitespace-nowrap">Pendapatan</th>
                            <th class="px-5 py-4 text-[10px] font-bold text-natural-500 uppercase tracking-wider whitespace-nowrap">Modal Item</th>
                            <th class="px-5 py-4 text-[10px] font-bold text-natural-500 uppercase tracking-wider text-right whitespace-nowrap">Laba Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($sales as $sale)
                        <tr class="hover:bg-natural-50/30 transition-colors group">
                            <td class="px-5 py-3.5">
                                <p class="text-[11px] font-bold text-natural-800 leading-none">#{{ $sale->invoice_number ?? 'INV-'.$sale->id }}</p>
                                <p class="text-[9px] text-natural-500 font-medium mt-1">{{ $sale->created_at->format('d/m/y H:i') }}</p>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex flex-col gap-0.5 max-w-[200px]">
                                    @foreach($sale->saleDetails as $detail)
                                        <p class="text-[9px] font-bold text-natural-700 leading-tight truncate">
                                            • {{ $detail->product->brand ?? 'Item' }} {{ $detail->product->model_series ?? '' }}
                                        </p>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2 py-0.5 rounded-md bg-natural-100 text-natural-600 text-[9px] font-bold uppercase">
                                    {{ $sale->payment_method ?? 'Cash' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <p class="text-[11px] font-bold text-rose-600">Rp {{ number_format($sale->total_amount - $sale->profit_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <span class="text-[11px] font-black text-emerald-600">+ Rp {{ number_format($sale->profit_amount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-natural-400 italic">Belum ada transaksi di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
