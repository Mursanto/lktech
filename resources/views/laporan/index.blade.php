<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <!-- Header -->
                <div class="bg-gradient-to-r from-lk-navy to-lk-cyan px-6 py-4">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a1 1 0 001 1h4a1 1 0 001-1v-1m3-2V8a2 2 0 00-2-2H8a2 2 0 00-2 2v8m3-2h6" />
                        </svg>
                        <h1 class="text-2xl font-bold text-white">Menu Laporan</h1>
                    </div>
                    <p class="text-blue-100 text-sm mt-1">Analisis lengkap dari Penjualan, Service, dan Sewa Laptop</p>
                </div>

                <!-- Report Cards -->
                <div class="p-6">

                    <!-- Baris 1: Penjualan, Laba Rugi, Stok -->
                    <div class="mb-3">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-400 inline-block"></span>
                            Laporan Penjualan &amp; Keuangan
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <!-- Laporan Penjualan Card -->
                            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-emerald-500 rounded-lg p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2V10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-emerald-800">Laporan Penjualan</h3>
                                        <p class="text-sm text-emerald-600">Analisis transaksi penjualan</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-700">
                                        Lihat ringkasan penjualan, grafik penjualan, dan analisis performa penjualan per periode.
                                    </p>
                                    <a href="{{ route('sales.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Buka Laporan
                                    </a>
                                </div>
                            </div>

                            <!-- Laporan Laba Rugi Card -->
                            <div class="bg-gradient-to-br from-violet-50 to-violet-100 border border-violet-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-violet-500 rounded-lg p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-violet-800">Laporan Laba &amp; Rugi</h3>
                                        <p class="text-sm text-violet-600">Analisis keuangan bisnis menyeluruh</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-700">
                                        Pantau total omzet dari penjualan, service, dan sewa. Termasuk perbandingan bulan ke bulan (MoM).
                                    </p>
                                    <a href="{{ route('reports.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-violet-600 text-white font-medium rounded-lg hover:bg-violet-700 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Buka Laporan
                                    </a>
                                </div>
                            </div>

                            <!-- Laporan Stok Card -->
                            <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-amber-500 rounded-lg p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-amber-800">Laporan Stok</h3>
                                        <p class="text-sm text-amber-600">Monitoring inventaris</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-700">
                                        Lihat ketersediaan stok per kategori, produk terlaris, dan analisis inventaris.
                                    </p>
                                    <a href="{{ route('products.index') }}"
                                       class="inline-flex items-center px-4 py-2 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-colors duration-200">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                        Buka Laporan
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Baris 2: Service & Sewa -->
                    <div class="mt-6">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-400 inline-block"></span>
                            Laporan Service &amp; Sewa
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Laporan Service Card -->
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-blue-800">Laporan Service</h3>
                                        <p class="text-sm text-blue-600">Rekap pekerjaan servis perangkat</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <p class="text-sm text-gray-700">
                                        Pantau seluruh order servis, status perbaikan (Menunggu / Proses / Selesai), biaya jasa, dan biaya sparepart per periode.
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('services.index') }}"
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                            Buka Laporan
                                        </a>
                                        <a href="{{ route('reports.index') }}"
                                           class="inline-flex items-center px-4 py-2 bg-white border border-blue-300 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition-colors duration-200 text-sm">
                                            Lihat di Laba &amp; Rugi
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Sewa Laptop Card -->
                            <div class="bg-gradient-to-br from-teal-50 to-cyan-100 border border-teal-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-teal-500 rounded-lg p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-teal-800">Laporan Sewa Laptop</h3>
                                        <p class="text-sm text-teal-600">Rekap penyewaan unit laptop</p>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <p class="text-sm text-gray-700">
                                        Pantau unit laptop yang sedang disewa, status (Aktif / Selesai / Terlambat), tanggal pengembalian, harga harian, dan total pendapatan sewa.
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('rentals.index') }}"
                                           class="inline-flex items-center px-4 py-2 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                            Buka Laporan
                                        </a>
                                        <a href="{{ route('reports.index') }}"
                                           class="inline-flex items-center px-4 py-2 bg-white border border-teal-300 text-teal-700 font-medium rounded-lg hover:bg-teal-50 transition-colors duration-200 text-sm">
                                            Lihat di Laba &amp; Rugi
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-lk-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informasi Laporan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-emerald-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Data Real-Time</h4>
                                    <p class="text-sm text-gray-600">Semua laporan menampilkan data terkini dari database</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-violet-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Analisis Lengkap</h4>
                                    <p class="text-sm text-gray-600">Mencakup penjualan, service, dan sewa dalam satu laporan</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Filter Periode</h4>
                                    <p class="text-sm text-gray-600">Saring data berdasarkan tanggal mulai dan tanggal akhir</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-amber-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">Export Data</h4>
                                    <p class="text-sm text-gray-600">Unduh laporan dalam format PDF atau Excel</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
