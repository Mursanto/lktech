<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-xl font-bold text-natural-900 tracking-tight leading-none">Informasi Laba &amp; Rugi</h2>
                <p class="text-natural-500 text-[10px] mt-0.5">Ringkasan pendapatan dari Penjualan, Service, dan Sewa secara real-time.</p>
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
             FILTER PERIODE
        ====================================================== --}}
        <form action="{{ route('reports.index') }}" method="GET">
            <div class="bg-white rounded-3xl border border-natural-100 shadow-sm px-5 py-3 flex flex-wrap items-end gap-4">
                <p class="text-[10px] font-bold text-natural-400 uppercase tracking-wider flex items-center gap-1.5 self-center mr-2">
                    <i class='bx bx-filter-alt text-sm'></i> Filter Periode
                </p>
                <div class="flex items-end gap-3 flex-wrap">
                    <div>
                        <label class="text-[9px] font-bold text-natural-400 uppercase ml-0.5">Dari</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="bg-natural-50 border-none rounded-xl text-xs py-2 px-3 focus:ring-2 focus:ring-brand-500/20 text-natural-700 font-medium">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-natural-400 uppercase ml-0.5">Sampai</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="bg-natural-50 border-none rounded-xl text-xs py-2 px-3 focus:ring-2 focus:ring-brand-500/20 text-natural-700 font-medium">
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2 px-4 rounded-xl transition-all">
                        Filter
                    </button>
                    @if(request('start_date') || request('end_date'))
                        <a href="{{ route('reports.index') }}" class="text-[10px] font-bold text-natural-400 hover:text-rose-500 transition-colors self-center">Reset</a>
                    @endif
                </div>
                <div class="ml-auto text-right">
                    @if(request('start_date') && request('end_date'))
                        <p class="text-[10px] text-brand-500 font-bold">{{ request('start_date') }} s/d {{ request('end_date') }}</p>
                    @else
                        <p class="text-[10px] text-natural-400 font-medium">Bulan {{ now()->translatedFormat('F Y') }}</p>
                    @endif
                </div>
            </div>
        </form>

        {{-- =====================================================
             ROW 1: 3-GRID SUMMARY CARDS — PENJUALAN
        ====================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 shrink-0">

            {{-- Card: Total Pendapatan Penjualan --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-cart-alt'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-bold text-natural-400 uppercase tracking-wider">Penjualan · Pendapatan</p>
                    <p class="text-lg font-black text-natural-800 truncate">Rp {{ number_format($sales->sum('total_amount'), 0, ',', '.') }}</p>
                    @if($growthPendapatan >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthPendapatan, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthPendapatan, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

            {{-- Card: Total Modal Stok --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-wallet'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-bold text-natural-400 uppercase tracking-wider">Penjualan · Modal Stok</p>
                    <p class="text-lg font-black text-natural-800 truncate">Rp {{ number_format($sales->sum('total_amount') - $sales->sum('profit_amount'), 0, ',', '.') }}</p>
                    @if($growthModal >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthModal, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthModal, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

            {{-- Card: Total Keuntungan Penjualan --}}
            <div class="bg-white p-4 rounded-3xl border border-natural-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-trending-up'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-bold text-natural-400 uppercase tracking-wider">Penjualan · Laba Bersih</p>
                    <p class="text-lg font-black text-brand-600 truncate">Rp {{ number_format($sales->sum('profit_amount'), 0, ',', '.') }}</p>
                    @if($growthLaba >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthLaba, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthLaba, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

        </div>

        {{-- =====================================================
             ROW 2: 3-GRID SUMMARY CARDS — SERVICE & SEWA
        ====================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 shrink-0">

            {{-- Card: Pendapatan Service --}}
            <div class="bg-white p-4 rounded-3xl border border-violet-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-wrench'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-bold text-violet-400 uppercase tracking-wider">Service · Total Pendapatan</p>
                    <p class="text-lg font-black text-natural-800 truncate">Rp {{ number_format($totalPendapatanService, 0, ',', '.') }}</p>
                    @if($growthService >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthService, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthService, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

            {{-- Card: Pendapatan Jasa Service (fee only) --}}
            <div class="bg-white p-4 rounded-3xl border border-violet-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-coin-stack'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-bold text-violet-400 uppercase tracking-wider">Service · Pendapatan Jasa</p>
                    <p class="text-lg font-black text-violet-700 truncate">Rp {{ number_format($totalLabaService, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-natural-400 mt-0.5 font-medium">biaya jasa (tanpa sparepart)</p>
                </div>
            </div>

            {{-- Card: Pendapatan Sewa --}}
            <div class="bg-white p-4 rounded-3xl border border-cyan-100 shadow-sm flex items-center gap-4">
                <div class="w-11 h-11 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl shrink-0">
                    <i class='bx bx-laptop'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-bold text-cyan-500 uppercase tracking-wider">Sewa Laptop · Pendapatan</p>
                    <p class="text-lg font-black text-cyan-700 truncate">Rp {{ number_format($totalPendapatanSewa, 0, ',', '.') }}</p>
                    @if($growthRental >= 0)
                        <p class="text-[10px] text-emerald-600 mt-0.5 font-bold">↑ +{{ number_format($growthRental, 1) }}% dari bulan lalu</p>
                    @else
                        <p class="text-[10px] text-rose-600 mt-0.5 font-bold">↓ {{ number_format($growthRental, 1) }}% dari bulan lalu</p>
                    @endif
                </div>
            </div>

        </div>

        {{-- =====================================================
             ROW 3: SPLIT — MoM Table (2/3) + Top Products (1/3)
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
                            {{-- Penjualan --}}
                            <tr class="bg-emerald-50/30">
                                <td colspan="4" class="px-5 pt-2.5 pb-1 text-[9px] font-black text-emerald-600 uppercase tracking-widest">
                                    <i class='bx bx-cart-alt mr-1'></i> Penjualan
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2 font-semibold text-natural-800 pl-8">Pendapatan Penjualan</td>
                                <td class="px-5 py-2 text-right text-natural-500">Rp {{ number_format($pmPendapatan, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-bold text-natural-800">Rp {{ number_format($cmPendapatan, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-black">
                                    @if($growthPendapatan >= 0)
                                        <span class="inline-flex items-center gap-0.5 text-emerald-600">↑ +{{ number_format($growthPendapatan, 1) }}%</span>
                                    @else
                                        <span class="inline-flex items-center gap-0.5 text-rose-600">↓ {{ number_format($growthPendapatan, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2 font-semibold text-natural-800 pl-8">Modal Stok</td>
                                <td class="px-5 py-2 text-right text-natural-500">Rp {{ number_format($pmModal, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-bold text-natural-800">Rp {{ number_format($cmModal, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-black">
                                    @if($growthModal >= 0)
                                        <span class="text-emerald-600">↑ +{{ number_format($growthModal, 1) }}%</span>
                                    @else
                                        <span class="text-rose-600">↓ {{ number_format($growthModal, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2 font-semibold text-natural-800 pl-8">Laba Bersih Penjualan</td>
                                <td class="px-5 py-2 text-right text-natural-500">Rp {{ number_format($pmLaba, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-bold text-natural-800">Rp {{ number_format($cmLaba, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-black">
                                    @if($growthLaba >= 0)
                                        <span class="text-emerald-600">↑ +{{ number_format($growthLaba, 1) }}%</span>
                                    @else
                                        <span class="text-rose-600">↓ {{ number_format($growthLaba, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- Service --}}
                            <tr class="bg-violet-50/30">
                                <td colspan="4" class="px-5 pt-2.5 pb-1 text-[9px] font-black text-violet-600 uppercase tracking-widest">
                                    <i class='bx bx-wrench mr-1'></i> Service
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2 font-semibold text-natural-800 pl-8">Pendapatan Service</td>
                                <td class="px-5 py-2 text-right text-natural-500">Rp {{ number_format($pmService, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-bold text-natural-800">Rp {{ number_format($cmService, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-black">
                                    @if($growthService >= 0)
                                        <span class="text-emerald-600">↑ +{{ number_format($growthService, 1) }}%</span>
                                    @else
                                        <span class="text-rose-600">↓ {{ number_format($growthService, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- Sewa --}}
                            <tr class="bg-cyan-50/30">
                                <td colspan="4" class="px-5 pt-2.5 pb-1 text-[9px] font-black text-cyan-600 uppercase tracking-widest">
                                    <i class='bx bx-laptop mr-1'></i> Sewa Laptop
                                </td>
                            </tr>
                            <tr class="hover:bg-natural-50/30 transition-colors">
                                <td class="px-5 py-2 font-semibold text-natural-800 pl-8">Pendapatan Sewa</td>
                                <td class="px-5 py-2 text-right text-natural-500">Rp {{ number_format($pmRental, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-bold text-natural-800">Rp {{ number_format($cmRental, 0, ',', '.') }}</td>
                                <td class="px-5 py-2 text-right font-black">
                                    @if($growthRental >= 0)
                                        <span class="text-emerald-600">↑ +{{ number_format($growthRental, 1) }}%</span>
                                    @else
                                        <span class="text-rose-600">↓ {{ number_format($growthRental, 1) }}%</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- TOTAL GABUNGAN --}}
                            @php
                                $totalCmAll = $cmPendapatan + $cmService + $cmRental;
                                $totalPmAll = $pmPendapatan + $pmService + $pmRental;
                                $growthAll  = $totalPmAll > 0 ? (($totalCmAll - $totalPmAll) / $totalPmAll) * 100 : ($totalCmAll > 0 ? 100 : 0);
                            @endphp
                            <tr class="bg-natural-900 text-white">
                                <td class="px-5 py-3 font-black text-sm">Total Seluruh Pendapatan</td>
                                <td class="px-5 py-3 text-right font-bold text-natural-300">Rp {{ number_format($totalPmAll, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-right font-black">Rp {{ number_format($totalCmAll, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-right font-black">
                                    @if($growthAll >= 0)
                                        <span class="text-emerald-400">↑ +{{ number_format($growthAll, 1) }}%</span>
                                    @else
                                        <span class="text-rose-400">↓ {{ number_format($growthAll, 1) }}%</span>
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

                {{-- Mini stats service & sewa bulan ini --}}
                <div class="border-t border-natural-100 px-4 py-3 space-y-2">
                    <p class="text-[9px] font-black text-natural-400 uppercase tracking-wider">Transaksi Bulan Ini</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <i class='bx bx-wrench text-violet-500 text-sm'></i>
                            <span class="text-xs text-natural-600 font-medium">Service</span>
                        </div>
                        <span class="text-xs font-black text-violet-600">{{ $services->count() }} order</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <i class='bx bx-laptop text-cyan-500 text-sm'></i>
                            <span class="text-xs text-natural-600 font-medium">Sewa Laptop</span>
                        </div>
                        <span class="text-xs font-black text-cyan-600">{{ $rentals->count() }} unit</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- =====================================================
             ROW 4: TABBED TRANSACTION TABLE
        ====================================================== --}}
        <div class="bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden flex-grow flex flex-col">

            {{-- Tab Navigation --}}
            <div class="px-5 py-3 border-b border-natural-100 bg-natural-50/50 flex items-center gap-3 flex-wrap">
                <i class='bx bx-receipt text-natural-500'></i>
                <h3 class="text-sm font-bold text-natural-800 mr-2">Rincian Transaksi
                    @if(request('start_date') && request('end_date'))
                        <span class="text-[10px] text-brand-500 font-medium">({{ request('start_date') }} s/d {{ request('end_date') }})</span>
                    @else
                        <span class="text-[10px] text-natural-400 font-medium">(Bulan {{ now()->translatedFormat('F Y') }})</span>
                    @endif
                </h3>

                <div class="flex items-center gap-1 ml-auto">
                    <button onclick="switchTab('semua')" id="tab-semua"
                            class="tab-btn active-tab px-3 py-1 rounded-xl text-[10px] font-black transition-all">
                        Semua
                        <span class="ml-1 px-1.5 py-0.5 rounded-md bg-natural-100 text-natural-600 text-[9px]">
                            {{ $sales->count() + $services->count() + $rentals->count() }}
                        </span>
                    </button>
                    <button onclick="switchTab('penjualan')" id="tab-penjualan"
                            class="tab-btn px-3 py-1 rounded-xl text-[10px] font-black transition-all">
                        Penjualan
                        <span class="ml-1 px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[9px]">{{ $sales->count() }}</span>
                    </button>
                    <button onclick="switchTab('service')" id="tab-service"
                            class="tab-btn px-3 py-1 rounded-xl text-[10px] font-black transition-all">
                        Service
                        <span class="ml-1 px-1.5 py-0.5 rounded-md bg-violet-50 text-violet-700 text-[9px]">{{ $services->count() }}</span>
                    </button>
                    <button onclick="switchTab('sewa')" id="tab-sewa"
                            class="tab-btn px-3 py-1 rounded-xl text-[10px] font-black transition-all">
                        Sewa
                        <span class="ml-1 px-1.5 py-0.5 rounded-md bg-cyan-50 text-cyan-700 text-[9px]">{{ $rentals->count() }}</span>
                    </button>
                </div>
            </div>

            {{-- ===================== TAB: SEMUA ===================== --}}
            <div id="content-semua" class="tab-content overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Nomor &amp; Tanggal</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Informasi</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider whitespace-nowrap">Pendapatan</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider text-right whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @php
                            // Gabungkan semua transaksi diurutkan by date
                            $allTransactions = collect();
                            foreach($sales as $s) {
                                $allTransactions->push(['type' => 'sale', 'date' => $s->created_at, 'data' => $s]);
                            }
                            foreach($services as $sv) {
                                $allTransactions->push(['type' => 'service', 'date' => $sv->created_at, 'data' => $sv]);
                            }
                            foreach($rentals as $r) {
                                $allTransactions->push(['type' => 'rental', 'date' => $r->created_at, 'data' => $r]);
                            }
                            $allTransactions = $allTransactions->sortByDesc('date');
                        @endphp

                        @forelse($allTransactions as $trx)
                            <tr class="hover:bg-natural-50/30 transition-colors">

                                {{-- Tipe Badge --}}
                                <td class="px-5 py-2.5">
                                    @if($trx['type'] === 'sale')
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded-lg text-[9px] font-black uppercase">Jual</span>
                                    @elseif($trx['type'] === 'service')
                                        <span class="px-2 py-0.5 bg-violet-50 text-violet-700 rounded-lg text-[9px] font-black uppercase">Servis</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-cyan-50 text-cyan-700 rounded-lg text-[9px] font-black uppercase">Sewa</span>
                                    @endif
                                </td>

                                {{-- Nomor & Tanggal --}}
                                <td class="px-5 py-2.5">
                                    @if($trx['type'] === 'sale')
                                        <p class="text-[11px] font-bold text-natural-800">#{{ $trx['data']->invoice_number ?? 'INV-'.$trx['data']->id }}</p>
                                    @elseif($trx['type'] === 'service')
                                        <p class="text-[11px] font-bold text-natural-800">#SRV-{{ str_pad($trx['data']->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    @else
                                        <p class="text-[11px] font-bold text-natural-800">#RNT-{{ str_pad($trx['data']->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    @endif
                                    <p class="text-[9px] text-natural-500 font-medium mt-0.5">{{ $trx['date']->format('d/m/y H:i') }}</p>
                                </td>

                                {{-- Informasi --}}
                                <td class="px-5 py-2.5">
                                    @if($trx['type'] === 'sale')
                                        <div class="flex flex-col gap-0.5 max-w-[200px]">
                                            @foreach($trx['data']->saleDetails->take(2) as $detail)
                                                <p class="text-[9px] font-bold text-natural-700 leading-tight truncate">
                                                    • {{ $detail->product->brand ?? 'Item' }} {{ $detail->product->model_series ?? '' }}
                                                </p>
                                            @endforeach
                                            @if($trx['data']->saleDetails->count() > 2)
                                                <p class="text-[9px] text-natural-400">+{{ $trx['data']->saleDetails->count() - 2 }} item lainnya</p>
                                            @endif
                                        </div>
                                    @elseif($trx['type'] === 'service')
                                        <p class="text-[10px] font-bold text-natural-700 truncate max-w-[200px]">{{ $trx['data']->device_name ?? '-' }}</p>
                                        <p class="text-[9px] text-natural-400 truncate max-w-[200px]">{{ Str::limit($trx['data']->complaint ?? '', 40) }}</p>
                                    @else
                                        <p class="text-[10px] font-bold text-natural-700 truncate max-w-[200px]">{{ $trx['data']->laptop_name ?? '-' }}</p>
                                        <p class="text-[9px] text-natural-400">{{ optional($trx['data']->rental_date)->format('d/m/y') }} – {{ optional($trx['data']->return_date)->format('d/m/y') }}</p>
                                    @endif
                                </td>

                                {{-- Pendapatan --}}
                                <td class="px-5 py-2.5 whitespace-nowrap">
                                    @if($trx['type'] === 'sale')
                                        <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($trx['data']->total_amount, 0, ',', '.') }}</p>
                                        <p class="text-[9px] text-emerald-600 font-medium">laba: Rp {{ number_format($trx['data']->profit_amount, 0, ',', '.') }}</p>
                                    @elseif($trx['type'] === 'service')
                                        <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($trx['data']->total_amount, 0, ',', '.') }}</p>
                                        <p class="text-[9px] text-violet-600 font-medium">jasa: Rp {{ number_format($trx['data']->service_fee, 0, ',', '.') }}</p>
                                    @else
                                        <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($trx['data']->total_price, 0, ',', '.') }}</p>
                                        <p class="text-[9px] text-cyan-600 font-medium">Rp {{ number_format($trx['data']->daily_price, 0, ',', '.') }}/hari</p>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-2.5 text-right">
                                    @if($trx['type'] === 'sale')
                                        <span class="px-2 py-0.5 rounded-md bg-natural-100 text-natural-600 text-[9px] font-bold uppercase">
                                            {{ $trx['data']->payment_method ?? 'Cash' }}
                                        </span>
                                    @elseif($trx['type'] === 'service')
                                        @php
                                            $statusColor = ['pending'=>'yellow','process'=>'blue','done'=>'emerald','cancelled'=>'red'][$trx['data']->status] ?? 'gray';
                                            $statusLabel = ['pending'=>'Menunggu','process'=>'Proses','done'=>'Selesai','cancelled'=>'Batal'][$trx['data']->status] ?? '-';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-md bg-{{ $statusColor }}-50 text-{{ $statusColor }}-700 text-[9px] font-bold">{{ $statusLabel }}</span>
                                    @else
                                        @php
                                            $rentalColor = ['active'=>'blue','completed'=>'emerald','overdue'=>'red'][$trx['data']->status] ?? 'gray';
                                            $rentalLabel = ['active'=>'Aktif','completed'=>'Selesai','overdue'=>'Terlambat'][$trx['data']->status] ?? '-';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-md bg-{{ $rentalColor }}-50 text-{{ $rentalColor }}-700 text-[9px] font-bold">{{ $rentalLabel }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-natural-400 italic text-sm">Belum ada transaksi di periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== TAB: PENJUALAN ===================== --}}
            <div id="content-penjualan" class="tab-content hidden overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-natural-50/50 border-b border-natural-100">
                            <th class="px-5 py-2.5 text-[10px] font-bold text-natural-500 uppercase tracking-wider">Faktur &amp; Tanggal</th>
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
                            <td colspan="6" class="px-6 py-10 text-center text-natural-400 italic text-sm">Belum ada transaksi penjualan di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== TAB: SERVICE ===================== --}}
            <div id="content-service" class="tab-content hidden overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-violet-50/50 border-b border-violet-100">
                            <th class="px-5 py-2.5 text-[10px] font-bold text-violet-500 uppercase tracking-wider">No. Servis &amp; Tanggal</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-violet-500 uppercase tracking-wider">Perangkat &amp; Keluhan</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-violet-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-violet-500 uppercase tracking-wider whitespace-nowrap">Total Tagihan</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-violet-500 uppercase tracking-wider whitespace-nowrap">Biaya Jasa</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-violet-500 uppercase tracking-wider text-right whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($services as $service)
                        <tr class="hover:bg-violet-50/20 transition-colors">
                            <td class="px-5 py-2.5">
                                <p class="text-[11px] font-bold text-natural-800">#SRV-{{ str_pad($service->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[9px] text-natural-500 font-medium mt-0.5">{{ $service->created_at->format('d/m/y H:i') }}</p>
                            </td>
                            <td class="px-5 py-2.5">
                                <p class="text-[10px] font-bold text-natural-800 truncate max-w-[180px]">{{ $service->device_name ?? '-' }}</p>
                                <p class="text-[9px] text-natural-400 truncate max-w-[180px]">{{ Str::limit($service->complaint ?? '-', 45) }}</p>
                            </td>
                            <td class="px-5 py-2.5">
                                <p class="text-[10px] font-semibold text-natural-700">{{ optional($service->customer)->name ?? 'Umum' }}</p>
                                <p class="text-[9px] text-natural-400">{{ optional($service->customer)->phone ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($service->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <span class="text-[11px] font-black text-violet-600">Rp {{ number_format($service->service_fee, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-5 py-2.5 text-right">
                                @php
                                    $sc = ['pending'=>'yellow','process'=>'blue','done'=>'emerald','cancelled'=>'red'][$service->status] ?? 'gray';
                                    $sl = ['pending'=>'Menunggu','process'=>'Proses','done'=>'Selesai','cancelled'=>'Batal'][$service->status] ?? '-';
                                @endphp
                                <span class="px-2 py-0.5 rounded-md bg-{{ $sc }}-50 text-{{ $sc }}-700 text-[9px] font-bold">{{ $sl }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-natural-400 italic text-sm">Belum ada transaksi service di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== TAB: SEWA ===================== --}}
            <div id="content-sewa" class="tab-content hidden overflow-x-auto">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-cyan-50/50 border-b border-cyan-100">
                            <th class="px-5 py-2.5 text-[10px] font-bold text-cyan-600 uppercase tracking-wider">No. Sewa &amp; Tanggal</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-cyan-600 uppercase tracking-wider">Laptop</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-cyan-600 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-cyan-600 uppercase tracking-wider whitespace-nowrap">Durasi Sewa</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-cyan-600 uppercase tracking-wider whitespace-nowrap">Harga/Hari</th>
                            <th class="px-5 py-2.5 text-[10px] font-bold text-cyan-600 uppercase tracking-wider text-right whitespace-nowrap">Total &amp; Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @forelse($rentals as $rental)
                        <tr class="hover:bg-cyan-50/20 transition-colors">
                            <td class="px-5 py-2.5">
                                <p class="text-[11px] font-bold text-natural-800">#RNT-{{ str_pad($rental->id, 5, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-[9px] text-natural-500 font-medium mt-0.5">{{ $rental->created_at->format('d/m/y H:i') }}</p>
                            </td>
                            <td class="px-5 py-2.5">
                                <p class="text-[10px] font-bold text-natural-800 truncate max-w-[160px]">{{ $rental->laptop_name ?? '-' }}</p>
                                <p class="text-[9px] text-natural-400">SN: {{ $rental->serial_number ?? $rental->manual_sn ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-2.5">
                                <p class="text-[10px] font-semibold text-natural-700">{{ $rental->customer_name ?? optional($rental->customer)->name ?? 'Umum' }}</p>
                                <p class="text-[9px] text-natural-400">{{ $rental->customer_phone ?? optional($rental->customer)->phone ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-[10px] font-bold text-natural-800">{{ optional($rental->rental_date)->format('d/m/y') }} – {{ optional($rental->return_date)->format('d/m/y') }}</p>
                                @if($rental->rental_date && $rental->return_date)
                                    <p class="text-[9px] text-cyan-600 font-medium">{{ $rental->rental_date->diffInDays($rental->return_date) }} hari</p>
                                @endif
                            </td>
                            <td class="px-5 py-2.5 whitespace-nowrap">
                                <p class="text-[11px] font-bold text-natural-800">Rp {{ number_format($rental->daily_price, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-5 py-2.5 text-right whitespace-nowrap">
                                <p class="text-[11px] font-black text-cyan-700 mb-0.5">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</p>
                                @php
                                    $rc = ['active'=>'blue','completed'=>'emerald','overdue'=>'red'][$rental->status] ?? 'gray';
                                    $rl = ['active'=>'Aktif','completed'=>'Selesai','overdue'=>'Terlambat'][$rental->status] ?? '-';
                                @endphp
                                <span class="px-2 py-0.5 rounded-md bg-{{ $rc }}-50 text-{{ $rc }}-700 text-[9px] font-bold">{{ $rl }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-natural-400 italic text-sm">Belum ada transaksi sewa di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Tab Switching Script --}}
    <style>
        .tab-btn { color: #6b7280; background: transparent; }
        .active-tab { color: #1f2937; background: #f3f4f6; }
    </style>

    <script>
        function switchTab(tab) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active-tab'));
            // Show selected
            document.getElementById('content-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).classList.add('active-tab');
        }
    </script>

</x-app-layout>
