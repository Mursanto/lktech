<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pesanan - LKTech</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' }
                    }
                }
            }
        }
    </script>
    <style>
        .orders-nav-tabs {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
        }
        .orders-nav-tabs::-webkit-scrollbar {
            display: none; /* Chrome/Safari */
        }
        @media (max-width: 576px) {
            .orders-nav-tabs button {
                font-size: 0.8rem !important;
                padding: 8px 12px !important;
            }
        }
    </style>
</head>
<body class="text-gray-800 antialiased flex flex-col min-h-screen">
    <x-navbar />

    <main class="flex-grow max-w-[1000px] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="guestOrdersApp()">
        <!-- Breadcrumb Navigasi -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li>
                    <a href="/" class="hover:text-brand-600 flex items-center gap-1 transition-colors">
                        <i class="bx bx-home"></i> Home
                    </a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li>
                    <a href="/katalog" class="hover:text-brand-600 transition-colors">Katalog</a>
                </li>
                <li><span class="text-gray-400">/</span></li>
                <li class="font-semibold text-gray-900" aria-current="page">Riwayat Transaksi</li>
            </ol>
        </nav>

        <div class="mb-4">
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Riwayat Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">Lacak status pesanan dan selesaikan pembayaran Anda di sini.</p>
        </div>

        <!-- FORM PENCARIAN CADANGAN -->
        <div class="bg-white p-3 rounded-xl border border-gray-200 mb-6 shadow-sm">
            <form @submit.prevent="searchOrders" class="flex gap-2">
                <input type="text" x-model="searchQuery" class="flex-1 rounded-lg border-gray-300 border px-3 py-2 text-sm focus:ring-brand-500 focus:border-brand-500" placeholder="Cari Kode Pesanan (Contoh: SALE-74-17...)" required>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold px-4 py-2 rounded-lg text-sm transition-colors shadow-sm flex items-center gap-1">
                    <i class='bx bx-search'></i> 
                    <span class="hidden sm:inline">Cari Pesanan</span>
                </button>
            </form>
        </div>

        {{-- Tabs --}}
        <div class="orders-nav-tabs border-b border-gray-200 mb-6 gap-6">
            <button @click="activeTab = 'pending'" 
                    :class="activeTab === 'pending' ? 'border-brand-600 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-3 border-b-2 font-bold text-sm transition-colors relative flex items-center">
                Menunggu Pembayaran
                <template x-if="pendingOrders.length > 0">
                    <span class="ml-1.5 inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold text-white bg-orange-500 rounded-full" x-text="pendingOrders.length"></span>
                </template>
            </button>
            <button @click="activeTab = 'processing'" 
                    :class="activeTab === 'processing' ? 'border-brand-600 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-3 border-b-2 font-bold text-sm transition-colors flex items-center">
                Diproses
                <template x-if="processingOrders.length > 0">
                    <span class="ml-1.5 inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold text-white bg-blue-500 rounded-full" x-text="processingOrders.length"></span>
                </template>
            </button>
            <button @click="activeTab = 'completed'" 
                    :class="activeTab === 'completed' ? 'border-brand-600 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-3 border-b-2 font-bold text-sm transition-colors">
                Selesai
            </button>
            <button @click="activeTab = 'cancelled'" 
                    :class="activeTab === 'cancelled' ? 'border-brand-600 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-3 border-b-2 font-bold text-sm transition-colors">
                Batal
            </button>
        </div>

        <!-- Loading Indicator -->
        <div x-show="isLoading" class="text-center py-12">
            <i class='bx bx-loader-alt bx-spin text-4xl text-brand-500 mb-3'></i>
            <p class="text-gray-500 font-medium text-sm">Memuat riwayat pesanan...</p>
        </div>

        <div x-show="!isLoading" style="display: none;">
            {{-- Tab Content: Pending --}}
            <div x-show="activeTab === 'pending'" x-transition.opacity.duration.300ms class="space-y-4">
                <template x-for="order in pendingOrders" :key="order.id">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-shopping-bag text-gray-400 text-xl'></i>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium" x-text="order.created_at_formatted + ' WIB'"></p>
                                    <p class="text-sm font-mono font-bold text-gray-800" x-text="order.reference_number"></p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                Menunggu Pembayaran
                            </span>
                        </div>
                        
                        <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                            <div class="flex-1 w-full min-w-0">
                                <template x-for="(detail, index) in order.details" :key="index">
                                    <template x-if="index < 2">
                                        <div class="flex items-start gap-3 mb-3 last:mb-0">
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                                <template x-if="detail.image_url">
                                                    <img :src="detail.image_url" class="w-full h-full object-cover">
                                                </template>
                                                <template x-if="!detail.image_url">
                                                    <i class='bx bx-laptop text-xl text-gray-400'></i>
                                                </template>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-bold text-gray-900 truncate" x-text="detail.product_name"></p>
                                                <p class="text-xs text-gray-500" x-text="detail.quantity + ' item × Rp ' + detail.price_formatted"></p>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="order.details_count > 2">
                                    <p class="text-xs text-gray-400 font-medium mt-2" x-text="'+ ' + (order.details_count - 2) + ' produk lainnya'"></p>
                                </template>
                            </div>
                            
                            <div class="sm:border-l border-t sm:border-t-0 border-gray-100 sm:pl-5 pt-4 sm:pt-0 w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0">
                                <div class="text-left sm:text-right mb-0 sm:mb-3">
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Total Tagihan</p>
                                    <p class="text-lg font-black text-brand-600" x-text="'Rp ' + order.total_formatted"></p>
                                </div>
                                <div class="flex gap-2">
                                    <a :href="'https://wa.me/628567354046?text=' + encodeURIComponent('Halo Admin, saya ingin menanyakan pesanan dengan nomor ' + order.reference_number)" target="_blank" class="px-3 py-2 rounded-xl text-brand-600 hover:bg-brand-50 border border-brand-200 transition-colors text-xs font-bold flex items-center gap-1">
                                        <i class='bx bxl-whatsapp text-base'></i>
                                    </a>
                                    <a :href="'/checkout/success/' + order.id" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl transition-colors text-xs font-bold shadow-sm shadow-blue-200 flex items-center gap-1.5">
                                        Bayar Sekarang <i class='bx bx-right-arrow-alt text-base'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="pendingOrders.length === 0">
                    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <i class='bx bx-receipt text-5xl text-gray-300 mb-3'></i>
                        <p class="text-gray-500 font-medium">Belum ada pesanan yang menunggu pembayaran.</p>
                    </div>
                </template>
            </div>

            {{-- Tab Content: Processing --}}
            <div x-show="activeTab === 'processing'" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                <template x-for="order in processingOrders" :key="order.id">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden opacity-90">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-check-circle text-blue-500 text-xl'></i>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium" x-text="order.created_at_formatted + ' WIB'"></p>
                                    <p class="text-sm font-mono font-bold text-gray-800" x-text="order.reference_number"></p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                                Lunas / Diproses
                            </span>
                        </div>
                        
                        <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                            <div class="flex-1 w-full min-w-0">
                                <template x-for="(detail, index) in order.details" :key="index">
                                    <template x-if="index < 2">
                                        <div class="flex items-start gap-3 mb-3 last:mb-0">
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                                <template x-if="detail.image_url">
                                                    <img :src="detail.image_url" class="w-full h-full object-cover">
                                                </template>
                                                <template x-if="!detail.image_url">
                                                    <i class='bx bx-laptop text-xl text-gray-400'></i>
                                                </template>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-bold text-gray-900 truncate" x-text="detail.product_name"></p>
                                                <p class="text-xs text-gray-500" x-text="detail.quantity + ' item'"></p>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                            
                            <div class="sm:border-l border-t sm:border-t-0 border-gray-100 sm:pl-5 pt-4 sm:pt-0 w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0">
                                <div class="text-left sm:text-right mb-0 sm:mb-3">
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Total Belanja</p>
                                    <p class="text-base font-black text-gray-900" x-text="'Rp ' + order.total_formatted"></p>
                                </div>
                                <div class="flex gap-2">
                                    <a :href="'https://wa.me/628567354046?text=' + encodeURIComponent('Halo Admin, saya ingin menanyakan pesanan Lunas saya dengan nomor ' + order.reference_number)" target="_blank" class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-xl transition-colors text-xs font-bold flex items-center gap-1.5">
                                        <i class='bx bxl-whatsapp text-base'></i> Chat Admin
                                    </a>
                                    <a :href="'/checkout/success/' + order.id" class="px-3 py-2 rounded-xl text-brand-600 hover:bg-brand-50 border border-brand-200 transition-colors text-xs font-bold flex items-center gap-1" title="Lihat Detail">
                                        <i class='bx bx-link-external text-base'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="processingOrders.length === 0">
                    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <i class='bx bx-box text-5xl text-gray-300 mb-3'></i>
                        <p class="text-gray-500 font-medium">Tidak ada pesanan yang sedang diproses.</p>
                    </div>
                </template>
            </div>

            {{-- Tab Content: Completed --}}
            <div x-show="activeTab === 'completed'" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                <template x-for="order in completedOrders" :key="order.id">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-check-double text-emerald-500 text-xl'></i>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium" x-text="order.created_at_formatted + ' WIB'"></p>
                                    <p class="text-sm font-mono font-bold text-gray-800" x-text="order.reference_number"></p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
                                Selesai
                            </span>
                        </div>
                        
                        <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                            <div class="flex-1 w-full min-w-0">
                                <template x-for="(detail, index) in order.details" :key="index">
                                    <template x-if="index < 2">
                                        <div class="flex items-start gap-3 mb-3 last:mb-0">
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                                <template x-if="detail.image_url">
                                                    <img :src="detail.image_url" class="w-full h-full object-cover">
                                                </template>
                                                <template x-if="!detail.image_url">
                                                    <i class='bx bx-laptop text-xl text-gray-400'></i>
                                                </template>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-bold text-gray-900 truncate" x-text="detail.product_name"></p>
                                                <p class="text-xs text-gray-500" x-text="detail.quantity + ' item × Rp ' + detail.price_formatted"></p>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="order.details_count > 2">
                                    <p class="text-xs text-gray-400 font-medium mt-2" x-text="'+ ' + (order.details_count - 2) + ' produk lainnya'"></p>
                                </template>
                            </div>
                            
                            <div class="sm:border-l border-t sm:border-t-0 border-gray-100 sm:pl-5 pt-4 sm:pt-0 w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0">
                                <div class="text-left sm:text-right mb-0 sm:mb-3">
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Total Tagihan</p>
                                    <p class="text-base font-black text-gray-900" x-text="'Rp ' + order.total_formatted"></p>
                                </div>
                                <div class="flex gap-2">
                                    <a :href="'/checkout/success/' + order.id" class="px-3 py-2 rounded-xl text-brand-600 hover:bg-brand-50 border border-brand-200 transition-colors text-xs font-bold flex items-center gap-1" title="Lihat Detail">
                                        <i class='bx bx-link-external text-base'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="completedOrders.length === 0">
                    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <i class='bx bx-check-shield text-5xl text-gray-300 mb-3'></i>
                        <p class="text-gray-500 font-medium">Belum ada pesanan yang selesai.</p>
                    </div>
                </template>
            </div>
            
            {{-- Tab Content: Cancelled --}}
            <div x-show="activeTab === 'cancelled'" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
                <template x-for="order in cancelledOrders" :key="order.id">
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm overflow-hidden opacity-75">
                        <div class="px-5 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-x-circle text-gray-400 text-xl'></i>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium" x-text="order.created_at_formatted + ' WIB'"></p>
                                    <p class="text-sm font-mono font-bold text-gray-600 line-through" x-text="order.reference_number"></p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 bg-gray-200 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">
                                Dibatalkan
                            </span>
                        </div>
                    </div>
                </template>
                <template x-if="cancelledOrders.length === 0">
                    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                        <i class='bx bx-x-circle text-5xl text-gray-300 mb-3'></i>
                        <p class="text-gray-500 font-medium">Tidak ada pesanan yang dibatalkan.</p>
                    </div>
                </template>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <div class="mt-auto">
        <x-footer />
    </div>

    <script>
        function guestOrdersApp() {
            return {
                activeTab: 'pending',
                isLoading: true,
                searchQuery: '',
                orders: [],

                get pendingOrders() {
                    return this.orders.filter(o => o.order_status === 'menunggu_pembayaran');
                },
                get processingOrders() {
                    return this.orders.filter(o => o.order_status === 'diproses');
                },
                get completedOrders() {
                    return this.orders.filter(o => o.order_status === 'selesai');
                },
                get cancelledOrders() {
                    return this.orders.filter(o => o.order_status === 'batal');
                },

                init() {
                    const storedOrders = JSON.parse(localStorage.getItem("lktech_guest_orders")) || [];
                    if (storedOrders.length > 0) {
                        this.fetchOrders({ references: storedOrders });
                    } else {
                        this.isLoading = false;
                    }
                },

                searchOrders() {
                    const q = this.searchQuery.trim();
                    if (!q) return;
                    this.fetchOrders({ search_query: q });
                },

                fetchOrders(payload) {
                    this.isLoading = true;
                    fetch('/api/guest-orders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            let hasNew = false;
                            if (payload.search_query && data.data.length > 0) {
                                let storedOrders = JSON.parse(localStorage.getItem("lktech_guest_orders")) || [];
                                data.data.forEach(order => {
                                    if (!storedOrders.includes(order.reference_number)) {
                                        storedOrders.unshift(order.reference_number);
                                        hasNew = true;
                                    }
                                });
                                
                                if (hasNew) {
                                    localStorage.setItem("lktech_guest_orders", JSON.stringify(storedOrders));
                                    // Fetch all updated orders from local storage to show full history
                                    this.fetchOrders({ references: storedOrders });
                                    this.searchQuery = '';
                                    return;
                                }
                            }
                            
                            if (payload.search_query && data.data.length === 0) {
                                alert('Pesanan tidak ditemukan.');
                            } else if (!payload.search_query || !hasNew) {
                                this.orders = data.data;
                            }
                        } else {
                            if (payload.search_query) {
                                alert('Pesanan tidak ditemukan.');
                            }
                            if (!payload.search_query) {
                                this.orders = [];
                            }
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        console.error(err);
                        this.isLoading = false;
                        if (payload.search_query) {
                            alert('Terjadi kesalahan saat mencari pesanan.');
                        }
                    });
                }
            }
        }
    </script>
</body>
</html>
