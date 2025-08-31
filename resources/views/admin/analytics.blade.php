@extends('admin.layouts.app')

@section('page-title', 'Analytics & Insights')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-chart-line"></i>
                Analytics & Insights
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Comprehensive dashboards showing system usage, student performance metrics, completion rates, and engagement statistics
            </p>
        </div>
        <div class="admin-card-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin: 0;">
                        System Analytics
                    </h2>
                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                        Monitor platform performance, user engagement, and learning outcomes
                    </p>
                </div>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="{{ route('admin.export.analytics.csv') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-download"></i>
                        Export Analytics (CSV)
                    </a>
                    <a href="{{ route('admin.export.analytics.pdf') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-file-pdf"></i>
                        Export Analytics (PDF)
                    </a>
                    <a href="{{ route('admin.export.system-report') }}" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-file-alt"></i>
                        System Report (JSON)
                    </a>
                    <a href="{{ route('admin.export.enrollments.csv') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-graduation-cap"></i>
                        Export Enrollments (CSV)
                    </a>
                    <a href="{{ route('admin.export.enrollments.pdf') }}" class="admin-btn admin-btn-outline">
                        <i class="fas fa-file-pdf"></i>
                        Export Enrollments (PDF)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Total Users</div>
                <div class="admin-stat-icon" style="background: var(--primary-blue);">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ $userAnalytics['total'] }}</div>
            <div class="admin-stat-change">+{{ $userAnalytics['growth'] }}% from last month</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Active Courses</div>
                <div class="admin-stat-icon" style="background: var(--accent-green);">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ $courseAnalytics['total'] }}</div>
            <div class="admin-stat-change">{{ $courseAnalytics['published'] }} published</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Total Enrollments</div>
                <div class="admin-stat-icon" style="background: var(--accent-purple);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ $enrollmentAnalytics['total'] }}</div>
            <div class="admin-stat-change">{{ $enrollmentAnalytics['completed'] }} completed</div>
        </div>
        
        <div class="admin-stat-card">
            <div class="admin-stat-header">
                <div class="admin-stat-title">Completion Rate</div>
                <div class="admin-stat-icon" style="background: var(--warm-orange);">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
            <div class="admin-stat-value">{{ $enrollmentAnalytics['completion_rate'] }}%</div>
            <div class="admin-stat-change">Average across all courses</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        <!-- User Growth Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-chart-area"></i>
                    User Growth ({{ date('Y') }})
                </h3>
            </div>
            <div class="admin-card-body">
                <canvas id="userGrowthChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Course Growth Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-chart-bar"></i>
                    Course Growth ({{ date('Y') }})
                </h3>
            </div>
            <div class="admin-card-body">
                <canvas id="courseGrowthChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Enrollment Growth Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-chart-line"></i>
                    Enrollment Growth ({{ date('Y') }})
                </h3>
            </div>
            <div class="admin-card-body">
                <canvas id="enrollmentGrowthChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Top Instructors Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-medal"></i>
                    Top Instructors
                </h3>
            </div>
            <div class="admin-card-body">
                <canvas id="topInstructorsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        <!-- Recent Users -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-user-plus"></i>
                    Recent Users
                </h3>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                @if(isset($recentUsers) && $recentUsers->count() > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        @foreach($recentUsers as $user)
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-bottom: 1px solid var(--border-light);">
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--eduflow-teal); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.875rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $user->name }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.875rem;">{{ $user->email }}</div>
                                    <div style="color: var(--text-light); font-size: 0.75rem;">Joined {{ $user->created_at->diffForHumans() }}</div>
                                </div>
                                <div>
                                    @if($user->role === 'admin')
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #fee2e2; color: #dc2626;">
                                            Admin
                                        </span>
                                    @elseif($user->role === 'instructor')
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #2563eb;">
                                            Instructor
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dcfce7; color: #16a34a;">
                                            Student
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; color: var(--text-secondary);">
                        <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: var(--text-light);"></i>
                        <p>No recent users to display</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Enrollments -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-graduation-cap"></i>
                    Recent Enrollments
                </h3>
            </div>
            <div class="admin-card-body" style="padding: 0;">
                @if(isset($recentEnrollments) && $recentEnrollments->count() > 0)
                    <div style="max-height: 400px; overflow-y: auto;">
                        @foreach($recentEnrollments as $enrollment)
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-bottom: 1px solid var(--border-light);">
                                <div style="width: 40px; height: 40px; border-radius: 8px; background: var(--accent-green); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem;">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $enrollment->course->title }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.875rem;">{{ $enrollment->user->name }}</div>
                                    <div style="color: var(--text-light); font-size: 0.75rem;">Enrolled {{ $enrollment->created_at->diffForHumans() }}</div>
                                </div>
                                <div>
                                    @if($enrollment->completed_at)
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dcfce7; color: #16a34a;">
                                            Completed
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #fef3c7; color: #d97706;">
                                            In Progress
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; color: var(--text-secondary);">
                        <i class="fas fa-graduation-cap" style="font-size: 2rem; margin-bottom: 1rem; display: block; color: var(--text-light);"></i>
                        <p>No recent enrollments to display</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-tachometer-alt"></i>
                Performance Metrics
            </h3>
        </div>
        <div class="admin-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center; padding: 1.5rem; background: var(--light-gray); border-radius: 12px;">
                    <div style="font-size: 2rem; color: var(--accent-green); margin-bottom: 0.5rem;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        {{ $enrollmentAnalytics['avg_completion_time'] ?? 'N/A' }}
                    </div>
                    <div style="color: var(--text-secondary); font-size: 0.875rem;">Average Completion Time (Days)</div>
                </div>

                <div style="text-align: center; padding: 1.5rem; background: var(--light-gray); border-radius: 12px;">
                    <div style="font-size: 2rem; color: var(--accent-blue); margin-bottom: 0.5rem;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        {{ $courseAnalytics['avg_rating'] ?? 'N/A' }}
                    </div>
                    <div style="color: var(--text-secondary); font-size: 0.875rem;">Average Course Rating</div>
                </div>

                <div style="text-align: center; padding: 1.5rem; background: var(--light-gray); border-radius: 12px;">
                    <div style="font-size: 2rem; color: var(--warm-orange); margin-bottom: 0.5rem;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        {{ $courseAnalytics['avg_enrollments'] ?? 'N/A' }}
                    </div>
                    <div style="color: var(--text-secondary); font-size: 0.875rem;">Average Enrollments per Course</div>
                </div>

                <div style="text-align: center; padding: 1.5rem; background: var(--light-gray); border-radius: 12px;">
                    <div style="font-size: 2rem; color: var(--accent-purple); margin-bottom: 0.5rem;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        {{ $userAnalytics['active_users'] ?? 'N/A' }}
                    </div>
                    <div style="color: var(--text-secondary); font-size: 0.875rem;">Active Users (Last 30 Days)</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// User Growth Chart
