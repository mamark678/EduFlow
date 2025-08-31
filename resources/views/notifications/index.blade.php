<x-app-layout>
    <div class="edu-card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🔔</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                My Notifications
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Stay updated with announcements from your course instructors.
            </p>
        </div>

        <!-- Header Actions -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary);">
                    📬 Announcements
                </h2>
                @if($unreadCount > 0)
                    <span class="edu-badge" style="background: #ef4444; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                        {{ $unreadCount }} new
                    </span>
                @endif
            </div>
            
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.markAllAsRead') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                        <span>✅</span> Mark All as Read
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        @if($notifications->count() > 0)
            <div style="space-y: 2rem;">
                @foreach($notifications as $notification)
                    <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem; transition: all 0.4s ease; {{ !$notification->isRead() ? 'border-left: 4px solid #3b82f6; background: rgba(59, 130, 246, 0.02);' : '' }}">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary);">
                                        {{ $notification->title }}
                                    </h3>
                                    @if(!$notification->isRead())
                                        <span class="edu-badge" style="background: #3b82f6; color: white; padding: 0.125rem 0.5rem; border-radius: 12px; font-size: 0.7rem; font-weight: 600;">
                                            NEW
                                        </span>
                                    @endif
                                </div>
                                
                                <div style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                    {{ Str::limit($notification->message, 150) }}
                                </div>
                                
                                <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 0.25rem; color: var(--text-secondary); font-size: 0.8rem;">
                                        <span>📚</span>
                                        <span>{{ $notification->course?->title ?? 'N/A' }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.25rem; color: var(--text-secondary); font-size: 0.8rem;">
                                        <span>👨‍🏫</span>
                                        <span>{{ $notification->course?->instructor?->name ?? 'N/A' }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.25rem; color: var(--text-secondary); font-size: 0.8rem;">
                                        <span>📅</span>
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 1rem;">
                            <a href="{{ route('notifications.show', $notification) }}" class="edu-btn edu-btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                <span>👁️</span> Read Full Message
                            </a>
                            @if(!$notification->isRead())
                                <form method="POST" action="{{ route('notifications.markAsRead', $notification) }}" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                        <span>✅</span> Mark as Read
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div style="margin-top: 2rem; display: flex; justify-content: center;">
                    {{ $notifications->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: 3rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
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

        <!-- Notification Stats -->
        @if($notifications->count() > 0)
            <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 16px; padding: 2rem; margin-top: 3rem;">
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem; text-align: center;">
                    📊 Notification Summary
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📬</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $notifications->total() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">Total Notifications</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🔔</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $unreadCount }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">Unread</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">✅</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $notifications->total() - $unreadCount }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">Read</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 