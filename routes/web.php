<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EnrollmentVerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Debug route
Route::get('/debug-user', function () {
    $user = auth()->user();
    return [
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role ?? 'NO ROLE FIELD',
        'all_attributes' => $user->toArray(),
    ];
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar.upload');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
});

// Admin routes
Route::middleware(['auth', \App\Http\Middleware\AdminOnly::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    
    // User management
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminController::class, 'userShow'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
    
    // Course management
    Route::get('/admin/courses', [AdminController::class, 'courses'])->name('admin.courses.index');
    
    // Communication management
    Route::get('/admin/announcements', [AdminController::class, 'announcements'])->name('admin.announcements.index');
    Route::get('/admin/announcements/create', [AdminController::class, 'announcementsCreate'])->name('admin.announcements.create');
    Route::post('/admin/announcements', [AdminController::class, 'announcementsStore'])->name('admin.announcements.store');
    Route::delete('/admin/announcements/{announcement}', [AdminController::class, 'announcementsDestroy'])->name('admin.announcements.destroy');
    
    Route::get('/admin/notifications', [AdminController::class, 'notifications'])->name('admin.notifications.index');
    Route::get('/admin/notifications/create', [AdminController::class, 'notificationsCreate'])->name('admin.notifications.create');
    Route::post('/admin/notifications', [AdminController::class, 'notificationsStore'])->name('admin.notifications.store');
    Route::delete('/admin/notifications/{notification}', [AdminController::class, 'notificationsDestroy'])->name('admin.notifications.destroy');
    
    Route::get('/admin/email-system', [AdminController::class, 'emailSystem'])->name('admin.email.index');
    Route::post('/admin/email-system/send', [AdminController::class, 'emailSystemSend'])->name('admin.email.send');
    
    // Admin forum routes
    Route::get('/admin/forums', [App\Http\Controllers\Admin\ForumController::class, 'index'])->name('admin.forums.index');
    Route::get('/admin/forums/create', [App\Http\Controllers\Admin\ForumController::class, 'create'])->name('admin.forums.create');
    Route::post('/admin/forums', [App\Http\Controllers\Admin\ForumController::class, 'store'])->name('admin.forums.store');
    Route::get('/admin/forums/{forum}/edit', [App\Http\Controllers\Admin\ForumController::class, 'edit'])->name('admin.forums.edit');
    Route::put('/admin/forums/{forum}', [App\Http\Controllers\Admin\ForumController::class, 'update'])->name('admin.forums.update');
    Route::delete('/admin/forums/{forum}', [App\Http\Controllers\Admin\ForumController::class, 'destroy'])->name('admin.forums.destroy');
    
    Route::get('/admin/forums/posts', [App\Http\Controllers\Admin\ForumController::class, 'posts'])->name('admin.forums.posts');
    Route::post('/admin/forums/posts/{post}/moderate', [App\Http\Controllers\Admin\ForumController::class, 'moderatePost'])->name('admin.forums.posts.moderate');
    
    Route::get('/admin/forums/comments', [App\Http\Controllers\Admin\ForumController::class, 'comments'])->name('admin.forums.comments');
    Route::post('/admin/forums/comments/{comment}/moderate', [App\Http\Controllers\Admin\ForumController::class, 'moderateComment'])->name('admin.forums.comments.moderate');
    
    // Export routes
    Route::get('/admin/export/users/csv', [AdminController::class, 'exportUsersToCsv'])->name('admin.export.users.csv');
    Route::get('/admin/export/enrollments/csv', [AdminController::class, 'exportEnrollmentsToCsv'])->name('admin.export.enrollments.csv');
    Route::get('/admin/export/courses/csv', [AdminController::class, 'exportCoursesToCsv'])->name('admin.export.courses.csv');
    Route::get('/admin/export/analytics/csv', [AdminController::class, 'exportAnalyticsToCsv'])->name('admin.export.analytics.csv');
    Route::get('/admin/export/system-report', [AdminController::class, 'exportSystemReport'])->name('admin.export.system-report');
    
    // PDF Export routes
    Route::get('/admin/export/users/pdf', [AdminController::class, 'exportUsersToPdf'])->name('admin.export.users.pdf');
    Route::get('/admin/export/enrollments/pdf', [AdminController::class, 'exportEnrollmentsToPdf'])->name('admin.export.enrollments.pdf');
    Route::get('/admin/export/courses/pdf', [AdminController::class, 'exportCoursesToPdf'])->name('admin.export.courses.pdf');
    Route::get('/admin/export/analytics/pdf', [AdminController::class, 'exportAnalyticsToPdf'])->name('admin.export.analytics.pdf');
});

