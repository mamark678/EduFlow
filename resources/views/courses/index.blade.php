<x-app-layout>
    <div class="edu-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    📚 Available Courses
                </h1>
                <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0;">
                    Explore our comprehensive collection of courses designed to accelerate your learning journey
                </p>
            </div>
            @if(Auth::user()->role === 'instructor')
                <a href="{{ route('courses.create') }}" class="edu-btn edu-btn-primary">
                    <span>🚀</span> Create New Course
                </a>
            @endif
        </div>

        @if($courses->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;">
                @foreach($courses as $course)
                    <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem; transition: all 0.4s ease;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div>
                                <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                                    {{ $course->title }}
                                </h3>
                                <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                    {{ Str::limit($course->description, 120) }}
                                </p>
                            </div>
                            <span class="edu-badge {{ $course->instructor->role === 'instructor' ? 'edu-badge-instructor' : 'edu-badge-student' }}">
                                {{ ucfirst($course->instructor->role) }}
                            </span>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">👨‍🏫</span>
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">{{ $course->instructor->name }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">📅</span>
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Created {{ $course->created_at->diffForHumans() }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">👥</span>
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">{{ $course->enrollments->count() }} students enrolled</span>
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <a href="{{ route('courses.show', $course) }}" class="edu-btn edu-btn-primary" style="flex: 1; justify-content: center;">
                                <span>👁️</span> View Details
                            </a>
                            @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                                <a href="{{ route('courses.edit', $course) }}" class="edu-btn edu-btn-secondary" style="flex: 1; justify-content: center;">
                                    <span>✏️</span> Edit
                                </a>
                                <form method="POST" action="{{ route('courses.destroy', $course) }}" style="flex: 1;" id="delete-course-form-{{ $course->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="edu-btn edu-btn-danger" style="width: 100%; justify-content: center;" onclick="showDeleteCourseModal({{ $course->id }})">
                                        🗑️ Delete
                                    </button>
                                </form>
                            @elseif(auth()->user()->role === 'student')
                                @php
                                    $enrollment = $course->enrollments
                                        ->where('user_id', auth()->id())
                                        ->where('status', 'approved')
                                        ->whereNotNull('enrolled_at')
                                        ->first();
                                    $isEnrolled = $enrollment !== null;
                                @endphp
                                @if(!$isEnrolled)
                                    <form method="POST" action="{{ route('courses.enroll', $course) }}" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="edu-btn edu-btn-success" style="width: 100%; justify-content: center;">➕ Enroll</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('courses.unenroll', $course) }}" style="flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="edu-btn edu-btn-warning" style="width: 100%; justify-content: center;">🚫 Unenroll</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem 2rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                    No Courses Available
                </h3>
                <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                    {{ auth()->user()->role === 'instructor' ? 'Start creating amazing courses for your students!' : 'Check back soon for new courses from our instructors.' }}
                </p>
                @if(auth()->user()->role === 'instructor')
                    <a href="{{ route('courses.create') }}" class="edu-btn edu-btn-primary">
                        <span>🚀</span> Create Your First Course
                    </a>
                @endif
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
    let courseIdToDelete = null;
    function showDeleteCourseModal(courseId) {
        courseIdToDelete = courseId;
        document.getElementById('deleteCourseModal').style.display = 'flex';
    }
    function hideDeleteCourseModal() {
        document.getElementById('deleteCourseModal').style.display = 'none';
        courseIdToDelete = null;
    }
    document.getElementById('confirmDeleteCourseBtn').onclick = function() {
        if (courseIdToDelete) {
            document.getElementById('delete-course-form-' + courseIdToDelete).submit();
        }
    };
    // Optional: Close modal on background click
    document.getElementById('deleteCourseModal').addEventListener('click', function(e) {
        if (e.target === this) hideDeleteCourseModal();
    });
</script> 