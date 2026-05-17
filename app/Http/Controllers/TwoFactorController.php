<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ActivityLog;
use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new GoogleAuthenticator();
    }

    /**
     * Show 2FA setup form.
     */
    public function showSetup()
    {
        $user = Auth::user();
        
        // Pastikan secret unik berdasarkan ID user dan tersimpan di session selama proses setup
        $sessionKey = '2fa_setup_secret_' . $user->id;
        if (!session()->has($sessionKey)) {
            // Generate secret baru yang unik
            session()->put($sessionKey, $this->google2fa->generateSecret());
        }
        $secret = session()->get($sessionKey);

        $qrUrl = GoogleQrUrl::generate(
            $user->email,
            $secret,
            'LKTech Inventory System'
        );

        return view('auth.2fa-setup', compact('secret', 'qrUrl'));
    }

    /**
     * Enable 2FA for the user.
     */
    public function enable(Request $request)
    {
        $request->validate([
            'secret' => 'required|string',
            'code' => 'required|string|digits:6',
        ]);

        $user = Auth::user();
        $secret = $request->secret;

        if ($this->google2fa->checkCode($secret, $request->code)) {
            $user->update([
                'google2fa_secret' => encrypt($secret),
                'google2fa_enabled_at' => now(),
            ]);

            // Log 2FA enablement
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => '2fa_enabled',
                'model_type' => User::class,
                'model_id' => $user->id,
                'old_values' => null,
                'new_values' => ['google2fa_enabled' => true],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Bersihkan session secret setelah berhasil
            session()->forget('2fa_setup_secret_' . $user->id);

            return redirect()->route('dashboard')
                ->with('success', '2FA has been enabled for your account.');
        }

        return back()
            ->withErrors(['code' => 'Invalid verification code.'])
            ->withInput();
    }

    /**
     * Show 2FA verification form.
     */
    public function showVerification()
    {
        if (!session()->has('2fa:user:id')) {
            return redirect()->route('login');
        }

        $method = session('2fa:method', 'google');

        return view('auth.2fa-verify', compact('method'));
    }

    /**
     * Verify 2FA code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|digits:6',
        ]);

        $userId = session('2fa:user:id');
        $method = session('2fa:method', 'google');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $isVerified = false;

        if ($method === 'email') {
            if ($user->otp_code === $request->code && $user->otp_expires_at->isFuture()) {
                $isVerified = true;
                // Clear OTP after success
                $user->update([
                    'otp_code' => null,
                    'otp_expires_at' => null,
                ]);
            }
        } else {
            // Default to Google Auth
            if (!$user->google2fa_secret) {
                return redirect()->route('login');
            }
            $secret = decrypt($user->google2fa_secret);
            if ($this->google2fa->checkCode($secret, $request->code)) {
                $isVerified = true;
            }
        }

        if ($isVerified) {
            session()->forget(['2fa:user:id', '2fa:method']);
            Auth::login($user);

            // Log successful 2FA verification
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => '2fa_verified',
                'model_type' => User::class,
                'model_id' => $user->id,
                'old_values' => null,
                'new_values' => [
                    'method' => $method,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['code' => 'Invalid verification code or code expired.']);
    }

    /**
     * Enable Email OTP for the user.
     */
    public function enableEmailOtp(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'otp_enabled' => true,
            'google2fa_secret' => null, // Disable Google Auth if enabling Email OTP
            'google2fa_enabled_at' => null,
        ]);

        // Log 2FA enablement
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'email_otp_enabled',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => null,
            'new_values' => ['otp_enabled' => true],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Email OTP 2FA has been enabled for your account.');
    }

    /**
     * Disable Email OTP for the user.
     */
    public function disableEmailOtp(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'otp_enabled' => false,
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // Log 2FA disablement
        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'email_otp_disabled',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => ['otp_enabled' => true],
            'new_values' => ['otp_enabled' => false],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Email OTP 2FA has been disabled for your account.');
    }
}
