<style>
@keyframes pulseBadge {
  0% { transform: scale(1) translate(25%, -25%); }
  50% { transform: scale(1.15) translate(25%, -25%); }
  100% { transform: scale(1) translate(25%, -25%); }
}

@keyframes blueGoldRadiate {
  0% { color: #1e3a8a; text-shadow: 0 0 2px rgba(30,58,138,0.2); }
  50% { color: #fbbf24; text-shadow: 0 0 6px rgba(251,191,36,0.6); }
  100% { color: #1e3a8a; text-shadow: 0 0 2px rgba(30,58,138,0.2); }
}
.tagline-radiate-bluegold {
  animation: blueGoldRadiate 4s infinite ease-in-out;
}
</style>
<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false, mobileSearchOpen: false }">
    @php
        $pendingOrdersCount = 0;
        $userOrderIds = session()->get('user_orders', []);
        if (!empty($userOrderIds)) {
            $pendingOrdersCount = \App\Models\Sale::whereIn('id', $userOrderIds)
                ->where('payment_status', 'pending')
                ->count();
        }
    @endphp
    <div class="max-w-[1400px] mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14 gap-2 sm:gap-4">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 sm:h-8 w-auto">
                    <div class="hidden sm:flex flex-col">
                        <span class="font-montserrat font-black text-xl tracking-tight text-blue-900 leading-none">LKTech TN SEREAL</span>
                        <span class="text-[6.5px] font-bold uppercase tracking-widest mt-1 tagline-radiate-bluegold w-full text-center">
                            Hardware Andal. Software Profesional. Satu Integrasi.
                        </span>
                    </div>
                </a>
            </div>
            
            <!-- Mobile Search Bar (Always Visible) -->
            <div class="flex-1 md:hidden px-2">
                <form action="{{ route('katalog.index') }}" method="GET" class="relative w-full flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full pl-3 pr-8 py-1.5 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-[13px] shadow-inner transition-shadow">
                    <button type="submit" class="absolute right-0 top-0 h-full px-2.5 flex items-center justify-center text-gray-400 hover:text-brand-600">
                        <i class='bx bx-search text-base'></i>
                    </button>
                </form>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('home') ? 'text-brand-600' : '' }}">Beranda</a>
                <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('katalog.*') ? 'text-brand-600' : '' }}">Katalog</a>
                <div class="relative group flex items-center h-full" x-data="{ open: false, mitraOpen: false }" @mouseleave="open = false; mitraOpen = false">
                    <button @mouseover="open = true" class="hover:text-brand-600 transition-colors flex items-center gap-1 h-full py-4 -my-4 {{ request()->routeIs('rakit-pc') || request()->routeIs('jasa-website') || request()->routeIs('wifi-voucher') || request()->routeIs('jasa-furniture') || request()->routeIs('martabak-jawara') ? 'text-brand-600' : '' }}">
                        Layanan <i class='bx bx-chevron-down text-lg'></i>
                    </button>
                    <div x-show="open" x-transition.opacity class="absolute top-full left-0 pt-2 w-56 z-50" style="display: none;">
                        <div class="bg-white border border-gray-100 rounded-xl shadow-lg py-2 overflow-hidden">
                            <!-- Layanan Utama -->
                            <div class="px-4 py-1.5">
                                <span class="text-[10px] font-black text-brand-500 uppercase tracking-widest">Layanan Utama</span>
                            </div>
                            <a href="{{ route('rakit-pc') }}" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                Rakit PC Custom
                            </a>
                            <a href="https://wa.me/628567354046?text=Halo%20LKtech,%20saya%20ingin%20mendapatkan%20informasi%20Sewa%20Perangkat%20IT." target="_blank" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                Sewa Perangkat IT
                            </a>
                            <a href="{{ route('jasa-website') }}" class="block px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors border-b border-gray-100">
                                Jasa Pembuatan Website
                            </a>
                            <!-- Layanan Mitra — accordion toggle (klik untuk expand ke bawah) -->
                            <div>
                                <button @click="mitraOpen = !mitraOpen"
                                        class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors cursor-pointer">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Layanan Mitra</span>
                                    <i class='bx text-sm text-gray-400 transition-transform duration-200'
                                       :class="mitraOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                </button>
                                <!-- Sub-items expand ke bawah -->
                                <div x-show="mitraOpen"
                                     x-transition:enter="transition ease-out duration-150"
                                     x-transition:enter-start="opacity-0 -translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-100"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 -translate-y-1"
                                     class="bg-gray-50 border-t border-gray-100"
                                     style="display:none;">
                                    <a href="{{ route('wifi-voucher') }}" class="block px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                        WiFi Voucher Starlink
                                    </a>
                                    <a href="{{ route('jasa-furniture') }}" class="block px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                        Jasa Furniture
                                    </a>
                                    <a href="{{ route('martabak-jawara') }}" class="block px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                        Martabak Jawara
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('tentang-kami') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('tentang-kami') ? 'text-brand-600' : '' }}">Tentang Kami</a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="flex-1 max-w-3xl px-4 hidden lg:block">
                <form action="{{ route('home') }}" method="GET" class="relative flex items-center w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laptop, merk, atau prosesor..." 
                           class="w-full pl-4 pr-10 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all shadow-sm">
                    <button type="submit" class="absolute right-0 top-0 h-full px-3 flex items-center justify-center text-gray-400 hover:text-brand-600 bg-gray-50 rounded-r-lg border-l border-gray-300">
                        <i class='bx bx-search text-lg'></i>
                    </button>
                </form>
            </div>

            <!-- Auth Navigation (Desktop) -->
            <div class="hidden md:flex flex-shrink-0 items-center gap-3">
                <!-- Riwayat Pesanan Link -->
                <a href="{{ route('orders.index') }}" class="relative text-gray-600 hover:text-brand-600 p-2 transition-colors" title="Riwayat Pesanan">
                    <i class='bx bx-receipt text-2xl'></i>
                    @if($pendingOrdersCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center min-w-[18px] h-[18px] text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full shadow-sm border-2 border-white" style="animation: pulseBadge 2s infinite;">{{ $pendingOrdersCount }}</span>
                    @elseif($processingOrdersCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center min-w-[18px] h-[18px] text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-blue-500 rounded-full shadow-sm border-2 border-white">{{ $processingOrdersCount }}</span>
                    @elseif($hasOrderHistory)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center w-[10px] h-[10px] transform translate-x-0 -translate-y-1/4 bg-gray-400 border border-white rounded-circle rounded-full"></span>
                    @endif
                </a>

                <a href="{{ route('checkout.index') }}" class="relative text-gray-600 hover:text-brand-600 p-2 mr-2 transition-colors" x-data="{ cartCount: {{ count(session('cart', [])) }} }" @cart-updated.window="cartCount = $event.detail">
                    <i class='bx bx-cart text-2xl'></i>
                    <span x-show="cartCount > 0" x-text="cartCount" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-orange-500 rounded-full shadow-sm"></span>
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-brand-600">Dashboard</a>
                    <div class="h-6 w-px bg-gray-200"></div>
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 px-3 py-1.5 bg-brand-50 text-brand-700 rounded-lg font-bold text-sm hover:bg-brand-100 transition shadow-sm border border-brand-200">
                        <i class='bx bx-user-circle text-lg'></i> Profil
                    </a>
                @else
                    @if(request()->routeIs('home'))
                    <button @click="loginModalOpen = true" class="flex items-center gap-2 px-4 py-1.5 bg-white text-brand-600 border border-brand-600 rounded-lg font-bold text-sm hover:bg-brand-50 transition shadow-sm">
                        Masuk
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-1.5 bg-white text-brand-600 border border-brand-600 rounded-lg font-bold text-sm hover:bg-brand-50 transition shadow-sm">
                        Masuk
                    </a>
                    @endif
                @endauth
            </div>

            <!-- Cart & Hamburger (Mobile) -->
            <div class="flex items-center md:hidden gap-1">
                <!-- Riwayat Pesanan Link (Mobile) -->
                <a href="{{ route('orders.index') }}" class="relative text-gray-600 hover:text-brand-600 p-1.5 transition-colors" title="Riwayat Pesanan">
                    <i class='bx bx-receipt text-2xl'></i>
                    @if($pendingOrdersCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center min-w-[18px] h-[18px] text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full shadow-sm border-2 border-white" style="animation: pulseBadge 2s infinite;">{{ $pendingOrdersCount }}</span>
                    @elseif($processingOrdersCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center min-w-[18px] h-[18px] text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-blue-500 rounded-full shadow-sm border-2 border-white">{{ $processingOrdersCount }}</span>
                    @elseif($hasOrderHistory)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center w-[10px] h-[10px] transform translate-x-0 -translate-y-1/4 bg-gray-400 border border-white rounded-circle rounded-full"></span>
                    @endif
                </a>

                <a href="{{ route('checkout.index') }}" class="relative text-gray-600 hover:text-brand-600 p-1.5 transition-colors" x-data="{ cartCount: {{ count(session('cart', [])) }} }" @cart-updated.window="cartCount = $event.detail">
                    <i class='bx bx-cart text-2xl'></i>
                    <span x-show="cartCount > 0" x-text="cartCount" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-orange-500 rounded-full shadow-sm"></span>
                </a>
                
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-brand-600 focus:outline-none p-1.5 rounded-lg">
                    <i class='bx bx-menu text-3xl' x-show="!mobileMenuOpen"></i>
                    <i class='bx bx-x text-3xl' x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <nav x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white shadow-xl absolute w-full left-0 border-t border-gray-100 z-40" 
         x-cloak>
        <div class="flex flex-col px-3 pb-4 pt-1">
            <a href="{{ route('home') }}" class="block w-full px-4 py-3.5 text-[15px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-100 {{ request()->routeIs('home') ? 'text-brand-600 font-semibold border-l-4 border-brand-600 bg-brand-50/80' : 'text-gray-800 font-medium border-l-4 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                Beranda
            </a>

            <a href="{{ route('katalog.index') }}" class="block w-full px-4 py-3.5 text-[15px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-100 {{ request()->routeIs('katalog.*') ? 'text-brand-600 font-semibold border-l-4 border-brand-600 bg-brand-50/80' : 'text-gray-800 font-medium border-l-4 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                Katalog
            </a>

            <a href="{{ route('rakit-pc') }}" class="block w-full px-4 py-3.5 text-[15px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-100 {{ request()->routeIs('rakit-pc') ? 'text-brand-600 font-semibold border-l-4 border-brand-600 bg-brand-50/80' : 'text-gray-800 font-medium border-l-4 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                Rakit PC Custom
            </a>

            <a href="{{ route('jasa-website') }}" class="block w-full px-4 py-3.5 text-[15px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-100 {{ request()->routeIs('jasa-website') ? 'text-brand-600 font-semibold border-l-4 border-brand-600 bg-brand-50/80' : 'text-gray-800 font-medium border-l-4 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                Jasa Pembuatan Website
            </a>

            <!-- Layanan Mitra — accordion -->
            @php
                $isMitraActive = request()->routeIs('wifi-voucher') || request()->routeIs('jasa-furniture') || request()->routeIs('martabak-jawara');
            @endphp
            <div x-data="{ mitraMobileOpen: {{ $isMitraActive ? 'true' : 'false' }} }" class="border-b border-gray-100">
                <button @click="mitraMobileOpen = !mitraMobileOpen"
                        class="w-full flex items-center justify-between px-4 py-3.5 text-[15px] transition-all duration-200 ease-in-out rounded-md {{ $isMitraActive ? 'text-brand-600 font-semibold border-l-4 border-brand-600 bg-brand-50/80' : 'text-gray-800 font-medium border-l-4 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                    <span>Layanan Mitra</span>
                    <i class='bx text-lg transition-transform duration-200'
                       :class="mitraMobileOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                </button>
                <div x-show="mitraMobileOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="pl-6 pb-2 pt-1"
                     x-cloak>
                    <a href="{{ route('wifi-voucher') }}" class="block w-full px-4 py-3 text-[14px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-50 {{ request()->routeIs('wifi-voucher') ? 'text-brand-600 font-semibold border-l-2 border-brand-600' : 'text-gray-600 font-medium border-l-2 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                        WiFi Voucher Starlink
                    </a>
                    <a href="{{ route('jasa-furniture') }}" class="block w-full px-4 py-3 text-[14px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-50 {{ request()->routeIs('jasa-furniture') ? 'text-brand-600 font-semibold border-l-2 border-brand-600' : 'text-gray-600 font-medium border-l-2 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                        Jasa Furniture
                    </a>
                    <a href="{{ route('martabak-jawara') }}" class="block w-full px-4 py-3 text-[14px] transition-all duration-200 ease-in-out rounded-md {{ request()->routeIs('martabak-jawara') ? 'text-brand-600 font-semibold border-l-2 border-brand-600' : 'text-gray-600 font-medium border-l-2 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                        Martabak Jawara
                    </a>
                </div>
            </div>

            <a href="{{ route('tentang-kami') }}" class="block w-full px-4 py-3.5 text-[15px] transition-all duration-200 ease-in-out rounded-md border-b border-gray-100 {{ request()->routeIs('tentang-kami') ? 'text-brand-600 font-semibold border-l-4 border-brand-600 bg-brand-50/80' : 'text-gray-800 font-medium border-l-4 border-transparent hover:text-brand-600 hover:bg-brand-50 active:bg-brand-100/60' }}">
                Tentang Kami
            </a>
        </div>
    </nav>
</header>
