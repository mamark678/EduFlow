<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmailVerificationController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $email = $request->session()->get('pending_verification_email');
        $userName = $request->session()->get('pending_verification_name');
        
        if (!$email) {
            return redirect()->route('register');
        }

        return view('auth.verify-email', compact('email', 'userName'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $email = $request->session()->get('pending_verification_email');
        
        if (!$email) {
            return redirect()->route('register')->withErrors(['email' => 'No pending verification found.']);
        }

        $user = User::where('email', $email)
                   ->where('email_verification_code', $request->verification_code)
                   ->where('email_verification_expires_at', '>', now())
                   ->first();

        if (!$user) {
            return back()->withErrors(['verification_code' => 'Invalid or expired verification code.']);
        }

        // Mark email as verified
        $user->update([
            'email_verified' => true,
            'email_verification_code' => null,
            'email_verification_expires_at' => null,
        ]);

        // Log the user in
        auth()->login($user);

        // Clear session
        $request->session()->forget(['pending_verification_email', 'pending_verification_name']);

        return redirect()->route('dashboard')->with('status', 'Email verified successfully! Welcome to EduFlow.');
    }

    public function resend(Request $request)
    {
        $email = $request->session()->get('pending_verification_email');
        
        if (!$email) {
            return redirect()->route('register');
        }

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return redirect()->route('register');
        }

        // Generate new verification code
        $verificationCode = strtoupper(substr(md5(uniqid()), 0, 6));
        
        $user->update([
            'email_verification_code' => $verificationCode,
            'email_verification_expires_at' => now()->addMinutes(10),
        ]);

        // Send new verification email
        Mail::to($user->email)->send(new EmailVerificationMail($verificationCode, $user->name));

        return back()->with('status', 'New verification code has been sent to your email.');
    }
}
