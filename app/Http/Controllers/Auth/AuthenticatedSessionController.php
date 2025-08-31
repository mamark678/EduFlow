<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\LoginOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        \Log::info('=== LOGIN ATTEMPT STARTED ===', [
            'email' => $request->email,
            'timestamp' => now()
        ]);
        
        try {
            $request->authenticate();
            \Log::info('Authentication successful', ['email' => $request->email]);
        } catch (\Exception $e) {
            \Log::error('Authentication failed', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }

        $user = Auth::user();
        \Log::info('User authenticated', [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'email_verified' => $user->email_verified
        ]);

        // Check if email is verified (temporarily disabled for testing)
        // if (!$user->email_verified) {
        //     Auth::logout();
        //     $request->session()->invalidate();
        //     $request->session()->regenerateToken();
        //     
        //     return redirect()->route('login')
        //                    ->withErrors(['email' => 'Please verify your email address before logging in.']);
        // }

        \Log::info('Generating OTP for non-admin user', ['user_id' => $user->id]);

        // Generate OTP for non-admin users
        $otpCode = strtoupper(substr(md5(uniqid()), 0, 6));
        
        $user->update([
            'login_otp' => $otpCode,
            'login_otp_expires_at' => now()->addMinutes(5),
        ]);

        \Log::info('OTP generated and saved', [
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'expires_at' => now()->addMinutes(5)
        ]);

        // Send OTP email
        try {
            Mail::to($user->email)->send(new LoginOtpMail($otpCode, $user->name));
            \Log::info('OTP email sent successfully', ['email' => $user->email]);
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email', [
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);
        }

        // Store user data temporarily (before logout)
        $userEmail = $user->email;
        $userName = $user->name;

        // Logout temporarily
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        \Log::info('User logged out and session regenerated', [
            'new_session_id' => $request->session()->getId()
        ]);

        // Store data in the new session
        $request->session()->put('pending_login_email', $userEmail);
        $request->session()->put('pending_login_name', $userName);

        \Log::info('Session data stored after regeneration', [
            'pending_login_email' => $request->session()->get('pending_login_email'),
            'pending_login_name' => $request->session()->get('pending_login_name'),
            'session_id' => $request->session()->getId()
        ]);

        // Debug: Log the OTP code
        \Log::info('OTP generated for user: ' . $userEmail . ' - Code: ' . $otpCode);

        \Log::info('=== REDIRECTING TO OTP VERIFICATION ===');
        
        return redirect()->route('otp.verification.notice');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
