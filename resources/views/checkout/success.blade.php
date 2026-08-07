<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pembayaran - LKTech</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript"
        src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' }
                    }
                }
            }
        }
    </script>

    <style>
        html, body { height: 100%; margin: 0; }

        @keyframes ticker-pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.45; }
        }
        .timer-urgent { animation: ticker-pulse 0.85s ease-in-out infinite; }

        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fade-in-up 0.35s ease-out both; }

        @keyframes slide-up {
            from { opacity: 0; transform: translateY(100%); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .slide-up { animation: slide-up 0.3s ease-out both; }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        /* Mobile: full screen layout with sticky bottom */
        @media (max-width: 1023px) {
            .mobile-payment-body { 
                display: flex; 
                flex-direction: column;
                min-height: 100vh;
                margin-top: 0;
            }
            .mobile-scroll-area {
                flex: 1;
                overflow-y: auto;
                padding-bottom: 80px; /* room for sticky WA btn */
            }
            .mobile-sticky-bottom {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 40;
            }
        }

        /* Desktop: fill the viewport below the navbar */
        @media (min-width: 1024px) {
            .payment-grid-wrapper {
                min-height: calc(100vh - 56px); /* 56px is h-14 navbar */
            }
        }

        /* Modal backdrop */
        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(2px);
            z-index: 50;
            display: flex;
            align-items: flex-end;
        }
        @media (min-width: 1024px) {
            .modal-backdrop { align-items: center; justify-content: center; }
        }
        .modal-sheet {
            width: 100%;
            background: white;
            border-radius: 20px 20px 0 0;
            max-height: 90vh;
            overflow-y: auto;
            padding: 20px 16px 32px;
        }
        @media (min-width: 1024px) {
            .modal-sheet {
                border-radius: 20px;
                max-width: 420px;
                padding: 28px;
            }
        }
        .modal-handle {
            width: 40px; height: 4px;
            background: #e2e8f0;
            border-radius: 4px;
            margin: 0 auto 16px;
        }
    </style>
</head>

@php
    /* ── PHP computed values ── */
    $deadlineTs   = $sale->created_at->addHours(1)->timestamp;
    $customerName = $sale->customer->name ?? 'Pelanggan';
    $refId        = $sale->payment_reference_id ?? ('SALE-' . $sale->id);
    $totalFormatted = 'Rp ' . number_format($sale->total_amount, 0, ',', '.');

    // Deadline label: "8 Agu 2026, 08:49 WIB"
    $idMonths = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $dl = $sale->created_at->addHours(1);
    $deadlineLabel = $dl->day . ' ' . $idMonths[$dl->month] . ' ' . $dl->year . ', ' . $dl->format('H:i') . ' WIB';

    $waConfirmMsg = urlencode(
        "Halo Admin LKTech. Saya ingin konfirmasi pembayaran untuk pesanan {$refId} " .
        "atas nama {$customerName} sejumlah {$totalFormatted}. Berikut bukti transfernya:"
    );
    $waSuccessMsg = urlencode(
        "Halo Admin LKTech. Saya baru saja menyelesaikan pembayaran untuk pesanan {$refId} " .
        "atas nama {$customerName}. Mohon info untuk biaya ongkos kirimnya."
    );

    $isQris = ($sale->payment_method === 'Transfer Manual' || $sale->payment_method === 'QRIS');
    $isVA   = isset($paymentInfo) && !empty($paymentInfo['va_number']);
@endphp

<body class="bg-gray-50 text-gray-800 antialiased font-sans" style="min-height:100vh">

    {{-- ════════════════════════════════════════════════
         CHECKOUT FOCUS HEADER
         ════════════════════════════════════════════════ --}}
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm flex items-center justify-between px-4 h-14 lg:px-8 relative" x-data="{ recentOrders: [] }" x-init="recentOrders = JSON.parse(sessionStorage.getItem('recent_orders') || '[]')" @recent-orders-updated.window="recentOrders = JSON.parse(sessionStorage.getItem('recent_orders') || '[]')">
        <a href="{{ route('katalog.index') }}" class="text-gray-600 hover:text-brand-600 flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors">
            <i class='bx bx-arrow-back text-xl'></i>
        </a>
        <h1 class="font-bold text-gray-800 text-sm md:text-base tracking-tight absolute left-1/2 -translate-x-1/2">Status Pembayaran</h1>
        
        <div class="flex items-center gap-1">
            <!-- Recent Orders Dropdown -->
            <div class="relative" x-data="{ openRecent: false }" @click.away="openRecent = false">
                <button @click="openRecent = !openRecent" class="relative text-gray-600 hover:text-brand-600 flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors">
                    <i class='bx bx-receipt text-xl'></i>
                    <span x-show="recentOrders.length > 0" x-text="recentOrders.length" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full shadow-sm"></span>
                </button>
                
                <div x-show="openRecent" x-transition.opacity class="absolute top-full right-0 mt-2 w-72 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50 -mr-2 sm:-mr-4" style="display: none;">
                    <div class="px-4 py-2 border-b border-gray-50 flex justify-between items-center">
                        <span class="font-bold text-gray-800 text-sm">Riwayat Sesi Ini</span>
                        <span class="text-xs text-gray-400 font-medium"><span x-text="recentOrders.length"></span> Pesanan</span>
                    </div>
                    
                    <div class="max-h-64 overflow-y-auto">
                        <template x-if="recentOrders.length === 0">
                            <div class="px-4 py-6 text-center text-sm text-gray-500 flex flex-col items-center gap-2">
                                <i class='bx bx-ghost text-3xl text-gray-300'></i>
                                Belum ada transaksi.
                            </div>
                        </template>
                        <template x-for="order in recentOrders" :key="order.id">
                            <div class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition-colors text-left">
                                <div class="flex justify-between items-start mb-1.5">
                                    <span class="text-xs font-mono font-bold text-gray-700" x-text="order.ref"></span>
                                    <span class="text-[9px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-sm uppercase tracking-wider" x-text="order.status"></span>
                                </div>
                                <div class="flex items-center gap-3 mt-2">
                                    <a :href="order.url" class="text-[11px] font-semibold text-brand-600 hover:text-brand-700 flex items-center gap-1"><i class='bx bx-link-external'></i> Buka Order</a>
                                    <a :href="order.pdf_url" class="text-[11px] font-semibold text-gray-500 hover:text-gray-700 flex items-center gap-1"><i class='bx bx-download'></i> PDF</a>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <template x-if="recentOrders.length > 0">
                        <div class="px-4 pt-3 pb-1 text-center border-t border-gray-50 mt-1">
                            <button @click="sessionStorage.removeItem('recent_orders'); recentOrders = []; openRecent = false" class="text-[11px] text-red-500 hover:text-red-700 font-bold transition-colors">Kosongkan Riwayat Sesi</button>
                        </div>
                    </template>
                </div>
            </div>

            <a href="{{ route('checkout.index') }}" class="text-gray-600 hover:text-brand-600 flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 transition-colors">
                <i class='bx bx-cart text-xl'></i>
            </a>
        </div>
    </header>

    {{-- ════════════════════════════════════════════════
         ✅ SUCCESS STATE
         ════════════════════════════════════════════════ --}}
    @if($sale->payment_status === 'success')
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-8 pt-8">
        <div class="fade-in-up w-full max-w-md text-center">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm">
                <i class='bx bx-check text-5xl'></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Pembayaran Berhasil!</h1>
            <p class="text-gray-500 text-sm mb-1">Pesanan atas nama <strong class="text-gray-700">{{ $customerName }}</strong></p>
            <p class="text-xs text-gray-400 font-mono mb-6">Ref: {{ $refId }}</p>

            <div class="bg-blue-50 border border-blue-100 text-blue-700 rounded-xl p-4 mb-6 text-sm text-left flex items-start gap-3">
                <i class='bx bx-envelope text-xl shrink-0 mt-0.5'></i>
                <p>
                    <strong>Cek email kamu, invoice sudah kami kirim.</strong><br>
                    Biar lebih praktis, kamu juga bisa langsung cetak atau simpan PDF-nya di bawah sini. Semoga hari kamu menyenangkan!
                </p>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-5 text-left">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">SATU LAGI DARI KAMI</h2>
                <p class="text-sm text-gray-600 leading-relaxed mb-5">
                    "Mohon diperhatikan, biaya kirim belum kami masukkan ke total tadi. Tenang, Admin kami siap bantu di WA untuk carikan kurir yang pas & infokan tarifnya. Klik tombol di bawah untuk langsung chat!"
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="https://wa.me/628567354046?text={{ $waSuccessMsg }}" target="_blank"
                       class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-bold py-3 px-4 rounded-xl transition-all shadow-sm flex justify-center items-center gap-2 text-sm">
                        <i class='bx bxl-whatsapp text-xl'></i> Hubungi via WA
                    </a>
                    <a href="{{ route('checkout.invoice', $sale->id) }}"
                       class="w-full bg-white border-2 border-brand-500 hover:bg-brand-50 text-brand-600 font-bold py-3 px-4 rounded-xl transition-all shadow-sm flex justify-center items-center gap-2 text-sm">
                        <i class='bx bx-download text-xl'></i> Unduh Invoice PDF
                    </a>
                </div>
            </div>

            <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-brand-600 font-medium transition-colors inline-block mt-4">
                ← Kembali ke Beranda
            </a>
        </div>

        <div class="w-full max-w-6xl text-left">
            <x-payment-recommendations :products="$recommendedProducts" />
        </div>
    </main>

    {{-- ════════════════════════════════════════════════
         ⏳ PENDING STATE
         ════════════════════════════════════════════════ --}}
    @else
    <div class="mobile-payment-body lg:block"
         x-data="paymentPage({{ $deadlineTs }}, {{ $sale->id }})"
         x-init="startCountdown()">

        {{-- ══════════════════════════════════════════════
             MOBILE LAYOUT  (lg:hidden)
             ══════════════════════════════════════════════ --}}
        <div class="lg:hidden mobile-payment-body">

            {{-- ── 1. Timer Card ── --}}
            <div class="bg-amber-50 border-b border-amber-200 px-4 py-3 flex items-center justify-between"
                 :class="urgent ? 'bg-red-50 border-red-200 timer-urgent' : ''">
                <div class="min-w-0">
                    <p class="text-[10px] font-semibold text-gray-500 leading-none mb-0.5">Bayar sebelum</p>
                    <p class="text-xs font-bold text-gray-800">{{ $deadlineLabel }}</p>
                </div>
                <div class="flex items-center gap-1.5 shrink-0 ml-2 px-3 py-1.5 rounded-full font-mono font-black text-sm"
                     :class="urgent
                         ? 'bg-red-100 text-red-700'
                         : 'bg-amber-100 text-amber-800'">
                    <i class='bx bx-time-five text-base'></i>
                    <span x-text="displayTime">--:--:--</span>
                </div>
            </div>

            {{-- ── 2. Scrollable content ── --}}
            <div class="mobile-scroll-area px-4 py-4 space-y-3">

                {{-- Main Payment Card --}}
                <div class="fade-in-up bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                    {{-- Status Badge row --}}
                    <div class="px-4 pt-4 pb-3 flex items-center justify-between border-b border-gray-50">
                        <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-bold px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                            Menunggu Pembayaran
                        </span>
                        <span class="text-[10px] text-gray-400 font-mono truncate ml-2">{{ $refId }}</span>
                    </div>

                    {{-- Total Tagihan + Lihat Detail --}}
                    <div class="px-4 py-4" x-data="{ detailOpen: false }">
                        <div class="flex items-start justify-between mb-0.5">
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Total Tagihan</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-3xl font-black text-brand-600 leading-tight">{{ $totalFormatted }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $sale->total_amount }}').then(()=>{ alert('Nominal disalin!') })"
                                            class="text-brand-500 hover:text-brand-700 transition-colors" title="Salin Nominal">
                                        <i class='bx bx-copy text-lg'></i>
                                    </button>
                                </div>
                            </div>
                            <button @click="detailOpen = !detailOpen"
                                    class="text-xs font-semibold text-brand-600 flex items-center gap-0.5 mt-1 shrink-0 ml-2">
                                <span x-text="detailOpen ? 'Sembunyikan' : 'Lihat Detail'"></span>
                                <i class='bx text-sm' :class="detailOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-400 mb-0">Bayarkan tepat sesuai nominal di atas</p>

                        {{-- Collapsible order items --}}
                        <div x-show="detailOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-3 border-t border-gray-50 pt-3 space-y-2">
                            @foreach($sale->saleDetails as $detail)
                            <div class="flex items-center justify-between">
                                <div class="min-w-0 flex-1 pr-2">
                                    <p class="text-xs font-semibold text-gray-700 truncate">
                                        {{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}
                                    </p>
                                    <p class="text-[10px] text-gray-400">{{ $detail->quantity }} × Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</p>
                                </div>
                                <p class="text-xs font-bold text-gray-900 shrink-0">
                                    Rp {{ number_format($detail->price_at_transaction * $detail->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                            @endforeach
                            <div class="flex items-center justify-between border-t border-gray-100 pt-2 mt-1">
                                <p class="text-xs font-bold text-gray-700">Total</p>
                                <p class="text-sm font-black text-brand-600">{{ $totalFormatted }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Mini QRIS preview / VA info --}}
                    @if($isQris)
                    <div class="px-4 pb-4 flex items-center gap-3 border-t border-gray-50 pt-3">
                        {{-- Mini QRIS thumbnail, tap to open modal --}}
                        <button @click="showQrisModal = true"
                                class="relative shrink-0 w-[100px] h-[100px] bg-white border-2 border-dashed border-brand-200 rounded-xl overflow-hidden flex items-center justify-center group">
                            <img src="{{ asset('images/Qris.jpeg') }}" alt="QRIS"
                                 class="w-full h-full object-cover rounded-lg opacity-90 group-hover:opacity-100 transition-opacity">
                            <div class="absolute inset-0 bg-brand-900/50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                <i class='bx bx-expand text-white text-xl'></i>
                                <p class="text-white text-[9px] font-bold mt-0.5">Perbesar</p>
                            </div>
                        </button>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-700 mb-1">Bayar via QRIS</p>
                            <p class="text-[10px] text-gray-500 leading-relaxed">Tap gambar untuk memperbesar kode QR agar mudah di-scan</p>
                            <button @click="showQrisModal = true"
                                    class="mt-2 text-xs font-bold text-brand-600 flex items-center gap-1">
                                <i class='bx bx-qr-scan'></i> Tampilkan QR Code
                            </button>
                        </div>
                    </div>
                    @elseif($isVA)
                    <div class="px-4 pb-4 border-t border-gray-50 pt-3">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Nomor Virtual Account — {{ $paymentInfo['bank'] }}
                        </p>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black text-gray-900 tracking-wider font-mono">{{ $paymentInfo['va_number'] }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $paymentInfo['va_number'] }}').then(()=>{ alert('Nomor VA disalin!') })"
                                    class="text-brand-500" title="Salin">
                                <i class='bx bx-copy text-lg'></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    {{-- ── 2-column CTA Buttons ── --}}
                    <div class="grid grid-cols-2 gap-2 px-4 pb-4">
                        {{-- Lihat Cara Bayar --}}
                        <button @click="showCaraBayarModal = true"
                                class="flex items-center justify-center gap-1.5 border border-brand-200 text-brand-700 bg-brand-50 font-semibold text-xs py-2.5 px-3 rounded-xl hover:bg-brand-100 transition-colors">
                            <i class='bx bx-help-circle text-sm'></i>
                            Cara Bayar
                        </button>
                        {{-- Status Pembayaran --}}
                        <button @click="checkStatus()" :disabled="isCheckingStatus"
                                class="flex items-center justify-center gap-1.5 bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:cursor-wait text-white font-semibold text-xs py-2.5 px-3 rounded-xl transition-colors">
                            <template x-if="isCheckingStatus">
                                <i class='bx bx-loader-alt bx-spin text-sm'></i>
                            </template>
                            <template x-if="!isCheckingStatus">
                                <i class='bx bx-refresh text-sm'></i>
                            </template>
                            <span x-text="isCheckingStatus ? 'Memeriksa...' : 'Cek Status'"></span>
                        </button>
                    </div>
                </div>

                {{-- Info notes (Tokopedia style) --}}
                <div class="fade-in-up bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-3 space-y-2 text-[11px] text-gray-500">
                    <div class="flex items-start gap-2">
                        <i class='bx bx-info-circle text-gray-400 text-sm shrink-0 mt-0.5'></i>
                        <p>Bayarkan <strong class="text-gray-700">tepat sesuai nominal</strong> yang tertera. Pembayaran lebih atau kurang tidak dapat diproses otomatis.</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <i class='bx bx-info-circle text-gray-400 text-sm shrink-0 mt-0.5'></i>
                        <p>Setelah transfer, kirim <strong class="text-gray-700">bukti pembayaran</strong> ke Admin via WhatsApp untuk konfirmasi manual.</p>
                    </div>
                </div>

                {{-- Back link --}}
                <div class="text-center pb-2">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-brand-600 font-medium transition-colors">
                        ← Kembali ke Beranda
                    </a>
                </div>

                {{-- Rekomendasi Produk Terlaris (Mobile) --}}
                <div class="px-4 pb-4">
                    <x-payment-recommendations :products="$recommendedProducts" />
                </div>
            </div>

            {{-- ── 3. Sticky Bottom WA Button ── --}}
            <div class="mobile-sticky-bottom px-4 py-3 bg-white/95 backdrop-blur border-t border-gray-100 shadow-lg">
                @if($isQris)
                <a href="https://wa.me/628567354046?text={{ $waConfirmMsg }}" target="_blank"
                   class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-bold py-3 px-4 rounded-2xl transition-all flex justify-center items-center gap-2 text-sm shadow-md shadow-green-200">
                    <i class='bx bxl-whatsapp text-xl'></i> Konfirmasi Pembayaran via WA
                </a>
                @else
                <button type="button" @click.prevent="payNow()" :disabled="isLoading"
                        class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3 px-4 rounded-2xl transition-all flex justify-center items-center gap-2 text-sm shadow-md shadow-blue-200">
                    <template x-if="isLoading"><i class='bx bx-loader-alt bx-spin text-xl'></i></template>
                    <template x-if="!isLoading"><i class='bx bx-credit-card-front text-xl'></i></template>
                    <span x-text="isLoading ? 'Memproses...' : 'Lanjutkan Pembayaran'"></span>
                </button>
                @endif
            </div>

        </div>
        {{-- END MOBILE LAYOUT --}}


        {{-- ══════════════════════════════════════════════
             DESKTOP LAYOUT  (hidden lg:block)
             ══════════════════════════════════════════════ --}}
        <div class="hidden lg:flex payment-grid-wrapper flex-col pt-10">
            <div class="flex-1 grid grid-cols-2">

                {{-- ─── LEFT — Bill info ─── --}}
                <div class="flex flex-col justify-center px-10 xl:px-14 py-6 border-r border-gray-100">

                    <div class="fade-in-up mb-3">
                        <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <h1 class="fade-in-up text-3xl font-black text-gray-900 leading-tight mb-1">
                        Selesaikan Pembayaran Anda
                    </h1>
                    <p class="text-gray-400 text-sm mb-4 fade-in-up">
                        Pesanan untuk <span class="font-semibold text-gray-700">{{ $customerName }}</span>
                    </p>

                    {{-- Desktop countdown --}}
                    <div class="hidden lg:flex fade-in-up items-center gap-3 rounded-xl px-4 py-3 mb-5 border"
                         :class="urgent ? 'bg-red-50 border-red-200 text-red-700 timer-urgent' : 'bg-amber-50 border-amber-200 text-amber-800'">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                             :class="urgent ? 'bg-red-100' : 'bg-amber-100'">
                            <i class='bx bx-time-five text-lg'></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-semibold opacity-70 uppercase tracking-wider leading-none mb-0.5">Bayar sebelum {{ $deadlineLabel }}</p>
                            <p class="font-mono font-black text-2xl leading-tight" x-text="displayTime">--:--:--</p>
                        </div>
                    </div>

                    {{-- Order detail card --}}
                    <div class="fade-in-up bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-4" x-data="{ detailOpen: false }">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-50 bg-gray-50/60">
                            <div>
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Nomor Referensi</p>
                                <p class="font-mono font-bold text-gray-800 text-xs mt-0.5">{{ $refId }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Pembeli</p>
                                <p class="font-semibold text-gray-800 text-xs mt-0.5">{{ $customerName }}</p>
                            </div>
                        </div>
                        <div class="px-4 py-4 bg-gradient-to-br from-brand-50 to-white">
                            <div class="flex items-start justify-between mb-1">
                                <div>
                                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                                    <div class="flex items-center gap-3">
                                        <p class="text-4xl font-black text-brand-600 leading-none">{{ $totalFormatted }}</p>
                                        <button onclick="navigator.clipboard.writeText('{{ $sale->total_amount }}').then(()=>{ alert('Nominal disalin!') })"
                                                class="text-brand-500 hover:text-brand-700 transition-colors" title="Salin Nominal">
                                            <i class='bx bx-copy text-2xl'></i>
                                        </button>
                                    </div>
                                </div>
                                <button @click="detailOpen = !detailOpen" class="text-xs font-semibold text-brand-600 flex items-center gap-0.5 shrink-0 mt-1">
                                    <span x-text="detailOpen ? 'Sembunyikan' : 'Lihat Detail'"></span>
                                    <i class='bx text-sm' :class="detailOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Bayarkan tepat sesuai nominal di atas</p>

                            {{-- Collapsible order items (Desktop) --}}
                            <div x-show="detailOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-4 border-t border-gray-100 pt-4 space-y-3">
                                @foreach($sale->saleDetails as $detail)
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0 flex-1 pr-2">
                                        <p class="text-sm font-semibold text-gray-700 truncate">
                                            {{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $detail->quantity }} × Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900 shrink-0">
                                        Rp {{ number_format($detail->price_at_transaction * $detail->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($isQris)
                    <div class="fade-in-up bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 mb-4">
                        <p class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                            <i class='bx bx-info-circle'></i> Cara Bayar QRIS
                        </p>
                        <ol class="text-xs text-blue-700 space-y-1 leading-relaxed list-decimal pl-4">
                            <li>Buka aplikasi e-Wallet / m-Banking Anda</li>
                            <li>Pilih menu <strong>Scan / QRIS</strong></li>
                            <li>Scan kode QR di kanan, masukkan nominal <strong>{{ $totalFormatted }}</strong></li>
                            <li>Kirim bukti bayar ke Admin via WhatsApp</li>
                        </ol>
                    </div>
                    @elseif($isVA)
                    <div class="fade-in-up bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 mb-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Virtual Account — {{ $paymentInfo['bank'] }}</p>
                        <div class="flex items-center gap-2">
                            <span class="text-xl font-black text-gray-900 tracking-wider font-mono">{{ $paymentInfo['va_number'] }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $paymentInfo['va_number'] }}').then(()=>{ alert('Nomor VA disalin!') })"
                                    class="text-brand-500 hover:text-brand-700 transition-colors">
                                <i class='bx bx-copy text-lg'></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="mt-1">
                        <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-brand-600 font-medium transition-colors">
                            ← Kembali ke Beranda
                        </a>
                    </div>
                </div>

                {{-- ─── RIGHT — Payment action ─── --}}
                <div class="flex flex-col items-center justify-center px-8 xl:px-14 py-8 bg-gradient-to-b from-gray-50 to-white">

                    @if($isQris)
                    <div class="fade-in-up text-center mb-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">Bayar Via</p>
                        <p class="text-lg font-black text-gray-800 flex items-center justify-center gap-2">
                            <i class='bx bx-qr-scan text-brand-500 text-xl'></i> QRIS
                        </p>
                    </div>

                    <div class="fade-in-up bg-white border border-gray-200 rounded-2xl p-4 shadow-sm mb-6 inline-block max-w-sm w-full relative group">
                        <button @click="showQrisModal = true" class="w-full relative block overflow-hidden rounded-xl bg-gray-50 flex justify-center">
                            <img src="{{ asset('images/Qris.jpeg') }}" alt="QRIS LKTech TN Sereal"
                                 class="w-full h-auto object-contain rounded-xl max-h-72">
                            <div class="absolute inset-0 bg-brand-900/50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-xl">
                                <i class='bx bx-expand text-white text-3xl'></i>
                                <p class="text-white text-sm font-bold mt-1">Perbesar QRIS</p>
                            </div>
                        </button>
                    </div>

                    <div class="fade-in-up w-full max-w-sm">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button @click="checkStatus()" :disabled="isCheckingStatus"
                                    class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-wait text-white font-bold py-3 px-3 rounded-xl transition-all shadow-md shadow-blue-200 flex justify-center items-center gap-2 text-xs">
                                <template x-if="isCheckingStatus">
                                    <i class='bx bx-loader-alt bx-spin text-lg'></i>
                                </template>
                                <template x-if="!isCheckingStatus">
                                    <i class='bx bx-refresh text-lg'></i>
                                </template>
                                <span x-text="isCheckingStatus ? 'Memeriksa...' : 'Cek Status'"></span>
                            </button>
                            <a href="https://wa.me/628567354046?text={{ $waConfirmMsg }}" target="_blank"
                               class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-3 rounded-xl transition-all shadow-md shadow-emerald-200 flex justify-center items-center gap-1.5 text-xs text-center leading-tight">
                                <i class='bx bxl-whatsapp text-lg shrink-0'></i> Konfirmasi via WA
                            </a>
                        </div>
                    </div>

                    @elseif($isVA)
                    <div class="fade-in-up text-center mb-6">
                        <div class="w-20 h-20 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class='bx bx-bank text-4xl'></i>
                        </div>
                        <p class="text-sm font-bold text-gray-700 mb-1">Transfer ke Virtual Account</p>
                        <p class="text-3xl font-black text-brand-600">{{ $totalFormatted }}</p>
                    </div>
                    <div class="fade-in-up w-full max-w-sm bg-white border border-gray-100 rounded-2xl shadow-sm p-5 text-center">
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-3">Nomor VA — {{ $paymentInfo['bank'] }}</p>
                        <div class="flex items-center justify-center gap-2 mb-3">
                            <span class="text-2xl font-black text-gray-900 tracking-widest font-mono">{{ $paymentInfo['va_number'] }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $paymentInfo['va_number'] }}').then(()=>{ alert('Nomor VA disalin!') })"
                                    class="text-brand-500 hover:text-brand-700 transition-colors">
                                <i class='bx bx-copy text-xl'></i>
                            </button>
                        </div>
                    </div>

                    @else
                    <div class="fade-in-up text-center mb-6">
                        <div class="w-20 h-20 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class='bx bx-credit-card text-4xl'></i>
                        </div>
                        <p class="text-sm text-gray-500 mb-6 max-w-xs">Jika Anda belum menyelesaikan pembayaran atau halaman tertutup, klik tombol di bawah.</p>
                    </div>
                    <div class="fade-in-up w-full max-w-xs">
                        <button type="button" @click.prevent="payNow()" :disabled="isLoading"
                                class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-2xl transition-all shadow-md shadow-blue-200 flex justify-center items-center gap-2">
                            <template x-if="isLoading"><i class='bx bx-loader-alt bx-spin text-xl'></i></template>
                            <template x-if="!isLoading"><i class='bx bx-credit-card-front text-xl'></i></template>
                            <span x-text="isLoading ? 'Memproses...' : 'Lanjutkan Pembayaran'"></span>
                        </button>
                    </div>
                    @endif
                </div>
                {{-- END RIGHT --}}

            </div>
            
            {{-- Rekomendasi Produk Terlaris (Desktop Full Width) --}}
            <div class="px-8 xl:px-14 pb-10 bg-gray-50 border-t border-gray-200">
                <x-payment-recommendations :products="$recommendedProducts" />
            </div>
        </div>
        {{-- END DESKTOP LAYOUT --}}

        {{-- ══════════════════════════════════════════════
             MODALS (shared mobile + desktop)
             ══════════════════════════════════════════════ --}}

        {{-- Modal: QRIS Full Screen --}}
        <div x-show="showQrisModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click.self="showQrisModal = false"
             class="modal-backdrop"
             style="display:none">
            <div class="modal-sheet slide-up">
                <div class="modal-handle lg:hidden"></div>
                <div class="flex items-center justify-between mb-4">
                    <p class="font-black text-gray-900 text-base flex items-center gap-2">
                        <i class='bx bx-qr-scan text-brand-500 text-xl'></i> Scan QRIS
                    </p>
                    <button @click="showQrisModal = false" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
                        <i class='bx bx-x text-lg'></i>
                    </button>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 flex justify-center mb-4">
                    <img src="{{ asset('images/Qris.jpeg') }}" alt="QRIS LKTech" class="max-h-72 w-auto object-contain rounded-xl">
                </div>

                <div class="text-center mb-4">
                    <p class="text-xs text-gray-400 mb-0.5">Bayarkan tepat</p>
                    <p class="text-2xl font-black text-brand-600">{{ $totalFormatted }}</p>
                </div>

                <a href="https://wa.me/628567354046?text={{ $waConfirmMsg }}" target="_blank"
                   class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-bold py-3 px-4 rounded-2xl transition-all shadow-md shadow-green-200 flex justify-center items-center gap-2 text-sm">
                    <i class='bx bxl-whatsapp text-xl'></i> Konfirmasi via WhatsApp
                </a>

                <p class="text-[10px] text-center text-gray-400 mt-3">Kirim bukti pembayaran ke Admin untuk konfirmasi manual</p>
            </div>
        </div>

        {{-- Modal: Cara Bayar --}}
        <div x-show="showCaraBayarModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click.self="showCaraBayarModal = false"
             class="modal-backdrop"
             style="display:none">
            <div class="modal-sheet slide-up">
                <div class="modal-handle lg:hidden"></div>
                <div class="flex items-center justify-between mb-5">
                    <p class="font-black text-gray-900 text-base flex items-center gap-2">
                        <i class='bx bx-help-circle text-brand-500 text-xl'></i> Cara Bayar QRIS
                    </p>
                    <button @click="showCaraBayarModal = false" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors">
                        <i class='bx bx-x text-lg'></i>
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach([
                        ['icon'=>'bx-mobile-alt','step'=>'Buka Aplikasi','desc'=>'Buka aplikasi e-Wallet (GoPay, OVO, Dana, ShopeePay) atau m-Banking pilihan Anda'],
                        ['icon'=>'bx-qr-scan','step'=>'Scan QR Code','desc'=>'Pilih menu Scan / QRIS, lalu arahkan kamera ke kode QR di halaman ini'],
                        ['icon'=>'bx-edit','step'=>'Masukkan Nominal','desc'=>'Pastikan nominal yang dimasukkan tepat: '.$totalFormatted],
                        ['icon'=>'bx-check-shield','step'=>'Konfirmasi Pembayaran','desc'=>'Setelah berhasil, screenshot bukti bayar dan kirim ke Admin LKTech via WhatsApp'],
                    ] as $idx => $step)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center shrink-0 font-black text-sm">
                            {{ $idx + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $step['step'] }}</p>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-700 flex items-start gap-2">
                    <i class='bx bx-time-five text-sm shrink-0 mt-0.5'></i>
                    <p>Selesaikan pembayaran sebelum <strong>{{ $deadlineLabel }}</strong> agar pesanan tidak dibatalkan.</p>
                </div>

                <button @click="showCaraBayarModal = false"
                        class="w-full mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-2xl transition-colors text-sm">
                    Mengerti
                </button>
            </div>
        </div>

    </div>
    {{-- END PENDING STATE --}}
    @endif

    {{-- Footer intentionally hidden on payment page --}}

    <script>
        function paymentPage(deadlineTimestamp, saleId) {
            return {
                isLoading:          false,
                isCheckingStatus:   false,
                displayTime:        '--:--:--',
                urgent:             false,
                showQrisModal:      false,
                showCaraBayarModal: false,
                _timer:             null,

                startCountdown() {
                    this._tick();
                    this._timer = setInterval(() => this._tick(), 1000);
                },

                _tick() {
                    const now  = Math.floor(Date.now() / 1000);
                    const diff = deadlineTimestamp - now;

                    if (diff <= 0) {
                        this.displayTime = '00:00:00';
                        this.urgent      = true;
                        clearInterval(this._timer);
                        return;
                    }

                    const h = Math.floor(diff / 3600);
                    const m = Math.floor((diff % 3600) / 60);
                    const s = diff % 60;

                    this.displayTime =
                        String(h).padStart(2, '0') + ':' +
                        String(m).padStart(2, '0') + ':' +
                        String(s).padStart(2, '0');

                    this.urgent = diff < 300; // red when < 5 min
                },

                checkStatus() {
                    this.isCheckingStatus = true;
                    // Reload triggers server-side Midtrans sync
                    setTimeout(() => window.location.reload(), 600);
                },

                async payNow() {
                    this.isLoading = true;
                    try {
                        const response = await fetch('{{ route("payment.snap_token") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept':       'application/json'
                            },
                            body: JSON.stringify({ transaction_id: {{ $sale->id }}, type: 'sale' })
                        });

                        if (!response.ok) {
                            alert('Gagal memproses pembayaran. Silakan coba lagi.');
                            this.isLoading = false;
                            return;
                        }

                        const data = await response.json();
                        this.isLoading = false;

                        if (data.snap_token) {
                            if (data.snap_token.startsWith('mock-')) {
                                window.location.reload();
                                return;
                            }
                            window.snap.pay(data.snap_token, {
                                onSuccess: () => window.location.reload(),
                                onPending: () => {},
                                onError:   () => alert('Pembayaran gagal atau dibatalkan.'),
                                onClose:   () => {}
                            });
                        } else {
                            alert('Gagal mendapatkan token: ' + (data.error || 'Unknown Error'));
                        }
                    } catch (err) {
                        this.isLoading = false;
                        console.error(err);
                        alert('Terjadi kesalahan koneksi sistem.');
                    }
                }
            }
        }
    </script>

    @if($sale->payment_status === 'success')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderInfo = {
                id: '{{ $sale->id }}',
                ref: '{{ $refId }}',
                status: 'Lunas',
                url: '{{ route('checkout.success', $sale->id) }}',
                pdf_url: '{{ route('checkout.invoice', $sale->id) }}'
            };
            
            let recentOrders = JSON.parse(sessionStorage.getItem('recent_orders') || '[]');
            
            if (!recentOrders.some(order => order.id === orderInfo.id)) {
                recentOrders.unshift(orderInfo);
                if (recentOrders.length > 10) recentOrders.pop();
                sessionStorage.setItem('recent_orders', JSON.stringify(recentOrders));
                window.dispatchEvent(new CustomEvent('recent-orders-updated'));
            }
        });
    </script>
    @endif
</body>
</html>
