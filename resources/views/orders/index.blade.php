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

    <main class="flex-grow max-w-[1000px] w-full mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'pending' }">
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

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Riwayat Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">Lacak status pesanan dan selesaikan pembayaran Anda di sini.</p>
        </div>

        {{-- Tabs --}}
        <div class="orders-nav-tabs border-b border-gray-200 mb-6 gap-6">
            <button @click="activeTab = 'pending'" 
                    :class="activeTab === 'pending' ? 'border-brand-600 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-3 border-b-2 font-bold text-sm transition-colors relative">
                Menunggu Pembayaran
                @if($pendingOrders->count() > 0)
                    <span class="ml-1.5 inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold text-white bg-orange-500 rounded-full">{{ $pendingOrders->count() }}</span>
                @endif
            </button>
            <button @click="activeTab = 'processing'" 
                    :class="activeTab === 'processing' ? 'border-brand-600 text-brand-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap pb-3 border-b-2 font-bold text-sm transition-colors">
                Diproses
                @if($processingOrders->count() > 0)
                    <span class="ml-1.5 inline-flex items-center justify-center px-2 py-0.5 text-[10px] font-bold text-white bg-blue-500 rounded-full">{{ $processingOrders->count() }}</span>
                @endif
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

        {{-- Tab Content: Pending --}}
        <div x-show="activeTab === 'pending'" x-transition.opacity.duration.300ms class="space-y-4">
            @forelse($pendingOrders as $order)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <i class='bx bx-shopping-bag text-gray-400 text-xl'></i>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                                <p class="text-sm font-mono font-bold text-gray-800">{{ $order->payment_reference_id ?? 'SALE-'.$order->id }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                            Menunggu Pembayaran
                        </span>
                    </div>
                    
                    <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                        <div class="flex-1 w-full min-w-0">
                            @foreach($order->saleDetails->take(2) as $detail)
                                <div class="flex items-start gap-3 mb-3 last:mb-0">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($detail->product && $detail->product->image_path)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($detail->product->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class='bx bx-laptop text-xl text-gray-400'></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}</p>
                                        <p class="text-xs text-gray-500">{{ $detail->quantity }} item × Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @if($order->saleDetails->count() > 2)
                                <p class="text-xs text-gray-400 font-medium mt-2">+ {{ $order->saleDetails->count() - 2 }} produk lainnya</p>
                            @endif
                        </div>
                        
                        <div class="sm:border-l border-t sm:border-t-0 border-gray-100 sm:pl-5 pt-4 sm:pt-0 w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0">
                            <div class="text-left sm:text-right mb-0 sm:mb-3">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Total Tagihan</p>
                                <p class="text-lg font-black text-brand-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="https://wa.me/628567354046?text={{ urlencode('Halo Admin, saya ingin menanyakan pesanan dengan nomor ' . ($order->payment_reference_id ?? 'SALE-'.$order->id)) }}" target="_blank" class="px-3 py-2 rounded-xl text-brand-600 hover:bg-brand-50 border border-brand-200 transition-colors text-xs font-bold flex items-center gap-1">
                                    <i class='bx bxl-whatsapp text-base'></i>
                                </a>
                                <a href="{{ route('checkout.success', $order->id) }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl transition-colors text-xs font-bold shadow-sm shadow-blue-200 flex items-center gap-1.5">
                                    Bayar Sekarang <i class='bx bx-right-arrow-alt text-base'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                    <i class='bx bx-receipt text-5xl text-gray-300 mb-3'></i>
                    <p class="text-gray-500 font-medium">Belum ada pesanan yang menunggu pembayaran.</p>
                </div>
            @endforelse
        </div>

        {{-- Tab Content: Processing --}}
        <div x-show="activeTab === 'processing'" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
            @forelse($processingOrders as $order)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden opacity-90">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <i class='bx bx-check-circle text-blue-500 text-xl'></i>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                                <p class="text-sm font-mono font-bold text-gray-800">{{ $order->payment_reference_id ?? 'SALE-'.$order->id }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full">
                            Lunas / Diproses
                        </span>
                    </div>
                    
                    <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                        <div class="flex-1 w-full min-w-0">
                            @foreach($order->saleDetails->take(2) as $detail)
                                <div class="flex items-start gap-3 mb-3 last:mb-0">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($detail->product && $detail->product->image_path)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($detail->product->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class='bx bx-laptop text-xl text-gray-400'></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}</p>
                                        <p class="text-xs text-gray-500">{{ $detail->quantity }} item</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="sm:border-l border-t sm:border-t-0 border-gray-100 sm:pl-5 pt-4 sm:pt-0 w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0">
                            <div class="text-left sm:text-right mb-0 sm:mb-3">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Total Belanja</p>
                                <p class="text-base font-black text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="https://wa.me/628567354046?text={{ urlencode('Halo Admin, saya ingin menanyakan pesanan Lunas saya dengan nomor ' . ($order->payment_reference_id ?? 'SALE-'.$order->id)) }}" target="_blank" class="px-4 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-xl transition-colors text-xs font-bold flex items-center gap-1.5">
                                    <i class='bx bxl-whatsapp text-base'></i> Chat Admin
                                </a>
                                <a href="{{ route('checkout.success', $order->id) }}" class="px-3 py-2 rounded-xl text-brand-600 hover:bg-brand-50 border border-brand-200 transition-colors text-xs font-bold flex items-center gap-1" title="Lihat Detail">
                                    <i class='bx bx-link-external text-base'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                    <i class='bx bx-box text-5xl text-gray-300 mb-3'></i>
                    <p class="text-gray-500 font-medium">Tidak ada pesanan yang sedang diproses.</p>
                </div>
            @endforelse
        </div>

        {{-- Tab Content: Completed --}}
        <div x-show="activeTab === 'completed'" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
            @forelse($completedOrders as $order)
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <i class='bx bx-check-double text-emerald-500 text-xl'></i>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                                <p class="text-sm font-mono font-bold text-gray-800">{{ $order->payment_reference_id ?? 'SALE-'.$order->id }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full">
                            Selesai
                        </span>
                    </div>
                    
                    <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5">
                        <div class="flex-1 w-full min-w-0">
                            @foreach($order->saleDetails->take(2) as $detail)
                                <div class="flex items-start gap-3 mb-3 last:mb-0">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($detail->product && $detail->product->image_path)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($detail->product->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class='bx bx-laptop text-xl text-gray-400'></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}</p>
                                        <p class="text-xs text-gray-500">{{ $detail->quantity }} item × Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @if($order->saleDetails->count() > 2)
                                <p class="text-xs text-gray-400 font-medium mt-2">+ {{ $order->saleDetails->count() - 2 }} produk lainnya</p>
                            @endif
                        </div>
                        
                        <div class="sm:border-l border-t sm:border-t-0 border-gray-100 sm:pl-5 pt-4 sm:pt-0 w-full sm:w-auto flex flex-row sm:flex-col items-center sm:items-end justify-between sm:justify-center shrink-0">
                            <div class="text-left sm:text-right mb-0 sm:mb-3">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest mb-0.5">Total Tagihan</p>
                                <p class="text-base font-black text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('checkout.success', $order->id) }}" class="px-3 py-2 rounded-xl text-brand-600 hover:bg-brand-50 border border-brand-200 transition-colors text-xs font-bold flex items-center gap-1" title="Lihat Detail">
                                    <i class='bx bx-link-external text-base'></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                    <i class='bx bx-check-shield text-5xl text-gray-300 mb-3'></i>
                    <p class="text-gray-500 font-medium">Belum ada pesanan yang selesai.</p>
                </div>
            @endforelse
        </div>
        
        <div x-show="activeTab === 'cancelled'" x-transition.opacity.duration.300ms class="space-y-4" style="display: none;">
            @forelse($cancelledOrders as $order)
                <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm overflow-hidden opacity-75">
                    <div class="px-5 py-3 border-b border-gray-200 flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <i class='bx bx-x-circle text-gray-400 text-xl'></i>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                                <p class="text-sm font-mono font-bold text-gray-600 line-through">{{ $order->payment_reference_id ?? 'SALE-'.$order->id }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-gray-200 text-gray-600 text-xs font-bold px-3 py-1 rounded-full">
                            Dibatalkan
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-300">
                    <i class='bx bx-x-circle text-5xl text-gray-300 mb-3'></i>
                    <p class="text-gray-500 font-medium">Tidak ada pesanan yang dibatalkan.</p>
                </div>
            @endforelse
        </div>

    </main>

    {{-- Footer --}}
    <div class="mt-auto">
        <x-footer />
    </div>

</body>
</html>
