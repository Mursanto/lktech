<!-- Bottom Nav Bar -->
<div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 flex justify-around items-center h-16 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] md:hidden">
    <!-- Item 1: Beranda -->
    <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full text-xs transition-colors {{ request()->routeIs('home') ? 'text-brand-600' : 'text-gray-500 hover:text-brand-600' }}">
        <i class='bx {{ request()->routeIs('home') ? 'bxs-home' : 'bx-home-alt' }} text-2xl mb-1'></i>
        <span class="text-[10px] font-bold">Beranda</span>
    </a>
    
    <!-- Item 2: Katalog -->
    <a href="{{ route('katalog.index') }}" class="flex flex-col items-center justify-center w-full h-full text-xs transition-colors {{ request()->routeIs('katalog.*') ? 'text-brand-600' : 'text-gray-500 hover:text-brand-600' }}">
        <i class='bx {{ request()->routeIs('katalog.*') ? 'bxs-grid-alt' : 'bx-grid-alt' }} text-2xl mb-1'></i>
        <span class="text-[10px] font-bold">Katalog</span>
    </a>
    
    <!-- Item 3: WhatsApp -->
    <a href="https://wa.me/628567354046?text=Halo%20LKtech" target="_blank" class="flex flex-col items-center justify-center w-full h-full text-xs text-emerald-500 hover:text-emerald-600 transition-colors">
        <i class='bx bxl-whatsapp text-2xl mb-1'></i>
        <span class="text-[10px] font-bold">WhatsApp</span>
    </a>
    
    <!-- Item 4: Akun -->
    @auth
    <a href="{{ url('/dashboard') }}" class="flex flex-col items-center justify-center w-full h-full text-xs transition-colors text-gray-500 hover:text-brand-600">
        <i class='bx bxs-user-circle text-2xl mb-1'></i>
        <span class="text-[10px] font-bold">Akun</span>
    </a>
    @else
    <a href="{{ route('login') }}" class="flex flex-col items-center justify-center w-full h-full text-xs transition-colors text-gray-500 hover:text-brand-600">
        <i class='bx bx-user-circle text-2xl mb-1'></i>
        <span class="text-[10px] font-bold">Masuk</span>
    </a>
    @endauth
</div>
