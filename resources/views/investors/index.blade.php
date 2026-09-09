<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-base font-bold text-natural-900 tracking-tight leading-none">Manajemen Investor</h2>
                <p class="text-natural-500 text-[9px] mt-1">Daftar pemodal & ringkasan aset kepemilikan</p>
            </div>
            <a href="{{ route('investors.create') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-lg transition-all shadow-sm hover:shadow-md">
                <i class='bx bx-plus text-sm'></i> Tambah Investor
            </a>
        </div>
    </x-slot>

    <div class="flex flex-col flex-1 space-y-4">

        @if(session('success'))
        <div class="flex items-center gap-2 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm font-semibold">
            <i class='bx bx-check-circle text-lg'></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-2 p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-semibold">
            <i class='bx bx-error-circle text-lg'></i> {{ session('error') }}
        </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl p-4 text-white shadow-sm">
                <p class="text-[10px] font-bold text-violet-200 uppercase tracking-wider mb-1">Total Investor Aktif</p>
                <p class="text-3xl font-black">{{ $investors->where('is_active', true)->count() }}</p>
                <p class="text-violet-200 text-xs mt-1">dari {{ $investors->count() }} investor terdaftar</p>
            </div>
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl p-4 text-white shadow-sm">
                <p class="text-[10px] font-bold text-indigo-200 uppercase tracking-wider mb-1">Total Nilai Aset Investor</p>
                <div class="flex items-start gap-1">
                    <span class="text-sm font-bold text-indigo-200 mt-1">Rp</span>
                    <span class="text-2xl font-black">{{ number_format($totalAsset, 0, ',', '.') }}</span>
                </div>
                <p class="text-indigo-200 text-xs mt-1">Nilai stok aktif milik investor</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-4 text-white shadow-sm">
                <p class="text-[10px] font-bold text-emerald-200 uppercase tracking-wider mb-1">Total Bagi Hasil (All Time)</p>
                <div class="flex items-start gap-1">
                    <span class="text-sm font-bold text-emerald-200 mt-1">Rp</span>
                    <span class="text-2xl font-black">{{ number_format($totalInvestorShare, 0, ',', '.') }}</span>
                </div>
                <p class="text-emerald-200 text-xs mt-1">Akumulasi hak semua investor</p>
            </div>
        </div>

        {{-- Tabel Investor --}}
        <div class="bg-white rounded-2xl border border-natural-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-natural-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-natural-800">Daftar Investor</h3>
                <a href="{{ route('investor.report') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-violet-50 hover:bg-violet-100 text-violet-700 text-xs font-bold rounded-lg transition-all border border-violet-200">
                    <i class='bx bx-bar-chart-alt-2 text-sm'></i> Laporan Konsolidasi
                </a>
            </div>

            @if($investors->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-natural-400">
                <i class='bx bx-user-pin text-5xl mb-3'></i>
                <p class="font-semibold text-sm">Belum ada investor terdaftar</p>
                <a href="{{ route('investors.create') }}" class="mt-3 text-brand-600 text-xs font-bold hover:underline">+ Tambah investor pertama</a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-natural-50 border-b border-natural-100">
                            <th class="text-left px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">#</th>
                            <th class="text-left px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Investor</th>
                            <th class="text-center px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Bagi Hasil</th>
                            <th class="text-right px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Produk</th>
                            <th class="text-right px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Nilai Aset Aktif</th>
                            <th class="text-right px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Profit Diterima</th>
                            <th class="text-center px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Status</th>
                            <th class="text-center px-4 py-3 text-natural-500 font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-50">
                        @foreach($investors as $i => $investor)
                        <tr class="hover:bg-natural-50/60 transition-colors">
                            <td class="px-4 py-3 text-natural-400 font-mono">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center text-white font-black text-xs shrink-0">
                                        {{ strtoupper(substr($investor->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-natural-800">{{ $investor->name }}</p>
                                        <p class="text-natural-400 text-[10px]">{{ $investor->email ?? $investor->phone ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center gap-1 bg-violet-50 text-violet-700 border border-violet-200 px-2.5 py-1 rounded-full font-black text-[11px]">
                                    {{ number_format($investor->share_percentage, 1) }}%
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="font-bold text-natural-700">{{ $investor->products_count }}</span>
                                <span class="text-natural-400 ml-1">unit</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="font-bold text-indigo-600 whitespace-nowrap"><span class="text-[10px] font-medium mr-0.5 text-indigo-400">Rp</span>{{ number_format($investor->asset_value, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="font-bold text-emerald-600 whitespace-nowrap"><span class="text-[10px] font-medium mr-0.5 text-emerald-400">Rp</span>{{ number_format($investor->investor_share, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($investor->is_active)
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 bg-natural-100 text-natural-500 border border-natural-200 px-2 py-0.5 rounded-full text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-natural-400 rounded-full"></span> Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('investors.edit', $investor) }}"
                                       class="p-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-colors" title="Edit">
                                        <i class='bx bx-edit text-sm'></i>
                                    </a>
                                    <form action="{{ route('investors.destroy', $investor) }}" method="POST" onsubmit="return confirm('Hapus investor {{ $investor->name }}? Pastikan tidak ada produk terkait.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-500 rounded-lg transition-colors" title="Hapus">
                                            <i class='bx bx-trash text-sm'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </div>
</x-app-layout>
