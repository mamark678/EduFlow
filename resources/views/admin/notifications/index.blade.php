@extends('admin.layouts.app')

@section('page-title', 'Notifications Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-bell"></i>
                Notifications Management
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Manage and monitor all system notifications sent to users
            </p>
        </div>
        <div class="admin-card-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin: 0;">
                        System Notifications
                    </h2>
                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                        Track and manage all notifications sent across the platform
                    </p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('admin.notifications.create') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-plus"></i>
                        Send Notification
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
                <form method="GET" action="{{ route('admin.notifications.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                    <input type="text" name="search" placeholder="Search notifications..." 
                           value="{{ request('search') }}" 
                           style="padding: 0.5rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; min-width: 200px;">
                    
                    <select name="status" style="padding: 0.5rem 1rem; border: 1px solid var(--border-light); border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                    </select>
                    
                    <button type="submit" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-list"></i>
                All Notifications ({{ $notifications->total() }})
            </h3>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            @if($notifications->count() > 0)
                <div style="max-height: 600px; overflow-y: auto;">
                    @foreach($notifications as $notification)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem; border-bottom: 1px solid var(--border-light);">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $notification->read_at ? 'var(--text-light)' : 'var(--accent-blue)' }}; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem;">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0;">{{ $notification->title }}</h4>
                                    @if($notification->read_at)
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #e5e7eb; color: #6b7280;">
                                            Read
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #2563eb;">
                                            Unread
                                        </span>
                                    @endif
                                </div>
                                <p style="color: var(--text-secondary); margin: 0 0 0.5rem 0; line-height: 1.5;">
                                    {{ Str::limit($notification->message, 150) }}
                                </p>
                                <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: var(--text-light);">
                                    <span>
                                        <i class="fas fa-user"></i>
                                        {{ $notification->user->name }}
                                    </span>
                                    @if($notification->course)
                                        <span>
                                            <i class="fas fa-book"></i>
                                            {{ $notification->course->title }}
                                        </span>
                                    @endif
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if($notification->read_at)
                                        <span>
                                            <i class="fas fa-check"></i>
                                            Read {{ $notification->read_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <form method="POST" id="deleteNotificationForm-{{ $notification->id }}" action="{{ route('admin.notifications.destroy', $notification) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="admin-btn admin-btn-danger" style="padding: 0.5rem;" onclick="confirmDeleteNotification({{ $notification->id }}, '{{ addslashes($notification->title) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div style="padding: 1.5rem; border-top: 1px solid var(--border-light);">
                    {{ $notifications->links() }}
                </div>
            @else
                <div style="padding: 3rem; text-align: center; color: var(--text-secondary);">
                    <i class="fas fa-bell" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: var(--text-light);"></i>
                    <h3 style="margin: 0 0 0.5rem 0; color: var(--text-primary);">No Notifications Found</h3>
                    <p style="margin: 0 0 1.5rem 0;">No notifications have been sent yet.</p>
                    <a href="{{ route('admin.notifications.create') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-plus"></i>
                        Send Notification
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 

<div id="deleteNotificationModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000;">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">
        <div style="background: white; border-radius: 16px; box-shadow: var(--shadow-xl); max-width: 400px; width: 100%;">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color);">
                <h5 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Confirm Delete</h5>
            </div>
            <div style="padding: 1.5rem 2rem;">
                <p style="color: var(--text-primary); margin-bottom: 1rem;">Are you sure you want to delete notification <strong id="deleteNotificationTitle"></strong>?</p>
                <p style="color: var(--coral); font-size: 0.875rem; margin: 0;">This action cannot be undone.</p>
            </div>
            <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--border-color); display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeDeleteNotificationModal()" class="admin-btn admin-btn-secondary">
                    Cancel
                </button>
                <button type="button" id="confirmDeleteNotificationBtn" class="admin-btn admin-btn-danger">
                    Delete Notification
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let notificationIdToDelete = null;
function confirmDeleteNotification(notificationId, notificationTitle) {
    document.getElementById('deleteNotificationTitle').textContent = notificationTitle;
    notificationIdToDelete = notificationId;
    document.getElementById('deleteNotificationModal').style.display = 'block';
}
function closeDeleteNotificationModal() {
    document.getElementById('deleteNotificationModal').style.display = 'none';
    notificationIdToDelete = null;
}
document.getElementById('confirmDeleteNotificationBtn').onclick = function() {
    if (notificationIdToDelete) {
        document.getElementById('deleteNotificationForm-' + notificationIdToDelete).submit();
    }
};
document.getElementById('deleteNotificationModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteNotificationModal();
});
</script> 