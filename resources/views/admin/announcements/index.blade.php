@extends('admin.layouts.app')

@section('page-title', 'Announcements Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-bullhorn"></i>
                Announcements Management
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Create and manage system-wide announcements and course-specific notifications
            </p>
        </div>
        <div class="admin-card-body">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <div>
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin: 0;">
                        System Announcements
                    </h2>
                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                        Broadcast important messages to users across the platform
                    </p>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('admin.announcements.create') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-plus"></i>
                        Create Announcement
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
                <form method="GET" action="{{ route('admin.announcements.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                    <input type="text" name="search" placeholder="Search announcements..." 
                           value="{{ request('search') }}" 
                           style="padding: 0.5rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; min-width: 200px;">
                    
                    <select name="status" style="padding: 0.5rem 1rem; border: 1px solid var(--border-light); border-radius: 8px;">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                    
                    <select name="audience" style="padding: 0.5rem 1rem; border: 1px solid var(--border-light); border-radius: 8px;">
                        <option value="">All Audiences</option>
                        <option value="all" {{ request('audience') === 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="students" {{ request('audience') === 'students' ? 'selected' : '' }}>Students</option>
                        <option value="instructors" {{ request('audience') === 'instructors' ? 'selected' : '' }}>Instructors</option>
                        <option value="admins" {{ request('audience') === 'admins' ? 'selected' : '' }}>Admins</option>
                    </select>
                    
                    <button type="submit" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-list"></i>
                All Announcements ({{ $announcements->total() }})
            </h3>
        </div>
        <div class="admin-card-body" style="padding: 0;">
            @if($announcements->count() > 0)
                <div style="max-height: 600px; overflow-y: auto;">
                    @foreach($announcements as $announcement)
                        <div style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem; border-bottom: 1px solid var(--border-light);">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $announcement->is_published ? 'var(--accent-green)' : 'var(--warm-orange)' }}; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.25rem;">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0;">{{ $announcement->title }}</h4>
                                    @if($announcement->is_published)
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #dcfce7; color: #16a34a;">
                                            Published
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: #fef3c7; color: #d97706;">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                                <p style="color: var(--text-secondary); margin: 0 0 0.5rem 0; line-height: 1.5;">
                                    {{ Str::limit($announcement->message, 150) }}
                                </p>
                                <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: var(--text-light);">
                                    <span>
                                        <i class="fas fa-user"></i>
                                        {{ $announcement->creator->name }}
                                    </span>
                                    <span>
                                        <i class="fas fa-users"></i>
                                        {{ ucfirst(str_replace('_', ' ', $announcement->target_audience)) }}
                                    </span>
                                    @if($announcement->course)
                                        <span>
                                            <i class="fas fa-book"></i>
                                            {{ $announcement->course->title }}
                                        </span>
                                    @endif
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        {{ $announcement->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <form method="POST" id="deleteAnnouncementForm-{{ $announcement->id }}" action="{{ route('admin.announcements.destroy', $announcement) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="admin-btn admin-btn-danger" style="padding: 0.5rem;" onclick="confirmDeleteAnnouncement({{ $announcement->id }}, '{{ addslashes($announcement->title) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div style="padding: 1.5rem; border-top: 1px solid var(--border-light);">
                    {{ $announcements->links() }}
                </div>
            @else
                <div style="padding: 3rem; text-align: center; color: var(--text-secondary);">
                    <i class="fas fa-bullhorn" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: var(--text-light);"></i>
                    <h3 style="margin: 0 0 0.5rem 0; color: var(--text-primary);">No Announcements Found</h3>
                    <p style="margin: 0 0 1.5rem 0;">Create your first announcement to start communicating with users.</p>
                    <a href="{{ route('admin.announcements.create') }}" class="admin-btn admin-btn-primary">
                        <i class="fas fa-plus"></i>
                        Create Announcement
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="deleteAnnouncementModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000;">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">
        <div style="background: white; border-radius: 16px; box-shadow: var(--shadow-xl); max-width: 400px; width: 100%;">
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-color);">
                <h5 style="font-size: 1.125rem; font-weight: 600; color: var(--text-primary); margin: 0;">Confirm Delete</h5>
            </div>
            <div style="padding: 1.5rem 2rem;">
                <p style="color: var(--text-primary); margin-bottom: 1rem;">Are you sure you want to delete announcement <strong id="deleteAnnouncementTitle"></strong>?</p>
                <p style="color: var(--coral); font-size: 0.875rem; margin: 0;">This action cannot be undone.</p>
            </div>
            <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--border-color); display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" onclick="closeDeleteAnnouncementModal()" class="admin-btn admin-btn-secondary">
                    Cancel
                </button>
                <button type="button" id="confirmDeleteAnnouncementBtn" class="admin-btn admin-btn-danger">
                    Delete Announcement
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let announcementIdToDelete = null;
function confirmDeleteAnnouncement(announcementId, announcementTitle) {
    document.getElementById('deleteAnnouncementTitle').textContent = announcementTitle;
    announcementIdToDelete = announcementId;
    document.getElementById('deleteAnnouncementModal').style.display = 'block';
}
function closeDeleteAnnouncementModal() {
    document.getElementById('deleteAnnouncementModal').style.display = 'none';
    announcementIdToDelete = null;
}
document.getElementById('confirmDeleteAnnouncementBtn').onclick = function() {
    if (announcementIdToDelete) {
        document.getElementById('deleteAnnouncementForm-' + announcementIdToDelete).submit();
    }
};
document.getElementById('deleteAnnouncementModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteAnnouncementModal();
});
</script>
@endsection 