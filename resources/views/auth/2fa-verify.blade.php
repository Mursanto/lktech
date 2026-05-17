<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="relative">
                <div class="logo-container">
                    <img src="{{ asset('images/LKtech.png') }}" 
                         alt="LKtech Logo" 
                         class="logo-image w-32 h-32 sm:w-40 sm:h-40 object-contain">
                </div>
            </div>
        </x-slot>

        <div class="mb-4 text-sm text-white/90">
            @if(isset($method) && $method === 'email')
                {{ __('Two-factor authentication is required. We have sent a verification code to your email address. Please enter the code below to continue.') }}
            @else
                {{ __('Two-factor authentication is required. Please enter the verification code from your Google Authenticator app.') }}
            @endif
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('2fa.verify.post') }}">
            @csrf

            <!-- Verification Code -->
            <div>
                <x-label for="code" :value="__('Verification Code')" />

                <x-input id="code" class="block mt-1 w-full bg-white/20 border-white/30 text-white placeholder-white/70 backdrop-blur-sm" 
                         type="text" name="code" required autofocus 
                         placeholder="000000" maxlength="6" pattern="[0-9]{6}" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-button class="ml-3 bg-blue-600 hover:bg-blue-700 text-white border-blue-500 transition-colors">
                    {{ __('Verify') }}
                </x-button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-white/70 hover:text-white underline">
                    {{ __('Cancel and Logout') }}
                </button>
            </form>
        </div>
    </x-auth-card>

    <style>
        .logo-container {
            animation: float 4s ease-in-out infinite;
        }
        
        .logo-image {
            filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.6)) drop-shadow(0 0 25px rgba(139, 92, 246, 0.4));
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-12px) scale(1.02); }
        }
    </style>
</x-guest-layout>
