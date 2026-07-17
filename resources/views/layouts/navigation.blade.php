<!-- Sidebar Backdrop for mobile -->
<div x-show="sidebarOpen && window.innerWidth < 1024" 
     class="fixed inset-0 z-40 bg-natural-900/40 backdrop-blur-sm lg:hidden"
     x-transition.opacity
     @click="sidebarOpen = false" x-cloak></div>

<!-- Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0 w-64 lg:w-72' : '-translate-x-full lg:translate-x-0 lg:w-24'"
       class="fixed inset-y-0 left-0 z-50 lg:static transition-all duration-300 ease-in-out flex flex-col p-4 bg-transparent shrink-0 h-screen">
    
    <!-- Floating Sidebar Content -->
    <div class="flex flex-col flex-1 bg-white rounded-3xl shadow-sm border border-natural-100/50 overflow-hidden">
        
        <!-- Logo (Reduced height from 72px to 60px) -->
        <div class="flex items-center h-[60px] shrink-0 px-5 mt-1 transition-all duration-300" :class="sidebarOpen ? 'justify-start' : 'justify-center px-0'">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full transition-all duration-300 group" :class="sidebarOpen ? 'justify-start' : 'justify-center'">
                <img src="{{ asset('images/LKtech.png') }}" alt="LK Tech" class="h-8 w-auto object-contain transition-transform group-hover:scale-105 shrink-0">
                <span x-show="sidebarOpen" x-transition.opacity class="font-black text-[12px] text-natural-800 leading-tight tracking-tight uppercase group-hover:text-brand-600 transition-colors line-clamp-2">LKtech<br>TN SEREAL</span>
            </a>
        </div>

        <!-- Navigation Links (Aligned to px-5 to match Logo) -->
        <div class="flex-1 overflow-y-auto py-2 px-3 space-y-0.5 custom-scrollbar transition-all duration-300">
            
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Dashboard">
                <i class='bx bx-grid-alt text-lg {{ request()->routeIs('dashboard') ? 'text-brand-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Dashboard</span>
            </a>

            <a href="/" target="_blank"
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium mr-2"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Landing Page">
                <i class='bx bx-globe text-lg text-natural-400 group-hover:text-brand-500 transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Landing Page</span>
            </a>

            <a href="{{ route('products.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Inventaris">
                <i class='bx bx-box text-lg {{ request()->routeIs('products.*') ? 'text-blue-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Inventaris</span>
            </a>

            <a href="{{ route('catalog.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('catalog.*') ? 'bg-fuchsia-50 text-fuchsia-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Katalog Produk">
                <i class='bx bx-store-alt text-lg {{ request()->routeIs('catalog.*') ? 'text-fuchsia-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Katalog Produk</span>
            </a>

            @hasanyrole('Admin|Staff|Kasir|Sales')
            <a href="{{ route('sales.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('sales.*') ? 'bg-emerald-50 text-emerald-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Penjualan">
                <i class='bx bx-cart text-lg {{ request()->routeIs('sales.*') ? 'text-emerald-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Penjualan</span>
            </a>
            @endhasanyrole

            @hasanyrole('Admin|Teknisi|Staff|Kasir|Sales')
            <a href="{{ route('services.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('services.*') ? 'bg-amber-50 text-amber-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Servis">
                <i class='bx bx-wrench text-lg {{ request()->routeIs('services.*') ? 'text-amber-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Servis</span>
            </a>
            @endhasanyrole

            @hasanyrole('Admin|Staff|Kasir|Sales')
            <a href="{{ route('rentals.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('rentals.*') ? 'bg-cyan-50 text-cyan-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Sewa Laptop">
                <i class='bx bx-laptop text-lg {{ request()->routeIs('rentals.*') ? 'text-cyan-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Sewa Laptop</span>
            </a>
            @endhasanyrole

            @if(auth()->user()->hasPermissionTo('access_rakit_pc'))
            <a href="{{ route('rakit-pc-admin.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('rakit-pc-admin.*') ? 'bg-purple-50 text-purple-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Rakit PC">
                <i class='bx bx-desktop text-lg {{ request()->routeIs('rakit-pc-admin.*') ? 'text-purple-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Rakit PC</span>
            </a>
            @endif

            @if(auth()->user()->hasRole('Admin'))
            <a href="{{ route('jasa-website-admin.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('jasa-website-admin.*') ? 'bg-brand-50 text-brand-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Jasa Website">
                <i class='bx bx-code-alt text-lg {{ request()->routeIs('jasa-website-admin.*') ? 'text-brand-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Jasa Website</span>
            </a>

            <a href="{{ route('wifi-voucher-admin.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('wifi-voucher-admin.*') ? 'bg-teal-50 text-teal-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="WiFi Voucher">
                <i class='bx bx-wifi text-lg {{ request()->routeIs('wifi-voucher-admin.*') ? 'text-teal-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">WiFi Voucher</span>
            </a>
            @endif

            @if(auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasPermissionTo('access_blog') || auth()->user()->hasPermissionTo('access_settings')))
            <!-- Administrasi Section -->
            <div x-show="sidebarOpen" class="px-5 mt-2 mb-1 flex items-center transition-opacity duration-300">
                <div class="h-px bg-natural-100 flex-1"></div>
                <p class="px-3 text-[8px] font-bold text-natural-400 uppercase tracking-widest whitespace-nowrap">Administrasi</p>
                <div class="h-px bg-natural-100 flex-1"></div>
            </div>
            <!-- Separator for mini mode -->
            <div x-show="!sidebarOpen" class="mt-2 mb-1 flex justify-center transition-opacity duration-300">
                <div class="h-px w-6 bg-natural-200"></div>
            </div>
            
            @if(auth()->user()->hasRole('Admin'))
            <a href="{{ route('reports.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('reports.*') ? 'bg-rose-50 text-rose-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Laporan">
                <i class='bx bx-pie-chart-alt-2 text-lg {{ request()->routeIs('reports.*') ? 'text-rose-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Laporan</span>
            </a>
            @endif

            @if(auth()->user()->hasPermissionTo('access_blog'))
            <a href="{{ route('posts.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('posts.*') ? 'bg-pink-50 text-pink-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Blog / Artikel">
                <i class='bx bx-news text-lg {{ request()->routeIs('posts.*') ? 'text-pink-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Blog / Artikel</span>
            </a>
            @endif

            @if(auth()->user()->hasRole('Admin'))
            <a href="{{ route('categories.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('categories.*') ? 'bg-orange-50 text-orange-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Kategori">
                <i class='bx bx-purchase-tag text-lg {{ request()->routeIs('categories.*') ? 'text-orange-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Kategori</span>
            </a>

            <a href="{{ route('users.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Manajemen User">
                <i class='bx bx-user text-lg {{ request()->routeIs('users.*') ? 'text-indigo-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">User</span>
            </a>
            
            <a href="{{ route('activity-logs.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('activity-logs.*') ? 'bg-slate-100 text-slate-800 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Log Aktivitas">
                <i class='bx bx-history text-lg {{ request()->routeIs('activity-logs.*') ? 'text-slate-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Log Aktivitas</span>
            </a>
            @endif
            
            @if(auth()->user()->hasPermissionTo('access_settings'))
            <a href="{{ route('settings.index') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-purple-50 text-purple-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Pengaturan Web">
                <i class='bx bx-cog text-lg {{ request()->routeIs('settings.*') ? 'text-purple-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Pengaturan Web</span>
            </a>
            
            <a href="{{ route('promo.edit') }}" 
               class="flex items-center gap-3 py-1.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('promo.*') ? 'bg-fuchsia-50 text-fuchsia-700 font-bold mr-2' : 'text-natural-600 hover:bg-natural-50 hover:text-natural-900 font-medium' }}"
               :class="sidebarOpen ? 'px-5 justify-start' : 'px-0 justify-center'" title="Pengaturan Banner Promo">
                <i class='bx bx-image text-lg {{ request()->routeIs('promo.*') ? 'text-fuchsia-600' : 'text-natural-400 group-hover:text-natural-600' }} transition-colors shrink-0'></i>
                <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap text-[13px]">Banner Promo</span>
            </a>
            @endif
            @endif

        </div>

        <!-- User Profile (Aligned to px-5) -->
        <div class="mt-auto p-3 border-t border-natural-100 bg-natural-50/50 shrink-0">
            <div class="flex items-center" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <div class="flex items-center gap-2.5 px-2">
                    <div class="w-8 h-8 shrink-0 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold text-xs shadow-sm" title="{{ Auth::user()->name ?? 'User' }}">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex flex-col min-w-0" x-show="sidebarOpen" x-transition.opacity>
                        <span class="text-[11px] font-bold text-natural-900 truncate w-24">{{ Auth::user()->name ?? 'Admin User' }}</span>
                        <span class="text-[9px] text-natural-500 truncate w-24">{{ Auth::user()->email ?? 'admin@lktech.com' }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline" x-show="sidebarOpen" x-transition.opacity>
                    @csrf
                    <button type="submit" class="text-natural-400 hover:text-red-500 transition-colors p-1" title="Log Out">
                        <i class='bx bx-log-out text-lg'></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
