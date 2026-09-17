<x-guest-layout>
    <!-- Background styling to match a modal-like experience -->
    <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-[#F8FAFC]">
        <!-- Decorative blurred blobs in background -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-brand-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-cyan-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60"></div>

        <!-- The Main Card -->
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-8 overflow-hidden z-10 border border-gray-100">
             
            <!-- Decorative Blue/Cyan header bar (matches login modal) -->
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-blue-500 to-cyan-500"></div>

            <div class="text-center mb-8 mt-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/LKtech.png') }}" alt="LKTech" class="h-10 mx-auto mb-4 hover:scale-105 transition-transform">
                </a>
                <h3 class="text-2xl font-black text-gray-800">Lupa Password</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Masukkan alamat email Anda untuk menerima tautan reset password.
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-envelope text-gray-400 text-lg'></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm transition-all bg-gray-50 hover:bg-white focus:bg-white @error('email') border-red-500 @enderror" placeholder="admin@lktech.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-[11px] mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
                        Kirim Tautan Reset Password
                    </button>
                </div>
                
                <div class="text-center pt-4 border-t border-gray-100 mt-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-500 hover:text-brand-600 transition-colors flex items-center justify-center gap-1">
                        <i class='bx bx-arrow-back'></i> Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
