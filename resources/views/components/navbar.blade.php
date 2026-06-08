<header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14 gap-4">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/LKtech.png') }}" alt="LKTech Logo" class="h-7 w-auto">
                    <span class="font-montserrat font-black text-xl tracking-tight text-blue-900 hidden sm:block">LKTech TN SEREAL</span>
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center gap-6 text-sm font-bold text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('home') ? 'text-brand-600' : '' }}">Beranda</a>
                <a href="{{ route('katalog.index') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('katalog.*') ? 'text-brand-600' : '' }}">Katalog</a>
                <div class="relative group" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" class="hover:text-brand-600 transition-colors flex items-center gap-1 {{ request()->routeIs('rakit-pc') || request()->routeIs('jasa-website') ? 'text-brand-600' : '' }}">
                        Layanan <i class='bx bx-chevron-down text-lg'></i>
                    </button>
                    <div x-show="open" x-transition.opacity class="absolute top-full left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2 z-50" style="display: none;">
                        <a href="{{ route('rakit-pc') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">Rakit PC</a>
                        <a href="{{ route('jasa-website') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">Jasa Pembuatan Website</a>
                    </div>
                </div>
                <a href="{{ route('blog.index') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('blog.*') ? 'text-brand-600' : '' }}">Blog & Panduan</a>
                <a href="{{ route('tentang-kami') }}" class="hover:text-brand-600 transition-colors {{ request()->routeIs('tentang-kami') ? 'text-brand-600' : '' }}">Tentang Kami</a>
            </div>

            <!-- Search Bar (Desktop) -->
            <div class="flex-1 max-w-2xl px-4 lg:px-12 hidden lg:block">
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

            <!-- Hamburger Button (Mobile) -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-brand-600 focus:outline-none p-2 rounded-lg">
                    <i class='bx bx-menu text-3xl' x-show="!mobileMenuOpen"></i>
                    <i class='bx bx-x text-3xl' x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Search Bar (visible only on mobile/tablet) -->
    <div class="block lg:hidden bg-white border-t border-gray-50">
        <form action="{{ route('katalog.index') }}" method="GET" class="px-4 pb-3 pt-2">
            <div class="relative w-full shadow-sm rounded-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari laptop, merk, atau prosesor..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-shadow">
                <button type="submit" class="absolute right-0 top-0 h-full px-4 flex items-center justify-center text-gray-400 hover:text-brand-600">
                    <i class='bx bx-search text-lg'></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Mobile Menu Dropdown -->
    <nav x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white shadow-xl absolute w-full left-0 border-t border-gray-100 pb-2 z-40" 
         x-cloak>
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors border-b border-gray-50">
                Beranda
            </a>
            <a href="{{ route('katalog.index') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors border-b border-gray-50">
                Katalog Produk
            </a>
            <a href="{{ route('rakit-pc') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors border-b border-gray-50">
                Rakit PC
            </a>
            <a href="{{ route('jasa-website') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors border-b border-gray-50">
                Jasa Website
            </a>
            <a href="{{ route('blog.index') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors border-b border-gray-50">
                Blog & Panduan
            </a>
            <a href="{{ route('tentang-kami') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors border-b border-gray-50">
                Tentang Kami
            </a>
            <a href="{{ route('kebijakan-garansi') }}" class="block px-4 py-3.5 text-[15px] font-bold text-gray-800 hover:bg-brand-50 hover:text-brand-600 rounded-xl transition-colors">
                Kebijakan Garansi
            </a>
        </div>
    </nav>
</header>
