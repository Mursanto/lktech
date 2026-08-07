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
            50%       { opacity: 0.55; }
        }
        .timer-urgent { animation: ticker-pulse 0.9s ease-in-out infinite; }

        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fade-in-up 0.4s ease-out both; }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        /* Desktop: fill the viewport below the navbar (64px navbar assumed) */
        @media (min-width: 1024px) {
            .payment-grid-wrapper {
                height: calc(100vh - 64px);
                overflow: hidden;
            }
        }
    </style>
</head>

@php
    /* Countdown deadline: 1 hour from order creation */
    $deadlineTs     = $sale->created_at->addHours(1)->timestamp;
    $customerName   = $sale->customer->name ?? 'Pelanggan';
    $refId          = $sale->payment_reference_id ?? ('SALE-' . $sale->id);
    $totalFormatted = 'Rp ' . number_format($sale->total_amount, 0, ',', '.');

    $waConfirmMsg = urlencode(
        "Halo Admin LKTech. Saya ingin konfirmasi pembayaran untuk pesanan {$refId} " .
        "atas nama {$customerName} sejumlah {$totalFormatted}. Berikut bukti transfernya:"
    );
    $waSuccessMsg = urlencode(
        "Halo Admin LKTech. Saya baru saja menyelesaikan pembayaran untuk pesanan {$refId} " .
        "atas nama {$customerName}. Mohon info untuk biaya ongkos kirimnya."
    );
@endphp

