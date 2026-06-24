<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pesanan - LKTech</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

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
</head>
<body class="text-gray-800 antialiased flex flex-col min-h-screen">
    <x-navbar />

    <main class="flex-grow max-w-3xl mx-auto px-4 w-full py-12 pt-32 flex flex-col items-center text-center" x-data="orderStatus()">
        
        @if($sale->payment_status === 'success')
            <div class="w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mb-6 shadow-sm">
                <i class='bx bx-check text-6xl'></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">Pembayaran Berhasil Lunas!</h1>
            <p class="text-gray-600 mb-8 max-w-lg">
                Terima kasih, <strong>{{ $sale->customer->name ?? 'Pelanggan' }}</strong>. Pembayaran Anda telah kami catat dengan Nomor Referensi: <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm">{{ $sale->payment_reference_id ?? 'SALE-'.$sale->id }}</span>
            </p>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 w-full max-w-md mb-8">
                <h2 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Langkah Selanjutnya</h2>
                <p class="text-sm text-gray-700 leading-relaxed mb-6 font-medium">
                    Sesuai dengan kebijakan kami, harga yang Anda bayarkan <strong class="text-orange-600">belum termasuk ongkos kirim</strong>. 
                    <br><br>
                    Silakan hubungi Admin kami sekarang via WhatsApp untuk menentukan kurir dan biaya pengiriman unit fisik Anda.
                </p>
                
                @php
                    $customerName = $sale->customer->name ?? 'Pelanggan';
                    $waMessage = urlencode("Halo Admin LKTech. Saya baru saja menyelesaikan pembayaran untuk pesanan {$sale->payment_reference_id} atas nama {$customerName}. Mohon info untuk biaya ongkos kirimnya.");
                @endphp
                <a href="https://wa.me/628567354046?text={{ $waMessage }}" target="_blank" 
                   class="w-full bg-[#25D366] hover:bg-[#128C7E] text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-emerald-200 flex justify-center items-center gap-2">
                    <i class='bx bxl-whatsapp text-2xl'></i> Hubungi Admin di WhatsApp
                </a>
            </div>
        @else
            <div class="w-24 h-24 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mb-6 shadow-sm">
                <i class='bx bx-time text-6xl'></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">Menunggu Pembayaran</h1>
            <p class="text-gray-600 mb-8 max-w-lg">
                Hai <strong>{{ $sale->customer->name ?? 'Pelanggan' }}</strong>, pesanan Anda dengan Nomor Referensi <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm">{{ $sale->payment_reference_id ?? 'SALE-'.$sale->id }}</span> sedang menunggu pembayaran.
            </p>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 w-full max-w-md mb-8">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-100">
                    <span class="text-gray-500 font-medium text-sm">Total Tagihan</span>
                    <span class="text-xl font-black text-brand-600">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                </div>
                
                @if(isset($paymentInfo) && $paymentInfo['va_number'])
                    <!-- Tampilan VA Proposional -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Nomor Virtual Account ({{ $paymentInfo['bank'] }})</p>
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-2xl font-black text-gray-900 tracking-wider font-mono">{{ $paymentInfo['va_number'] }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $paymentInfo['va_number'] }}'); alert('Nomor VA disalin!')" class="text-brand-500 hover:text-brand-700 transition-colors" title="Salin VA">
                                <i class='bx bx-copy text-xl'></i>
                            </button>
                        </div>
                        @if($paymentInfo['biller_code'])
                            <p class="text-xs mt-2 text-gray-500">Kode Perusahaan (Biller Code): <strong class="text-gray-900">{{ $paymentInfo['biller_code'] }}</strong></p>
                        @endif
                    </div>
                @elseif(isset($paymentInfo) && str_contains($paymentInfo['payment_type'], 'qris'))
                    <!-- Tampilan QRIS Instructions -->
                    <div class="mb-6 p-4 bg-brand-50 text-brand-800 rounded-xl border border-brand-100 text-sm font-medium flex items-start gap-3">
                        <i class='bx bx-qr-scan text-xl mt-0.5 text-brand-600'></i> 
                        <p>Pembayaran via QRIS. Silakan klik tombol di bawah untuk memunculkan ulang kode QR dan memindainya dengan aplikasi e-Wallet atau m-Banking Anda.</p>
                    </div>
                @endif

                @if($sale->payment_method === 'Transfer Manual' || $sale->payment_method === 'QRIS')
                    <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-1">Pembayaran via QRIS</p>
                        <p class="text-sm text-gray-700 mb-4">Silakan scan kode QRIS di bawah ini dengan aplikasi e-Wallet atau m-Banking Anda sesuai <strong>Total Tagihan</strong>:</p>
                        <div class="flex justify-center mb-4">
                            <img src="{{ asset('images/Qris.jpeg') }}" alt="QRIS LKTech" class="w-48 h-auto rounded-xl shadow-sm border border-gray-200">
                        </div>
                    </div>
                    
                    @php
                        $customerName = $sale->customer->name ?? 'Pelanggan';
                        $waMessage = urlencode("Halo Admin LKTech. Saya ingin konfirmasi pembayaran untuk pesanan {$sale->payment_reference_id} atas nama {$customerName} sejumlah Rp " . number_format($sale->total_amount, 0, ',', '.') . ". Berikut bukti transfernya:");
                    @endphp
                    <a href="https://wa.me/628567354046?text={{ $waMessage }}" target="_blank" 
                       class="w-full bg-[#25D366] hover:bg-[#128C7E] text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-emerald-200 flex justify-center items-center gap-2">
                        <i class='bx bxl-whatsapp text-2xl'></i> Konfirmasi Pembayaran via WA
                    </a>
                @else
                    <p class="text-sm text-gray-500 leading-relaxed mb-6 font-medium">
                        Jika Anda belum menyelesaikan pembayaran atau halaman tertutup, silakan klik tombol di bawah ini.
                    </p>

                    <button type="button" @click.prevent="payNow()" :disabled="isLoading"
                            class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md flex justify-center items-center gap-2">
                        <template x-if="isLoading">
                            <i class='bx bx-loader-alt bx-spin text-xl'></i>
                        </template>
                        <template x-if="!isLoading">
                            <i class='bx bx-credit-card-front text-xl'></i>
                        </template>
                        <span x-text="isLoading ? 'Memproses...' : 'Lanjutkan Pembayaran'"></span>
                    </button>
                @endif
            </div>
        @endif

        <a href="{{ route('home') }}" class="text-gray-500 hover:text-brand-600 font-medium transition-colors">
            &larr; Kembali ke Beranda
        </a>

    </main>

    <x-footer />

    <script>
        function orderStatus() {
            return {
                isLoading: false,
                async payNow() {
                    this.isLoading = true;
                    try {
                        const response = await fetch('{{ route("payment.snap_token") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                transaction_id: {{ $sale->id }},
                                type: 'sale'
                            })
                        });

                        if (!response.ok) {
                            alert("Gagal memproses pembayaran. Silakan coba lagi.");
                            this.isLoading = false;
                            return;
                        }

                        const responseData = await response.json();
                        this.isLoading = false;

                        if (responseData.snap_token) {
                            if (responseData.snap_token.startsWith('mock-')) {
                                window.location.reload();
                                return;
                            }

                            window.snap.pay(responseData.snap_token, {
                                onSuccess: function(result) {
                                    window.location.reload();
                                },
                                onPending: function(result) {
                                    // Let it stay on this page
                                },
                                onError: function(result) {
                                    alert('Pembayaran gagal atau dibatalkan.');
                                },
                                onClose: function() {
                                    // User closed the popup
                                }
                            });
                        } else {
                            alert('Gagal mendapatkan token: ' + (responseData.error || 'Unknown Error'));
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
