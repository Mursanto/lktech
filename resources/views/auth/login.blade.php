<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="relative">
                <!-- Animated Logo with Glow Effect -->
                <div class="logo-container">
                    <img src="{{ asset('images/LKtech.png') }}" 
                         alt="LKtech Logo" 
                         class="logo-image w-32 h-32 sm:w-40 sm:h-40 object-contain">
                </div>
                
                <!-- CSS for Enhanced Logo Animations -->
                <style>
                    .logo-container {
                        animation: float 4s ease-in-out infinite;
                    }
                    
                    .logo-image {
                        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 25px rgba(139, 92, 246, 0.4));
                        animation: softGlow 3s ease-in-out infinite alternate;
                        transition: all 0.3s ease;
                    }
                    
                    @keyframes float {
                        0%, 100% {
                            transform: translateY(0px) scale(1);
                        }
                        50% {
                            transform: translateY(-12px) scale(1.02);
                        }
                    }
                    
                    @keyframes softGlow {
                        0% {
                            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 25px rgba(139, 92, 246, 0.4));
                        }
                        50% {
                            filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.8)) drop-shadow(0 0 35px rgba(139, 92, 246, 0.6)) drop-shadow(0 0 45px rgba(59, 130, 246, 0.3));
                        }
                        100% {
                            filter: drop-shadow(0 0 25px rgba(255, 255, 255, 0.7)) drop-shadow(0 0 40px rgba(139, 92, 246, 0.5)) drop-shadow(0 0 55px rgba(59, 130, 246, 0.4));
                        }
                    }
                </style>
            </div>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Alamat Email -->
            <div>
                <x-label for="email" :value="__('Alamat Email')" />

                <x-input id="email" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/70 backdrop-blur-sm" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            </div>

            <!-- Kata Sandi -->
            <div class="mt-4">
                <x-label for="password" :value="__('Kata Sandi')" />

                <x-input id="password" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/70 backdrop-blur-sm"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="Masukkan kata sandi" />
            </div>

            <!-- Ingat Saya -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-white/30 bg-white/20 text-blue-500 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-white/80">Ingat Saya</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white/80 hover:text-white transition-colors" href="{{ route('password.request') }}">
                        Lupa Kata Sandi?
                    </a>
                @endif

                <x-button class="ml-3 bg-blue-600 hover:bg-blue-700 text-white border-blue-500 transition-colors">
                    Masuk
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