<body class="bg-gray-50 text-gray-800 antialiased font-sans flex flex-col" style="min-height:100vh">

    {{-- NAVBAR --}}
    <x-navbar />

    {{-- ════════════════════════════════════════════════════════
         SUCCESS STATE — paid, compact 1-column centred layout
         ════════════════════════════════════════════════════════ --}}
    @if($sale->payment_status === 'success')
    <main class="flex-grow flex items-center justify-center px-4 py-8 pt-24">
        <div class="fade-in-up w-full max-w-md text-center">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm">
                <i class='bx bx-check text-5xl'></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900 mb-2 tracking-tight">Pembayaran Berhasil Lunas!</h1>
            <p class="text-gray-500 text-sm mb-1">Pesanan atas nama <strong class="text-gray-700">{{ $customerName }}</strong></p>
            <p class="text-xs text-gray-400 font-mono mb-6">Ref: {{ $refId }}</p>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5 mb-5 text-left">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Langkah Selanjutnya</h2>
                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                    Harga yang Anda bayarkan <strong class="text-orange-600">belum termasuk ongkos kirim</strong>.
                    Silakan hubungi Admin kami via WhatsApp untuk menentukan kurir dan biaya pengiriman.
                </p>
                <a href="https://wa.me/628567354046?text={{ $waSuccessMsg }}" target="_blank"
                   class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-bold py-3 px-4 rounded-xl transition-all shadow-sm flex justify-center items-center gap-2 text-sm">
                    <i class='bx bxl-whatsapp text-xl'></i> Hubungi Admin via WhatsApp
                </a>
            </div>

            <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-brand-600 font-medium transition-colors">
                ← Kembali ke Beranda
            </a>
        </div>
    </main>

    {{-- ════════════════════════════════════════════════════════
         PENDING STATE — 2-column desktop, stacked+accordion mobile
         ════════════════════════════════════════════════════════ --}}
    @else
    <main class="payment-grid-wrapper flex-grow flex flex-col pt-16 lg:pt-0"
          x-data="paymentPage({{ $deadlineTs }}, {{ $sale->id }})"
          x-init="startCountdown()">

        {{-- Mobile countdown banner --}}
        <div class="lg:hidden bg-orange-50 border-b border-orange-200 px-4 py-2.5 flex items-center justify-center gap-2 text-orange-700 text-xs font-semibold shrink-0"
             :class="urgent ? 'bg-red-50 border-red-200 text-red-700 timer-urgent' : ''">
            <i class='bx bx-time-five text-sm'></i>
            <span>Selesaikan Pembayaran Dalam:</span>
            <span class="font-mono font-black text-sm" x-text="displayTime">--:--:--</span>
        </div>

        {{-- 2-column grid --}}
        <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 lg:overflow-hidden">

            {{-- ─────────────────────────────────────
                 LEFT COLUMN  —  Bill info
                 ───────────────────────────────────── --}}
            <div class="flex flex-col justify-center px-5 lg:px-10 xl:px-14 py-5 lg:py-6 lg:border-r border-gray-100 overflow-y-auto custom-scrollbar">

                {{-- Status badge --}}
                <div class="fade-in-up mb-3">
                    <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                        Menunggu Pembayaran
                    </span>
                </div>

                <h1 class="fade-in-up text-2xl lg:text-3xl font-black text-gray-900 leading-tight mb-1">
                    Selesaikan Pembayaran Anda
                </h1>
                <p class="text-gray-400 text-sm mb-4 fade-in-up">
                    Pesanan untuk <span class="font-semibold text-gray-700">{{ $customerName }}</span>
                </p>

                {{-- Desktop countdown timer --}}
                <div class="hidden lg:flex fade-in-up items-center gap-3 rounded-xl px-4 py-3 mb-5 border"
                     :class="urgent
                         ? 'bg-red-50 border-red-200 text-red-700 timer-urgent'
                         : 'bg-orange-50 border-orange-200 text-orange-700'">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                         :class="urgent ? 'bg-red-100' : 'bg-orange-100'">
                        <i class='bx bx-time-five text-lg'></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold opacity-70 uppercase tracking-wider leading-none mb-0.5">Selesaikan Pembayaran Dalam</p>
                        <p class="font-mono font-black text-2xl leading-tight" x-text="displayTime">--:--:--</p>
                    </div>
                </div>

                {{-- Order detail card --}}
                <div class="fade-in-up bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden mb-4">
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
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                        <p class="text-3xl lg:text-4xl font-black text-brand-600 leading-none">{{ $totalFormatted }}</p>
                        <p class="text-xs text-gray-400 mt-1">Bayarkan tepat sesuai nominal di atas</p>
                    </div>
                </div>

                {{-- Transfer / QRIS instructions --}}
                @if($sale->payment_method === 'Transfer Manual' || $sale->payment_method === 'QRIS')
                <div class="fade-in-up bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 mb-4">
                    <p class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class='bx bx-info-circle'></i> Cara Bayar QRIS
                    </p>
                    <ol class="text-xs text-blue-700 space-y-1 leading-relaxed list-decimal pl-4">
                        <li>Buka aplikasi e-Wallet / m-Banking Anda</li>
                        <li>Pilih menu <strong>Scan / QRIS</strong></li>
                        <li>Scan kode QR, masukkan nominal <strong>{{ $totalFormatted }}</strong></li>
                        <li>Kirim bukti bayar ke Admin via WhatsApp di bawah ini</li>
                    </ol>
                </div>
                @elseif(isset($paymentInfo) && $paymentInfo['va_number'])
                <div class="fade-in-up bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 mb-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Virtual Account — {{ $paymentInfo['bank'] }}</p>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-black text-gray-900 tracking-wider font-mono">{{ $paymentInfo['va_number'] }}</span>
                        <button onclick="navigator.clipboard.writeText('{{ $paymentInfo['va_number'] }}').then(()=>{ alert('Nomor VA disalin!') })"
                                class="text-brand-500 hover:text-brand-700 transition-colors" title="Salin VA">
                            <i class='bx bx-copy text-lg'></i>
                        </button>
                    </div>
                    @if($paymentInfo['biller_code'])
                    <p class="text-xs mt-1 text-gray-500">Kode Perusahaan: <strong class="text-gray-800">{{ $paymentInfo['biller_code'] }}</strong></p>
                    @endif
                </div>
                @endif

                {{-- Mobile: QRIS image + WA button (inline, above accordion) --}}
                @if($sale->payment_method === 'Transfer Manual' || $sale->payment_method === 'QRIS')
                <div class="lg:hidden fade-in-up flex flex-col items-center gap-3 mb-4">
                    <div class="bg-white border border-gray-200 rounded-xl p-3 shadow-sm inline-block">
                        <img src="{{ asset('images/Qris.jpeg') }}" alt="QRIS LKTech"
                             class="w-52 h-52 object-contain rounded-lg">
                    </div>
                    <a href="https://wa.me/628567354046?text={{ $waConfirmMsg }}" target="_blank"
                       class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-bold py-3.5 px-4 rounded-2xl transition-all shadow-lg shadow-green-200 flex justify-center items-center gap-2 text-sm">
                        <i class='bx bxl-whatsapp text-xl'></i> Konfirmasi Pembayaran via WA
                    </a>
                </div>
                @else
                <div class="lg:hidden fade-in-up mb-4">
                    <button type="button" @click.prevent="payNow()" :disabled="isLoading"
                            class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-2xl transition-all shadow-md flex justify-center items-center gap-2 text-sm">
                        <template x-if="isLoading"><i class='bx bx-loader-alt bx-spin text-xl'></i></template>
                        <template x-if="!isLoading"><i class='bx bx-credit-card-front text-xl'></i></template>
                        <span x-text="isLoading ? 'Memproses...' : 'Lanjutkan Pembayaran'"></span>
                    </button>
                </div>
                @endif

                {{-- Mobile: Accordion for order items --}}
                <div class="lg:hidden fade-in-up" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between text-xs font-semibold text-gray-500 border border-gray-200 bg-white rounded-xl px-4 py-2.5 hover:bg-gray-50 transition-colors mb-2">
                        <span class="flex items-center gap-1.5">
                            <i class='bx bx-list-ul'></i>
                            Detail Pesanan ({{ $sale->saleDetails->count() }} item)
                        </span>
                        <i class='bx text-base transition-transform duration-200'
                           :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
                        @foreach($sale->saleDetails as $detail)
                        <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-50 last:border-b-0">
                            <div class="min-w-0 flex-1 pr-2">
                                <p class="text-xs font-semibold text-gray-800 truncate">
                                    {{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}
                                </p>
                                <p class="text-[10px] text-gray-400">{{ $detail->quantity }} × Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-xs font-bold text-gray-900 shrink-0">
                                Rp {{ number_format($detail->price_at_transaction * $detail->quantity, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-brand-600 font-medium transition-colors">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
            {{-- END LEFT COLUMN --}}

            {{-- ─────────────────────────────────────
                 RIGHT COLUMN  —  Payment action (desktop only)
                 ───────────────────────────────────── --}}
            <div class="hidden lg:flex flex-col items-center justify-center px-8 xl:px-14 py-8 bg-gradient-to-b from-gray-50 to-white">

                @if($sale->payment_method === 'Transfer Manual' || $sale->payment_method === 'QRIS')

                {{-- QRIS header --}}
                <div class="fade-in-up text-center mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-0.5">Bayar Via</p>
                    <p class="text-lg font-black text-gray-800 flex items-center justify-center gap-2">
                        <i class='bx bx-qr-scan text-brand-500 text-xl'></i> QRIS
                    </p>
                </div>

                {{-- QRIS image — compact --}}
                <div class="fade-in-up bg-white border border-gray-200 rounded-2xl p-4 shadow-md mb-4 inline-block">
                    <img src="{{ asset('images/Qris.jpeg') }}" alt="QRIS LKTech TN Sereal"
                         class="max-h-64 w-auto object-contain rounded-xl">
                </div>

                {{-- Amount reminder --}}
                <div class="fade-in-up text-center mb-5">
                    <p class="text-xs text-gray-400 mb-0.5">Nominal yang harus dibayar</p>
                    <p class="text-2xl font-black text-brand-600">{{ $totalFormatted }}</p>
                </div>

                {{-- WA confirm button + items list --}}
                <div class="fade-in-up w-full max-w-xs">
                    <a href="https://wa.me/628567354046?text={{ $waConfirmMsg }}" target="_blank"
                       class="w-full bg-[#25D366] hover:bg-[#1ebe5d] text-white font-bold py-3 px-4 rounded-2xl transition-all shadow-lg shadow-green-200 flex justify-center items-center gap-2 text-sm mb-4">
                        <i class='bx bxl-whatsapp text-xl'></i> Konfirmasi Pembayaran via WA
                    </a>

                    {{-- Compact order items --}}
                    <div class="bg-white border border-gray-100 rounded-xl shadow-sm overflow-hidden">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-3 py-2 border-b border-gray-50 bg-gray-50/60">
                            Detail Pesanan
                        </p>
                        <div class="max-h-32 overflow-y-auto custom-scrollbar">
                            @foreach($sale->saleDetails as $detail)
                            <div class="flex items-center justify-between px-3 py-2 border-b border-gray-50 last:border-b-0">
                                <div class="min-w-0 flex-1 pr-2">
                                    <p class="text-[10px] font-semibold text-gray-700 truncate">
                                        {{ $detail->product->brand ?? '' }} {{ $detail->product->model_series ?? 'Produk' }}
                                    </p>
                                    <p class="text-[9px] text-gray-400">× {{ $detail->quantity }}</p>
                                </div>
                                <p class="text-[10px] font-bold text-gray-800 shrink-0">
                                    Rp {{ number_format($detail->price_at_transaction * $detail->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @elseif(isset($paymentInfo) && $paymentInfo['va_number'])

                {{-- VA Payment right panel --}}
                <div class="fade-in-up text-center mb-6">
                    <div class="w-20 h-20 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i class='bx bx-bank text-4xl'></i>
                    </div>
                    <p class="text-sm font-bold text-gray-700 mb-1">Transfer ke Virtual Account</p>
                    <p class="text-3xl font-black text-brand-600">{{ $totalFormatted }}</p>
                </div>
                <div class="fade-in-up w-full max-w-sm bg-white border border-gray-100 rounded-2xl shadow-sm p-5 text-center">
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-3">
                        Nomor VA — {{ $paymentInfo['bank'] }}
                    </p>
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <span class="text-2xl font-black text-gray-900 tracking-widest font-mono">{{ $paymentInfo['va_number'] }}</span>
                        <button onclick="navigator.clipboard.writeText('{{ $paymentInfo['va_number'] }}').then(()=>{ alert('Nomor VA disalin!') })"
                                class="text-brand-500 hover:text-brand-700 transition-colors" title="Salin VA">
                            <i class='bx bx-copy text-xl'></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-400">Bayar sebelum waktu habis</p>
                </div>

                @else

                {{-- Generic / Midtrans popup --}}
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
            {{-- END RIGHT COLUMN --}}

        </div>
        {{-- END GRID --}}

    </main>
    @endif

    {{-- Footer intentionally hidden on the payment page --}}

    <script>
        function paymentPage(deadlineTimestamp, saleId) {
            return {
                isLoading:   false,
                displayTime: '--:--:--',
                urgent:      false,
                _timer:      null,

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

                    // Turn red/urgent when < 5 minutes remain
                    this.urgent = diff < 300;
                },

                async payNow() {
                    this.isLoading = true;
                    try {
                        const response = await fetch('{{ route("payment.snap_token") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type':  'application/json',
                                'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept':        'application/json'
                            },
                            body: JSON.stringify({ transaction_id: {{ $sale->id }}, type: 'sale' })
                        });

                        if (!response.ok) {
                            alert('Gagal memproses pembayaran. Silakan coba lagi.');
                            this.isLoading = false;
                            return;
                        }

                        const data     = await response.json();
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
</body>
</html>
