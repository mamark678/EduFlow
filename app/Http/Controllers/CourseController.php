<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = \App\Models\Course::with('instructor')->get();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \Log::info('CourseController@create was called');
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|in:beginner,intermediate,advanced',
            'duration' => 'nullable|integer|min:1|max:500',
            'max_students' => 'nullable|integer|min:1|max:1000',
            'prerequisites' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
        ]);

        $course = new \App\Models\Course($validated);
        $course->instructor_id = auth()->id();
        $course->save();

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = \App\Models\Course::with(['instructor', 'modules', 'enrollments'])->findOrFail($id);
        $user = auth()->user();
        
        // Check if user is enrolled (for students) or is the instructor
        $isEnrolled = false;
        $isInstructor = false;
        $enrollmentStatus = null;
        
        if ($user) {
            if ($user->role === 'student') {
                $enrollment = $course->enrollments()
                    ->where('user_id', $user->id)
                    ->where('status', 'approved')
                    ->whereNotNull('enrolled_at')
                    ->first();
                if ($enrollment) {
                    $isEnrolled = true;
                    $enrollmentStatus = $enrollment->status;
                }
            } elseif ($user->role === 'instructor') {
                $isInstructor = ($course->instructor_id === $user->id);
            } elseif ($user->role === 'admin') {
                $isInstructor = true; // Admins have instructor-like access to all courses
            }
        }
        
        return view('courses.show', compact('course', 'isEnrolled', 'isInstructor', 'enrollmentStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'nullable|string|in:beginner,intermediate,advanced',
            'duration' => 'nullable|integer|min:1|max:500',
            'max_students' => 'nullable|integer|min:1|max:1000',
            'prerequisites' => 'nullable|string',
            'learning_objectives' => 'nullable|string',
        ]);

        $course = \App\Models\Course::findOrFail($id);
        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
