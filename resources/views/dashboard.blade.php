<x-app-layout>
    <div class="edu-card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎓</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                Welcome back, {{ Auth::user()->name }}!
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Ready to continue your learning journey? Here's what's happening with your {{ Auth::user()->role === 'instructor' ? 'teaching' : 'learning' }} experience.
            </p>
        </div>

        <!-- Quick Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
            <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 16px; padding: 2rem; text-align: center; transition: all 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    @if(Auth::user()->role === 'instructor')
                        {{ $stats['courses_count'] ?? 0 }}
                    @else
                        {{ $stats['courses_enrolled'] ?? 0 }}
                    @endif
                </div>
                <div style="color: var(--text-secondary); font-size: 1rem; font-weight: 500;">
                    {{ Auth::user()->role === 'instructor' ? 'Courses Created' : 'Courses Enrolled' }}
                </div>
            </div>
            
            <div style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 16px; padding: 2rem; text-align: center; transition: all 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">⭐</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    @if(Auth::user()->role === 'instructor')
                        {{ $stats['students_enrolled'] ?? 0 }}
                    @else
                        {{ $stats['certificates_earned'] ?? 0 }}
                    @endif
                </div>
                <div style="color: var(--text-secondary); font-size: 1rem; font-weight: 500;">
                    {{ Auth::user()->role === 'instructor' ? 'Students Enrolled' : 'Certificates Earned' }}
                </div>
            </div>
            
            <div style="background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 16px; padding: 2rem; text-align: center; transition: all 0.3s ease;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    @if(Auth::user()->role === 'instructor')
                        {{ $stats['average_rating'] ?? 0 }}%
                    @else
                        {{ $stats['overall_progress'] ?? 0 }}%
                    @endif
                </div>
                <div style="color: var(--text-secondary); font-size: 1rem; font-weight: 500;">
                    {{ Auth::user()->role === 'instructor' ? 'Average Rating' : 'Overall Progress' }}
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="margin-bottom: 3rem;">
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                ⚡ Quick Actions
        </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                @if(Auth::user()->role === 'instructor')

                    <a href="{{ route('enrollments.pending') }}" class="edu-btn edu-btn-info" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>📝</span> Review Enrollments
                    </a>
                    <a href="{{ route('courses.create') }}" class="edu-btn edu-btn-primary" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>🚀</span> Create New Course
                    </a>
                    <a href="{{ route('instructor.forums.index') }}" class="edu-btn edu-btn-success" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>💬</span> Join Community
                    </a>
                    <a href="{{ route('announcements.index') }}" class="edu-btn edu-btn-warning" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>📧</span> Send Announcements
                    </a>
                @else
                    <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-primary" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>🔍</span> Browse Courses
                    </a>
                    <a href="{{ route('forum.index') }}" class="edu-btn edu-btn-info" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>💬</span> Join Community
                    </a>
                    <a href="{{ route('progress.index') }}" class="edu-btn edu-btn-success" style="justify-content: center; padding: 1.5rem; font-size: 1rem;">
                        <span>📊</span> View Progress
                    </a>
                @endif
            </div>
        </div>

        <!-- Recent Activity / Notifications -->
        <div style="margin-bottom: 3rem;">
            @if(Auth::user()->role === 'student')
                <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                    🔔 Recent Notifications
                </h2>
                <div style="background: rgba(255, 255, 255, 0.9); border-radius: 16px; padding: 2rem; border: 1px solid var(--border-color);">
                    @php
                        $recentNotifications = Auth::user()->notifications()->with('course')->latest()->take(5)->get();
                    @endphp
                    @if($recentNotifications->count() > 0)
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach($recentNotifications as $notification)
                                <li style="margin-bottom: 1.5rem; border-bottom: 1px solid #f1f1f1; padding-bottom: 1rem;">
                                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                        <span style="font-size: 1.5rem; margin-top: 0.25rem;">{{ !$notification->isRead() ? '🔔' : '📬' }}</span>
                                        <div style="flex: 1;">
                                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                                <div style="font-weight: 600; font-size: 1.1rem; color: var(--text-primary);">{{ $notification->title }}</div>
                                                @if(!$notification->isRead())
                                                    <span style="background: #ef4444; color: white; padding: 0.125rem 0.5rem; border-radius: 12px; font-size: 0.7rem; font-weight: 600;">NEW</span>
                                                @endif
                                            </div>
                                            <div style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 0.25rem;">{{ Str::limit($notification->message, 80) }}</div>
                                            <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.8rem; color: var(--text-secondary);">
                                                <span>📚 {{ $notification->course?->title ?? 'N/A' }}</span>
                                                <span>📅 {{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('notifications.show', $notification) }}" class="edu-btn edu-btn-primary" style="padding: 0.25rem 0.75rem; font-size: 0.8rem;">
                                            <span>👁️</span> Read
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div style="text-align: center; margin-top: 1.5rem;">
                            <a href="{{ route('notifications.index') }}" class="edu-btn edu-btn-secondary">
                                <span>📬</span> View All Notifications
                            </a>
                        </div>
                    @else
                        <div style="text-align: center; padding: 2rem;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                            <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                                No Notifications Yet
                            </h3>
                            <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                                When your instructors send announcements, they'll appear here. Enroll in courses to start receiving updates!
                            </p>
                            <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-primary">
                                <span>🔍</span> Browse Courses
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                    📅 Recent Activity
                </h2>
                <div style="background: rgba(255, 255, 255, 0.9); border-radius: 16px; padding: 2rem; border: 1px solid var(--border-color);">
                    @if($recentCourses->count() > 0)
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach($recentCourses as $course)
                                <li style="margin-bottom: 1.5rem; border-bottom: 1px solid #f1f1f1; padding-bottom: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <span style="font-size: 2rem;">📚</span>
                                        <div>
                                            <div style="font-weight: 600; font-size: 1.1rem; color: var(--text-primary);">{{ $course->title }}</div>
                                            <div style="color: var(--text-secondary); font-size: 0.95rem;">Created {{ $course->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div style="text-align: center; padding: 2rem;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
                            <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                                No Recent Activity
                            </h3>
                            <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                                Start creating courses and assignments to see your activity here!
                            </p>
                            <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-primary">
                                <span>🚀</span> Create Your First Course
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
