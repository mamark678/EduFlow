@extends('admin.layouts.app')

@section('page-title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-tachometer-alt"></i>
                Welcome to EduFlow Admin
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Comprehensive platform management for students, instructors, and administrators
            </p>
        </div>
        <div class="admin-card-body">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin: 0;">
                        Good {{ date('H') < 12 ? 'Morning' : (date('H') < 17 ? 'Afternoon' : 'Evening') }}, {{ Auth::user()->name }}!
                    </h2>
                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                        Here's what's happening with your EduFlow platform today
                    </p>
                </div>
                <div style="text-align: right;">
                    <div style="color: var(--text-secondary); font-size: 0.875rem;">{{ date('l, F j, Y') }}</div>
                    <div style="color: var(--text-light); font-size: 0.75rem;">{{ date('g:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Total Users</div>
                <div class="admin-stat-icon" style="background: var(--primary-blue);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\User::count() }}</div>
            <div class="admin-stat-change">+{{ \App\Models\User::where('created_at', '>=', now()->subDays(30))->count() }} this month</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Active Courses</div>
                <div class="admin-stat-icon" style="background: var(--accent-green);">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\Course::count() }}</div>
            <div class="admin-stat-change">{{ \App\Models\Course::where('is_published', true)->count() }} published</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Total Enrollments</div>
                <div class="admin-stat-icon" style="background: var(--accent-purple);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\Enrollment::count() }}</div>
            <div class="admin-stat-change">{{ \App\Models\Enrollment::whereNotNull('completed_at')->count() }} completed</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Learning Modules</div>
                <div class="admin-stat-icon" style="background: var(--warm-orange);">
                    <i class="fas fa-cube"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ \App\Models\Module::count() }}</div>
            <div class="admin-stat-change">{{ \App\Models\Module::where('is_published', true)->count() }} published</div>
        </div>
    </div>

    <!-- Management Sections -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        <!-- User Management -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-users"></i>
                    User Management
                </h3>
            </div>
            <div class="admin-card-body">
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Account creation, role assignment, and permission settings for students, instructors, and administrators
                </p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--coral); margin-bottom: 0.5rem;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Admins</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-blue); margin-bottom: 0.5rem;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\User::where('role', 'instructor')->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Instructors</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\User::where('role', 'student')->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Students</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--warm-orange); margin-bottom: 0.5rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">New This Week</div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-users"></i>
                        Manage Users
                    </a>
                    <a href="#" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-user-plus"></i>
                        Create User
                    </a>
                    <a href="{{ route('admin.export.users.csv') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-download"></i>
                        Export Users (CSV)
                    </a>
                    <a href="{{ route('admin.export.users.pdf') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-file-pdf"></i>
                        Export Users (PDF)
                    </a>
                </div>
            </div>
        </div>

        <!-- Course Management -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-book-open"></i>
                    Course Management
                </h3>
            </div>
            <div class="admin-card-body">
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Tools for creating, organizing, and overseeing courses including curriculum planning and enrollment management
                </p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Course::where('is_published', true)->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Published</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--warm-orange); margin-bottom: 0.5rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Course::where('is_published', false)->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Draft</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-blue); margin-bottom: 0.5rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Course::withCount('enrollments')->orderBy('enrollments_count', 'desc')->first()?->enrollments_count ?? 0 }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Most Popular</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-purple); margin-bottom: 0.5rem;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">N/A</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Avg Rating</div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.courses.index') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-book-open"></i>
                        Manage Courses
                    </a>
                    <a href="#" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-plus-circle"></i>
                        Create Course
                    </a>
                    <a href="{{ route('admin.export.courses.csv') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-download"></i>
                        Export Courses (CSV)
                    </a>
                    <a href="{{ route('admin.export.courses.pdf') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-file-pdf"></i>
                        Export Courses (PDF)
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Management -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-folder-open"></i>
                    Content Management
                </h3>
            </div>
            <div class="admin-card-body">
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Central repository for learning materials, documents, multimedia files, and resources with version control
                </p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-blue); margin-bottom: 0.5rem;">
                            <i class="fas fa-video"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Video::count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Videos</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--warm-orange); margin-bottom: 0.5rem;">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Document::count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Documents</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Module::count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Modules</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-purple); margin-bottom: 0.5rem;">
                            <i class="fas fa-code-branch"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Module::where('is_published', true)->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Published</div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('admin.courses.index') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-folder-open"></i>
                        Manage Content
                    </a>
                    <a href="#" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-upload"></i>
                        Upload Files
                    </a>
                </div>
            </div>
        </div>

        <!-- Analytics & Reporting -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-chart-line"></i>
                    Analytics & Reporting
                </h3>
            </div>
            <div class="admin-card-body">
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Comprehensive dashboards showing system usage, student performance metrics, and engagement statistics
                </p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">
                            {{ \App\Models\Enrollment::count() > 0 ? round((\App\Models\Enrollment::whereNotNull('completed_at')->count() / \App\Models\Enrollment::count()) * 100, 1) : 0 }}%
                        </div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Completion Rate</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-blue); margin-bottom: 0.5rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subDays(30))->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Active Users</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--warm-orange); margin-bottom: 0.5rem;">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Enrollment::where('created_at', '>=', now()->subDays(7))->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">New Enrollments</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-purple); margin-bottom: 0.5rem;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Comment::count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Comments</div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('admin.analytics') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-chart-line"></i>
                        View Analytics
                    </a>
                    <a href="#" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-download"></i>
                        Export Reports
                    </a>
                </div>
            </div>
        </div>

        <!-- Communication Management -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-bullhorn"></i>
                    Communication Management
                </h3>
            </div>
            <div class="admin-card-body">
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Administrative oversight of messaging systems, announcements, notifications, and communication policies
                </p>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-blue); margin-bottom: 0.5rem;">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Notification::count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Notifications</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\Comment::count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Comments</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--warm-orange); margin-bottom: 0.5rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">{{ \App\Models\User::where('email_verified', true)->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Verified Emails</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: var(--light-gray); border-radius: 8px;">
                        <div style="font-size: 1.5rem; color: var(--accent-purple); margin-bottom: 0.5rem;">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div style="font-weight: 600; color: var(--text-primary);">0</div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem;">Announcements</div>
                    </div>
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('admin.announcements.create') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-bullhorn"></i>
                        Send Announcement
                    </a>
                    <a href="#" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </h3>
        </div>
        <div class="admin-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-secondary" style="justify-content: center; padding: 1rem;">
                    <i class="fas fa-users mr-2"></i>
                    Manage Users
                </a>
                <a href="{{ route('admin.courses.index') }}" class="admin-btn admin-btn-secondary" style="justify-content: center; padding: 1rem;">
                    <i class="fas fa-book-open mr-2"></i>
                    Manage Courses
                </a>
                <a href="{{ route('admin.analytics') }}" class="admin-btn admin-btn-secondary" style="justify-content: center; padding: 1rem;">
                    <i class="fas fa-chart-line mr-2"></i>
                    View Analytics
                </a>
                <a href="#" class="admin-btn admin-btn-secondary" style="justify-content: center; padding: 1rem;">
                    <i class="fas fa-bullhorn mr-2"></i>
                    Send Announcement
                </a>
                <a href="#" class="admin-btn admin-btn-secondary" style="justify-content: center; padding: 1rem;">
                    <i class="fas fa-cog mr-2"></i>
                    System Settings
                </a>
                <a href="{{ route('dashboard') }}" class="admin-btn admin-btn-secondary" style="justify-content: center; padding: 1rem;">
                    <i class="fas fa-home mr-2"></i>
                    Main Site
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 