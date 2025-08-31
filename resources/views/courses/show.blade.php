<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Course Details') }}
        </h2>
    </x-slot>

    <div class="edu-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <span>←</span> Back to Courses
                    </a>
                    <span class="edu-badge {{ $course->instructor->role === 'instructor' ? 'edu-badge-instructor' : 'edu-badge-student' }}">
                        {{ ucfirst($course->instructor->role) }} Course
                    </span>
                </div>
                <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                    {{ $course->title }}
                </h1>
                <p style="color: var(--text-secondary); font-size: 1.1rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    {{ $course->description ?: 'No description available for this course.' }}
                </p>
                <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--text-secondary); font-size: 1rem;">👨‍🏫</span>
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">Instructor: {{ $course->instructor->name }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--text-secondary); font-size: 1rem;">📅</span>
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">Created {{ $course->created_at->format('M d, Y') }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--text-secondary); font-size: 1rem;">👥</span>
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">{{ $course->enrollments->count() }} students enrolled</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--text-secondary); font-size: 1rem;">📚</span>
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">{{ $course->modules->count() }} modules</span>
                    </div>
                </div>
            </div>
            @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-primary">
                        <span>📚</span> Manage Modules
                    </a>
                    <a href="{{ route('courses.edit', $course) }}" class="edu-btn edu-btn-secondary">
                        <span>✏️</span> Edit Course
                    </a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display: inline;" id="delete-course-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="edu-btn edu-btn-danger" onclick="showDeleteCourseModal()">
                            <span>🗑️</span> Delete Course
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Course Modules Section -->
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                📚 Course Modules
            </h2>
            
            @if($course->modules->count() > 0)
                <div style="display: grid; gap: 1rem;">
                    @foreach($course->modules->where('is_published', true) as $module)
                        <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                <div style="flex: 1;">
                                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                                        {{ $module->title }}
                                    </h3>
                                    @if($module->description)
                                        @php
                                            $plain = $module->description;
                                            $plain = preg_replace('/<\/div>\s*<div[^>]*>/i', "\n\n", $plain);
                                            $plain = preg_replace('/<\/?div[^>]*>/i', "\n", $plain);
                                            $plain = preg_replace('/<\/p>\s*<p[^>]*>/i', "\n\n", $plain);
                                            $plain = preg_replace('/<\/?p[^>]*>/i', "\n", $plain);
                                            $plain = preg_replace('/<strong[^>]*>(.*?)<\/strong>/i', '$1', $plain);
                                            $plain = strip_tags($plain);
                                            $plain = trim($plain);
                                            $plain = preg_replace('/\n\s*\n\s*\n/', "\n\n", $plain);
                                            $plain = preg_replace('/^\s+|\s+$/m', '', $plain);
                                        @endphp
                                        <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5; white-space: pre-line;">
                                            {{ $plain }}
                                        </p>
                                    @endif
                                    <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                        @if($module->video_type && ($module->video_path || $module->video_url))
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span style="color: var(--text-secondary); font-size: 0.875rem;">🎬</span>
                                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Video</span>
                                            </div>
                                        @endif
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">📝</span>
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">Module {{ $loop->iteration }}</span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $enrollment = $course->enrollments
                                        ->where('user_id', auth()->id())
                                        ->where('status', 'approved')
                                        ->whereNotNull('enrolled_at')
                                        ->first();
                                    $isEnrolled = $enrollment !== null;
                                @endphp
                                @if($isEnrolled || $isInstructor || auth()->user()->role === 'admin')
                                    <a href="{{ route('courses.modules.show', [$course, $module]) }}" class="edu-btn edu-btn-primary">
                                        <span>👁️</span> View Module
                                    </a>
                                @else
                                    <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-secondary); font-size: 0.875rem;">
                                        <span>🔒</span>
                                        <span>Enroll to Access</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                        No Modules Available
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 1rem;">
                        @if($isInstructor)
                            Start building your course by adding modules and videos!
                        @else
                            This course doesn't have any modules yet. Check back soon!
                        @endif
                    </p>
                    @if($isInstructor)
                        <a href="{{ route('courses.modules.create', $course) }}" class="edu-btn edu-btn-primary">
                            <span>➕</span> Add First Module
                        </a>
                    @endif
                </div>
            @endif
        </div>

        @php
            $enrollment = $course->enrollments
                ->where('user_id', auth()->id())
                ->where('status', 'approved')
                ->whereNotNull('enrolled_at')
                ->first();
            $isEnrolled = $enrollment !== null;
            // Calculate $needsCodeEntry for students who are approved but not yet fully enrolled
            $needsCodeEntry = false;
            if(auth()->user()->role === 'student' && !$isEnrolled) {
                $approvedPending = $course->enrollments
                    ->where('user_id', auth()->id())
                    ->where('status', 'approved')
                    ->whereNull('enrolled_at')
                    ->first();
                $needsCodeEntry = $approvedPending !== null;
            }
        @endphp
        {{-- Student Enrollment Status Sections --}}
        @if(auth()->user()->role === 'student')
            {{-- 1. Show Request Enrollment section ONLY if not enrolled, not pending, not approved, and not needsCodeEntry --}}
            @if(!$isEnrolled && !$enrollmentStatus && !$needsCodeEntry)
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                        🎓 Enroll in This Course
                    </h2>
                    @if(session('success'))
                        <div style="background: #d1fae5; color: #065f46; border: 1px solid #10b981; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div style="background: #fee2e2; color: #991b1b; border: 1px solid #f87171; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if(session('info'))
                        <div style="background: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                            {{ session('info') }}
                        </div>
                    @endif
                    <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 16px; padding: 2rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🚀</div>
                        <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                            Ready to Start Learning?
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                            Request enrollment in this course. The instructor will review your request and send you an enrollment code if approved.
                        </p>
                        <form method="POST" action="{{ route('courses.enroll', $course) }}" style="max-width: 300px; margin: 0 auto;">
                            @csrf
                            <button type="submit" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 0.75rem 1.5rem; margin-bottom: 1rem;">
                                <span>📧</span> Request Enrollment
                            </button>
                        </form>
                        <div style="border-top: 1px solid rgba(59, 130, 246, 0.2); padding-top: 1rem; margin-top: 1rem;">
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">
                                The instructor will be notified and will review your request.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($enrollmentStatus === 'pending')
                {{-- 2. Show "Enrollment Pending" if status is pending --}}
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                    <div style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 16px; padding: 2rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">⏳</div>
                        <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                            Enrollment Request Pending
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                            Your enrollment request has been sent to the instructor. They will review your request and send you an enrollment code if approved.
                        </p>
                        <div style="border-top: 1px solid rgba(245, 158, 11, 0.2); padding-top: 1rem; margin-top: 1rem;">
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">
                                Check your email for updates or contact the instructor directly.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($needsCodeEntry)
                {{-- 3. Show "Enrollment Approved! Enter Code" if needsCodeEntry --}}
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                    <div style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 16px; padding: 2rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
                        <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                            Enrollment Approved!
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                            Your enrollment has been approved! Check your email for the enrollment code, then use it to complete your enrollment.
                        </p>
                        <a href="{{ route('enrollments.enter-code') }}" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 0.75rem 1.5rem; margin-bottom: 1rem;">
                            <span>🔑</span> Enter Enrollment Code
                        </a>
                        <div style="border-top: 1px solid rgba(34, 197, 94, 0.2); padding-top: 1rem; margin-top: 1rem;">
                            <p style="color: var(--text-secondary); font-size: 0.9rem;">
                                Didn't receive the code? Check your spam folder or contact the instructor.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($isEnrolled)
                {{-- 4. Show Congratulations if fully enrolled --}}
                <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                    <div style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 16px; padding: 2rem; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
                        <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                            Congratulations, You Are Now Enrolled!
                        </h3>
                        <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                            You have full access to all course content and modules. Start learning now!
                        </p>
                        <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                            <span>📚</span> View All Modules
                        </a>
                    </div>
                </div>
            @endif
        @endif

        @if(auth()->user()->role === 'student' && $enrollmentStatus === 'rejected')
            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <div style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 16px; padding: 2rem; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">❌</div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                        Enrollment Request Rejected
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Your enrollment request for this course has been rejected by the instructor.
                    </p>
                    
                    <div style="border-top: 1px solid rgba(239, 68, 68, 0.2); padding-top: 1rem; margin-top: 1rem;">
                        <p style="color: var(--text-secondary); font-size: 0.9rem;">
                            Contact the instructor if you have questions about the rejection.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

<!-- Delete Course Confirmation Modal -->
<div id="deleteCourseModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:2rem; max-width:400px; margin:auto; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <h2 style="margin-bottom:1rem;">Delete Course?</h2>
        <p style="margin-bottom:2rem;">Are you sure you want to delete this course? <br>This action cannot be undone and will remove all modules, videos, and enrollments associated with this course.</p>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <button type="button" onclick="hideDeleteCourseModal()" style="padding:0.5rem 1.5rem; border-radius:8px; border:none; background:#e5e7eb; color:#374151;">Cancel</button>
            <button type="button" id="confirmDeleteCourseBtn" class="edu-btn edu-btn-danger" style="padding:0.5rem 1.5rem;">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
    function showDeleteCourseModal() {
        document.getElementById('deleteCourseModal').style.display = 'flex';
    }
    function hideDeleteCourseModal() {
        document.getElementById('deleteCourseModal').style.display = 'none';
    }
    document.getElementById('confirmDeleteCourseBtn').onclick = function() {
        document.getElementById('delete-course-form').submit();
    };
    // Optional: Close modal on background click
    document.getElementById('deleteCourseModal').addEventListener('click', function(e) {
        if (e.target === this) hideDeleteCourseModal();
    });
</script> 