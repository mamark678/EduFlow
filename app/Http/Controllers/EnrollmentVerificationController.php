<?php

namespace App\Http\Controllers;

use App\Mail\EnrollmentVerificationMail;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\EnrollmentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EnrollmentVerificationController extends Controller
{
    public function show($token)
    {
        \Log::info('Enrollment verification accessed', ['token' => $token, 'url' => request()->url()]);
        
        $verification = EnrollmentVerification::where('verification_token', $token)
                                             ->where('expires_at', '>', now())
                                             ->where('verified', false)
                                             ->with('course')
                                             ->first();

        if (!$verification) {
            \Log::info('Verification not found or expired', ['token' => $token]);
            return view('enrollment.expired', [
                'message' => 'This enrollment link has expired or is invalid.'
            ]);
        }

        // Check if this is a completion request
        if (request()->has('complete')) {
            \Log::info('Completing enrollment', ['token' => $token, 'email' => $verification->email]);
            return $this->completeEnrollment($verification);
        }

        \Log::info('Showing verification page', ['token' => $token]);
        return view('enrollment.verify', compact('verification'));
    }

    private function completeEnrollment($verification)
    {
        \Log::info('Starting completeEnrollment', ['verification_id' => $verification->id, 'email' => $verification->email]);
        // Find user by email from verification record
        $user = \App\Models\User::where('email', $verification->email)->first();
        \Log::info('User lookup', ['user' => $user ? $user->id : null]);
        
        if (!$user) {
            \Log::warning('User not found for enrollment', ['email' => $verification->email]);
            return redirect()->route('login')->with('message', 'User account not found. Please log in with the email address used for enrollment.');
        }

        // Check if already enrolled
        $existingEnrollment = \App\Models\Enrollment::where('user_id', $user->id)
                                                   ->where('course_id', $verification->course_id)
                                                   ->first();
        \Log::info('Existing enrollment check', ['existing' => $existingEnrollment ? $existingEnrollment->id : null]);

        if ($existingEnrollment) {
            $verification->update(['verified' => true]);
            \Log::info('User already enrolled, marking verification as verified', ['user_id' => $user->id]);
            
            // Ensure user is logged in before redirecting
            if (!auth()->check()) {
                auth()->login($user);
            }
            
            return redirect()->route('courses.show', $verification->course_id)
                           ->with('status', 'You are already enrolled in this course.');
        }

        // Create enrollment
        $enrollment = \App\Models\Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $verification->course_id,
            'enrolled_at' => now(),
        ]);
        \Log::info('Enrollment created', ['enrollment_id' => $enrollment->id]);

        // Mark verification as complete
        $verification->update(['verified' => true]);
        \Log::info('Verification marked as complete', ['verification_id' => $verification->id]);

        // Log the user in if they're not already logged in
        if (!auth()->check()) {
            \Log::info('User not logged in, attempting login', ['user_id' => $user->id]);
            try {
                auth()->login($user);
                \Log::info('User logged in successfully', ['user_id' => $user->id, 'auth_id' => auth()->id()]);
            } catch (\Exception $e) {
                \Log::error('Failed to login user', ['user_id' => $user->id, 'error' => $e->getMessage()]);
                return redirect()->route('login')->with('message', 'Login failed. Please log in manually.');
            }
        } else {
            \Log::info('User already logged in', ['user_id' => auth()->id()]);
        }

        // Ensure session is saved and regenerate session ID for security
        try {
            session()->regenerate();
            session()->save();
            \Log::info('Session regenerated and saved successfully');
        } catch (\Exception $e) {
            \Log::error('Failed to regenerate session', ['error' => $e->getMessage()]);
        }
        
        \Log::info('About to redirect to course page', ['course_id' => $verification->course_id, 'auth_check' => auth()->check()]);

        return redirect()->route('courses.show', $verification->course_id)
                       ->with('status', 'Enrollment completed successfully! Welcome to the course.');
    }

    public function verify(Request $request, $token)
    {
        // This method is kept for backward compatibility but redirects to show
        return redirect()->route('enrollment.verify', $token);
    }

    public function initiate(Request $request, Course $course)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('message', 'Please log in to enroll in courses.');
        }

        $user = auth()->user();

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
                                       ->where('course_id', $course->id)
                                       ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.show', $course)
                           ->with('status', 'You are already enrolled in this course.');
        }

        // Generate verification token
        $verificationToken = md5(uniqid() . time());

        // Create enrollment verification
        EnrollmentVerification::create([
            'course_id' => $course->id,
            'email' => $request->email,
            'verification_token' => $verificationToken,
            'expires_at' => now()->addHours(24),
            'verified' => false,
        ]);

        // Send verification email
        Mail::to($request->email)->send(new EnrollmentVerificationMail(
            $verificationToken,
            $course->title,
            $request->email
        ));

        return redirect()->route('courses.show', $course)
                       ->with('status', 'Enrollment verification email sent! Please check your email to complete enrollment.');
    }

    public function expired()
    {
        return view('enrollment.expired');
    }
}
