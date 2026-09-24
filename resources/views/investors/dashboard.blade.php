<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="truncate pr-2">
                @if($investor)
                <h2 class="text-xs sm:text-base font-bold text-natural-900 tracking-tight leading-none truncate">Dashboard Investor — {{ $investor->name }}</h2>
                <p class="text-natural-500 text-[8px] sm:text-[9px] mt-1 truncate">Pantau aset & riwayat bagi hasil Anda secara real-time</p>
                @else
                <h2 class="text-xs sm:text-base font-bold text-natural-900 tracking-tight leading-none truncate">Dashboard Investor</h2>
                <p class="text-natural-500 text-[8px] sm:text-[9px] mt-1 truncate">Akun Anda belum terhubung ke profil investor</p>
                @endif
            </div>
            @if($investor)
            <div class="text-right shrink-0">
                <p class="text-[7px] sm:text-[10px] text-natural-400 uppercase tracking-wider hidden xs:block">Persentase Bagi Hasil</p>
                <p class="text-[7px] sm:text-[10px] text-natural-400 uppercase tracking-wider block xs:hidden">Bagi Hasil</p>
                <p class="text-sm sm:text-xl font-black text-violet-600 leading-tight">{{ number_format($investor->share_percentage, 1) }}%</p>
            </div>
            @endif
        </div>
    </x-slot>

    @if(!$investor)
    {{-- Belum terhubung --}}
    <div class="flex flex-col items-center justify-center py-20 text-natural-400">
        <div class="w-20 h-20 bg-natural-100 rounded-full flex items-center justify-center mb-4">
            <i class='bx bx-user-x text-4xl'></i>
        </div>
        <p class="font-bold text-natural-600 text-lg mb-2">Akun Belum Terhubung</p>
        <p class="text-sm text-center max-w-sm">Email akun Anda ({{ auth()->user()->email }}) belum terdaftar sebagai profil investor. Hubungi Admin LKTech untuk menghubungkan akun Anda.</p>
    </div>

    @else
    <div class="flex flex-col flex-1 space-y-4">
    
        {{-- Control Bar --}}
        <form x-ref="filterForm" method="GET" action="{{ route('investor.dashboard') }}" class="bg-white rounded-xl border border-natural-100 shadow-sm p-2.5 sm:p-3">
            <input type="hidden" name="tab" :value="activeTab">
            <div class="flex flex-col md:flex-row items-center justify-between gap-2.5 sm:gap-3">
                <div class="flex flex-col md:flex-row items-start md:items-center w-full md:w-auto gap-2">
                    <div class="grid grid-cols-2 md:flex items-center gap-2 w-full md:w-auto" :class="activeTab === 'stok' ? 'opacity-50 pointer-events-none' : ''" :title="activeTab === 'stok' ? 'Filter tanggal hanya aktif di tab Riwayat Terjual' : ''">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <label class="text-[9px] font-bold text-natural-500 uppercase tracking-wider">Dari</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="w-full px-2 py-1.5 border border-natural-200 rounded-lg text-[10px] sm:text-xs focus:border-brand-500 focus:outline-none">
                        </div>
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <label class="text-[9px] font-bold text-natural-500 uppercase tracking-wider">Sampai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="w-full px-2 py-1.5 border border-natural-200 rounded-lg text-[10px] sm:text-xs focus:border-brand-500 focus:outline-none">
                        </div>
                    </div>
                    
                    {{-- Quick Presets --}}
                    <div class="flex items-center gap-1 mt-1 md:mt-0" x-show="activeTab === 'riwayat'">
                        <button type="button" @click="setDates('{{ now()->startOfMonth()->toDateString() }}', '{{ now()->endOfMonth()->toDateString() }}')" class="px-2 py-1 bg-natural-100 hover:bg-natural-200 text-natural-600 rounded text-[9px] sm:text-[10px] font-semibold transition-colors">Bulan Ini</button>
                        <button type="button" @click="setDates('{{ now()->subMonths(3)->startOfMonth()->toDateString() }}', '{{ now()->endOfMonth()->toDateString() }}')" class="px-2 py-1 bg-natural-100 hover:bg-natural-200 text-natural-600 rounded text-[9px] sm:text-[10px] font-semibold transition-colors">3 Bulan Terakhir</button>
                        <button type="button" @click="setDates('{{ now()->startOfYear()->toDateString() }}', '{{ now()->endOfYear()->toDateString() }}')" class="px-2 py-1 bg-natural-100 hover:bg-natural-200 text-natural-600 rounded text-[9px] sm:text-[10px] font-semibold transition-colors">Tahun Ini</button>
                    </div>
                </div>
                
                <div class="flex items-center justify-end w-full md:w-auto gap-2">
                    <button type="submit" class="px-3 sm:px-4 py-1.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg text-[10px] sm:text-xs transition-all shadow-sm flex items-center justify-center">
                        Filter
                    </button>
                    @if($startDate || $endDate)
                    <a href="{{ route('investor.dashboard', ['tab' => request('tab', 'stok')]) }}" class="px-3 sm:px-4 py-1.5 bg-natural-100 hover:bg-natural-200 text-natural-600 font-bold rounded-lg text-[10px] sm:text-xs transition-all flex items-center justify-center">
                        Reset
                    </a>
                    @endif
                    <a href="{{ route('investor.dashboard.export', request()->query()) }}" class="px-3 sm:px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-[10px] sm:text-xs transition-all shadow-sm flex items-center justify-center gap-1.5">
                        <i class='bx bx-spreadsheet'></i> <span class="hidden xs:inline">Download</span> Excel
                    </a>
                </div>
            </div>
        </form>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-12 gap-3">
            {{-- Total Investasi --}}
            <div class="bg-white rounded-xl border border-natural-100 p-2.5 sm:p-3 shadow-sm col-span-1 lg:col-span-3 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-1">
                    <p class="text-[8px] sm:text-[9px] font-bold text-natural-500 uppercase tracking-wider leading-tight pr-1">Total Modal</p>
                    <div class="w-5 h-5 sm:w-6 sm:h-6 bg-blue-50 text-blue-600 rounded flex items-center justify-center shrink-0">
                        <i class='bx bx-briefcase text-xs sm:text-sm'></i>
                    </div>
                </div>
                <div class="flex items-start gap-0.5 sm:gap-1 whitespace-nowrap">
                    <span class="text-[10px] sm:text-xs font-bold text-natural-500 mt-0.5 sm:mt-0.5">Rp</span>
                    <span class="text-[13px] sm:text-lg lg:text-xl font-black text-natural-800 tracking-tight">{{ number_format($totalInvestment, 0, ',', '.') }}</span>
                </div>
                <p class="text-natural-500 font-medium text-[9px] sm:text-[10px] mt-1">{{ $totalQty }} Unit Barang</p>
            </div>

            {{-- Pendapatan Bersih --}}
            <div class="bg-white rounded-xl border border-natural-100 p-2.5 sm:p-3 shadow-sm flex flex-col col-span-1 lg:col-span-4 justify-between">
                <div class="flex justify-between items-start mb-1">
                    <p class="text-[8px] sm:text-[9px] font-bold text-natural-500 uppercase tracking-wider leading-tight pr-1">Total Profit</p>
                    <div class="w-5 h-5 sm:w-6 sm:h-6 bg-emerald-50 text-emerald-600 rounded flex items-center justify-center shrink-0">
                        <i class='bx bx-money text-xs sm:text-sm'></i>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-1.5">
                    <div class="flex items-start gap-0.5 sm:gap-1 whitespace-nowrap">
                        <span class="text-[10px] sm:text-xs font-bold text-natural-500 mt-0.5 sm:mt-0.5">Rp</span>
                        <span class="text-[13px] sm:text-lg lg:text-xl font-black text-natural-800 tracking-tight">{{ number_format($investorShare, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-natural-400 font-medium text-[9px] sm:text-[10px] mt-0.5 sm:mt-0 sm:text-right">{{ $soldQty }} Terjual</p>
                </div>
                
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-1 sm:gap-1.5 mt-auto">
                    <div class="bg-amber-50 rounded p-1 border border-amber-100 flex justify-between xl:block items-center">
                        <p class="text-[7px] sm:text-[8px] font-bold text-amber-500 uppercase leading-tight xl:mb-0.5">Pending</p>
                        <p class="text-[9px] sm:text-[10px] font-bold text-amber-700">Rp {{ number_format($totalPendingPayout, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-emerald-50 rounded p-1 border border-emerald-100 flex justify-between xl:block items-center">
                        <p class="text-[7px] sm:text-[8px] font-bold text-emerald-500 uppercase leading-tight xl:mb-0.5">Lunas</p>
                        <p class="text-[9px] sm:text-[10px] font-bold text-emerald-700">Rp {{ number_format($totalPaidPayout, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Nilai Sisa Aset --}}
            <div class="bg-white rounded-xl border border-natural-100 p-2.5 sm:p-3 shadow-sm col-span-1 lg:col-span-3 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-1">
                    <p class="text-[8px] sm:text-[9px] font-bold text-natural-500 uppercase tracking-wider leading-tight pr-1">Nilai Sisa Aset</p>
                    <div class="w-5 h-5 sm:w-6 sm:h-6 bg-amber-50 text-amber-600 rounded flex items-center justify-center shrink-0">
                        <i class='bx bx-box text-xs sm:text-sm'></i>
                    </div>
                </div>
                <div class="flex items-start gap-0.5 sm:gap-1 whitespace-nowrap">
                    <span class="text-[10px] sm:text-xs font-bold text-natural-500 mt-0.5 sm:mt-0.5">Rp</span>
                    <span class="text-[13px] sm:text-lg lg:text-xl font-black text-natural-800 tracking-tight">{{ number_format($assetValue, 0, ',', '.') }}</span>
                </div>
                <p class="text-natural-500 font-medium text-[9px] sm:text-[10px] mt-1">{{ $currentStockQty }} Unit Tersedia</p>
            </div>

            {{-- ROI --}}
            @php $roi = $totalInvestment > 0 ? ($investorShare / $totalInvestment) * 100 : 0; @endphp
            <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-2.5 sm:p-3 shadow-sm text-white col-span-1 lg:col-span-2 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-1">
                    <p class="text-[8px] sm:text-[9px] font-bold text-violet-200 uppercase tracking-wider leading-tight pr-1">ROI</p>
                    <div class="w-5 h-5 sm:w-6 sm:h-6 bg-white/20 rounded flex items-center justify-center shrink-0">
                        <i class='bx bx-trending-up text-xs sm:text-sm'></i>
                    </div>
                </div>
                <p class="text-[13px] sm:text-lg lg:text-xl font-black whitespace-nowrap" title="Kalkulasi otomatis berbasis skema LKTech {{ 100 - $investor->share_percentage }}% : Investor {{ number_format($investor->share_percentage, 0) }}%">{{ number_format($roi, 2, ',', '.') }}%</p>
                <p class="text-violet-200 text-[7px] sm:text-[8px] mt-1 font-medium leading-tight opacity-90 cursor-help" title="Kalkulasi otomatis berbasis skema LKTech {{ 100 - $investor->share_percentage }}% : Investor {{ number_format($investor->share_percentage, 0) }}%">(Profit &divide; Modal)</p>
            </div>
        </div>

        {{-- Chart Trend Profit Bulanan (Dihilangkan sementara) --}}
        {{--
        <div class="bg-white rounded-2xl border border-natural-100 shadow-sm py-4 px-5">
            <h3 class="text-sm font-bold text-natural-800 mb-3 flex items-center gap-2">
                <i class='bx bx-line-chart text-violet-500 text-lg'></i> Trend Bagi Hasil 6 Bulan Terakhir
            </h3>
            <div class="relative h-[140px]">
                <canvas id="investorTrendChart"></canvas>
            </div>
        </div>
        --}}

        {{-- Data Area with Tabs --}}
        <div x-data="{ 
            activeTab: '{{ request('tab', 'stok') }}',
            setDates(start, end) {
                document.getElementById('start_date').value = start;
                document.getElementById('end_date').value = end;
                this.$refs.filterForm.submit();
            }
        }">
            {{-- Tabs Navigation --}}
            <div class="flex items-center gap-1 sm:gap-4 border-b border-natural-200 mb-3 px-1 sm:px-2 overflow-x-auto hide-scrollbar">
                <button @click="activeTab = 'stok'" 
                        :class="activeTab === 'stok' ? 'border-brand-500 text-brand-700 font-bold' : 'border-transparent text-natural-500 hover:text-natural-700 font-medium'"
                        class="px-2 sm:px-4 py-2.5 sm:py-3 border-b-2 text-[10px] sm:text-sm transition-all focus:outline-none flex items-center gap-1 sm:gap-2 whitespace-nowrap">
                    <i class='bx bx-box text-sm sm:text-lg'></i>
                    Stok Tersedia ({{ $currentStockQty }} Unit)
                </button>
                <button @click="activeTab = 'riwayat'" 
                        :class="activeTab === 'riwayat' ? 'border-brand-500 text-brand-700 font-bold' : 'border-transparent text-natural-500 hover:text-natural-700 font-medium'"
                        class="px-2 sm:px-4 py-2.5 sm:py-3 border-b-2 text-[10px] sm:text-sm transition-all focus:outline-none flex items-center gap-1 sm:gap-2 whitespace-nowrap">
                    <i class='bx bx-receipt text-sm sm:text-lg'></i>
                    Riwayat Terjual ({{ $soldQty }} Unit)
                </button>
            </div>

            {{-- Tab 1: Stok Produk Aktif --}}
            <div x-show="activeTab === 'stok'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-2xl border border-natural-100 shadow-sm overflow-hidden">
                <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-natural-100">
                    <h3 class="text-xs sm:text-sm font-bold text-natural-800">Produk Saya di Inventori LKTech</h3>
                <p class="text-[9px] sm:text-[10px] text-natural-400 mt-0.5">{{ $activeProducts->count() }} produk tersedia</p>
            </div>
            @if($activeProducts->isEmpty())
            <div class="py-8 text-center text-natural-400 text-sm">
                <i class='bx bx-box text-3xl mb-2'></i>
                <p>Tidak ada produk aktif saat ini</p>
            </div>
            @else
            <div class="overflow-x-auto hide-scrollbar">
                <table class="w-full text-[10px] sm:text-xs">
                    <thead>
                        <tr class="bg-natural-50 border-b border-natural-100">
                            <th class="text-left px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider">Produk</th>
                            <th class="text-left px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider">Kategori</th>
                            <th class="text-center px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider">Stok</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider whitespace-nowrap">Modal/Unit</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider whitespace-nowrap">Total Modal Sisa</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider whitespace-nowrap">Harga Jual/Unit</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider whitespace-nowrap">Est. Bagi Hasil ({{ number_format($investor->share_percentage, 0) }}%)</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-[9px] sm:text-[11px] text-natural-500 font-bold uppercase tracking-wider whitespace-nowrap">Est. Total Return</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @foreach($activeProducts as $product)
                        @php
                            $nettProfit = max(0, $product->selling_price - $product->purchase_price);
                            $estBagiHasil = $nettProfit * ($investor->share_percentage / 100);
                            $estTotalReturn = $product->purchase_price + $estBagiHasil;
                        @endphp
                        <tr class="hover:bg-natural-50/60 transition-colors">
                            <td class="px-2 sm:px-3 py-2 sm:py-3 min-w-[120px]">
                                <p class="font-bold text-natural-800">{{ $product->brand }} {{ $product->model_series }}</p>
                                <p class="font-normal text-natural-500 text-[8px] sm:text-[10px]">SN: {{ $product->serial_number }}</p>
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-natural-500">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-center">
                                <span class="font-bold text-natural-700">{{ $product->stock }}</span>
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-semibold text-natural-600 whitespace-nowrap">
                                <span class="text-[9px] mr-0.5 text-natural-400">Rp</span>{{ number_format($product->purchase_price, 0, ',', '.') }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-semibold text-amber-600 whitespace-nowrap">
                                <span class="text-[9px] mr-0.5 text-amber-400">Rp</span>{{ number_format(($product->stock ?? 1) * $product->purchase_price, 0, ',', '.') }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-bold text-emerald-600 whitespace-nowrap">
                                <span class="text-[9px] mr-0.5 text-emerald-400 font-semibold">Rp</span>{{ number_format($product->selling_price, 0, ',', '.') }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-bold text-violet-600 whitespace-nowrap">
                                <span class="text-[9px] mr-0.5 text-violet-400 font-semibold">Rp</span>{{ number_format($estBagiHasil, 0, ',', '.') }}
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-bold text-blue-600 whitespace-nowrap">
                                <span class="text-[9px] mr-0.5 text-blue-400 font-semibold">Rp</span>{{ number_format($estTotalReturn, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            </div>

            {{-- Tab 2: Riwayat Bagi Hasil Transaksi --}}
            <div x-cloak x-show="activeTab === 'riwayat'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white rounded-2xl border border-natural-100 shadow-sm overflow-hidden">
                <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-natural-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xs sm:text-sm font-bold text-natural-800">Riwayat Transaksi</h3>
                    <p class="text-[9px] sm:text-[10px] text-natural-400 mt-0.5">{{ $details->count() }} transaksi penjualan (all time)</p>
                </div>
                @if($details->isNotEmpty())
                <a href="{{ route('investor.dashboard.export') }}" class="px-2 sm:px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-[10px] sm:text-xs transition-all shadow-sm flex items-center gap-1 sm:gap-1.5 whitespace-nowrap">
                    <i class='bx bx-spreadsheet'></i> <span class="hidden xs:inline">Download</span>
                </a>
                @endif
            </div>
            @if($details->isEmpty())
            <div class="py-10 text-center text-natural-400 text-sm">
                <i class='bx bx-receipt text-3xl mb-2'></i>
                <p>Belum ada transaksi penjualan produk Anda</p>
            </div>
            @else
            <div class="overflow-x-auto hide-scrollbar">
                <table class="w-full text-[10px] sm:text-xs">
                    <thead>
                        <tr class="bg-natural-50 border-b border-natural-100">
                            <th class="text-left px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider">Invoice</th>
                            <th class="text-left px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider">Produk</th>
                            <th class="text-center px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider">Qty</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider whitespace-nowrap">Modal</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider whitespace-nowrap">Jual</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider whitespace-nowrap">Profit</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-violet-600 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider whitespace-nowrap">Hak ({{ number_format($investor->share_percentage, 1) }}%)</th>
                            <th class="text-center px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="text-right px-2 sm:px-3 py-2 sm:py-3 text-natural-500 font-semibold text-[9px] sm:text-[11px] uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50 text-[10px] sm:text-xs">
                        @foreach($details as $detail)
                        <tr class="hover:bg-natural-50/60 transition-colors">
                            <td class="px-2 sm:px-3 py-2 sm:py-3 font-bold text-brand-600 whitespace-nowrap">{{ $detail['invoice'] }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 font-semibold text-natural-700 min-w-[120px]">{{ $detail['product'] }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-center text-natural-600">{{ $detail['qty'] }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right whitespace-nowrap"><span class="text-[8px] sm:text-[10px] font-medium mr-0.5 text-natural-400">Rp</span>{{ number_format($detail['purchase_price'], 0, ',', '.') }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right whitespace-nowrap"><span class="text-[8px] sm:text-[10px] font-medium mr-0.5 text-natural-400">Rp</span>{{ number_format($detail['price'], 0, ',', '.') }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-bold text-amber-600 whitespace-nowrap"><span class="text-[8px] sm:text-[10px] font-medium mr-0.5 text-amber-500">Rp</span>{{ number_format($detail['profit'], 0, ',', '.') }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right font-black text-violet-600 whitespace-nowrap"><span class="text-[8px] sm:text-[10px] font-medium mr-0.5 text-violet-500">Rp</span>{{ number_format($detail['investor_share'], 0, ',', '.') }}</td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-center whitespace-nowrap">
                                @if(isset($detail['payout_status']) && $detail['payout_status'] == 'paid')
                                    <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-emerald-100 text-emerald-700 rounded text-[9px] sm:text-[10px] font-bold">Lunas</span>
                                @else
                                    <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-amber-100 text-amber-700 rounded text-[9px] sm:text-[10px] font-bold">Pending</span>
                                @endif
                            </td>
                            <td class="px-2 sm:px-3 py-2 sm:py-3 text-right text-natural-400 whitespace-nowrap">
                                {{ $detail['date'] ? \Carbon\Carbon::parse($detail['date'])->format('d M Y') : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-violet-50 border-t-2 border-violet-200 font-bold">
                            <td colspan="5" class="px-2 sm:px-3 py-2 sm:py-3 text-natural-700 font-bold text-[10px] sm:text-xs">Total Hak Bagi Hasil</td>
                            <td colspan="2" class="px-2 sm:px-3 py-2 sm:py-3 text-right text-violet-700 font-black text-xs sm:text-sm whitespace-nowrap"><span class="text-[9px] sm:text-xs font-semibold mr-0.5 text-violet-500">Rp</span>{{ number_format($investorShare, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('investorTrendChart')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($trendLabels),
                    datasets: [{
                        label: 'Hak Bagi Hasil (Rp)',
                        data: @json($profitTrend),
                        backgroundColor: 'rgba(139, 92, 246, 0.2)',
                        borderColor: 'rgba(139, 92, 246, 0.9)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (context) => 'Rp ' + context.parsed.y.toLocaleString('id-ID')
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 1000000,
                            ticks: {
                                stepSize: 200000,
                                callback: (val) => 'Rp ' + val.toLocaleString('id-ID'),
                                font: { size: 10 }
                            },
                            grid: { display: false }
                        },
                        x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                    }
                }
            });
        }
    </script>
    @endif

</x-app-layout>
