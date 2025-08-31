<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Get recent courses for instructors
        $recentCourses = collect();
        if ($user->role === 'instructor') {
            $recentCourses = $user->courses()
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->take(5)
                ->get();
        }
        
        // Calculate real statistics
        $stats = $this->calculateUserStats($user);
        
        return view('dashboard', compact('recentCourses', 'stats'));
    }
    
    private function calculateUserStats($user)
    {
        if ($user->role === 'instructor') {
            return $this->calculateInstructorStats($user);
        } else {
            return $this->calculateStudentStats($user);
        }
    }
    
    private function calculateInstructorStats($user)
    {
        $courses = $user->courses();
        $totalCourses = $courses->count();
        
        // Calculate total students enrolled across all courses
        $totalStudents = $courses->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');
        
        // Calculate average rating (placeholder for now)
        $averageRating = 0; // TODO: Implement rating system
        
        return [
            'courses_count' => $totalCourses,
            'students_enrolled' => $totalStudents,
            'average_rating' => $averageRating,
        ];
    }
    
    private function calculateStudentStats($user)
    {
        $enrollments = $user->enrollments()->with('course.modules');
        $totalEnrollments = $enrollments->count();
        
        // Calculate certificates earned (courses completed)
        $certificatesEarned = $enrollments->where('completed_at', '!=', null)->count();
        
        // Calculate overall progress across all enrolled courses
        $overallProgress = $this->calculateOverallProgress($user);
        
        return [
            'courses_enrolled' => $totalEnrollments,
            'certificates_earned' => $certificatesEarned,
            'overall_progress' => $overallProgress,
        ];
    }
    
    private function calculateOverallProgress($user)
    {
        $enrollments = $user->enrollments()->with('course.modules')->get();
        
        if ($enrollments->isEmpty()) {
            return 0;
        }
        
        $totalModules = 0;
        $completedModules = 0;
        
        foreach ($enrollments as $enrollment) {
            $courseModules = $enrollment->course->modules;
            $totalModules += $courseModules->count();
            
            // For now, we'll use a simple calculation
            // In the future, this should track actual module completion
            if ($enrollment->completed_at) {
                $completedModules += $courseModules->count();
            }
        }
        
        if ($totalModules === 0) {
            return 0;
        }
        
        return round(($completedModules / $totalModules) * 100);
    }
} 