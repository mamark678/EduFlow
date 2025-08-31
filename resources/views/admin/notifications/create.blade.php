@extends('admin.layouts.app')

@section('page-title', 'Send Notification')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-plus"></i>
                Send New Notification
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Send targeted notifications to specific users or groups
            </p>
        </div>
    </div>

    <!-- Create Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-edit"></i>
                Notification Details
            </h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-6">
                @csrf
                
                <!-- Title -->
                <div>
                    <label for="title" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Notification Title *
                    </label>
                    <input type="text" id="title" name="title" required
                           value="{{ old('title') }}"
                           placeholder="Enter notification title..."
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem; transition: border-color 0.2s;">
                    @error('title')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Notification Message *
                    </label>
                    <textarea id="message" name="message" required rows="6"
                              placeholder="Enter your notification message..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem; resize: vertical; transition: border-color 0.2s;">{{ old('message') }}</textarea>
                    @error('message')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recipients -->
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Select Recipients *
                    </label>
                    <div style="background: var(--light-gray); padding: 1.5rem; border-radius: 12px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                            @foreach($users as $user)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="checkbox" id="user_{{ $user->id }}" name="user_ids[]" 
                                           value="{{ $user->id }}" 
                                           {{ in_array($user->id, old('user_ids', [])) ? 'checked' : '' }}
                                           style="width: 1.25rem; height: 1.25rem;">
                                    <label for="user_{{ $user->id }}" style="font-weight: 500; color: var(--text-primary); cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="width: 24px; height: 24px; border-radius: 50%; background: var(--eduflow-teal); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                        {{ $user->name }}
                                        <span style="font-size: 0.75rem; color: var(--text-secondary);">
                                            ({{ ucfirst($user->role) }})
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                            <button type="button" onclick="selectAll()" class="admin-btn admin-btn-secondary" style="margin-right: 0.5rem;">
                                <i class="fas fa-check-double"></i>
                                Select All
                            </button>
                            <button type="button" onclick="deselectAll()" class="admin-btn admin-btn-secondary">
                                <i class="fas fa-times"></i>
                                Deselect All
                            </button>
                        </div>
                    </div>
                    @error('user_ids')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Association (Optional) -->
                <div>
                    <label for="course_id" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Associate with Course (Optional)
                    </label>
                    <select id="course_id" name="course_id"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem;">
                        <option value="">No course association</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    <p style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.5rem;">
                        Associating with a course will help users understand the context of the notification.
                    </p>
                    @error('course_id')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                    <a href="{{ route('admin.notifications.index') }}" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Send Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectAll() {
    const checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = true);
}

function deselectAll() {
    const checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
}
</script>
@endsection 