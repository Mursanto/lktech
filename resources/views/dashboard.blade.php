<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-base font-bold text-natural-900 tracking-tight leading-none">Dashboard Overview</h2>
                <p class="text-natural-500 text-[9px] mt-1">Selamat datang kembali, <span class="font-bold text-brand-600">{{ auth()->user()->name ?? 'Admin User' }}</span>!</p>
            </div>
        </div>
    </x-slot>

    <div class="flex flex-col flex-1 space-y-3">

        <!-- Colorful Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-2.5 shrink-0">
            
            <!-- Total Stok Card (Blue) -->
            <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-blue-400 to-blue-500 text-white flex flex-col justify-between group">
                <div class="p-3 flex-1 flex flex-col items-center">
                    <p class="text-[10px] font-bold text-blue-100 mb-0.5 opacity-90 text-center uppercase tracking-wider">Total Stok</p>
                    <div class="flex items-baseline justify-center gap-1 mb-1.5">
                        <h3 class="text-2xl font-black leading-none">{{ $totalStok ?? 0 }}</h3>
                        <span class="text-[10px] font-medium text-blue-100">Unit</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-1 text-[9px] font-medium text-blue-50 w-full mt-auto">
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Laptop & Device: {{ $stokDevice ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Komponen & Sparepart: {{ $stokSparepart ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Aksesoris: {{ $stokAksesoris ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Lisensi & Software: {{ $stokSoftware ?? 0 }}</div>
                    </div>
                </div>
                <div class="bg-black/10 py-1 px-3 text-[9px] font-medium text-center text-blue-100">Real-time</div>
            </div>

            <!-- Total Servis Card (Orange) -->
            @hasanyrole('Admin|Teknisi|Staff|Kasir|Sales')
            <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-orange-400 to-orange-500 text-white flex flex-col justify-between group">
                <div class="p-3 flex-1 flex flex-col items-center">
                    <p class="text-[10px] font-bold text-orange-100 mb-0.5 opacity-90 text-center uppercase tracking-wider">Total Servis</p>
                    <div class="flex items-baseline justify-center gap-1 mb-1.5">
                        <h3 class="text-2xl font-black leading-none">{{ $totalServis ?? 0 }}</h3>
                        <span class="text-[10px] font-medium text-orange-100">Unit</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-1 text-[9px] font-medium text-orange-50 w-full mt-auto">
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Pending: {{ $servisPending ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Proses: {{ $servisProcess ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Done: {{ $servisDone ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Batal: {{ $servisCancelled ?? 0 }}</div>
                    </div>
                </div>
                <div class="bg-black/10 py-1 px-3 text-[9px] font-medium text-center text-orange-100">Real-time</div>
            </div>
            @endhasanyrole

            <!-- Total Sewa Card (Cyan) -->
            @hasanyrole('Admin|Staff|Kasir|Sales')
            <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-cyan-400 to-cyan-500 text-white flex flex-col justify-between group">
                <div class="p-3 flex-1 flex flex-col items-center">
                    <p class="text-[10px] font-bold text-cyan-100 mb-0.5 opacity-90 text-center uppercase tracking-wider">Total Sewa</p>
                    <div class="flex items-baseline justify-center gap-1 mb-1.5">
                        <h3 class="text-2xl font-black leading-none">{{ $totalSewa ?? 0 }}</h3>
                        <span class="text-[10px] font-medium text-cyan-100">Unit</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-1 text-[9px] font-medium text-cyan-50 w-full mt-auto">
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center col-span-2">Aktif: {{ $sewaAktif ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center">Done: {{ $sewaSelesai ?? 0 }}</div>
                        <div class="bg-white/10 px-1 py-0.5 rounded text-center text-red-100">Telat: {{ $sewaTerlambat ?? 0 }}</div>
                    </div>
                </div>
                <div class="bg-black/10 py-1 px-3 text-[9px] font-medium text-center text-cyan-100">Real-time</div>
            </div>
            @endhasanyrole

            <!-- Omzet Card (Admin & Kasir) (Green) -->
            @hasanyrole('Admin|Staff|Kasir|Sales')
            <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-emerald-400 to-emerald-500 text-white flex flex-col justify-between group relative">
                <div class="p-3 flex-1 flex flex-col relative z-10">
                    <p class="text-[10px] font-bold text-emerald-100 mb-0.5 opacity-90 uppercase tracking-wider">Omzet Bulan Ini</p>
                    <div class="flex items-start gap-1" title="Rp {{ number_format($omzetBulanIni ?? 0, 0, ',', '.') }}">
                        <span class="text-xs font-bold text-emerald-200 mt-1">Rp</span>
                        <h3 class="text-lg font-black leading-tight truncate">{{ number_format($omzetBulanIni ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="mt-1 text-[9px] font-medium flex items-center gap-1 relative z-10">
                        <span class="px-1 py-0.5 rounded bg-white/10 flex items-center gap-0.5 {{ ($omzetGrowth ?? 0) >= 0 ? 'text-white' : 'text-red-200' }}">
                            <i class='bx {{ ($omzetGrowth ?? 0) > 0 ? 'bx-trending-up' : (($omzetGrowth ?? 0) < 0 ? 'bx-trending-down' : 'bx-minus') }}'></i>
                            {{ ($omzetGrowth ?? 0) > 0 ? '+' : ''}}{{ number_format($omzetGrowth ?? 0, 1, ',', '.') }}% vs Bulan Lalu
                        </span>
                    </div>
                </div>
                <div class="absolute bottom-6 left-0 right-0 h-10 w-full opacity-40 z-0">
                    <canvas id="omzetChart"></canvas>
                </div>
                <div class="bg-black/10 py-1 px-3 text-[9px] font-medium text-center text-emerald-100 z-10">Update</div>
            </div>
            @endhasanyrole

            <!-- Laba Card (Admin) (Purple) -->
            @role('Admin')
            <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-indigo-400 to-indigo-500 text-white flex flex-col justify-between group relative">
                <div class="p-3 flex-1 flex flex-col relative z-10">
                    <p class="text-[10px] font-bold text-indigo-100 mb-0.5 opacity-90 uppercase tracking-wider">Laba Bulan Ini</p>
                    <p class="text-[8px] text-indigo-200 mb-1 opacity-80 leading-none">Setelah dipotong bagi hasil investor</p>
                    <div class="flex items-start gap-1" title="Rp {{ number_format($labaBulanIni ?? 0, 0, ',', '.') }}">
                        <span class="text-xs font-bold text-indigo-200 mt-1">Rp</span>
                        <h3 class="text-lg font-black leading-tight truncate">{{ number_format($labaBulanIni ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="mt-1 text-[9px] font-medium flex items-center gap-1 relative z-10">
                        <span class="px-1 py-0.5 rounded bg-white/10 flex items-center gap-0.5 {{ ($labaGrowth ?? 0) >= 0 ? 'text-white' : 'text-red-200' }}">
                            <i class='bx {{ ($labaGrowth ?? 0) > 0 ? 'bx-trending-up' : (($labaGrowth ?? 0) < 0 ? 'bx-trending-down' : 'bx-minus') }}'></i>
                            {{ ($labaGrowth ?? 0) > 0 ? '+' : ''}}{{ number_format($labaGrowth ?? 0, 1, ',', '.') }}% vs Bulan Lalu
                        </span>
                    </div>
                </div>
                <div class="absolute bottom-6 left-0 right-0 h-10 w-full opacity-40 z-0">
                    <canvas id="labaChart"></canvas>
                </div>
                <div class="bg-black/10 py-1 px-3 text-[9px] font-medium text-center text-indigo-100 z-10">Update</div>
            </div>
            @endrole
        </div>

        <!-- Lower Section (Balanced Rows) -->
        <div class="flex flex-col gap-4">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-stretch">
                
                <!-- Akses Cepat -->
                <div class="bg-white p-4 flex flex-col border border-natural-100 shadow-sm rounded-2xl overflow-hidden">
                    <h3 class="text-sm font-bold text-natural-900 mb-3 flex items-center gap-2 border-b border-natural-50 pb-2 shrink-0">
                        <i class='bx bx-bolt-circle text-amber-500 text-lg'></i> Akses Cepat
                    </h3>
                    <div class="grid grid-cols-2 gap-3 content-start pt-1 flex-grow">
                        <a href="{{ route('products.index') }}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-natural-50 bg-natural-50 hover:bg-white hover:border-blue-200 hover:shadow-soft-hover hover:-translate-y-0.5 transition-all duration-200 group text-center">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-1.5 group-hover:scale-110 transition-transform shadow-sm">
                                <i class='bx bx-box'></i>
                            </div>
                            <span class="font-bold text-natural-700 text-[11px] group-hover:text-blue-600 transition-colors">Stok</span>
                        </a>

                        <a href="{{ route('catalog.index') }}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-natural-50 bg-natural-50 hover:bg-white hover:border-fuchsia-200 hover:shadow-soft-hover hover:-translate-y-0.5 transition-all duration-200 group text-center">
                            <div class="w-10 h-10 rounded-xl bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center text-2xl mb-1.5 group-hover:scale-110 transition-transform shadow-sm">
                                <i class='bx bx-book-open'></i>
                            </div>
                            <span class="font-bold text-natural-700 text-[11px] group-hover:text-fuchsia-600 transition-colors">Katalog</span>
                        </a>

                        @hasanyrole('Admin|Staff|Kasir|Sales')
                        <a href="{{ route('sales.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-natural-50 bg-natural-50 hover:bg-white hover:border-emerald-200 hover:shadow-soft-hover hover:-translate-y-0.5 transition-all duration-200 group text-center">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-1.5 group-hover:scale-110 transition-transform shadow-sm">
                                <i class='bx bx-cart-add'></i>
                            </div>
                            <span class="font-bold text-natural-700 text-[11px] group-hover:text-emerald-600 transition-colors">Jual</span>
                        </a>
                        @endhasanyrole
                        
                        @hasanyrole('Admin|Staff|Kasir|Sales')
                        <a href="{{ route('rentals.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-natural-50 bg-natural-50 hover:bg-white hover:border-cyan-200 hover:shadow-soft-hover hover:-translate-y-0.5 transition-all duration-200 group text-center">
                            <div class="w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl mb-1.5 group-hover:scale-110 transition-transform shadow-sm">
                                <i class='bx bx-laptop'></i>
                            </div>
                            <span class="font-bold text-natural-700 text-[11px] group-hover:text-cyan-600 transition-colors">Sewa</span>
                        </a>
                        @endhasanyrole

                        @hasanyrole('Admin|Teknisi|Staff|Kasir|Sales')
                        <a href="{{ route('services.create') }}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-natural-50 bg-natural-50 hover:bg-white hover:border-amber-200 hover:shadow-soft-hover hover:-translate-y-0.5 transition-all duration-200 group text-center">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-1.5 group-hover:scale-110 transition-transform shadow-sm">
                                <i class='bx bx-wrench'></i>
                            </div>
                            <span class="font-bold text-natural-700 text-[11px] group-hover:text-amber-600 transition-colors">Servis</span>
                        </a>
                        @endhasanyrole

                        @role('Admin')
                        <a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center p-3 rounded-xl border border-natural-50 bg-natural-50 hover:bg-white hover:border-rose-200 hover:shadow-soft-hover hover:-translate-y-0.5 transition-all duration-200 group text-center">
                            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl mb-1.5 group-hover:scale-110 transition-transform shadow-sm">
                                <i class='bx bx-bar-chart-alt-2'></i>
                            </div>
                            <span class="font-bold text-natural-700 text-[11px] group-hover:text-rose-600 transition-colors">Laporan</span>
                        </a>
                        @endrole
                    </div>
                </div>

                <!-- Ringkasan Inventaris (Terpadu) -->
                <div class="bg-white p-4 flex flex-col border border-natural-100 shadow-sm rounded-2xl overflow-hidden">
                    <div class="flex justify-between items-center mb-3 border-b border-natural-50 pb-2 shrink-0">
                        <h3 class="text-sm font-bold text-natural-900 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center"><i class='bx bx-box text-sm'></i></div> 
                            Ringkasan Inventaris
                        </h3>
                    </div>
                    
                    <div class="flex flex-col overflow-y-auto pr-1 custom-scrollbar flex-grow">
                        @if(!empty($stokRendah) && count($stokRendah) > 0)
                            @foreach($stokRendah as $item)
                                <div class="flex items-center py-2.5 px-1 border-b border-natural-50 last:border-b-0 hover:bg-natural-50/50 transition-colors">
                                    <div class="flex-grow min-w-0 pr-3">
                                        <p class="text-xs font-bold text-natural-800 truncate" title="{{ $item->brand }} {{ $item->model_series }}">{{ $item->brand }} {{ $item->model_series }}</p>
                                        <p class="text-[10px] text-natural-500 font-medium truncate">{{ $item->category->name ?? 'Produk' }}</p>
                                    </div>
                                    <div class="text-[10px] font-black px-2.5 py-1 rounded-lg shrink-0 border {{ $item->stock <= 10 ? 'text-orange-600 bg-orange-50 border-orange-100' : 'text-emerald-600 bg-emerald-50 border-emerald-100' }}">
                                        {{ $item->stock }} Unit
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-full py-6 text-natural-400 bg-natural-50 rounded-xl border border-dashed border-natural-200">
                                <p class="text-xs font-medium italic text-center">Stok Aman & Tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kolom 3: Widget Investor & Pengunjung -->
                <div class="flex flex-col gap-4">
                    <!-- Bagi Hasil Investor -->
                    <div class="bg-white p-5 flex flex-col border border-natural-100 shadow-sm rounded-2xl overflow-hidden bg-gradient-to-br from-amber-50/40 to-white relative justify-center flex-1">
                        <div class="w-full flex justify-center mb-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center relative z-10 shadow-sm">
                                <i class='bx bx-pie-chart-alt text-xl'></i>
                            </div> 
                        </div>
                        <h3 class="text-sm font-bold text-natural-900 text-center relative z-10">Bagi Hasil Investor</h3>
                        <p class="text-[10px] text-natural-500 mb-3 text-center relative z-10 uppercase tracking-wider font-bold">Bulan Ini</p>
                        
                        <div class="flex flex-col items-center justify-center relative z-10">
                            <div class="flex items-start gap-1 mb-3" title="Rp {{ number_format($investorShareBulanIni ?? 0, 0, ',', '.') }}">
                                <span class="text-sm font-bold text-amber-500 mt-1">Rp</span>
                                <span class="text-2xl font-black text-amber-600 leading-none truncate max-w-[200px]">{{ number_format($investorShareBulanIni ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-[10px] font-bold flex items-center gap-1.5 {{ ($investorUnpaidCount ?? 0) > 0 ? 'text-orange-600 bg-orange-50 border-orange-200' : 'text-emerald-600 bg-emerald-50 border-emerald-200' }} px-3 py-1.5 rounded-lg border shadow-sm">
                                <i class='bx {{ ($investorUnpaidCount ?? 0) > 0 ? 'bx-time-five' : 'bx-check-circle' }} text-sm'></i> 
                                {{ ($investorUnpaidCount ?? 0) > 0 ? ($investorUnpaidCount . ' Belum Transfer') : 'Semua Lunas' }}
                            </div>
                        </div>
                    </div>

                    <!-- Pengunjung Katalog -->
                    <div class="bg-white p-5 flex flex-col border border-natural-100 shadow-sm rounded-2xl overflow-hidden bg-gradient-to-br from-violet-50/40 to-white relative justify-center flex-1">
                        <div class="w-full flex justify-center mb-3">
                            <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center relative z-10 shadow-sm">
                                <i class='bx bx-line-chart text-xl'></i>
                            </div> 
                        </div>
                        <h3 class="text-sm font-bold text-natural-900 text-center relative z-10">Pengunjung Katalog</h3>
                        <p class="text-[10px] text-natural-500 mb-3 text-center relative z-10 uppercase tracking-wider font-bold">Total Trafik Bulan Ini</p>
                        
                        <div class="flex flex-col items-center justify-center relative z-10">
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="text-3xl font-black text-violet-600 leading-none">{{ $visitorCount ?? 0 }}</span>
                                <span class="text-[10px] font-bold text-violet-500 uppercase tracking-wider">Unik</span>
                            </div>
                            <div class="text-[10px] font-bold flex items-center gap-1.5 text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200 shadow-sm">
                                <i class='bx bx-trending-up text-sm'></i> Trafik Aktif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if(typeof Chart === 'undefined') return;
            const labels = @json($trendLabels ?? ['M1','M2','M3']);
            const salesData = @json($salesTrend ?? [0,0,0]);
            const profitData = @json($profitTrend ?? [0,0,0]);
            
            const opt = {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                scales: { x: { display: false }, y: { display: false, beginAtZero: true } },
                elements: { point: { radius: 0 }, line: { tension: 0.4, borderWidth: 1.5 } }
            };

            const ctx1 = document.getElementById('omzetChart');
            if(ctx1) new Chart(ctx1, { type: 'line', data: { labels: labels, datasets: [{ data: salesData, borderColor: 'rgba(255,255,255,0.5)', fill: false }] }, options: opt });

            const ctx2 = document.getElementById('labaChart');
            if(ctx2) new Chart(ctx2, { type: 'line', data: { labels: labels, datasets: [{ data: profitData, borderColor: 'rgba(255,255,255,0.5)', fill: false }] }, options: opt });
        });
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }
    </style>
</x-app-layout>
