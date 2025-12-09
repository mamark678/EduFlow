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

        $request->session()->regenerate();
        
        $user->update([
            'last_login_at' => now(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
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
