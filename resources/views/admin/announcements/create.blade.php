@extends('admin.layouts.app')

@section('page-title', 'Create Announcement')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-plus"></i>
                Create New Announcement
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Broadcast important messages to users across the platform
            </p>
        </div>
    </div>

    <!-- Create Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-edit"></i>
                Announcement Details
            </h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-6">
                @csrf
                
                <!-- Title -->
                <div>
                    <label for="title" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Announcement Title *
                    </label>
                    <input type="text" id="title" name="title" required
                           value="{{ old('title') }}"
                           placeholder="Enter announcement title..."
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem; transition: border-color 0.2s;">
                    @error('title')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Announcement Message *
                    </label>
                    <textarea id="message" name="message" required rows="6"
                              placeholder="Enter your announcement message..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem; resize: vertical; transition: border-color 0.2s;">{{ old('message') }}</textarea>
                    @error('message')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Target Audience -->
                <div>
                    <label for="target_audience" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Target Audience *
                    </label>
                    <select id="target_audience" name="target_audience" required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem;">
                        <option value="">Select target audience...</option>
                        <option value="all" {{ old('target_audience') === 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="students" {{ old('target_audience') === 'students' ? 'selected' : '' }}>Students Only</option>
                        <option value="instructors" {{ old('target_audience') === 'instructors' ? 'selected' : '' }}>Instructors Only</option>
                        <option value="admins" {{ old('target_audience') === 'admins' ? 'selected' : '' }}>Admins Only</option>
                    </select>
                    @error('target_audience')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Selection (conditional) -->
                <div id="course_selection" style="display: none;">
                    <label for="course_id" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Select Course *
                    </label>
                    <select id="course_id" name="course_id"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem;">
                        <option value="">Select a course...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publish Options -->
                <div style="background: var(--light-gray); padding: 1.5rem; border-radius: 12px;">
                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0 0 1rem 0;">
                        <i class="fas fa-cog"></i>
                        Publish Options
                    </h4>
                    
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <input type="checkbox" id="is_published" name="is_published" value="1" 
                               {{ old('is_published') ? 'checked' : '' }}
                               style="width: 1.25rem; height: 1.25rem;">
                        <label for="is_published" style="font-weight: 500; color: var(--text-primary); cursor: pointer;">
                            Publish immediately
                        </label>
                    </div>
                    
                    <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0.5rem 0 0 0;">
                        If checked, the announcement will be published immediately and notifications will be sent to the target audience.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                    <a href="{{ route('admin.announcements.index') }}" class="admin-btn admin-btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-save"></i>
                        Create Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetAudience = document.getElementById('target_audience');
    const courseSelection = document.getElementById('course_selection');
    const courseId = document.getElementById('course_id');
    
    function toggleCourseSelection() {
        if (targetAudience.value === 'specific_course') {
            courseSelection.style.display = 'block';
            courseId.required = true;
        } else {
            courseSelection.style.display = 'none';
            courseId.required = false;
            courseId.value = '';
        }
    }
    
    targetAudience.addEventListener('change', toggleCourseSelection);
    toggleCourseSelection(); // Run on page load
});
</script>
@endsection 