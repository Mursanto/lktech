<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang & Checkout - LKTech</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' }
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-800 antialiased flex flex-col min-h-screen">
    <div class="hidden sm:block"><x-navbar /></div>

    {{-- Mobile Floating Header (Anti-Gravity) --}}
    <div class="sm:hidden sticky top-0 bg-white/80 backdrop-blur-md h-[56px] flex items-center justify-between px-4 z-50 border-b border-gray-100 shadow-sm box-border">
        <a href="/katalog" class="w-11 h-11 flex items-center justify-start text-gray-700 hover:text-brand-600 transition-colors -ml-2">
            <i class='bx bx-left-arrow-alt text-3xl'></i>
        </a>
        <div class="flex-1 text-center flex flex-col items-center justify-center">
            <span class="text-[16px] font-bold text-gray-900 leading-none">Checkout</span>
        </div>
        <div class="w-11 h-11 flex items-center justify-end -mr-2">
            <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-[30px] object-contain">
        </div>
    </div>

    {{-- Kirimkan data keranjang sebagai variabel PHP ke dalam JS, sertakan URL gambar yang sudah lengkap dari sisi server --}}
    @php
        $cartForJs = array_values(array_map(function($item) {
            $imageUrl = null;
            if (!empty($item['photo'])) {
                $imageUrl = \Illuminate\Support\Facades\Storage::url($item['photo']);
            } elseif (!empty($item['image'])) {
                $imageUrl = $item['image'];
            }
            return [
                'id'       => (string) $item['id'], // Paksa string untuk konsistensi x-model
                'name'     => $item['name'],
                'price'    => (int) $item['price'],
                'quantity' => (int) $item['quantity'],
                'imageUrl' => $imageUrl,
            ];
        }, $cart));
    @endphp

    <main class="w-full sm:max-w-7xl sm:mx-auto px-4 sm:px-6 lg:px-8 pt-3 sm:pt-5 pb-[90px] lg:pb-8 box-border" x-data="checkoutPage({{ Js::from($cartForJs) }})">

        {{-- Toast Notification --}}
        <div x-show="toast.show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[999] bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3"
             style="display:none">
            <i class='bx bx-check-circle text-green-400 text-xl'></i>
            <span class="text-sm font-semibold" x-text="toast.message"></span>
        </div>

        {{-- Dialog Konfirmasi Custom (menggantikan confirm() browser) --}}
        <div x-show="dialog.show"
             class="fixed inset-0 z-50 flex items-center justify-center"
             style="display:none">
            <div class="absolute inset-0 bg-black/40" @click="dialog.show = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 z-10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class='bx bx-trash text-red-500 text-xl'></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900" x-text="dialog.title"></h3>
                </div>
                <p class="text-sm text-gray-500 mb-5 ml-13" x-text="dialog.message"></p>
                <div class="flex gap-3">
                    <button @click="dialog.show = false" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">Batal</button>
                    <button @click="dialog.confirm(); dialog.show = false;" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-sm font-bold transition-colors">Hapus</button>
                </div>
            </div>
        </div>

        {{-- Breadcrumb: hidden on mobile, visible on sm+ --}}
        <nav aria-label="breadcrumb" class="hidden sm:block mb-2 sm:mb-3">
            <ol class="flex items-center text-[11px] sm:text-sm text-gray-500 font-medium overflow-x-auto whitespace-nowrap scrollbar-hide pb-1" style="scrollbar-width: none; -ms-overflow-style: none;">
                <li class="flex items-center shrink-0">
                    <a href="/" class="inline-flex items-center gap-1 hover:text-brand-600 hover:underline transition-colors">
                        <i class="bx bx-home-alt"></i> Home
                    </a>
                </li>
                <li class="flex items-center shrink-0">
                    <span class="mx-2 text-gray-400 text-lg leading-none">›</span>
                    <a href="/katalog" class="hover:text-brand-600 hover:underline transition-colors">Katalog</a>
                </li>
                <li class="flex items-center shrink-0">
                    <span class="mx-2 text-gray-400 text-lg leading-none">›</span>
                    <span class="text-gray-800 font-semibold" aria-current="page">Keranjang</span>
                </li>
            </ol>
        </nav>

        <div class="hidden sm:flex mb-4 flex-row items-center justify-between gap-2">
            <div class="flex items-baseline gap-2">
                <h1 class="text-lg sm:text-2xl font-black text-gray-900 tracking-tight">Keranjang</h1>
                <p class="text-xs sm:text-sm text-gray-500"><span class="font-bold text-brand-600" x-text="totalQty"></span> item</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="text-sm py-1.5 px-3 rounded-lg border border-brand-200 text-brand-600 hover:text-brand-700 hover:bg-brand-50 transition-colors flex items-center gap-1 font-semibold">
                <span class="sm:hidden text-[11px]">+ Tambah Barang</span>
                <span class="hidden sm:inline-flex items-center gap-1.5"><i class='bx bx-left-arrow-alt text-lg'></i> Tambah Belanjaan</span>
            </a>
        </div>

        <div class="flex flex-col lg:flex-row gap-4 sm:gap-8">
            {{-- LEFT: Daftar Produk --}}
            <div class="w-full lg:flex-1 space-y-3 sm:space-y-6">

                {{-- DAFTAR PRODUK (tampil jika keranjang tidak kosong) --}}
                <template x-if="cartItems.length > 0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        {{-- Header --}}
                        <div x-show="cartItems.length > 1" class="flex justify-between items-center px-4 sm:px-5 py-2.5 sm:py-3 border-b border-gray-100 bg-gray-50/50" style="display: none;">
                            <label class="flex items-center gap-2.5 sm:gap-3 cursor-pointer">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="w-4 h-4 sm:w-5 sm:h-5 rounded text-brand-600 border-gray-300 focus:ring-brand-500 cursor-pointer">
                                <span class="font-bold text-gray-800 text-sm sm:text-base">Pilih Semua</span>
                                <span class="text-[11px] sm:text-xs text-gray-400 font-normal hidden sm:inline">(<span x-text="selectedItems.length"></span> dipilih)</span>
                            </label>
                            <button type="button" @click="confirmEmpty()"
                                    class="flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2.5 sm:px-3 py-1.5 rounded-lg transition-colors">
                                <i class='bx bx-trash text-base'></i> Kosongkan
                            </button>
                        </div>

                        {{-- Item List --}}
                        <div class="divide-y divide-gray-100">
                            <template x-for="item in cartItems" :key="item.id">
                                <div class="flex items-center gap-2.5 sm:gap-3 px-4 sm:px-5 py-3 hover:bg-gray-50/50 transition-colors">
                                    {{-- Checkbox --}}
                                    <input x-show="cartItems.length > 1" type="checkbox" :value="item.id" x-model="selectedItems" @change="syncSelectAll()"
                                           class="w-4 h-4 sm:w-5 sm:h-5 rounded text-brand-600 border-gray-300 focus:ring-brand-500 cursor-pointer flex-shrink-0">

                                    {{-- Gambar Produk --}}
                                    <div class="w-[60px] h-[60px] sm:w-16 sm:h-16 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 bg-gray-100">
                                        <template x-if="item.imageUrl">
                                            <img :src="item.imageUrl" class="w-full h-full object-cover" loading="lazy"
                                                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        </template>
                                        <div class="w-full h-full flex items-center justify-center text-gray-300" :style="item.imageUrl ? 'display:none' : 'display:flex'">
                                            <i class='bx bx-laptop text-2xl'></i>
                                        </div>
                                    </div>

                                    {{-- Info Produk --}}
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 text-xs sm:text-sm line-clamp-2 leading-snug mb-1" x-text="item.name"></p>
                                        <div class="flex items-center justify-between mt-1">
                                            <div class="font-bold text-brand-600 text-[13px] sm:text-sm whitespace-nowrap" x-text="'Rp ' + formatRp(item.price * item.quantity)"></div>
                                            <div class="flex items-center gap-3">
                                                {{-- Tombol Hapus --}}
                                                <button type="button" @click="confirmRemove(item.id, item.name)"
                                                        class="hidden sm:flex flex-shrink-0 w-8 h-8 items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                    <i class='bx bx-trash text-lg'></i>
                                                </button>
                                                {{-- Kontrol Qty --}}
                                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                                    <button type="button" @click="changeQty(item, -1)"
                                                            class="w-7 h-6 sm:w-8 sm:h-7 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-sm">
                                                        <i class='bx bx-minus'></i>
                                                    </button>
                                                    <span class="w-7 sm:w-9 text-center text-[13px] sm:text-sm font-bold text-gray-800 border-x border-gray-200 h-6 sm:h-7 flex items-center justify-center" x-text="item.quantity"></span>
                                                    <button type="button" @click="changeQty(item, 1)"
                                                            class="w-7 h-6 sm:w-8 sm:h-7 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition-colors text-sm">
                                                        <i class='bx bx-plus'></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Formulir Informasi Pembeli (tampil jika ada produk) --}}
                <template x-if="cartItems.length > 0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-5">
                        <h2 class="text-[13px] sm:text-base font-bold text-gray-900 mb-3 pb-2.5 sm:pb-3 border-b border-gray-100">Informasi Pembeli & Pengiriman</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Baris 1: Nama Lengkap & Email -->
                            <div>
                                <label class="block text-[13px] sm:text-sm font-semibold text-gray-700 mb-[3px]">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" x-model="formData.customer_name" @blur="validateField('customer_name')"
                                       :class="errors.customer_name ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'"
                                       class="w-full px-[12px] py-[10px] min-h-[44px] border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-[13px] sm:text-sm transition-all shadow-sm placeholder-gray-500 text-gray-900"
                                       placeholder="Nama Lengkap Anda">
                                <p x-show="errors.customer_name" x-text="errors.customer_name" class="text-red-500 text-[11px] mt-1"></p>
                            </div>
                            <div>
                                <label class="block text-[13px] sm:text-sm font-semibold text-gray-700 mb-[3px]">Alamat Email <span class="text-red-500">*</span></label>
                                <input type="email" x-model="formData.email" @blur="validateField('email')"
                                       :class="errors.email ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'"
                                       class="w-full px-[12px] py-[10px] min-h-[44px] border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-[13px] sm:text-sm transition-all shadow-sm placeholder-gray-500 text-gray-900"
                                       placeholder="budi@email.com">
                                <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-[11px] mt-1"></p>
                            </div>

                            <!-- Baris 2: WhatsApp -->
                            <div>
                                <label class="flex items-center text-[13px] sm:text-sm font-semibold text-gray-700 mb-[3px]">
                                    Nomor WhatsApp <span class="text-red-500 ml-1">*</span>
                                    <div class="relative ml-1.5 group cursor-pointer" @click.prevent="alert('Konfirmasi ongkir & resi akan dikirim via WhatsApp.')">
                                        <i class='bx bx-info-circle text-brand-500 text-sm'></i>
                                    </div>
                                </label>
                                <input type="text" x-model="formData.phone" @blur="validateField('phone')"
                                       :class="errors.phone ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'"
                                       class="w-full px-[12px] py-[10px] min-h-[44px] border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-[13px] sm:text-sm transition-all shadow-sm placeholder-gray-500 text-gray-900"
                                       placeholder="08123456789">
                                <p x-show="errors.phone" x-text="errors.phone" class="text-red-500 text-[11px] mt-1"></p>
                            </div>
                            <div class="hidden md:block"></div>

                            <!-- Alamat Pengiriman (Selalu Tampil - Required) -->
                            <div class="md:col-span-2">
                                <label class="block text-[13px] sm:text-sm font-semibold text-gray-700 mb-[3px]">Alamat Pengiriman <span class="text-red-500">*</span></label>
                                <textarea x-model="formData.address" rows="2" style="min-height: 60px;" @blur="validateField('address')"
                                          :class="errors.address ? 'border-red-400 ring-1 ring-red-400' : 'border-gray-300'"
                                          class="w-full px-[12px] py-[10px] border rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-[13px] sm:text-sm transition-all shadow-sm placeholder-gray-500 text-gray-900"
                                          placeholder="Alamat Lengkap (Jalan, No, Kota)"></textarea>
                                <p x-show="errors.address" x-text="errors.address" class="text-red-500 text-[11px] mt-1"></p>
                            </div>

                            <!-- Catatan Pesanan (Accordion Opsional) -->
                            <div class="md:col-span-2">
                                <button type="button" @click="showCatatan = !showCatatan" class="flex items-center gap-1.5 text-[13px] font-semibold text-gray-500 hover:text-brand-600 transition-colors min-h-[36px]">
                                    <i class='bx' :class="showCatatan ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                    <span x-text="showCatatan ? 'Sembunyikan Catatan' : '+ Tambah Catatan Pesanan (Opsional)'"></span>
                                </button>
                                <div x-show="showCatatan" x-transition.opacity.duration.300ms style="display: none;" class="mt-2">
                                    <input type="text" x-model="formData.notes"
                                           class="w-full px-[12px] py-[10px] min-h-[44px] border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-[13px] sm:text-sm transition-all shadow-sm placeholder-gray-500 text-gray-900"
                                           placeholder="Catatan pengiriman/produk">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                {{-- Keranjang Kosong --}}
                <template x-if="cartItems.length === 0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 sm:p-10 flex flex-col items-center justify-center text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class='bx bx-cart text-4xl text-gray-300'></i>
                        </div>
                        <h2 class="text-xl font-black text-gray-900 mb-2">Keranjang Kosong</h2>
                        <p class="text-gray-400 text-sm max-w-xs mb-6">Belum ada produk. Yuk pilih laptop atau aksesori favorit Anda!</p>
                        <a href="{{ route('katalog.index') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 px-6 rounded-xl transition-all shadow-sm text-sm">
                            Mulai Belanja
                        </a>
                    </div>
                </template>
            </div>

            {{-- RIGHT: Ringkasan Belanja --}}
            <div class="w-full lg:w-[380px] flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-5 sticky top-24">
                    <h2 class="text-[15px] sm:text-base font-bold text-gray-900 mb-3 sm:mb-4 pb-3 border-b border-gray-100">Ringkasan Belanja</h2>

                    {{-- Error Banner --}}
                    <div x-show="showErrorBanner"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex gap-3 items-start"
                         style="display:none">
                        <i class='bx bx-error-circle text-red-500 text-xl flex-shrink-0'></i>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-red-700">Inputan tidak sesuai</p>
                            <p class="text-xs text-red-600 mt-0.5" x-text="errorBannerDetail"></p>
                        </div>
                        <button @click="showErrorBanner = false" class="text-red-400 hover:text-red-600 flex-shrink-0">
                            <i class='bx bx-x text-lg'></i>
                        </button>
                    </div>

                    {{-- Info Dipilih --}}
                    <div class="bg-blue-50 rounded-xl p-2 sm:p-3 mb-3 sm:mb-4 flex items-center gap-2" x-show="cartItems.length > 1" style="display: none;">
                        <i class='bx bx-info-circle text-blue-500'></i>
                        <p class="text-[11px] sm:text-xs text-blue-700 font-medium">
                            <span x-text="selectedItems.length"></span> dari <span x-text="cartItems.length"></span> produk dipilih untuk dibayar
                        </p>
                    </div>

                    {{-- Ringkasan Harga --}}
                    <div class="space-y-2 sm:space-y-3 mb-4 sm:mb-5">
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Subtotal (<span x-text="selectedTotalQty"></span> produk)</span>
                            <span class="font-semibold text-gray-900" x-text="'Rp ' + formatRp(subtotal)"></span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex justify-between items-center text-sm text-gray-600">
                                <span>Biaya Pengiriman</span>
                                <span class="text-orange-500 font-semibold text-xs">Dihitung Terpisah</span>
                            </div>
                            <div class="mt-1 text-[10px] sm:text-xs text-orange-600 font-medium">
                                Ongkir & resi dikoordinasikan via WhatsApp.
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Bayar --}}
                    <button type="button" @click="processPayment($event)"
                            :disabled="isLoading || cartItems.length === 0 || selectedItems.length === 0"
                            class="hidden lg:flex w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none disabled:cursor-not-allowed text-white font-bold py-3.5 px-4 rounded-lg min-h-[44px] transition-all shadow-md justify-center items-center gap-2 text-sm">
                        <template x-if="isLoading">
                            <i class='bx bx-loader-alt bx-spin text-lg'></i>
                        </template>
                        <template x-if="!isLoading">
                            <i class='bx bx-credit-card-front text-lg'></i>
                        </template>
                        <span x-text="isLoading ? 'Memproses...' : (selectedItems.length === 0 ? 'Pilih produk dulu' : 'Bayar Sekarang')"></span>
                    </button>

                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-[11px] font-medium text-emerald-600">
                            <i class='bx bx-shield-alt-2 text-sm'></i>
                            Aman by Midtrans
                        </div>
                        <a href="https://wa.me/628567354046?text=Halo%20LKTech,%20saya%20butuh%20bantuan%20terkait%20transaksi/checkout%20pesanan%20saya." 
                           target="_blank"
                           class="flex items-center gap-1 text-[11px] font-bold text-gray-500 hover:text-emerald-600 transition-colors">
                            <i class='bx bxl-whatsapp text-sm'></i>
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sticky Bottom Action Bar (Mobile Only) --}}
        <div class="lg:hidden fixed bottom-0 left-0 w-full box-border bg-white border-t border-gray-100 py-2.5 px-4 flex flex-col z-50 shadow-[0_-4px_12px_rgba(0,0,0,0.05)]">
            <div class="flex justify-between items-center w-full mb-1.5">
                <div class="flex flex-col">
                    <span class="text-[11px] text-gray-500 font-semibold mb-0.5">Total Pembayaran</span>
                    <span class="text-base font-black text-brand-600" x-text="'Rp ' + formatRp(subtotal)"></span>
                </div>
                <button type="button" @click="processPayment($event)"
                        :disabled="isLoading || cartItems.length === 0 || selectedItems.length === 0"
                        class="bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none text-white font-bold py-2 px-6 rounded-lg min-h-[44px] transition-all shadow-[0_2px_8px_rgba(37,99,235,0.2)] flex items-center gap-1.5 text-[13px] min-w-[120px] justify-center">
                    <template x-if="isLoading">
                        <i class='bx bx-loader-alt bx-spin text-base'></i>
                    </template>
                    <span x-text="isLoading ? 'Proses...' : 'Bayar Sekarang'"></span>
                </button>
            </div>
            <div class="text-center">
                <span class="text-[9px] text-gray-400 font-medium">Dengan menekan tombol, Anda menyetujui S&K</span>
            </div>
        </div>
    </main>

    {{-- Minimalist Distraction-Free Footer --}}
    <footer class="hidden md:block bg-gray-50 border-t border-gray-200 mt-auto pb-24 lg:pb-5 pt-5">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col text-center md:text-left">
                <p class="text-[13px] font-medium text-gray-500">&copy; 2025 LKTech Solusi IT Integrated. All rights reserved.</p>
                <p class="text-[13px] text-gray-500">Hardware Andal. Software Profesional. Satu Integrasi.</p>
            </div>
            <div class="flex items-center gap-3 text-[13px] text-gray-500 font-medium">
                <a href="#" class="hover:text-brand-600 transition-colors">Kebijakan Privasi</a>
                <span class="text-gray-300">|</span>
                <a href="#" class="hover:text-brand-600 transition-colors">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </footer>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function checkoutPage(initialCart) {
            return {
                // ---- State ----
                cartItems: initialCart || [],
                selectedItems: (initialCart || []).map(i => i.id),
                selectAll: true,
                subtotal: 0,

                toast: { show: false, message: '' },
                dialog: { show: false, title: '', message: '', confirm: () => {} },

                formData: { customer_name: '', email: '', phone: '', address: '', notes: '' },
                errors: { customer_name: '', email: '', phone: '', address: '' },
                showCatatan: false,
                isLoading: false,
                showErrorBanner: false,
                errorBannerDetail: '',

                // ---- Init ----
                init() {
                    this.recalculate();
                },

                // ---- Computed ----
                get totalQty() {
                    return this.cartItems.reduce((s, i) => s + i.quantity, 0);
                },
                get selectedTotalQty() {
                    return this.cartItems.filter(i => this.selectedItems.includes(i.id)).reduce((s, i) => s + i.quantity, 0);
                },

                // ---- Helpers ----
                formatRp(val) {
                    return new Intl.NumberFormat('id-ID').format(val || 0);
                },

                recalculate() {
                    const sel = this.selectedItems;
                    this.subtotal = this.cartItems
                        .filter(i => sel.includes(i.id))
                        .reduce((s, i) => s + i.price * i.quantity, 0);
                    this.syncSelectAll();
                },

                syncSelectAll() {
                    this.selectAll = this.cartItems.length > 0
                        && this.selectedItems.length === this.cartItems.length;
                    this.recalcSubtotalOnly();
                },

                recalcSubtotalOnly() {
                    const sel = this.selectedItems;
                    this.subtotal = this.cartItems
                        .filter(i => sel.includes(i.id))
                        .reduce((s, i) => s + i.price * i.quantity, 0);
                },

                toggleAll() {
                    if (this.selectAll) {
                        this.selectedItems = this.cartItems.map(i => i.id);
                    } else {
                        this.selectedItems = [];
                    }
                    this.recalcSubtotalOnly();
                },

                showToast(msg) {
                    this.toast.message = msg;
                    this.toast.show = true;
                    setTimeout(() => { this.toast.show = false; }, 3000);
                },

                openDialog(title, message, onConfirm) {
                    this.dialog.title   = title;
                    this.dialog.message = message;
                    this.dialog.confirm = onConfirm;
                    this.dialog.show    = true;
                },

                // ---- Dialog Shortcuts (avoid nested quotes in HTML) ----
                confirmRemove(id, name) {
                    this.openDialog(
                        'Hapus Produk',
                        'Hapus produk ini dari keranjang?',
                        () => this.doRemoveItem(id)
                    );
                },

                confirmEmpty() {
                    this.openDialog(
                        'Kosongkan Keranjang',
                        'Semua produk akan dihapus dari keranjang. Lanjutkan?',
                        () => this.doEmptyCart()
                    );
                },

                // ---- Qty Change ----
                changeQty(item, delta) {
                    const newQty = item.quantity + delta;
                    if (newQty < 1) {
                        this.openDialog('Hapus Produk', 'Hapus "' + item.name + '" dari keranjang?', () => this.doRemoveItem(item.id));
                        return;
                    }
                    item.quantity = newQty;
                    this.recalculate();

                    fetch('/cart/update/' + item.id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ quantity: newQty })
                    }).then(r => r.json()).then(d => {
                        if (!d.success) alert(d.message || 'Gagal mengubah jumlah.');
                    }).catch(() => {});
                },

                // ---- Remove ----
                doRemoveItem(id) {
                    this.cartItems = this.cartItems.filter(i => i.id !== id);
                    this.selectedItems = this.selectedItems.filter(s => s !== id);
                    this.recalculate();
                    this.showToast('Produk berhasil dihapus');

                    fetch('/cart/remove/' + id, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
                    }).catch(() => {});
                },

                // ---- Empty ----
                doEmptyCart() {
                    this.cartItems = [];
                    this.selectedItems = [];
                    this.subtotal = 0;
                    this.selectAll = false;
                    this.showToast('Keranjang berhasil dikosongkan');

                    fetch('{{ route("cart.empty") }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
                    }).catch(() => {});
                },

                // ---- Validation ----
                validateField(field) {
                    this.errors[field] = '';
                    const v = this.formData[field]?.trim() || '';
                    if (field === 'customer_name') {
                        if (!v) this.errors[field] = 'Nama wajib diisi.';
                        else if (v.length < 3) this.errors[field] = 'Nama minimal 3 karakter.';
                    }
                    if (field === 'email') {
                        if (!v) this.errors[field] = 'Email wajib diisi.';
                        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) this.errors[field] = 'Format email tidak valid.';
                    }
                    if (field === 'phone') {
                        if (!v) this.errors[field] = 'Nomor WhatsApp wajib diisi.';
                        else if (!/^(\+62|62|0)[0-9]{8,13}$/.test(v)) this.errors[field] = 'Format nomor tidak valid (contoh: 08123456789).';
                    }
                    if (field === 'address') {
                        if (!v) this.errors[field] = 'Alamat pengiriman wajib diisi.';
                        else if (v.length < 10) this.errors[field] = 'Alamat terlalu singkat (min 10 karakter).';
                    }
                    return !this.errors[field];
                },

                validateAll() {
                    return ['customer_name', 'email', 'phone', 'address'].map(f => this.validateField(f)).every(Boolean);
                },

                // ---- Process Payment ----
                async processPayment(e) {
                    if (e && e.preventDefault) e.preventDefault();

                    if (!this.validateAll()) {
                        this.showErrorBanner = true;
                        const errFields = [];
                        if (this.errors.customer_name) errFields.push('Nama');
                        if (this.errors.email) errFields.push('Email');
                        if (this.errors.phone) errFields.push('WhatsApp');
                        if (this.errors.address) {
                            errFields.push('Alamat');
                            this.showAlamat = true;
                        }
                        this.errorBannerDetail = 'Mohon periksa kembali: ' + errFields.join(', ') + '.';
                        return;
                    }

                    this.showErrorBanner = false;
                    this.isLoading = true;

                    try {
                        const payload = { ...this.formData, selected_items: this.selectedItems };
                        const res = await fetch('{{ route("checkout.process") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        if (res.status === 422) {
                            const errData = await res.json();
                            this.isLoading = false;
                            if (errData.errors) {
                                if (errData.errors.customer_name) this.errors.customer_name = errData.errors.customer_name[0];
                                if (errData.errors.email) this.errors.email = errData.errors.email[0];
                                if (errData.errors.phone) this.errors.phone = errData.errors.phone[0];
                                if (errData.errors.address) {
                                    this.errors.address = errData.errors.address[0];
                                    this.showAlamat = true;
                                }
                            }
                            this.showErrorBanner = true;
                            this.errorBannerDetail = 'Mohon periksa kembali data yang dimasukkan.';
                            return;
                        }

                        if (!res.ok) {
                            this.isLoading = false;
                            this.showErrorBanner = true;
                            this.errorBannerDetail = 'Terjadi kesalahan pada server. Silakan coba beberapa saat lagi.';
                            return;
                        }

                        const data = await res.json();
                        this.isLoading = false;

                        if (data.snap_token) {
                            if (data.snap_token.startsWith('mock-')) {
                                window.location.href = '/checkout/success/' + data.order_id;
                                return;
                            }
                            window.snap.pay(data.snap_token, {
                                onSuccess: () => { window.location.href = '/checkout/success/' + data.order_id; },
                                onPending: () => { window.location.href = '/checkout/success/' + data.order_id; },
                                onError: () => { alert('Pembayaran gagal atau dibatalkan.'); },
                                onClose: () => { alert('Anda menutup pembayaran sebelum selesai.'); }
                            });
                        } else {
                            this.showErrorBanner = true;
                            this.errorBannerDetail = data.error || 'Gagal memproses pembayaran.';
                        }
                    } catch (err) {
                        this.isLoading = false;
                        console.error(err);
                        this.showErrorBanner = true;
                        this.errorBannerDetail = 'Terjadi kesalahan koneksi. Periksa internet Anda.';
                    }
                }
            };
        }
    </script>
</body>
</html>