const userCtx = document.getElementById('userGrowthChart').getContext('2d');
new Chart(userCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($monthlyUserGrowth)) !!},
        datasets: [{
            label: 'New Users',
            data: {!! json_encode(array_values($monthlyUserGrowth)) !!},
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Course Growth Chart
const courseCtx = document.getElementById('courseGrowthChart').getContext('2d');
new Chart(courseCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_keys($monthlyCourseGrowth)) !!},
        datasets: [{
            label: 'New Courses',
            data: {!! json_encode(array_values($monthlyCourseGrowth)) !!},
            backgroundColor: '#10b981',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Enrollment Growth Chart
const enrollmentCtx = document.getElementById('enrollmentGrowthChart').getContext('2d');
new Chart(enrollmentCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($monthlyEnrollmentGrowth)) !!},
        datasets: [{
            label: 'New Enrollments',
            data: {!! json_encode(array_values($monthlyEnrollmentGrowth)) !!},
            borderColor: '#8b5cf6',
            backgroundColor: 'rgba(139, 92, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Top Instructors Chart
const instructorsCtx = document.getElementById('topInstructorsChart').getContext('2d');
new Chart(instructorsCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($topInstructors->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($topInstructors->pluck('courses_count')) !!},
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    }
});
</script>
@endsection 