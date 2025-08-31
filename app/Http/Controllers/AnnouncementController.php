<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Mail;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role !== 'instructor') {
            return redirect()->route('dashboard');
        }
        
        $courses = $user->courses()->withCount('enrollments')->get();
        
        return view('announcements.index', compact('courses'));
    }
    
    public function create(Course $course = null)
    {
        $user = auth()->user();
        
        if ($user->role !== 'instructor') {
            return redirect()->route('dashboard');
        }
        
        // If no course specified, get all instructor's courses
        if (!$course) {
            $courses = $user->courses()->withCount('enrollments')->get();
            return view('announcements.create', compact('courses'));
        }
        
        // Check if instructor owns this course
        if ($course->instructor_id !== $user->id) {
            return redirect()->route('announcements.index')
                ->with('error', 'You can only send announcements for your own courses.');
        }
        
        return view('announcements.create', compact('course'));
    }
    
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role !== 'instructor') {
            return redirect()->route('announcements.index');
        }
        
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);
        
        $course = Course::findOrFail($request->course_id);
        
        // Check if instructor owns this course
        if ($course->instructor_id !== $user->id) {
            return redirect()->route('announcements.index')
                ->with('error', 'You can only send announcements for your own courses.');
        }
        
        // Get enrolled students
        $enrollments = $course->enrollments()->with('user')->get();
        
        // Create notifications for each enrolled student
        foreach ($enrollments as $enrollment) {
            \App\Models\Notification::create([
                'user_id' => $enrollment->user_id,
                'course_id' => $course->id,
                'title' => $request->subject,
                'message' => $request->message,
            ]);
        }
        
        $studentCount = $enrollments->count();
        
        return redirect()->route('announcements.index')
            ->with('success', "Announcement sent successfully to {$studentCount} enrolled students!");
    }
} 