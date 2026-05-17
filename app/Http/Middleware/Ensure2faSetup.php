<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ensure2faSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Wajibkan 2FA untuk Admin, Staff (Kasir), dan Teknisi
            if ($user->hasAnyRole(['Admin', 'Staff', 'Kasir', 'Sales', 'Teknisi'])) {
                
                // Jika belum setup Google 2FA dan belum setup Email OTP
                if (empty($user->google2fa_secret) && !$user->otp_enabled) {
                    
                    // Rute yang diizinkan saat 2FA belum aktif
                    $allowedRoutes = [
                        '2fa.setup',
                        '2fa.enable',
                        '2fa.disable',
                        '2fa.email.enable',
                        '2fa.email.disable',
                        'logout'
                    ];
                    
                    if (!$request->routeIs($allowedRoutes)) {
                        return redirect()->route('2fa.setup')
                            ->with('error', 'Sistem keamanan mewajibkan Anda (Admin, Kasir, dan Teknisi) untuk mengaktifkan 2FA sebelum dapat mengakses sistem.');
                    }
                }
            }
        }

        return $next($request);
    }
}
