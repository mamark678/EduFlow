@extends('admin.layouts.app')

@section('page-title', 'Email System')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h1 class="admin-card-title">
                <i class="fas fa-envelope"></i>
                Email System
            </h1>
            <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0;">
                Send bulk emails to users across the platform
            </p>
        </div>
    </div>

    <!-- Email Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-edit"></i>
                Compose Email
            </h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.email.send') }}" class="space-y-6">
                @csrf
                
                <!-- Subject -->
                <div>
                    <label for="subject" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Email Subject *
                    </label>
                    <input type="text" id="subject" name="subject" required
                           value="{{ old('subject') }}"
                           placeholder="Enter email subject..."
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem; transition: border-color 0.2s;">
                    @error('subject')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Email Message *
                    </label>
                    <textarea id="message" name="message" required rows="8"
                              placeholder="Enter your email message..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem; resize: vertical; transition: border-color 0.2s;">{{ old('message') }}</textarea>
                    @error('message')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recipient Type -->
                <div>
                    <label for="recipient_type" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Recipient Type *
                    </label>
                    <select id="recipient_type" name="recipient_type" required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border-light); border-radius: 8px; font-size: 1rem;">
                        <option value="">Select recipient type...</option>
                        <option value="all" {{ old('recipient_type') === 'all' ? 'selected' : '' }}>All Users</option>
                        <option value="students" {{ old('recipient_type') === 'students' ? 'selected' : '' }}>Students Only</option>
                        <option value="instructors" {{ old('recipient_type') === 'instructors' ? 'selected' : '' }}>Instructors Only</option>
                        <option value="admins" {{ old('recipient_type') === 'admins' ? 'selected' : '' }}>Admins Only</option>
                        <option value="specific_users" {{ old('recipient_type') === 'specific_users' ? 'selected' : '' }}>Specific Users</option>
                    </select>
                    @error('recipient_type')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specific Users Selection (conditional) -->
                <div id="specific_users_selection" style="display: none;">
                    <label style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                        Select Specific Users *
                    </label>
                    <div style="background: var(--light-gray); padding: 1.5rem; border-radius: 12px; max-height: 300px; overflow-y: auto;">
                        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                            @foreach($users as $user)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="checkbox" id="email_user_{{ $user->id }}" name="user_ids[]" 
                                           value="{{ $user->id }}" 
                                           {{ in_array($user->id, old('user_ids', [])) ? 'checked' : '' }}
                                           style="width: 1.25rem; height: 1.25rem;">
                                    <label for="email_user_{{ $user->id }}" style="font-weight: 500; color: var(--text-primary); cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
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
                            <button type="button" onclick="selectAllEmail()" class="admin-btn admin-btn-secondary" style="margin-right: 0.5rem;">
                                <i class="fas fa-check-double"></i>
                                Select All
                            </button>
                            <button type="button" onclick="deselectAllEmail()" class="admin-btn admin-btn-secondary">
                                <i class="fas fa-times"></i>
                                Deselect All
                            </button>
                        </div>
                    </div>
                    @error('user_ids')
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

                <!-- Recipient Count Display -->
                <div id="recipient_count" style="background: var(--light-gray); padding: 1rem; border-radius: 8px; display: none;">
                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0 0 0.5rem 0;">
                        <i class="fas fa-users"></i>
                        Recipient Information
                    </h4>
                    <p style="color: var(--text-secondary); margin: 0;">
                        This email will be sent to <span id="count_display" style="font-weight: 600; color: var(--text-primary);">0</span> recipients.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                    <button type="submit" class="admin-btn admin-btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Templates -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-file-alt"></i>
                Quick Templates
            </h3>
        </div>
        <div class="admin-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem;">
                <div style="background: var(--light-gray); padding: 1.5rem; border-radius: 12px; cursor: pointer;" 
                     onclick="useTemplate('welcome', 'Welcome to EduFlow!', 'Welcome to our learning platform. We\'re excited to have you on board!')">
                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0 0 0.5rem 0;">
                        <i class="fas fa-hand-wave"></i>
                        Welcome Message
                    </h4>
                    <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">
                        Send a warm welcome to new users
                    </p>
                </div>
                
                <div style="background: var(--light-gray); padding: 1.5rem; border-radius: 12px; cursor: pointer;" 
                     onclick="useTemplate('maintenance', 'Scheduled Maintenance Notice', 'We will be performing scheduled maintenance on our platform. Please expect some downtime.')">
                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0 0 0.5rem 0;">
                        <i class="fas fa-tools"></i>
                        Maintenance Notice
                    </h4>
                    <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">
                        Inform users about system maintenance
                    </p>
                </div>
                
                <div style="background: var(--light-gray); padding: 1.5rem; border-radius: 12px; cursor: pointer;" 
                     onclick="useTemplate('update', 'Platform Update', 'We\'ve released new features and improvements to enhance your learning experience.')">
                    <h4 style="font-weight: 600; color: var(--text-primary); margin: 0 0 0.5rem 0;">
                        <i class="fas fa-rocket"></i>
                        Feature Update
                    </h4>
                    <p style="color: var(--text-secondary); font-size: 0.875rem; margin: 0;">
                        Announce new features and updates
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientType = document.getElementById('recipient_type');
    const specificUsersSelection = document.getElementById('specific_users_selection');
    const courseSelection = document.getElementById('course_selection');
    const recipientCount = document.getElementById('recipient_count');
    const countDisplay = document.getElementById('count_display');
    
    function updateRecipientSelection() {
        specificUsersSelection.style.display = 'none';
        courseSelection.style.display = 'none';
        recipientCount.style.display = 'none';
        
        if (recipientType.value === 'specific_users') {
            specificUsersSelection.style.display = 'block';
            updateRecipientCount();
        } else if (recipientType.value === 'specific_course') {
            courseSelection.style.display = 'block';
            recipientCount.style.display = 'block';
            countDisplay.textContent = 'Course enrolled students';
        } else if (recipientType.value) {
            recipientCount.style.display = 'block';
            // You could make an AJAX call here to get the actual count
            countDisplay.textContent = 'All users in selected category';
        }
    }
    
    function updateRecipientCount() {
        const selectedUsers = document.querySelectorAll('input[name="user_ids[]"]:checked');
        recipientCount.style.display = 'block';
        countDisplay.textContent = selectedUsers.length;
    }
    
    recipientType.addEventListener('change', updateRecipientSelection);
    
    // Update count when checkboxes change
    document.querySelectorAll('input[name="user_ids[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateRecipientCount);
    });
    
    updateRecipientSelection(); // Run on page load
});

function selectAllEmail() {
    const checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = true);
    updateRecipientCount();
}

function deselectAllEmail() {
    const checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);
    updateRecipientCount();
}

function useTemplate(type, subject, message) {
    document.getElementById('subject').value = subject;
    document.getElementById('message').value = message;
}
</script>
@endsection 