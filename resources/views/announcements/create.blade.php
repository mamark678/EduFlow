<x-app-layout>
    <div class="edu-card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📧</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                Send Announcement
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Communicate important updates and information to your enrolled students.
            </p>
        </div>

        <form method="POST" action="{{ route('announcements.store') }}" style="max-width: 800px; margin: 0 auto;">
            @csrf
            
            <!-- Course Selection -->
            <div style="margin-bottom: 2rem;">
                <label for="course_id" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                    📚 Select Course
                </label>
                <select name="course_id" id="course_id" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: white; font-size: 1rem;">
                    <option value="">Choose a course...</option>
                    @if(isset($course))
                        <option value="{{ $course->id }}" selected>{{ $course->title }} ({{ $course->enrollments->count() }} students)</option>
                    @else
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->enrollments_count }} students)</option>
                        @endforeach
                    @endif
                </select>
                @error('course_id')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Subject -->
            <div style="margin-bottom: 2rem;">
                <label for="subject" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                    📝 Subject
                </label>
                <input type="text" name="subject" id="subject" required 
                       placeholder="Enter announcement subject..."
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: white; font-size: 1rem;"
                       value="{{ old('subject') }}">
                @error('subject')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Message -->
            <div style="margin-bottom: 2rem;">
                <label for="message" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                    💬 Message
                </label>
                <textarea name="message" id="message" rows="8" required 
                          placeholder="Write your announcement message here..."
                          style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; background: white; font-size: 1rem; resize: vertical;">{{ old('message') }}</textarea>
                @error('message')
                    <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
                <div style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.25rem;">
                    Maximum 1000 characters. <span id="char-count">0</span>/1000
                </div>
            </div>

            <!-- Preview Section -->
            <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
                <h3 style="font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">👁️ Preview</h3>
                <div style="background: white; border: 1px solid var(--border-color); border-radius: 8px; padding: 1rem;">
                    <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;" id="preview-subject">Subject will appear here...</div>
                    <div style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6;" id="preview-message">Message will appear here...</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('announcements.index') }}" class="edu-btn edu-btn-secondary" style="padding: 0.75rem 2rem;">
                    <span>←</span> Cancel
                </a>
                <button type="submit" class="edu-btn edu-btn-primary" style="padding: 0.75rem 2rem;">
                    <span>📧</span> Send Announcement
                </button>
            </div>
        </form>

        <!-- Tips Section -->
        <div style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 16px; padding: 2rem; margin-top: 3rem;">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem; text-align: center;">
                💡 Writing Effective Announcements
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">🎯 Be Clear & Concise</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">Get to the point quickly and use simple language that all students can understand.</p>
                </div>
                <div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">📅 Include Deadlines</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">If mentioning assignments or events, always include specific dates and times.</p>
                </div>
                <div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">🔗 Provide Context</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">Explain why the announcement is important and how it affects students' learning.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Character counter
        const messageTextarea = document.getElementById('message');
        const charCount = document.getElementById('char-count');
        const previewSubject = document.getElementById('preview-subject');
        const previewMessage = document.getElementById('preview-message');
        const subjectInput = document.getElementById('subject');

        messageTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            if (length > 1000) {
                charCount.style.color = '#dc2626';
            } else {
                charCount.style.color = 'var(--text-secondary)';
            }
            
            // Update preview
            previewMessage.textContent = this.value || 'Message will appear here...';
        });

        subjectInput.addEventListener('input', function() {
            previewSubject.textContent = this.value || 'Subject will appear here...';
        });
    </script>
</x-app-layout> 