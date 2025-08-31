<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Comment;
use App\Models\Announcement;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminGeneralMail;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function dashboard()
    {
        // User statistics
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalInstructors = User::where('role', 'instructor')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Course statistics
        $totalCourses = Course::count();
        $totalModules = Module::count();
        $totalEnrollments = Enrollment::count();
        $totalComments = Comment::count();

        // Recent activity
        $recentUsers = User::latest()->take(5)->get();
        $recentCourses = Course::with('instructor')->latest()->take(5)->get();
        $recentEnrollments = Enrollment::with(['user', 'course'])->latest()->take(5)->get();

        // Analytics data
        $userGrowth = $this->getUserGrowthData();
        $enrollmentGrowth = $this->getEnrollmentGrowthData();
        $courseStats = $this->getCourseStats();
        $topCourses = $this->getTopCourses();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalStudents', 'totalInstructors', 'totalAdmins',
            'totalCourses', 'totalModules', 'totalEnrollments', 'totalComments',
            'recentUsers', 'recentCourses', 'recentEnrollments',
            'userGrowth', 'enrollmentGrowth', 'courseStats', 'topCourses'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by email verification
        if ($request->filled('email_verified')) {
            $query->where('email_verified', $request->email_verified);
        }

        $users = $query->withCount(['courses', 'enrollments', 'comments'])
                      ->latest()
                      ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user)
    {
        $user->load(['courses', 'enrollments.course', 'comments.module']);
        
        $stats = [
            'courses_created' => $user->courses()->count(),
            'enrollments' => $user->enrollments()->count(),
            'comments_made' => $user->comments()->count(),
            'last_login' => $user->last_login_at ?? 'Never',
            'account_age' => $user->created_at->diffForHumans(),
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function userEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:student,instructor,admin',
            'email_verified' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'email_verified' => $request->has('email_verified'),
        ]);

        return redirect()->route('admin.users.show', $user)
                        ->with('success', 'User updated successfully.');
    }

    public function userDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
                        ->with('success', 'User deleted successfully.');
    }

    public function courses(Request $request)
    {
        $query = Course::with('instructor');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('instructor')) {
            $query->where('instructor_id', $request->instructor);
        }

        $courses = $query->withCount(['modules', 'enrollments'])
                        ->latest()
                        ->paginate(15);

        $instructors = User::where('role', 'instructor')->get();

        return view('admin.courses.index', compact('courses', 'instructors'));
    }

    public function analytics()
    {
        // Calculate growth percentages
        $lastMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $thisMonthUsers = User::whereMonth('created_at', now()->month)->count();
        $userGrowth = $lastMonthUsers > 0 ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;

        $lastMonthCourses = Course::whereMonth('created_at', now()->subMonth()->month)->count();
        $thisMonthCourses = Course::whereMonth('created_at', now()->month)->count();
        $courseGrowth = $lastMonthCourses > 0 ? round((($thisMonthCourses - $lastMonthCourses) / $lastMonthCourses) * 100, 1) : 0;

        $lastMonthEnrollments = Enrollment::whereMonth('created_at', now()->subMonth()->month)->count();
        $thisMonthEnrollments = Enrollment::whereMonth('created_at', now()->month)->count();
        $enrollmentGrowth = $lastMonthEnrollments > 0 ? round((($thisMonthEnrollments - $lastMonthEnrollments) / $lastMonthEnrollments) * 100, 1) : 0;

        // User analytics
        $userAnalytics = [
            'total' => User::count(),
            'this_month' => $thisMonthUsers,
            'this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'today' => User::whereDate('created_at', today())->count(),
            'growth' => $userGrowth,
        ];

        // Course analytics
        $courseAnalytics = [
            'total' => Course::count(),
            'this_month' => $thisMonthCourses,
            'this_week' => Course::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'today' => Course::whereDate('created_at', today())->count(),
            'published' => Course::where('is_published', true)->count(),
            'growth' => $courseGrowth,
        ];

        // Enrollment analytics
        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::whereNotNull('completed_at')->count();
        $completionRate = $totalEnrollments > 0 ? round(($completedEnrollments / $totalEnrollments) * 100, 1) : 0;

        $enrollmentAnalytics = [
            'total' => $totalEnrollments,
            'this_month' => $thisMonthEnrollments,
            'this_week' => Enrollment::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'today' => Enrollment::whereDate('created_at', today())->count(),
            'completed' => $completedEnrollments,
            'completion_rate' => $completionRate,
            'growth' => $enrollmentGrowth,
        ];

        // Growth charts data
        $monthlyUserGrowth = $this->getMonthlyUserGrowth();
        $monthlyCourseGrowth = $this->getMonthlyCourseGrowth();
        $monthlyEnrollmentGrowth = $this->getMonthlyEnrollmentGrowth();

        // Top performers
        $topInstructors = User::where('role', 'instructor')
                             ->withCount('courses')
                             ->orderBy('courses_count', 'desc')
                             ->take(10)
                             ->get();

        $topCourses = Course::withCount('enrollments')
                           ->orderBy('enrollments_count', 'desc')
                           ->take(10)
                           ->get();

        // Get recent data for the dashboard
        $recentUsers = User::latest()->take(5)->get();
        $recentEnrollments = Enrollment::with(['user', 'course'])->latest()->take(5)->get();

        return view('admin.analytics', compact(
            'userAnalytics', 'courseAnalytics', 'enrollmentAnalytics',
            'monthlyUserGrowth', 'monthlyCourseGrowth', 'monthlyEnrollmentGrowth',
            'topInstructors', 'topCourses', 'recentUsers', 'recentEnrollments'
        ));
    }

    private function getUserGrowthData()
    {
        return User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                  ->whereBetween('created_at', [now()->subDays(30), now()])
                  ->groupBy('date')
                  ->orderBy('date')
                  ->get()
                  ->pluck('count', 'date')
                  ->toArray();
    }

    private function getEnrollmentGrowthData()
    {
        return Enrollment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                        ->whereBetween('created_at', [now()->subDays(30), now()])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get()
                        ->pluck('count', 'date')
                        ->toArray();
    }

    private function getCourseStats()
    {
        return [
            'total' => Course::count(),
            'published' => Course::where('is_published', true)->count(),
            'draft' => Course::where('is_published', false)->count(),
            'with_modules' => Course::has('modules')->count(),
            'without_modules' => Course::doesntHave('modules')->count(),
        ];
    }

    private function getTopCourses()
    {
        return Course::withCount('enrollments')
                    ->orderBy('enrollments_count', 'desc')
                    ->take(5)
                    ->get();
    }

    private function getMonthlyUserGrowth()
    {
        $data = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                  ->whereYear('created_at', now()->year)
                  ->groupBy('year', 'month')
                  ->orderBy('year')
                  ->orderBy('month')
                  ->get()
                  ->mapWithKeys(function($item) {
                      $month = Carbon::createFromDate($item->year, $item->month, 1)->format('M');
                      return [$month => $item->count];
                  })
                  ->toArray();

        // Fill in missing months with 0
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];
        foreach ($months as $month) {
            $result[$month] = $data[$month] ?? 0;
        }
        
        return $result;
    }

    private function getMonthlyCourseGrowth()
    {
        $data = Course::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                    ->whereYear('created_at', now()->year)
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get()
                    ->mapWithKeys(function($item) {
                        $month = Carbon::createFromDate($item->year, $item->month, 1)->format('M');
                        return [$month => $item->count];
                    })
                    ->toArray();

        // Fill in missing months with 0
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];
        foreach ($months as $month) {
            $result[$month] = $data[$month] ?? 0;
        }
        
        return $result;
    }

    private function getMonthlyEnrollmentGrowth()
    {
        $data = Enrollment::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                        ->whereYear('created_at', now()->year)
                        ->groupBy('year', 'month')
                        ->orderBy('year')
                        ->orderBy('month')
                        ->get()
                        ->mapWithKeys(function($item) {
                            $month = Carbon::createFromDate($item->year, $item->month, 1)->format('M');
                            return [$month => $item->count];
                        })
                        ->toArray();

        // Fill in missing months with 0
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $result = [];
        foreach ($months as $month) {
            $result[$month] = $data[$month] ?? 0;
        }
        
        return $result;
    }

    // ==================== COMMUNICATION MANAGEMENT ====================

    public function announcements(Request $request)
    {
        $query = Announcement::with(['creator', 'course']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->published();
            } elseif ($request->status === 'draft') {
                $query->unpublished();
            }
        }

        // Filter by audience
        if ($request->filled('audience')) {
            $query->forAudience($request->audience);
        }

        $announcements = $query->latest()->paginate(15);
        $courses = Course::all();

        return view('admin.announcements.index', compact('announcements', 'courses'));
    }

    public function announcementsCreate()
    {
        $courses = Course::all();
        return view('admin.announcements.create', compact('courses'));
    }

    public function announcementsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'target_audience' => 'required|in:all,students,instructors,admins,specific_course',
            'course_id' => 'nullable|required_if:target_audience,specific_course|exists:courses,id',
            'is_published' => 'boolean',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'target_audience' => $request->target_audience,
            'course_id' => $request->course_id,
            'created_by' => auth()->id(),
            'is_published' => $request->has('is_published'),
            'published_at' => $request->has('is_published') ? now() : null,
        ]);

        // If published, create notifications for target audience
        if ($announcement->is_published) {
            $this->createAnnouncementNotifications($announcement);
        }

        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Announcement created successfully.');
    }

    public function announcementsDestroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')
                        ->with('success', 'Announcement deleted successfully.');
    }

    public function notifications(Request $request)
    {
        $query = Notification::with(['user', 'course']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter by read status
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->read();
            } elseif ($request->status === 'unread') {
                $query->unread();
            }
        }

        $notifications = $query->latest()->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function notificationsCreate()
    {
        $users = User::all();
        $courses = Course::all();
        return view('admin.notifications.create', compact('users', 'courses'));
    }

    public function notificationsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        foreach ($request->user_ids as $userId) {
            Notification::create([
                'user_id' => $userId,
                'course_id' => $request->course_id,
                'title' => $request->title,
                'message' => $request->message,
            ]);
        }

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'Notifications sent successfully.');
    }

    public function notificationsDestroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('admin.notifications.index')
                        ->with('success', 'Notification deleted successfully.');
    }

    public function emailSystem()
    {
        $users = User::all();
        $courses = Course::all();
        return view('admin.email.index', compact('users', 'courses'));
    }

    public function emailSystemSend(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'recipient_type' => 'required|in:all,students,instructors,admins,specific_users,specific_course',
            'user_ids' => 'nullable|required_if:recipient_type,specific_users|array',
            'user_ids.*' => 'exists:users,id',
            'course_id' => 'nullable|required_if:recipient_type,specific_course|exists:courses,id',
        ]);

        $recipients = $this->getEmailRecipients($request);
        $course = null;
        if ($request->filled('course_id')) {
            $course = \App\Models\Course::find($request->course_id);
        }

        foreach ($recipients as $user) {
            // Send real email
            Mail::to($user->email)->send(new AdminGeneralMail($request->subject, $request->message, $course));
            // Still create in-app notification
            Notification::create([
                'user_id' => $user->id,
                'course_id' => $request->course_id,
                'title' => $request->subject,
                'message' => $request->message,
            ]);
        }

        return redirect()->route('admin.email.index')
                        ->with('success', "Email notification sent to " . count($recipients) . " recipients.");
    }

    private function createAnnouncementNotifications($announcement)
    {
        $users = $this->getTargetUsers($announcement);

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'course_id' => $announcement->course_id,
                'title' => $announcement->title,
                'message' => $announcement->message,
            ]);
        }
    }

    private function getTargetUsers($announcement)
    {
        switch ($announcement->target_audience) {
            case 'all':
                return User::all();
            case 'students':
                return User::where('role', 'student')->get();
            case 'instructors':
                return User::where('role', 'instructor')->get();
            case 'admins':
                return User::where('role', 'admin')->get();
            case 'specific_course':
                return $announcement->course->enrollments()->with('user')->get()->pluck('user');
            default:
                return collect();
        }
    }

    private function getEmailRecipients($request)
    {
        switch ($request->recipient_type) {
            case 'all':
                return User::all();
            case 'students':
                return User::where('role', 'student')->get();
            case 'instructors':
                return User::where('role', 'instructor')->get();
            case 'admins':
                return User::where('role', 'admin')->get();
            case 'specific_users':
                return User::whereIn('id', $request->user_ids)->get();
            case 'specific_course':
                return $request->course->enrollments()->with('user')->get()->pluck('user');
            default:
                return collect();
        }
    }

    // ==================== EXPORT FUNCTIONALITY ====================

    public function exportUsersToCsv(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('email_verified')) {
            $query->where('email_verified', $request->email_verified);
        }

        $users = $query->withCount(['courses', 'enrollments', 'comments'])->get();

        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Role', 'Email Verified', 'Courses Created', 
                'Enrollments', 'Comments Made', 'Last Login', 'Created At'
            ]);

            // CSV Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->email_verified ? 'Yes' : 'No',
                    $user->courses_count,
                    $user->enrollments_count,
                    $user->comments_count,
                    $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportEnrollmentsToCsv(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);

        // Apply filters
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $enrollments = $query->get();

        $filename = 'enrollments_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($enrollments) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Student Name', 'Student Email', 'Course Title', 'Status', 
                'Enrolled At', 'Completed At', 'Created At'
            ]);

            // CSV Data
            foreach ($enrollments as $enrollment) {
                fputcsv($file, [
                    $enrollment->id,
                    $enrollment->user->name,
                    $enrollment->user->email,
                    $enrollment->course->title,
                    $enrollment->status,
                    $enrollment->enrolled_at ? $enrollment->enrolled_at->format('Y-m-d H:i:s') : 'Not enrolled',
                    $enrollment->completed_at ? $enrollment->completed_at->format('Y-m-d H:i:s') : 'Not completed',
                    $enrollment->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportCoursesToCsv(Request $request)
    {
        $query = Course::with('instructor');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('instructor')) {
            $query->where('instructor_id', $request->instructor);
        }

        if ($request->filled('published')) {
            $query->where('is_published', $request->published);
        }

        $courses = $query->withCount(['modules', 'enrollments'])->get();

        $filename = 'courses_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($courses) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, [
                'ID', 'Title', 'Description', 'Instructor', 'Category', 'Difficulty',
                'Modules Count', 'Enrollments Count', 'Published', 'Created At'
            ]);

            // CSV Data
            foreach ($courses as $course) {
                fputcsv($file, [
                    $course->id,
                    $course->title,
                    $course->description,
                    $course->instructor->name,
                    $course->category,
                    $course->difficulty,
                    $course->modules_count,
                    $course->enrollments_count,
                    $course->is_published ? 'Yes' : 'No',
                    $course->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportAnalyticsToCsv()
    {
        // Get analytics data
        $userAnalytics = [
            'total' => User::count(),
            'students' => User::where('role', 'student')->count(),
            'instructors' => User::where('role', 'instructor')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'this_month' => User::whereMonth('created_at', now()->month)->count(),
            'active_users' => User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subDays(30))->count(),
        ];

        $courseAnalytics = [
            'total' => Course::count(),
            'published' => Course::where('is_published', true)->count(),
            'draft' => Course::where('is_published', false)->count(),
            'this_month' => Course::whereMonth('created_at', now()->month)->count(),
        ];

        $enrollmentAnalytics = [
            'total' => Enrollment::count(),
            'completed' => Enrollment::whereNotNull('completed_at')->count(),
            'completion_rate' => Enrollment::count() > 0 ? round((Enrollment::whereNotNull('completed_at')->count() / Enrollment::count()) * 100, 1) : 0,
            'this_month' => Enrollment::whereMonth('created_at', now()->month)->count(),
        ];

        $filename = 'analytics_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($userAnalytics, $courseAnalytics, $enrollmentAnalytics) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Metric', 'Value', 'Description']);
            
            // User Analytics
            fputcsv($file, ['Total Users', $userAnalytics['total'], 'Total number of registered users']);
            fputcsv($file, ['Students', $userAnalytics['students'], 'Number of student accounts']);
            fputcsv($file, ['Instructors', $userAnalytics['instructors'], 'Number of instructor accounts']);
            fputcsv($file, ['Admins', $userAnalytics['admins'], 'Number of admin accounts']);
            fputcsv($file, ['New Users This Month', $userAnalytics['this_month'], 'Users registered this month']);
            fputcsv($file, ['Active Users (30 days)', $userAnalytics['active_users'], 'Users who logged in within 30 days']);
            
            fputcsv($file, ['', '', '']); // Empty row for spacing
            
            // Course Analytics
            fputcsv($file, ['Total Courses', $courseAnalytics['total'], 'Total number of courses']);
            fputcsv($file, ['Published Courses', $courseAnalytics['published'], 'Number of published courses']);
            fputcsv($file, ['Draft Courses', $courseAnalytics['draft'], 'Number of draft courses']);
            fputcsv($file, ['New Courses This Month', $courseAnalytics['this_month'], 'Courses created this month']);
            
            fputcsv($file, ['', '', '']); // Empty row for spacing
            
            // Enrollment Analytics
            fputcsv($file, ['Total Enrollments', $enrollmentAnalytics['total'], 'Total number of enrollments']);
            fputcsv($file, ['Completed Enrollments', $enrollmentAnalytics['completed'], 'Number of completed enrollments']);
            fputcsv($file, ['Completion Rate (%)', $enrollmentAnalytics['completion_rate'], 'Percentage of completed enrollments']);
            fputcsv($file, ['New Enrollments This Month', $enrollmentAnalytics['this_month'], 'Enrollments created this month']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSystemReport()
    {
        // Generate a comprehensive system report
        $report = [
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'system_stats' => [
                'total_users' => User::count(),
                'total_courses' => Course::count(),
                'total_enrollments' => Enrollment::count(),
                'total_modules' => Module::count(),
                'total_comments' => Comment::count(),
                'total_forums' => \App\Models\Forum::count(),
                'total_forum_posts' => \App\Models\ForumPost::count(),
            ],
            'user_breakdown' => [
                'students' => User::where('role', 'student')->count(),
                'instructors' => User::where('role', 'instructor')->count(),
                'admins' => User::where('role', 'admin')->count(),
            ],
            'course_breakdown' => [
                'published' => Course::where('is_published', true)->count(),
                'draft' => Course::where('is_published', false)->count(),
            ],
            'enrollment_breakdown' => [
                'completed' => Enrollment::whereNotNull('completed_at')->count(),
                'in_progress' => Enrollment::whereNull('completed_at')->count(),
            ],
            'recent_activity' => [
                'new_users_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
                'new_courses_this_week' => Course::where('created_at', '>=', now()->subWeek())->count(),
                'new_enrollments_this_week' => Enrollment::where('created_at', '>=', now()->subWeek())->count(),
            ]
        ];

        $filename = 'system_report_' . date('Y-m-d_H-i-s') . '.json';
        
        return response()->json($report, 200, [
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ==================== PDF EXPORT FUNCTIONALITY ====================

    public function exportUsersToPdf(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('email_verified')) {
            $query->where('email_verified', $request->email_verified);
        }

        $users = $query->withCount(['courses', 'enrollments', 'comments'])->get();

        $data = [
            'title' => 'Users Report',
            'generated_at' => now()->format('F j, Y \a\t g:i A'),
            'total_users' => $users->count(),
            'users' => $users,
            'filters' => [
                'search' => $request->search,
                'role' => $request->role,
                'email_verified' => $request->email_verified,
            ]
        ];

        $pdf = Pdf::loadView('admin.exports.users-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('users_report_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportEnrollmentsToPdf(Request $request)
    {
        $query = Enrollment::with(['user', 'course']);

        // Apply filters
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $enrollments = $query->get();

        $data = [
            'title' => 'Enrollments Report',
            'generated_at' => now()->format('F j, Y \a\t g:i A'),
            'total_enrollments' => $enrollments->count(),
            'enrollments' => $enrollments,
            'filters' => [
                'course_id' => $request->course_id,
                'status' => $request->status,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
            ]
        ];

        $pdf = Pdf::loadView('admin.exports.enrollments-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('enrollments_report_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportCoursesToPdf(Request $request)
    {
        $query = Course::with('instructor');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('instructor')) {
            $query->where('instructor_id', $request->instructor);
        }

        if ($request->filled('published')) {
            $query->where('is_published', $request->published);
        }

        $courses = $query->withCount(['modules', 'enrollments'])->get();

        $data = [
            'title' => 'Courses Report',
            'generated_at' => now()->format('F j, Y \a\t g:i A'),
            'total_courses' => $courses->count(),
            'courses' => $courses,
            'filters' => [
                'search' => $request->search,
                'instructor' => $request->instructor,
                'published' => $request->published,
            ]
        ];

        $pdf = Pdf::loadView('admin.exports.courses-pdf', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('courses_report_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function exportAnalyticsToPdf()
    {
        // Get analytics data
        $userAnalytics = [
            'total' => User::count(),
            'students' => User::where('role', 'student')->count(),
            'instructors' => User::where('role', 'instructor')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'this_month' => User::whereMonth('created_at', now()->month)->count(),
            'active_users' => User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subDays(30))->count(),
        ];

        $courseAnalytics = [
            'total' => Course::count(),
            'published' => Course::where('is_published', true)->count(),
            'draft' => Course::where('is_published', false)->count(),
            'this_month' => Course::whereMonth('created_at', now()->month)->count(),
        ];

        $enrollmentAnalytics = [
            'total' => Enrollment::count(),
            'completed' => Enrollment::whereNotNull('completed_at')->count(),
            'completion_rate' => Enrollment::count() > 0 ? round((Enrollment::whereNotNull('completed_at')->count() / Enrollment::count()) * 100, 1) : 0,
            'this_month' => Enrollment::whereMonth('created_at', now()->month)->count(),
        ];

        $data = [
            'title' => 'Analytics Report',
            'generated_at' => now()->format('F j, Y \a\t g:i A'),
            'userAnalytics' => $userAnalytics,
            'courseAnalytics' => $courseAnalytics,
            'enrollmentAnalytics' => $enrollmentAnalytics,
        ];

        $pdf = Pdf::loadView('admin.exports.analytics-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('analytics_report_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
