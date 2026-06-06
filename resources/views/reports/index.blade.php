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

        {{-- =====================================================
             ROW 1: 4-GRID — Summary Cards + Date Filter Card
        ====================================================== --}}
        <form action="{{ route('reports.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 shrink-0">

            {{-- Card 1: Total Pendapatan --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-trending-up'></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-lg font-black text-natural-800 truncate">Rp {{ number_format($sales->sum('total_amount'), 0, ',', '.') }}</p>
                    @if($growthPendapatan >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthPendapatan, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthPendapatan, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

            {{-- Card 2: Total Modal Stok --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-wallet'></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Total Modal Stok</p>
                    <p class="text-lg font-black text-natural-800 truncate">Rp {{ number_format($sales->sum('total_amount') - $sales->sum('profit_amount'), 0, ',', '.') }}</p>
                    @if($growthModal >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthModal, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthModal, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

            {{-- Card 3: Total Keuntungan --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-medal'></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider">Total Keuntungan</p>
                    <p class="text-lg font-black text-brand-600 truncate">Rp {{ number_format($sales->sum('profit_amount'), 0, ',', '.') }}</p>
                    @if($growthLaba >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthLaba, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthLaba, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

            {{-- Card 4: Date Filter --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex flex-col justify-between gap-3">
                <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider flex items-center gap-1.5">
                    <i class='bx bx-filter-alt text-sm'></i> Filter Periode
                </p>
                <div class="flex flex-col gap-2">
                    <div>
                        <label class="text-[9px] font-bold text-natural-400 uppercase ml-0.5">Dari</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full bg-natural-50 border-none rounded-xl text-xs py-2 px-3 focus:ring-2 focus:ring-brand-500/20 text-natural-700 font-medium">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-natural-400 uppercase ml-0.5">Sampai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full bg-natural-50 border-none rounded-xl text-xs py-2 px-3 focus:ring-2 focus:ring-brand-500/20 text-natural-700 font-medium">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2 px-3 rounded-xl transition-all">
                        Filter
                    </button>
                    @if(request('start_date') || request('end_date'))
                        <a href="{{ route('reports.index') }}" class="text-[10px] font-bold text-natural-400 hover:text-rose-500 transition-colors">Reset</a>
                    @endif
                </div>
            </div>

        </div>
        </form>

        {{-- =====================================================
             ROW 2: SPLIT — MoM Table (2/3) + Top Products (1/3)
        ====================================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 shrink-0">

            {{-- Left: MoM Comparison Table (col-span-2) --}}
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden">
                <div class="px-5 py-3 border-b border-natural-100 bg-natural-50/50 flex items-center gap-2">
                    <i class='bx bx-bar-chart-alt-2 text-natural-500'></i>
                    <h3 class="text-sm font-bold text-natural-800">Perbandingan Bulan ke Bulan (MoM)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-white text-natural-500 text-[10px] uppercase border-b border-natural-100">
                                <th class="px-5 py-2.5 font-bold">Metrik Keuangan</th>
                                <th class="px-5 py-2.5 font-bold text-right">Bulan Lalu</th>
                                <th class="px-5 py-2.5 font-bold text-right">Bulan Ini</th>
                                <th class="px-5 py-2.5 font-bold text-right">Tren</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-natural-50 text-[11px]">
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2.5 font-bold text-natural-800">Pendapatan</td>
                                <td class="px-5 py-2.5 text-right text-natural-500">Rp {{ number_format($pmPendapatan, 0, ',', '.') }}</td>
                                <td class="px-5 py-2.5 text-right font-bold text-natural-800">Rp {{ number_format($cmPendapatan, 0, ',', '.') }}</td>
                                <td class="px-5 py-2.5 text-right font-black">
                                    @if($growthPendapatan >= 0)
                                        <span class="inline-flex items-center gap-0.5 text-emerald-600">↑ +{{ number_format($growthPendapatan, 1) }}%</span>
                                    @else
                                        <span class="inline-flex items-center gap-0.5 text-rose-600">↓ {{ number_format($growthPendapatan, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2.5 font-bold text-natural-800">Modal Stok</td>
                                <td class="px-5 py-2.5 text-right text-natural-500">Rp {{ number_format($pmModal, 0, ',', '.') }}</td>
                                <td class="px-5 py-2.5 text-right font-bold text-natural-800">Rp {{ number_format($cmModal, 0, ',', '.') }}</td>
                                <td class="px-5 py-2.5 text-right font-black">
                                    @if($growthModal >= 0)
                                        <span class="text-emerald-600">↑ +{{ number_format($growthModal, 1) }}%</span>
                                    @else
                                        <span class="text-rose-600">↓ {{ number_format($growthModal, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2.5 font-bold text-natural-800">Laba Bersih</td>
                                <td class="px-5 py-2.5 text-right text-natural-500">Rp {{ number_format($pmLaba, 0, ',', '.') }}</td>
                                <td class="px-5 py-2.5 text-right font-bold text-natural-800">Rp {{ number_format($cmLaba, 0, ',', '.') }}</td>
                                <td class="px-5 py-2.5 text-right font-black">
                                    @if($growthLaba >= 0)
                                        <span class="text-emerald-600">↑ +{{ number_format($growthLaba, 1) }}%</span>
                                    @else
                                        <span class="text-rose-600">↓ {{ number_format($growthLaba, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right: Top Produk Terlaris (col-span-1) --}}
            @php
                $topProducts = \App\Models\SaleDetail::with('product')
                    ->whereHas('sale', fn($q) => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year))
                    ->get()
                    ->groupBy('product_id')
                    ->map(fn($items) => [
                        'name'  => optional($items->first()->product)->brand . ' ' . optional($items->first()->product)->model_series,
                        'count' => $items->sum('quantity'),
                    ])
                    ->sortByDesc('count')
                    ->take(5);
            @endphp
            <div class="lg:col-span-1 bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden">
                <div class="px-5 py-3 border-b border-natural-100 bg-natural-50/50 flex items-center gap-2">
                    <i class='bx bx-trophy text-amber-500'></i>
                    <h3 class="text-sm font-bold text-natural-800">Produk Terlaris <span class="text-[10px] text-natural-400 font-medium">(Bulan Ini)</span></h3>
                </div>
                <div class="p-4 space-y-2.5">
                    @forelse($topProducts as $item)
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center text-xs font-black shrink-0">
                                    {{ $loop->iteration }}
                                </div>
                                <p class="text-xs font-semibold text-natural-800 truncate">{{ $item['name'] ?: 'Produk Tanpa Nama' }}</p>
                            </div>
                            <span class="shrink-0 px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-black">{{ $item['count'] }} terjual</span>
                        </div>
                    @empty
                        <p class="text-xs text-natural-400 italic text-center py-4">Belum ada penjualan bulan ini.</p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- =====================================================
             ROW 3: TRANSACTION DETAIL TABLE
        ====================================================== --}}
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">
            <div class="px-5 py-3 border-b border-natural-100 bg-natural-50/50 flex items-center gap-2">
                <i class='bx bx-receipt text-natural-500'></i>
                <h3 class="text-sm font-bold text-natural-800">Rincian Transaksi
                    @if(request('start_date') && request('end_date'))
                        <span class="text-[10px] text-brand-500 font-medium">({{ request('start_date') }} s/d {{ request('end_date') }})</span>
                    @else
                        <span class="text-[10px] text-natural-400 font-medium">(Bulan {{ now()->translatedFormat('F Y') }})</span>
                    @endif
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Faktur & Tanggal</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Informasi Produk</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Metode</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider whitespace-nowrap">Pendapatan</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider whitespace-nowrap">Modal Item</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider text-right whitespace-nowrap">Laba Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($sales as $sale)
                        <tr class="hover:bg-natural-50/30 transition-colors group">
                            <td class="px-5 py-2.5">
                                <p class="text-[11px] font-bold text-natural-800 leading-none">#{{ $sale->invoice_number ?? 'INV-'.$sale->id }}</p>
                                <p class="text-[9px] text-natural-500 font-medium mt-0.5">{{ $sale->created_at->format('d/m/y H:i') }}</p>
                            </td>
                            <td class="px-5 py-2.5">
                                <div class="flex flex-col gap-0.5 max-w-[200px]">
                                    @foreach($sale->saleDetails as $detail)
                                        <p class="text-[9px] font-bold text-natural-700 leading-tight truncate">
                                            • {{ $detail->product->brand ?? 'Item' }} {{ $detail->product->model_series ?? '' }}
                                        </p>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-2.5">
                                <span class="px-2 py-0.5 rounded-md bg-natural-100 text-natural-600 text-[9px] font-bold uppercase">
                                    {{ $sale->payment_method ?? 'Cash' }}
                                </span>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-[11px] font-bold text-rose-600">Rp {{ number_format($sale->total_amount - $sale->profit_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-5 py-2.5 text-right whitespace-nowrap">
                                <span class="text-[11px] font-black text-emerald-600">+ Rp {{ number_format($sale->profit_amount, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-natural-400 italic text-sm">Belum ada transaksi di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
