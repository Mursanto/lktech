<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ActivityLog;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return redirect()->route('home')->with('showLoginPopup', true);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $ipAddress = $request->ip();
        
        // Check if the IP is locked due to too many failed attempts
        $lockoutKey = "login_lockout_{$ipAddress}";
        $attemptsKey = "login_attempts_{$ipAddress}";
        
        if (Cache::has($lockoutKey)) {
            return back()
                ->withErrors(['email' => 'Too many failed login attempts. Please try again in 10 minutes.'])
                ->withInput($request->only('email'));
        }

        // Get current attempts
        $attempts = Cache::get($attemptsKey, 0);
        
        // Attempt to authenticate
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if user has Google 2FA enabled
            if ($user->google2fa_secret && $user->hasAnyRole(['Admin', 'Staff', 'Kasir', 'Sales', 'Teknisi'])) {
                Auth::logout();
                session(['2fa:user:id' => $user->id]);
                
                // Clear login attempts on successful authentication
                Cache::forget($attemptsKey);
                Cache::forget($lockoutKey);
                
                return redirect()->route('2fa.verify');
            }

            // Check if user has Email OTP enabled
            if ($user->otp_enabled && $user->hasAnyRole(['Admin', 'Staff', 'Kasir', 'Sales', 'Teknisi'])) {
                // Generate OTP
                $otp = rand(100000, 999999);
                $user->update([
                    'otp_code' => $otp,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                // Determine target email based on role (Centralize to Admin)
                $targetEmail = $user->email;
                if ($user->hasAnyRole(['Staff', 'Kasir', 'Sales', 'Teknisi'])) {
                    $targetEmail = 'admin@lktech.com';
                }

                // Send OTP via Email
                \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\MailOtp($otp));

                Auth::logout();
                session(['2fa:user:id' => $user->id, '2fa:method' => 'email']);
                
                // Clear login attempts on successful authentication
                Cache::forget($attemptsKey);
                Cache::forget($lockoutKey);
                
                return redirect()->route('2fa.verify');
            }
            
            $request->session()->regenerate();
            
            // Clear login attempts on successful login
            Cache::forget($attemptsKey);
            Cache::forget($lockoutKey);
            
            // Log successful login
            $this->logLoginActivity($request, 'login', true);
            
            return redirect()->intended(route('dashboard'));
        }

        // Increment failed attempts
        $attempts++;
        Cache::put($attemptsKey, $attempts, now()->addMinutes(10));
        
        // Log failed login attempt
        $this->logLoginActivity($request, 'login_failed', false);
        
        // Check if this is the 5th failed attempt
        if ($attempts >= 5) {
            // Lock the IP for 10 minutes
            Cache::put($lockoutKey, true, now()->addMinutes(10));
            
            return back()
                ->withErrors(['email' => 'Account locked due to too many failed attempts. Please try again in 10 minutes.'])
                ->withInput($request->only('email'));
        }

        return back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->logLoginActivity($request, 'logout', true);
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**
     * Log login activity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $action
     * @param  bool  $success
     * @return void
     */
    protected function logLoginActivity(Request $request, $action, $success)
    {
        if ($success && Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => User::class,
                'model_id' => Auth::id(),
                'old_values' => null,
                'new_values' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } elseif (!$success) {
            // Log failed login attempt without user ID
            ActivityLog::create([
                'user_id' => null,
                'action' => $action,
                'model_type' => User::class,
                'model_id' => null,
                'old_values' => null,
                'new_values' => [
                    'email' => $request->email,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
    }
}
