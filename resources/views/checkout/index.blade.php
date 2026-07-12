<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - LKTech</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
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
<body class="text-gray-800 antialiased">
    <x-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24" x-data="checkoutForm()">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Keranjang & Checkout</h1>
            <p class="text-gray-500">Terdapat {{ array_sum(array_column($cart, 'quantity')) }} item dalam keranjang belanja Anda.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left: Cart Items -->
            <div class="w-full lg:flex-1 space-y-4">
                @if(count($cart) > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Pesanan Anda</h2>
                    
                    <div class="space-y-6">
                        @foreach($cart as $id => $item)
                        <div class="flex items-start gap-4 pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                            <div class="w-20 h-20 bg-gray-50 rounded-xl flex-shrink-0 border border-gray-200 overflow-hidden p-2">
                                @if(!empty($item['photo']))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($item['photo']) }}" class="w-full h-full rounded object-cover" onerror="this.src='https://source.unsplash.com/400x400/?laptop';">
                                @elseif(!empty($item['image']))
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class='bx bx-laptop text-gray-400 text-2xl'></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 flex flex-col justify-between h-[80px]">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-bold text-gray-900 line-clamp-2 text-sm md:text-base pr-4">{{ $item['name'] }}</h3>
                                    <button type="button" @click.prevent="removeItem('{{ route('cart.remove', $id) }}')" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus Item">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between w-full mt-auto">
                                    <div class="flex items-center border border-gray-200 rounded text-sm bg-white">
                                        <button type="button" @click.prevent="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="w-8 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors disabled:opacity-50" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <i class='bx bx-minus'></i>
                                        </button>
                                        <div class="w-8 h-7 flex items-center justify-center font-bold text-gray-800 border-x border-gray-200 text-xs">
                                            {{ $item['quantity'] }}
                                        </div>
                                        <button type="button" @click.prevent="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="w-8 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors">
                                            <i class='bx bx-plus'></i>
                                        </button>
                                    </div>
                                    <p class="font-bold text-brand-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-10 flex flex-col items-center justify-center h-full min-h-[300px]">
                    <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-5 border border-gray-100">
                        <i class='bx bx-shopping-bag text-4xl text-gray-400'></i>
                    </div>
                    <h2 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Keranjang Kosong</h2>
                    <p class="text-gray-500 text-center max-w-sm mb-6 text-sm">Belum ada produk yang ditambahkan. Silakan temukan produk favorit Anda dan mulai belanja!</p>
                    <a href="{{ route('katalog.index') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all shadow-sm text-sm">
                        Mulai Belanja
                    </a>
                </div>
                @endif
            </div>

            <!-- Right: Checkout Details -->
            <div class="w-full lg:w-[400px] flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan & Kontak</h2>
                    
                    <!-- Contact Form -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-100">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.customer_name" @blur="validateField('customer_name')" :class="errors.customer_name ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-colors" placeholder="Contoh: Budi Santoso">
                            <p x-show="errors.customer_name" x-text="errors.customer_name" class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class='bx bx-error-circle'></i></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" x-model="formData.email" @blur="validateField('email')" :class="errors.email ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-colors" placeholder="budi@email.com">
                            <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1 flex items-center gap-1"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.phone" @blur="validateField('phone')" :class="errors.phone ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'" class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-colors" placeholder="0812xxxx">
                            <p x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-xs mt-1 flex items-center gap-1"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pengiriman <span class="text-gray-400 font-normal text-xs">(Opsional)</span></label>
                            <textarea x-model="formData.address" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm" rows="3" placeholder="Contoh: Jl. Sudirman No. 123, Jakarta..."></textarea>
                        </div>
                    </div>

                    <!-- Inline Error Banner -->
                    <div x-show="showErrorBanner" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex gap-3 items-start">
                        <i class='bx bx-error-circle text-red-500 text-xl flex-shrink-0 mt-0.5'></i>
                        <div>
                            <p class="text-sm font-bold text-red-700">Inputan tidak sesuai</p>
                            <p class="text-xs text-red-600 mt-0.5" x-text="errorBannerDetail"></p>
                        </div>
                        <button @click="showErrorBanner = false" class="ml-auto text-red-400 hover:text-red-600 flex-shrink-0">
                            <i class='bx bx-x text-lg'></i>
                        </button>
                    </div>

                    <!-- Summary -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center text-gray-600 text-sm">
                            <span>Subtotal Produk</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600 text-sm">
                            <span>Biaya Pengiriman</span>
                            <span class="text-orange-600 font-bold text-xs italic">Dihitung Terpisah</span>
                        </div>
                        <div class="pt-3 border-t border-gray-100 flex justify-between items-center">
                            <span class="font-bold text-gray-900">Total Pembayaran</span>
                            <span class="text-xl font-black text-brand-600 tracking-tight">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Disclaimer -->
                    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6 flex gap-3 items-start">
                        <i class='bx bx-info-circle text-orange-500 text-xl flex-shrink-0 mt-0.5'></i>
                        <p class="text-xs text-orange-800 leading-relaxed font-medium">
                            <strong class="block mb-1">Harga Belum Termasuk Ongkos Kirim!</strong>
                            Biaya pengiriman unit fisik akan dikoordinasikan terpisah melalui WhatsApp secara manual setelah pembayaran produk ini berhasil.
                        </p>
                    </div>

                    <button type="button" @click.prevent="processPayment($event)" :disabled="isLoading || {{ count($cart) == 0 ? 'true' : 'false' }}" 
                            class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md flex justify-center items-center gap-2">
                        <template x-if="isLoading">
                            <i class='bx bx-loader-alt bx-spin text-xl'></i>
                        </template>
                        <template x-if="!isLoading">
                            <i class='bx bx-credit-card-front text-xl'></i>
                        </template>
                        <span x-text="isLoading ? 'Memproses...' : 'Bayar Sekarang'"></span>
                    </button>
                    
                    <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400 font-medium">
                        <i class='bx bx-shield-alt-2 text-emerald-500 text-base'></i> Pembayaran Aman by Midtrans
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script>
        function checkoutForm() {
            return {
                formData: {
                    customer_name: '',
                    email: '',
                    phone: '',
                    address: ''
                },
                errors: {
                    customer_name: '',
                    email: '',
                    phone: ''
                },
                isLoading: false,
                showErrorBanner: false,
                errorBannerDetail: '',

                // Validate individual field
                validateField(field) {
                    this.errors[field] = '';
                    
                    if (field === 'customer_name') {
                        const name = this.formData.customer_name.trim();
                        if (!name) {
                            this.errors.customer_name = 'Nama lengkap wajib diisi.';
                        } else if (name.length < 3) {
                            this.errors.customer_name = 'Nama minimal 3 karakter.';
                        }
                    }

                    if (field === 'email') {
                        const email = this.formData.email.trim();
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!email) {
                            this.errors.email = 'Email wajib diisi.';
                        } else if (!emailRegex.test(email)) {
                            this.errors.email = 'Inputan tidak sesuai. Gunakan format email yang valid (contoh: nama@email.com).';
                        }
                    }

                    if (field === 'phone') {
                        const phone = this.formData.phone.trim();
                        const phoneRegex = /^(\+62|62|0)[0-9]{8,13}$/;
                        if (!phone) {
                            this.errors.phone = 'Nomor WhatsApp wajib diisi.';
                        } else if (!phoneRegex.test(phone)) {
                            this.errors.phone = 'Inputan tidak sesuai. Gunakan format nomor yang valid (contoh: 08123456789).';
                        }
                    }

                    return !this.errors[field];
                },

                // Validate all fields
                validateAll() {
                    let valid = true;
                    ['customer_name', 'email', 'phone'].forEach(field => {
                        if (!this.validateField(field)) {
                            valid = false;
                        }
                    });
                    return valid;
                },

                get isFormValid() {
                    const name = this.formData.customer_name.trim();
                    const email = this.formData.email.trim();
                    const phone = this.formData.phone.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    const phoneRegex = /^(\+62|62|0)[0-9]{8,13}$/;

                    return name.length >= 3 && 
                           emailRegex.test(email) &&
                           phoneRegex.test(phone);
                },

                updateQuantity(id, qty) {
                    if (qty < 1) return;
                    fetch('/cart/update/' + id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ quantity: qty })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Gagal mengubah jumlah.');
                        }
                    })
                    .catch(() => window.location.reload());
                },
                removeItem(url) {
                    if(!confirm('Hapus produk ini dari keranjang?')) return;
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(() => window.location.reload())
                    .catch(() => window.location.reload());
                },

                async processPayment(e) {
                    if (e && typeof e.preventDefault === 'function') {
                        e.preventDefault();
                    }

                    // Client-side validation
                    if (!this.validateAll()) {
                        this.showErrorBanner = true;
                        const errorFields = [];
                        if (this.errors.customer_name) errorFields.push('Nama');
                        if (this.errors.email) errorFields.push('Email');
                        if (this.errors.phone) errorFields.push('WhatsApp');
                        this.errorBannerDetail = 'Mohon periksa kembali: ' + errorFields.join(', ') + '.';
                        return;
                    }

                    this.showErrorBanner = false;
                    this.isLoading = true;

                    try {
                        const response = await fetch('{{ route("checkout.process") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.formData)
                        });

                        // Handle Laravel validation errors (422)
                        if (response.status === 422) {
                            const errorData = await response.json();
                            this.isLoading = false;
                            
                            // Map server validation errors to form fields
                            if (errorData.errors) {
                                if (errorData.errors.customer_name) {
                                    this.errors.customer_name = 'Inputan tidak sesuai. ' + errorData.errors.customer_name[0];
                                }
                                if (errorData.errors.email) {
                                    this.errors.email = 'Inputan tidak sesuai. ' + errorData.errors.email[0];
                                }
                                if (errorData.errors.phone) {
                                    this.errors.phone = 'Inputan tidak sesuai. ' + errorData.errors.phone[0];
                                }
                            }
                            
                            this.showErrorBanner = true;
                            this.errorBannerDetail = 'Mohon periksa kembali data yang dimasukkan.';
                            return;
                        }

                        if (!response.ok) {
                            this.isLoading = false;
                            this.showErrorBanner = true;
                            this.errorBannerDetail = 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.';
                            console.error("SERVER ERROR:", await response.text());
                            return;
                        }

                        const responseData = await response.json();
                        this.isLoading = false;

                        if (responseData.snap_token) {
                            if (responseData.snap_token.startsWith('mock-')) {
                                window.location.href = '/checkout/success/' + responseData.order_id;
                                return;
                            }

                            window.snap.pay(responseData.snap_token, {
                                onSuccess: function(result) {
                                    window.location.href = '/checkout/success/' + responseData.order_id;
                                },
                                onPending: function(result) {
                                    window.location.href = '/checkout/success/' + responseData.order_id;
                                },
                                onError: function(result) {
                                    alert('Pembayaran gagal atau dibatalkan.');
                                },
                                onClose: function() {
                                    alert('Anda menutup pop-up sebelum menyelesaikan pembayaran.');
                                }
                            });
                        } else {
                            this.showErrorBanner = true;
                            this.errorBannerDetail = responseData.error || 'Gagal memproses pembayaran. Silakan coba lagi.';
                        }
                    } catch (err) {
                        this.isLoading = false;
                        console.error(err);
                        this.showErrorBanner = true;
                        this.errorBannerDetail = 'Terjadi kesalahan koneksi. Periksa koneksi internet Anda dan coba lagi.';
                    }
                }
            }
        }
    </script>
</body>
</html>
