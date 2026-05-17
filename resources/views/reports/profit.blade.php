<x-app-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <a href="{{ route('reports.index') }}" class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Laporan Laba & Rugi (Profit & Loss)</h2>
                        <p class="text-xs text-gray-500">Rincian pendapatan dan modal transaksi secara real-time</p>
                    </div>
                </div>
                <a href="{{ route('reports.profit-loss.export') ?? '#' }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Laporan
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-emerald-500 flex items-center gap-4">
                    <div class="p-4 bg-emerald-100 text-emerald-600 rounded-xl text-2xl">💰</div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Total Pendapatan (Omzet)</p>
                        <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500 flex items-center gap-4">
                    <div class="p-4 bg-orange-100 text-orange-600 rounded-xl text-2xl">📦</div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Total Harga Modal (HPP)</p>
                        <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalModal, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500 flex items-center gap-4">
                    <div class="p-4 bg-purple-100 text-purple-600 rounded-xl text-2xl">📈</div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Total Laba Bersih</p>
                        <h3 class="text-2xl font-black text-purple-700">Rp {{ number_format($totalLaba, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Rincian Transaksi Pembentuk Laba</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs uppercase border-b border-gray-200">
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">ID / Item Transaksi</th>
                                <th class="px-6 py-4 font-bold text-right">Pendapatan (Jual)</th>
                                <th class="px-6 py-4 font-bold text-right text-orange-600">Modal (Beli)</th>
                                <th class="px-6 py-4 font-bold text-right text-purple-600">Laba Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($sales as $sale)
                                @php
                                    $modal = $sale->total_amount - $sale->profit_amount;
                                @endphp
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 text-gray-600">{{ $sale->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-gray-800">{{ $sale->invoice_number ?? 'TRX-'.$sale->id }}</span>
                                        <div class="text-xs text-gray-400 mt-1">{{ $sale->product->brand ?? 'Item' }} {{ $sale->product->model_series ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-700">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-semibold text-orange-600">- Rp {{ number_format($modal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-purple-600">+ Rp {{ number_format($sale->profit_amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        <div class="text-3xl mb-2">📊</div>
                                        Belum ada data transaksi yang menghasilkan laba.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