// Course routes
Route::middleware(['auth'])->group(function () {
    // Instructor only routes
    Route::middleware([\App\Http\Middleware\InstructorOnly::class])->group(function () {
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
        
        // Module management routes (instructor only)
        Route::get('/courses/{course}/modules/create', [ModuleController::class, 'create'])->name('courses.modules.create');
        Route::post('/courses/{course}/modules', [ModuleController::class, 'store'])->name('courses.modules.store');
        Route::get('/courses/{course}/modules/{module}/edit', [ModuleController::class, 'edit'])->name('courses.modules.edit');
        Route::put('/courses/{course}/modules/{module}', [ModuleController::class, 'update'])->name('courses.modules.update');
        Route::delete('/courses/{course}/modules/{module}', [ModuleController::class, 'destroy'])->name('courses.modules.destroy');
        
        // Video routes
        Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
        Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
        
        // Document routes
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    });
    
    // Place /courses/{course} after /courses/create
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    
    // Module viewing (for enrolled students and instructors) - moved outside instructor middleware
    Route::get('/courses/{course}/modules', [ModuleController::class, 'index'])->name('courses.modules.index');
    Route::get('/courses/{course}/modules/{module}', [ModuleController::class, 'show'])->name('courses.modules.show');
    
    // Module viewing (for enrolled students and instructors)
    Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
    
    // Comment routes (for enrolled students and instructors)
    Route::post('/courses/{course}/modules/{module}/comments', [CommentController::class, 'store'])->name('courses.modules.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/courses/{course}/modules/{module}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('courses.modules.comments.reply');
    
    // Enrollment routes
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::delete('/courses/{course}/unenroll', [EnrollmentController::class, 'unenroll'])->name('courses.unenroll');
    Route::post('/enrollments/complete', [EnrollmentController::class, 'completeEnrollment'])->name('enrollments.complete');
    Route::get('/enrollments/enter-code', [EnrollmentController::class, 'showEnterCode'])->name('enrollments.enter-code');
    
    // Instructor enrollment management routes
    Route::middleware([\App\Http\Middleware\InstructorOnly::class])->group(function () {
        Route::get('/enrollments/pending', [EnrollmentController::class, 'pendingEnrollments'])->name('enrollments.pending');
        Route::post('/enrollments/{enrollment}/approve', [EnrollmentController::class, 'approveEnrollment'])->name('enrollments.approve');
        Route::post('/enrollments/{enrollment}/reject', [EnrollmentController::class, 'rejectEnrollment'])->name('enrollments.reject');
    });
    
    // Progress routes (for students)
    Route::get('/progress', [App\Http\Controllers\ProgressController::class, 'index'])->name('progress.index');
    Route::get('/courses/{course}/progress', [App\Http\Controllers\ProgressController::class, 'courseProgress'])->name('progress.course');
    
    // Announcement routes (for instructors)
    Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create');
    Route::get('/announcements/create/{course}', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create.course');
    Route::post('/announcements', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcements.store');
    
    // Notification routes (for students)
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::patch('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    
    // AJAX notification routes
    Route::post('/notifications/{notification}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead.ajax');

    // New route for finishing a module
    Route::post('/courses/{course}/modules/{module}/finish', [App\Http\Controllers\ModuleController::class, 'finishModule'])->name('courses.modules.finish');

    // New route for proceeding again
    Route::post('/courses/{course}/modules/{module}/proceed-again', [App\Http\Controllers\ModuleController::class, 'proceedAgain'])->name('courses.modules.proceedAgain');

    // New route for keeping progress
    Route::post('/courses/{course}/modules/{module}/keep-progress', [App\Http\Controllers\ModuleController::class, 'keepProgress'])->name('courses.modules.keepProgress');
    
    // Forum routes (Reddit-style - any user can create forums)
    Route::get('/forum', [App\Http\Controllers\ForumController::class, 'index'])->name('forum.index');
    Route::get('/forum/search', [App\Http\Controllers\ForumController::class, 'search'])->name('forum.search');
    Route::get('/forum/create', [App\Http\Controllers\ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum', [App\Http\Controllers\ForumController::class, 'store'])->name('forum.store');
    Route::get('/forum/{forum}', [App\Http\Controllers\ForumController::class, 'show'])->name('forum.show');
    
    // Post creation routes
    Route::get('/forum/post/create', [App\Http\Controllers\ForumController::class, 'createPost'])->name('forum.create-post');
    Route::post('/forum/post', [App\Http\Controllers\ForumController::class, 'storePost'])->name('forum.store-post');
    
    // Forum management routes (for forum creators/moderators)
    Route::middleware(['auth'])->group(function () {
        Route::get('/forums/manage', [App\Http\Controllers\ForumController::class, 'manage'])->name('forums.manage');
        Route::get('/forums/{forum}/edit', [App\Http\Controllers\ForumController::class, 'edit'])->name('forums.edit');
        Route::put('/forums/{forum}', [App\Http\Controllers\ForumController::class, 'update'])->name('forums.update');
        Route::delete('/forums/{forum}', [App\Http\Controllers\ForumController::class, 'destroy'])->name('forums.destroy');
        
        // Forum moderation routes
        Route::get('/forums/{forum}/moderate', [App\Http\Controllers\ForumController::class, 'moderate'])->name('forums.moderate');
        Route::post('/forums/posts/{post}/moderate', [App\Http\Controllers\ForumController::class, 'moderatePost'])->name('forums.posts.moderate');
        Route::post('/forums/comments/{comment}/moderate', [App\Http\Controllers\ForumController::class, 'moderateComment'])->name('forums.comments.moderate');
    });
    
    // Instructor forum management routes (legacy - for instructor-specific features)
    Route::middleware([\App\Http\Middleware\InstructorOnly::class])->group(function () {
        Route::get('/instructor/forums', [App\Http\Controllers\Instructor\ForumController::class, 'index'])->name('instructor.forums.index');
        Route::get('/instructor/forums/create', [App\Http\Controllers\Instructor\ForumController::class, 'create'])->name('instructor.forums.create');
        Route::post('/instructor/forums', [App\Http\Controllers\Instructor\ForumController::class, 'store'])->name('instructor.forums.store');
        Route::get('/instructor/forums/posts', [App\Http\Controllers\Instructor\ForumController::class, 'posts'])->name('instructor.forums.posts');
        Route::post('/instructor/forums/posts/{post}/moderate', [App\Http\Controllers\Instructor\ForumController::class, 'moderatePost'])->name('instructor.forums.posts.moderate');
        Route::get('/instructor/forums/comments', [App\Http\Controllers\Instructor\ForumController::class, 'comments'])->name('instructor.forums.comments');
        Route::post('/instructor/forums/comments/{comment}/moderate', [App\Http\Controllers\Instructor\ForumController::class, 'moderateComment'])->name('instructor.forums.comments.moderate');
    });
    
    // Forum posts
    Route::get('/forum/posts/{post}', [App\Http\Controllers\ForumPostController::class, 'show'])->name('forum.posts.show');
    Route::get('/forum/posts/{post}/edit', [App\Http\Controllers\ForumPostController::class, 'edit'])->name('forum.posts.edit');
    Route::put('/forum/posts/{post}', [App\Http\Controllers\ForumPostController::class, 'update'])->name('forum.posts.update');
    Route::delete('/forum/posts/{post}', [App\Http\Controllers\ForumPostController::class, 'destroy'])->name('forum.posts.destroy');
    
    // Forum comments
    Route::post('/forum/posts/{post}/comments', [App\Http\Controllers\ForumCommentController::class, 'store'])->name('forum.comments.store');
    Route::get('/forum/comments/{comment}/edit', [App\Http\Controllers\ForumCommentController::class, 'edit'])->name('forum.comments.edit');
    Route::put('/forum/comments/{comment}', [App\Http\Controllers\ForumCommentController::class, 'update'])->name('forum.comments.update');
    Route::delete('/forum/comments/{comment}', [App\Http\Controllers\ForumCommentController::class, 'destroy'])->name('forum.comments.destroy');
    
    // Forum voting routes
    Route::post('/forum/vote', [App\Http\Controllers\ForumVoteController::class, 'vote'])->name('forum.vote');
});

// Test route to check if routes are accessible
Route::get('/test-route', function () {
    return 'Test route works!';
});

// Very simple test route
Route::get('/simple-test', function () {
    return 'Simple test works!';
});

// Test avatar functionality
Route::get('/test-avatar', function () {
    $user = auth()->user();
    if (!$user) {
        return 'No user logged in';
    }
    
    return [
        'user_id' => $user->id,
        'avatar_field' => $user->avatar,
        'avatar_url' => $user->avatar_url,
        'avatar_exists' => $user->avatar ? Storage::disk('public')->exists('avatars/' . $user->avatar) : false,
        'storage_url' => $user->avatar ? Storage::disk('public')->url('avatars/' . $user->avatar) : null,
    ];
})->middleware('auth');

// Test enrollment verification route pattern
Route::get('/test-enrollment/{token}', function ($token) {
    return "Test enrollment route works with token: {$token}";
});

// Enrollment verification routes - moved to separate group without middleware
Route::group([], function () {
    Route::get('/enrollment/verify/{token}', [EnrollmentVerificationController::class, 'show'])->name('enrollment.verify');
    Route::get('/enrollment/expired', [EnrollmentVerificationController::class, 'expired'])->name('enrollment.expired');
});

Route::get('/test-create', function () {
    return 'Test Create Route Works!';
});

Route::get('/admin-redirect', function () {
    return redirect()->route('admin.dashboard');
})->name('admin.redirect');

Route::get('/otp/verify', [OtpVerificationController::class, 'show'])->name('otp.verification.notice');
Route::post('/otp/verify', [OtpVerificationController::class, 'verify'])->name('otp.verification.verify');
Route::post('/otp/resend', [OtpVerificationController::class, 'resend'])->name('otp.verification.resend');

// Debug route to test OTP flow
Route::get('/debug-otp', function () {
    $user = \App\Models\User::where('role', 'student')->first();
    if (!$user) {
        return 'No student user found';
    }
    
    // Generate OTP
    $otpCode = strtoupper(substr(md5(uniqid()), 0, 6));
    
    $user->update([
        'login_otp' => $otpCode,
        'login_otp_expires_at' => now()->addMinutes(5),
    ]);
    
    // Set session
    session(['pending_login_email' => $user->email]);
    session(['pending_login_name' => $user->name]);
    
    return [
        'user_email' => $user->email,
        'otp_code' => $otpCode,
        'session_email' => session('pending_login_email'),
        'session_name' => session('pending_login_name'),
    ];
});

// Debug route to check user email verification
Route::get('/debug-user', function () {
    $user = \App\Models\User::where('email', 'stinemarv@gmail.com')->first();
    if (!$user) {
        return 'User not found';
    }
    
    return [
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        'email_verified' => $user->email_verified,
        'email_verified_at' => $user->email_verified_at,
    ];
});

// Test route to directly trigger OTP flow
Route::get('/test-login-otp', function () {
    $user = \App\Models\User::where('email', 'stinemarv@gmail.com')->first();
    if (!$user) {
        return 'User not found';
    }
    
    // Generate OTP
    $otpCode = strtoupper(substr(md5(uniqid()), 0, 6));
    
    $user->update([
        'login_otp' => $otpCode,
        'login_otp_expires_at' => now()->addMinutes(5),
    ]);
    
    // Set session
    session(['pending_login_email' => $user->email]);
    session(['pending_login_name' => $user->name]);
    
    return [
        'message' => 'OTP flow triggered successfully',
        'user_email' => $user->email,
        'otp_code' => $otpCode,
        'session_email' => session('pending_login_email'),
        'session_name' => session('pending_login_name'),
        'next_step' => 'Visit /otp/verify to see the OTP form'
    ];
});

// Direct login test route
Route::get('/test-direct-login', function () {
    $user = \App\Models\User::where('email', 'stinemarv@gmail.com')->first();
    if (!$user) {
        return 'User not found';
    }
    
    // Log the user in directly
    Auth::login($user);
    
    // Generate OTP
    $otpCode = strtoupper(substr(md5(uniqid()), 0, 6));
    
    $user->update([
        'login_otp' => $otpCode,
        'login_otp_expires_at' => now()->addMinutes(5),
    ]);
    
    // Set session
    session(['pending_login_email' => $user->email]);
    session(['pending_login_name' => $user->name]);
    
    // Logout temporarily
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    
    return [
        'message' => 'Direct login test completed',
        'user_email' => $user->email,
        'otp_code' => $otpCode,
        'session_email' => session('pending_login_email'),
        'session_name' => session('pending_login_name'),
        'next_step' => 'Visit /otp/verify to see the OTP form'
    ];
});

// Password check route
Route::get('/check-password', function () {
    $user = \App\Models\User::where('email', 'stinemarv@gmail.com')->first();
    if (!$user) {
        return 'User not found';
    }
    
    // Test with common passwords
    $testPasswords = ['password', '123456', 'password123', 'admin', 'test'];
    $results = [];
    
    foreach ($testPasswords as $password) {
        $results[$password] = \Hash::check($password, $user->password);
    }
    
    return [
        'user_email' => $user->email,
        'password_tests' => $results,
        'note' => 'If any password shows true, use that password in the login form'
    ];
});

// Test session data route
Route::get('/test-session', function () {
    // Simulate the login flow
    $user = \App\Models\User::where('email', 'stinemarv@gmail.com')->first();
    if (!$user) {
        return 'User not found';
    }
    
    // Generate OTP
    $otpCode = strtoupper(substr(md5(uniqid()), 0, 6));
    
    $user->update([
        'login_otp' => $otpCode,
        'login_otp_expires_at' => now()->addMinutes(5),
    ]);
    
    // Simulate the exact login flow
    $userEmail = $user->email;
    $userName = $user->name;
    
    // Logout and regenerate session
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    
    // Use flash data
    session()->flash('pending_login_email', $userEmail);
    session()->flash('pending_login_name', $userName);
    
    return [
        'message' => 'Session test completed',
        'user_email' => $userEmail,
        'otp_code' => $otpCode,
        'flash_email' => session('pending_login_email'),
        'flash_name' => session('pending_login_name'),
        'session_id' => session()->getId(),
        'next_step' => 'Visit /otp/verify to test the flow'
    ];
});

// Test enrollment route
Route::get('/test-enrollment', function () {
    $course = \App\Models\Course::first();
    if (!$course) {
        return 'No courses found in database';
    }
    
    return [
        'message' => 'Testing enrollment route',
        'course_id' => $course->id,
        'course_title' => $course->title,
        'enroll_route' => route('courses.enroll', $course),
        'unenroll_route' => route('courses.unenroll', $course),
    ];
});

// Test enrollment status
Route::get('/test-enrollment-status', function () {
    $user = auth()->user();
    $course = \App\Models\Course::first();
    
    if (!$course) {
        return 'No courses found';
    }
    
    $isEnrolled = $course->enrollments()->where('user_id', $user->id)->exists();
    $enrollmentCount = $course->enrollments()->count();
    
    return [
        'user_id' => $user->id,
        'user_role' => $user->role,
        'course_id' => $course->id,
        'course_title' => $course->title,
        'is_enrolled' => $isEnrolled,
        'total_enrollments' => $enrollmentCount,
        'is_instructor' => $user->id === $course->instructor_id,
        'note' => 'If is_enrolled is false, you need to enroll first'
    ];
});

// Test enrollment verification route
Route::get('/test-enrollment-verify/{token}', function ($token) {
    $verification = \App\Models\EnrollmentVerification::where('verification_token', $token)->first();
    
    if (!$verification) {
        return ['error' => 'Verification not found', 'token' => $token];
    }
    
    return [
        'verification_found' => true,
        'verification_id' => $verification->id,
        'email' => $verification->email,
        'course_id' => $verification->course_id,
        'expires_at' => $verification->expires_at,
        'verified' => $verification->verified,
        'user_exists' => \App\Models\User::where('email', $verification->email)->exists(),
        'enrollment_exists' => \App\Models\Enrollment::where('user_id', \App\Models\User::where('email', $verification->email)->first()?->id)
                                                    ->where('course_id', $verification->course_id)
                                                    ->exists(),
        'test_url' => route('enrollment.verify', $token) . '?complete=1'
    ];
});

// Test route to create sample notifications
Route::get('/test-notifications', function () {
    $user = \App\Models\User::where('role', 'student')->first();
    if (!$user) {
        return 'No student user found';
    }
    
    $course = \App\Models\Course::first();
    if (!$course) {
        return 'No course found';
    }
    
    // Create sample notifications
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'title' => 'Welcome to EduFlow!',
        'message' => 'Thank you for joining our learning platform. Start exploring courses today!',
    ]);
    
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'title' => 'New Course Available',
        'message' => 'A new course has been added to your dashboard. Check it out!',
    ]);
    
    \App\Models\Notification::create([
        'user_id' => $user->id,
        'course_id' => $course->id,
        'title' => 'Course Update',
        'message' => 'New content has been added to one of your enrolled courses.',
        'read_at' => now(), // This one is read
    ]);
    
    return [
        'message' => 'Sample notifications created successfully',
        'user_id' => $user->id,
        'notifications_count' => $user->notifications()->count(),
        'unread_count' => $user->unreadNotifications()->count(),
    ];
});

require __DIR__.'/auth.php';