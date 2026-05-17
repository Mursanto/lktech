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
                </div>

                <!-- Report Cards -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
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
                                    <h3 class="text-lg font-semibold text-violet-800">Laporan Laba Rugi</h3>
                                    <p class="text-sm text-violet-600">Analisis keuangan bisnis</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-700">
                                    Pantau total omzet, laba bersih, dan analisis profitabilitas bisnis Anda.
                                </p>
                                <a href="{{ route('reports.profit') }}" 
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

                    <!-- Additional Information -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-lk-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informasi Laporan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                    <p class="text-sm text-gray-600">Dapatkan insight mendalam tentang performa bisnis</p>
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
