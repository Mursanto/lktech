<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-3">
                <div class="flex items-center space-x-1 bg-natural-100 p-1 rounded-xl">
                    <a href="{{ route('investors.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all text-natural-500 hover:text-natural-700 hover:bg-natural-200">
                        Daftar Investor
                    </a>
                    <a href="{{ route('investor.report') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-all bg-white text-natural-900 shadow-sm">
                        Laporan Konsolidasi
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col flex-1 space-y-4">

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('investor.report') }}" class="bg-white rounded-2xl border border-natural-100 shadow-sm p-4">
            <div class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-natural-500 uppercase tracking-wider mb-1">Investor</label>
                    <select name="investor_id" class="px-3 py-2 border-2 border-natural-200 rounded-xl text-sm font-semibold focus:border-brand-500 focus:outline-none min-w-[180px]">
                        <option value="">Semua Investor</option>
                        @foreach($allInvestors as $inv)
                        <option value="{{ $inv->id }}" {{ $investorId == $inv->id ? 'selected' : '' }}>{{ $inv->name }} ({{ number_format($inv->share_percentage, 1) }}%)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-natural-500 uppercase tracking-wider mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-3 py-2 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-natural-500 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-3 py-2 border-2 border-natural-200 rounded-xl text-sm focus:border-brand-500 focus:outline-none">
                </div>
                <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm hover:shadow-md">
                    <i class='bx bx-filter-alt mr-1'></i> Filter
                </button>
                @if($startDate || $endDate || $investorId)
                <a href="{{ route('investor.report') }}" class="px-4 py-2 bg-natural-100 hover:bg-natural-200 text-natural-600 font-bold rounded-xl text-sm transition-all">
                    Reset
                </a>
                @endif
                
                <div class="ml-auto">
                    <a href="{{ route('investor.report.export', request()->query()) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm hover:shadow-md flex items-center gap-2">
                        <i class='bx bx-spreadsheet'></i> Download Excel
                    </a>
                </div>
            </div>
            @if(!$startDate && !$endDate)
            <p class="text-natural-400 text-[10px] mt-2 flex items-center gap-1"><i class='bx bx-info-circle'></i> Menampilkan data bulan ini ({{ now()->translatedFormat('F Y') }}). Pilih rentang tanggal untuk periode berbeda.</p>
            @endif
        </form>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            {{-- Total Aset --}}
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-4 text-white shadow-sm col-span-2 lg:col-span-1">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class='bx bx-wallet text-base'></i>
                    </div>
                    <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-wider">Total Aset Konsolidasi</p>
                </div>
                <p class="text-xl font-black leading-none">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</p>
                <div class="mt-2 space-y-1 text-[10px] text-indigo-200">
                    <p>LKTech: Rp {{ number_format($lktechAssetValue, 0, ',', '.') }}</p>
                    <p>Investor: Rp {{ number_format($investorAssetValue, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Total Profit --}}
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-4 text-white shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class='bx bx-trending-up text-base'></i>
                    </div>
                    <p class="text-[10px] font-bold text-amber-200 uppercase tracking-wider">
                        {{ $investorId ? 'Profit Kotor Barang Investor' : 'Total Profit Terjual' }}
                    </p>
                </div>
                <p class="text-xl font-black leading-none">Rp {{ number_format($totalGrossProfit, 0, ',', '.') }}</p>
                <p class="mt-2 text-[10px] text-amber-200">
                    {{ $investorId ? 'Total profit dari produk milik investor terpilih' : 'Semua produk (LKTech + Investor)' }}
                </p>
            </div>

            {{-- Bagi Hasil Investor --}}
            <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl p-4 text-white shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class='bx bx-user-pin text-base'></i>
                    </div>
                    <p class="text-[10px] font-bold text-violet-200 uppercase tracking-wider">Total Hak Investor</p>
                </div>
                <p class="text-xl font-black leading-none">Rp {{ number_format($totalInvestorShare, 0, ',', '.') }}</p>
                <p class="mt-2 text-[10px] text-violet-200">Dari profit produk investor</p>
            </div>

            {{-- Pendapatan Bersih LKTech --}}
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-4 text-white shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class='bx bx-buildings text-base'></i>
                    </div>
                    <p class="text-[10px] font-bold text-emerald-200 uppercase tracking-wider">
                        {{ $investorId ? 'Bagian LKTech (Dari Investor)' : 'Pendapatan Bersih LKTech' }}
                    </p>
                </div>
                <p class="text-xl font-black leading-none">Rp {{ number_format($totalLktechNetProfit, 0, ',', '.') }}</p>
                <p class="mt-2 text-[10px] text-emerald-200">
                    {{ $investorId ? 'Porsi keanggotaan LKTech dari produk investor' : 'Produk sendiri + sisa dari investor' }}
                </p>
            </div>
        </div>

        {{-- Per-Investor Breakdown --}}
        @forelse($investorBreakdowns as $breakdown)
        @php 
            $inv = $breakdown['investor']; 
            $pendingPayout = collect($breakdown['details'])->where('payout_status', '!==', 'paid')->sum('investor_share');
        @endphp
        <div x-data="{ open: true, showModal: false }" class="bg-white rounded-2xl border border-natural-100 shadow-sm overflow-hidden">

            {{-- Investor Header --}}
            <div @click="open = !open"
                 class="flex items-center justify-between px-5 py-4 cursor-pointer hover:bg-natural-50 transition-colors border-b border-natural-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center text-white font-black text-sm shrink-0 shadow-sm">
                        {{ strtoupper(substr($inv->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="font-bold text-natural-800 text-sm">{{ $inv->name }}</p>
                            <span class="text-[10px] font-black bg-violet-50 text-violet-700 border border-violet-200 px-2 py-0.5 rounded-full">
                                {{ number_format($inv->share_percentage, 1) }}% Bagi Hasil
                            </span>
                            @if(!$inv->is_active)
                            <span class="text-[10px] font-bold bg-natural-100 text-natural-500 px-2 py-0.5 rounded-full">Nonaktif</span>
                            @endif
                        </div>
                        <p class="text-natural-400 text-[10px]">{{ $inv->email ?? $inv->phone ?? 'Tanpa kontak' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-6 shrink-0">
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] text-natural-400 uppercase tracking-wider">Aset Aktif</p>
                        <p class="font-bold text-indigo-600 text-sm">Rp {{ number_format($breakdown['asset_value'], 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] text-natural-400 uppercase tracking-wider">Profit Kotor</p>
                        <p class="font-bold text-natural-800 text-sm">Rp {{ number_format($breakdown['gross_profit'], 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-natural-400 uppercase tracking-wider">Status Payout</p>
                        <div class="flex items-center gap-2 mt-0.5 justify-end">
                            @if($pendingPayout > 0)
                                <p class="font-bold text-amber-600 text-[11px] bg-amber-50 px-2 py-0.5 rounded-md border border-amber-100 inline-block">Belum Ditransfer (Rp {{ number_format($pendingPayout, 0, ',', '.') }})</p>
                                <button @click.stop="showModal = true" class="px-2 py-1 bg-brand-600 hover:bg-brand-700 text-white rounded text-[10px] font-bold transition-colors shadow-sm">
                                    Proses Transfer
                                </button>
                            @else
                                <p class="font-bold text-emerald-600 text-[11px] bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100 inline-block">Lunas</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-natural-400 uppercase tracking-wider">Hak Investor</p>
                        <p class="font-black text-violet-600 text-base">Rp {{ number_format($breakdown['investor_share'], 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] text-natural-400 uppercase tracking-wider">Bagian LKTech</p>
                        <p class="font-bold text-emerald-600 text-sm">Rp {{ number_format($breakdown['lktech_share'], 0, ',', '.') }}</p>
                    </div>
                    <i class='bx text-natural-400 text-lg transition-transform' :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                </div>
            </div>

            {{-- Modal Proses Transfer --}}
            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                <div @click.away="showModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden" x-transition>
                    <div class="px-6 py-4 border-b border-natural-100 flex justify-between items-center bg-natural-50">
                        <h3 class="font-bold text-natural-800 text-lg">Proses Transfer Bagi Hasil</h3>
                        <button @click="showModal = false" class="text-natural-400 hover:text-natural-600 text-2xl leading-none">&times;</button>
                    </div>
                    <form action="{{ route('investor.report.bulk-payout') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="investor_id" value="{{ $inv->id }}">
                        
                        <div>
                            <label class="block text-xs font-bold text-natural-600 mb-1">Total Transfer</label>
                            <div class="text-xl font-black text-brand-600">Rp {{ number_format($pendingPayout, 0, ',', '.') }}</div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-natural-600 mb-1">Tanggal Transfer</label>
                            <input type="date" name="payout_date" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-natural-200 rounded-lg text-sm focus:border-brand-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-natural-600 mb-1">Rekening Tujuan</label>
                            <input type="text" name="payout_account" required placeholder="Contoh: BCA 123456789 a/n {{ $inv->name }}" class="w-full px-3 py-2 border border-natural-200 rounded-lg text-sm focus:border-brand-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-natural-600 mb-1">Lampiran Bukti (Opsional)</label>
                            <input type="file" name="payout_attachment" class="w-full text-sm text-natural-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 border border-natural-200 rounded-lg focus:outline-none">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-natural-100">
                            <button type="button" @click="showModal = false" class="px-4 py-2 bg-natural-100 hover:bg-natural-200 text-natural-700 font-bold rounded-lg text-sm transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-lg text-sm transition-colors shadow-sm">Konfirmasi Transfer</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Detail Transaksi --}}
            <div x-show="open" x-transition>
                @if(count($breakdown['details']) === 0)
                <div class="flex items-center gap-2 px-5 py-6 text-natural-400 text-sm">
                    <i class='bx bx-receipt text-xl'></i>
                    Belum ada transaksi penjualan produk investor ini dalam periode yang dipilih.
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-violet-50/50 border-b border-natural-100">
                                <th class="text-left px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Invoice</th>
                                <th class="text-left px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Produk</th>
                                <th class="text-left px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Pelanggan</th>
                                <th class="text-center px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Qty</th>
                                <th class="text-right px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Harga Jual</th>
                                <th class="text-right px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">HPP</th>
                                <th class="text-right px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Profit</th>
                                <th class="text-center px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">%</th>
                                <th class="text-right px-4 py-2.5 text-violet-600 font-bold uppercase tracking-wider">Hak Investor</th>
                                <th class="text-right px-4 py-2.5 text-emerald-600 font-bold uppercase tracking-wider">Bagian LKTech</th>
                                <th class="text-right px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="text-center px-4 py-2.5 text-natural-500 font-bold uppercase tracking-wider">Status Pencairan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-natural-50">
                            @foreach($breakdown['details'] as $detail)
                            <tr class="hover:bg-natural-50/60 transition-colors">
                                <td class="px-4 py-2.5">
                                    <a href="{{ route('sales.show', $detail['sale_id']) }}" class="text-brand-600 font-bold hover:underline">{{ $detail['invoice'] }}</a>
                                </td>
                                <td class="px-4 py-2.5 font-semibold text-natural-700 max-w-[140px] truncate" title="{{ $detail['product'] }}">{{ $detail['product'] }}</td>
                                <td class="px-4 py-2.5 text-natural-500">{{ $detail['customer'] }}</td>
                                <td class="px-4 py-2.5 text-center text-natural-600 font-semibold">{{ $detail['qty'] }}</td>
                                <td class="px-4 py-2.5 text-right font-semibold">Rp {{ number_format($detail['price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2.5 text-right text-natural-500">Rp {{ number_format($detail['purchase_price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2.5 text-right font-bold text-natural-800">Rp {{ number_format($detail['profit'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2.5 text-center">
                                    <span class="text-[10px] font-black bg-violet-50 text-violet-600 px-1.5 py-0.5 rounded-full">{{ number_format($detail['share_pct'], 1) }}%</span>
                                </td>
                                <td class="px-4 py-2.5 text-right font-black text-violet-600">Rp {{ number_format($detail['investor_share'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2.5 text-right font-bold text-emerald-600">Rp {{ number_format($detail['lktech_share'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2.5 text-right text-natural-400">
                                    {{ $detail['date'] ? \Carbon\Carbon::parse($detail['date'])->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-2.5 text-center">
                                    @if(isset($detail['payout_status']) && $detail['payout_status'] == 'paid')
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold block mb-1">Sudah Transfer</span>
                                    @else
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-[10px] font-bold block mb-1">Belum Transfer</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-violet-50/80 border-t-2 border-violet-200 font-bold">
                                <td colspan="8" class="px-4 py-2.5 text-natural-700 text-xs font-bold">Subtotal {{ $inv->name }}</td>
                                <td class="px-4 py-2.5 text-right text-violet-700 font-black text-xs">Rp {{ number_format($breakdown['investor_share'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2.5 text-right text-emerald-700 font-black text-xs">Rp {{ number_format($breakdown['lktech_share'], 0, ',', '.') }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl border border-natural-100 p-12 text-center text-natural-400">
            <i class='bx bx-user-pin text-5xl mb-3'></i>
            <p class="font-semibold">Belum ada investor aktif</p>
            <a href="{{ route('investors.create') }}" class="mt-3 inline-block text-brand-600 text-sm font-bold hover:underline">+ Tambah investor pertama</a>
        </div>
        @endforelse

    </div>
</x-app-layout>
