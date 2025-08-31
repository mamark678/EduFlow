<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerificationMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,instructor'],
        ]);

        // Generate verification code
        $verificationCode = strtoupper(substr(md5(uniqid()), 0, 6));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verification_code' => $verificationCode,
            'email_verification_expires_at' => now()->addMinutes(10),
            'email_verified' => false,
        ]);

        event(new Registered($user));

        // Send verification email
        Mail::to($user->email)->send(new EmailVerificationMail($verificationCode, $user->name));

        // Store in session for verification
        $request->session()->put('pending_verification_email', $user->email);
        $request->session()->put('pending_verification_name', $user->name);

        return redirect()->route('email.verification.notice');
    }
}
