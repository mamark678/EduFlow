<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Module;

class ProgressController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role !== 'student') {
            return redirect()->route('dashboard');
        }
        
        $enrollments = $user->enrollments()->with(['course.modules'])->get();
        
        $progressData = [];
        $totalProgress = 0;
        $totalCourses = $enrollments->count();
        
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $modules = $course->modules;
            $totalModules = $modules->count();
            
            // Calculate course progress
            $completedModules = 0;
            if ($enrollment->completed_at) {
                $completedModules = $totalModules;
            }
            
            $courseProgress = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
            $totalProgress += $courseProgress;
            
            $progressData[] = [
                'course' => $course,
                'enrollment' => $enrollment,
                'total_modules' => $totalModules,
                'completed_modules' => $completedModules,
                'progress_percentage' => $courseProgress,
                'is_completed' => $enrollment->completed_at !== null,
            ];
        }
        
        $overallProgress = $totalCourses > 0 ? round($totalProgress / $totalCourses) : 0;
        
        return view('progress.index', compact('progressData', 'overallProgress', 'totalCourses'));
    }
    
    public function courseProgress(Course $course)
    {
        $user = auth()->user();
        
        // Check if user is enrolled in this course
        $enrollment = $user->enrollments()->where('course_id', $course->id)->where('status', 'approved')->whereNotNull('enrolled_at')->first();
        
        if (!$enrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You must be enrolled in this course to view progress.');
        }
        
        $modules = $course->modules;
        $totalModules = $modules->count();
        
        // Calculate module progress (for now, simple completion tracking)
        $completedModules = 0;
        if ($enrollment->completed_at) {
            $completedModules = $totalModules;
        }
        
        $progressPercentage = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
        
        return view('progress.course', compact('course', 'enrollment', 'modules', 'progressPercentage', 'completedModules', 'totalModules'));
    }
} 