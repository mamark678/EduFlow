<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Mail\EnrollmentRequestMail;
use App\Mail\EnrollmentCodeMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    public function enroll(Course $course): RedirectResponse
    {
        $user = Auth::user();
        
        // Check if already enrolled
        if ($course->enrollments()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereNotNull('enrolled_at')
            ->exists()) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        // Check if there's already a pending enrollment
        $pendingEnrollment = $course->enrollments()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingEnrollment) {
            return back()->with('error', 'You already have a pending enrollment request for this course.');
        }

        // Create pending enrollment
        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'pending',
            'code' => null,
        ]);

        // Send notification email to instructor
        try {
            Mail::to($course->instructor->email)->send(new EnrollmentRequestMail(
                $course,
                $user,
                $enrollment->id
            ));
            
            return back()->with('success', 'Enrollment request sent! The instructor will review your request and send you an enrollment code if approved.');
        } catch (\Exception $e) {
            // If email fails, delete the enrollment and show error
            $enrollment->delete();
            return back()->with('error', 'Failed to send enrollment request. Please try again.');
        }
    }

    public function approveEnrollment(Request $request, Enrollment $enrollment): RedirectResponse
    {
        // Check if user is the course instructor
        if (Auth::id() !== $enrollment->course->instructor_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Check if enrollment is already approved
        if ($enrollment->status === 'approved') {
            return back()->with('info', 'This enrollment request has already been approved.');
        }

        // Check if enrollment is not pending
        if ($enrollment->status !== 'pending') {
            return back()->with('error', 'This enrollment request cannot be approved.');
        }

        // Check if there's already an approved enrollment for this user and course
        $existingApproved = Enrollment::where('user_id', $enrollment->user_id)
            ->where('course_id', $enrollment->course_id)
            ->where('status', 'approved')
            ->where('id', '!=', $enrollment->id)
            ->first();

        if ($existingApproved) {
            // Delete the current pending enrollment since there's already an approved one
            $enrollment->delete();
            return back()->with('info', 'This student already has an approved enrollment for this course.');
        }

        // Generate enrollment code
        $enrollmentCode = strtoupper(Str::random(8));

        // Update the enrollment request status to approved and save the code
        $enrollment->update([
            'status' => 'approved',
            'code' => $enrollmentCode,
        ]);

        // Send enrollment code to student
        try {
            Mail::to($enrollment->user->email)->send(new EnrollmentCodeMail(
                $enrollment->course,
                $enrollmentCode
            ));
            return back()->with('success', 'Enrollment approved! Enrollment code has been sent to the student.');
        } catch (\Exception $e) {
            \Log::error('Failed to send enrollment code email: ' . $e->getMessage());
            return back()->with('error', 'Enrollment approved but failed to send email. Please contact the student manually with code: ' . $enrollmentCode);
        }
    }

    public function rejectEnrollment(Request $request, Enrollment $enrollment): RedirectResponse
    {
        // Check if user is the course instructor
        if (Auth::id() !== $enrollment->course->instructor_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Update enrollment request status to rejected
        $enrollment->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Enrollment request rejected.');
    }

    public function completeEnrollment(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|size:8',
        ]);

        $user = Auth::user();
        $code = strtoupper($request->code);

        // Find enrollment with matching code
        $enrollment = Enrollment::where('code', $code)
            ->where('status', 'approved')
            ->where('user_id', $user->id)
            ->whereNull('enrolled_at') // Only allow completion if not already completed
            ->first();

        if (!$enrollment) {
            return back()->with('error', 'Invalid enrollment code or you have already completed this enrollment.');
        }

        // Mark enrollment as completed
        $enrollment->update([
            'enrolled_at' => now(),
        ]);

        // Clean up any duplicate enrollments for the same user and course
        Enrollment::where('user_id', $user->id)
            ->where('course_id', $enrollment->course_id)
            ->where('id', '!=', $enrollment->id)
            ->delete();

        // Debug logging
        \Log::info('Enrollment completed', [
            'user_id' => $user->id,
            'course_id' => $enrollment->course_id,
            'enrollment_id' => $enrollment->id,
            'enrolled_at' => $enrollment->fresh()->enrolled_at
        ]);

        return redirect()->route('courses.show', $enrollment->course)
            ->with('success', 'Enrollment completed successfully! Welcome to the course.');
    }

    public function unenroll(Course $course): RedirectResponse
    {
        $user = Auth::user();
        $enrollment = $course->enrollments()->where('user_id', $user->id)->first();
        if ($enrollment) {
            $enrollment->delete();
            return back()->with('success', 'Unenrolled from course.');
        }
        return back()->with('error', 'You are not enrolled in this course.');
    }

    public function pendingEnrollments()
    {
        $user = Auth::user();
        
        if ($user->role !== 'instructor') {
            return redirect()->route('dashboard');
        }

        $pendingEnrollments = Enrollment::whereHas('course', function ($query) use ($user) {
            $query->where('instructor_id', $user->id);
        })
        ->where('status', 'pending')
        ->with(['user', 'course'])
        ->get();

        return view('enrollments.pending', compact('pendingEnrollments'));
    }

    public function showEnterCode()
    {
        return view('enrollments.enter-code');
    }
} 