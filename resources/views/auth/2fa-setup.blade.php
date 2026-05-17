<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-2xl">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Two-Factor Authentication Settings
            </h2>
            <p class="mt-2 text-center text-sm text-white/70">
                Enhance your account security by adding an extra layer of verification.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Google Authenticator Section -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-blue-500/20 rounded-lg mr-3">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Google Authenticator</h3>
                    </div>
                    
                    @if(Auth::user()->google2fa_secret)
                        <div class="mb-6 p-3 bg-green-500/20 border border-green-500/30 rounded-lg">
                            <p class="text-sm text-green-300 flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Enabled
                            </p>
                        </div>
                        <form action="{{ route('2fa.disable') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm font-medium">
                                Disable Google Auth
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-white/70 mb-6">
                            Use an authenticator app like Google Authenticator or Authy to generate secure codes.
                        </p>
                        <div class="mb-6 flex justify-center bg-white p-2 rounded-lg">
                            <img src="{{ $qrUrl }}" alt="QR Code" class="w-32 h-32">
                        </div>
                        <form action="{{ route('2fa.enable') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="secret" value="{{ $secret }}">
                            <div>
                                <label class="block text-xs font-medium text-white/60 mb-1">Verification Code</label>
                                <input type="text" name="code" required placeholder="000000" maxlength="6" 
                                       class="w-full bg-white/10 border-white/20 rounded-lg text-white placeholder-white/30 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                Enable Google Auth
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Email OTP Section -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="p-2 bg-purple-500/20 rounded-lg mr-3">
                            <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Email OTP</h3>
                    </div>

                    @if(Auth::user()->otp_enabled)
                        <div class="mb-6 p-3 bg-green-500/20 border border-green-500/30 rounded-lg">
                            <p class="text-sm text-green-300 flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Enabled
                            </p>
                        </div>
                        <form action="{{ route('2fa.email.disable') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors text-sm font-medium">
                                Disable Email OTP
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-white/70 mb-6">
                            Receive a 6-digit verification code sent to <strong>{{ Auth::user()->email }}</strong> whenever you sign in.
                        </p>
                        <div class="mb-6 flex justify-center py-4">
                            <svg class="h-20 w-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </div>
                        <form action="{{ route('2fa.email.enable') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors text-sm font-medium">
                                Enable Email OTP
                            </button>
                        </form>
                    @endif
                </div>

            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('dashboard') }}" class="text-sm text-white/50 hover:text-white transition-colors">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }
    </style>
</x-guest-layout>
