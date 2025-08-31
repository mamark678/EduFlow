<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OtpVerificationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        \Log::info('=== OTP VERIFICATION PAGE ACCESSED ===', [
            'session_id' => $request->session()->getId(),
            'all_session_data' => $request->session()->all()
        ]);
        
        // Get session data directly
        $email = $request->session()->get('pending_login_email');
        $userName = $request->session()->get('pending_login_name');
        
        // Debug: Log session data
        \Log::info('OTP verification page accessed', [
            'email' => $email,
            'userName' => $userName,
            'session_id' => $request->session()->getId()
        ]);
        
        if (!$email) {
            \Log::warning('No pending login email found in session');
            return redirect()->route('login');
        }

        \Log::info('Rendering OTP verification view', [
            'email' => $email,
            'userName' => $userName
        ]);

        return view('auth.verify-otp', compact('email', 'userName'));
    }

    public function verify(Request $request)
    {
        \Log::info('=== OTP VERIFICATION ATTEMPT ===', [
            'otp_code' => $request->otp_code,
            'session_id' => $request->session()->getId(),
            'all_session_data' => $request->session()->all()
        ]);

        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $email = $request->session()->get('pending_login_email');
        
        \Log::info('OTP verification - session data', [
            'email' => $email,
            'session_id' => $request->session()->getId()
        ]);
        
        if (!$email) {
            \Log::warning('No pending login email found in session during verification');
            return redirect()->route('login')->withErrors(['email' => 'No pending login verification found.']);
        }

        $user = User::where('email', $email)
                   ->where('login_otp', $request->otp_code)
                   ->where('login_otp_expires_at', '>', now())
                   ->first();

        \Log::info('OTP verification - user lookup', [
            'email' => $email,
            'otp_code' => $request->otp_code,
            'user_found' => $user ? 'yes' : 'no',
            'user_id' => $user ? $user->id : null
        ]);

        if (!$user) {
            \Log::warning('Invalid or expired OTP code', [
                'email' => $email,
                'otp_code' => $request->otp_code
            ]);
            return back()->withErrors(['otp_code' => 'Invalid or expired OTP code.']);
        }

        // Clear OTP and update last login time
        $user->update([
            'login_otp' => null,
            'login_otp_expires_at' => null,
            'last_login_at' => now(),
        ]);

        // Log the user in
        Auth::login($user);

        // Clear session
        $request->session()->forget(['pending_login_email', 'pending_login_name']);

        \Log::info('OTP verification successful - user logged in', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend(Request $request)
    {
        $email = $request->session()->get('pending_login_email');
        
        if (!$email) {
            return redirect()->route('login');
        }

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Generate new OTP
        $otpCode = strtoupper(substr(md5(uniqid()), 0, 6));
        
        $user->update([
            'login_otp' => $otpCode,
            'login_otp_expires_at' => now()->addMinutes(5),
            'last_login_at' => now(),
        ]);

        // Send new OTP email
        Mail::to($user->email)->send(new LoginOtpMail($otpCode, $user->name));

        return back()->with('status', 'New OTP code has been sent to your email.');
    }
}
