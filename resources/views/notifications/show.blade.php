<x-app-layout>
    <div class="edu-card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📬</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                Announcements
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Important update from your instructor.
            </p>
        </div>

        <!-- Breadcrumb -->
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem; padding: 1rem 1.5rem; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
            <a href="{{ route('dashboard') }}" style="color: #14b8a6; text-decoration: none; font-weight: 500;">Dashboard</a>
            <span style="color: #6b7280;">›</span>
            <a href="{{ route('notifications.index') }}" style="color: #14b8a6; text-decoration: none; font-weight: 500;">Notifications</a>
            <span style="color: #6b7280;">›</span>
            <span style="color: #6b7280;">{{ $notification->title }}</span>
        </div>

        <!-- Notification Content -->
        <div style="background: white; border-radius: 16px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); margin-bottom: 2rem;">
            <!-- Header -->
            <div style="border-bottom: 3px solid #e6fffa; padding-bottom: 1.5rem; margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <h2 style="color: var(--text-primary); font-size: 2rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span>📢</span>
                        {{ $notification->title }}
                    </h2>
                    @if(!$notification->isRead())
                        <span class="edu-badge" style="background: #3b82f6; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                            NEW
                        </span>
                    @endif
                </div>
                
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
                    <div style="background: #e6fffa; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; color: #2d5a27; font-weight: 500;">
                        📚 {{ $notification->course?->title ?? 'N/A' }}
                    </div>
                    <div style="background: #e6fffa; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; color: #2d5a27; font-weight: 500;">
                        👨‍🏫 {{ $notification->course?->instructor?->name ?? 'N/A' }}
                    </div>
                    <div style="background: #e6fffa; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; color: #2d5a27; font-weight: 500;">
                        📅 {{ $notification->created_at->format('M d, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div style="margin-bottom: 2rem;">
                <h3 style="font-weight: 600; color: var(--text-primary); margin-bottom: 1rem; font-size: 1.2rem;">Message:</h3>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; line-height: 1.8; color: var(--text-secondary); font-size: 1rem;">
                    {!! nl2br(e($notification->message)) !!}
                </div>
            </div>

            <!-- Course Info -->
            <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 12px; padding: 1.5rem;">
                <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">📚 Course Information</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Course Title</div>
                        <div style="color: var(--text-secondary);">{{ $notification->course?->title ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Instructor</div>
                        <div style="color: var(--text-secondary);">{{ $notification->course?->instructor?->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Modules</div>
                        <div style="color: var(--text-secondary);">{{ $notification->course?->modules?->count() ?? 'N/A' }} modules</div>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">Students</div>
                        <div style="color: var(--text-secondary);">{{ $notification->course?->enrollments?->count() ?? 'N/A' }} enrolled</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('notifications.index') }}" class="edu-btn edu-btn-secondary" style="padding: 0.75rem 2rem;">
                <span>←</span> Back to Notifications
            </a>
            @if($notification->course)
            <a href="{{ route('courses.show', $notification->course) }}" class="edu-btn edu-btn-primary" style="padding: 0.75rem 2rem;">
                <span>📚</span> View Course
            </a>
            @endif
            @if(!$notification->isRead())
                <form method="POST" action="{{ route('notifications.markAsRead', $notification) }}" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="edu-btn edu-btn-success" style="padding: 0.75rem 2rem;">
                        <span>✅</span> Mark as Read
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout> 