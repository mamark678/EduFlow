@extends('admin.layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="glass-card p-8 rounded-2xl flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <span class="bg-gradient-to-br from-green-400 to-green-600 rounded-xl p-3 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </span>
                Course Management
            </h1>
            <p class="text-gray-600 mt-2 text-lg">Manage all courses, their content, and instructor assignments</p>
        </div>
        <div class="flex items-center space-x-4 text-sm text-gray-500">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>Published</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800"><span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>Draft</span>
            <a href="{{ route('admin.export.courses.csv') }}" class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Courses (CSV)
            </a>
            <a href="{{ route('admin.export.courses.pdf') }}" class="inline-flex items-center px-4 py-2 rounded-full text-xs font-semibold bg-red-100 text-red-800 hover:bg-red-200 transition-colors ml-2">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Export Courses (PDF)
            </a>
        </div>
    </div>

    <!-- Filters/Search -->
    <div class="glass-card p-6 rounded-2xl">
        <form method="GET" action="{{ route('admin.courses.index') }}" class="flex flex-col md:flex-row md:items-end gap-4 md:gap-6">
            <div class="flex-1">
                <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white/50 backdrop-blur-sm" placeholder="Search by title or description...">
            </div>
            <div>
                <label for="instructor" class="block text-sm font-semibold text-gray-700 mb-2">Instructor</label>
                <select name="instructor" id="instructor" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white/50 backdrop-blur-sm">
                    <option value="">All</option>
                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}" {{ request('instructor') == $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white/50 backdrop-blur-sm">
                    <option value="">All</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="flex items-center gap-2 mt-2 md:mt-0">
                <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-full font-semibold transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
                @if(request('search') || request('instructor') || request('status'))
                    <a href="{{ route('admin.courses.index') }}" class="text-gray-600 hover:text-gray-800 font-medium text-sm flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($courses as $course)
        <div class="glass-card p-6 rounded-2xl flex flex-col h-full shadow-lg hover:shadow-2xl transition-shadow duration-200">
            <div class="flex items-center gap-4 mb-4">
                <div class="h-14 w-14 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-xl font-bold text-gray-900 truncate max-w-xs" title="{{ $course->title }}">{{ $course->title }}</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold @if($course->is_published) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                            @if($course->is_published)
                                Published
                            @else
                                Draft
                            @endif
                        </span>
                    </div>
                    <div class="text-xs text-gray-500 mt-1 truncate max-w-xs" title="{{ $course->description }}">{{ Str::limit($course->description, 60) }}</div>
                </div>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $course->instructor->name }}</div>
                        <div class="text-xs text-gray-500">{{ $course->instructor->email }}</div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap gap-4 mb-4">
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    {{ $course->modules_count ?? 0 }} modules
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                    {{ $course->videos_count ?? 0 }} videos
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    {{ $course->documents_count ?? 0 }} documents
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    {{ $course->enrollments_count ?? 0 }} enrollments
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto">
                <a href="{{ route('courses.show', $course) }}" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-2 rounded-lg font-semibold text-xs flex items-center gap-1 transition-colors" title="View Course">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View
                </a>
                <a href="{{ route('courses.edit', $course) }}" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-2 rounded-lg font-semibold text-xs flex items-center gap-1 transition-colors" title="Edit Course">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('courses.destroy', $course) }}" class="inline" id="admin-delete-course-form-{{ $course->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-2 rounded-lg font-semibold text-xs flex items-center gap-1 transition-colors" title="Delete Course" onclick="showAdminDeleteCourseModal({{ $course->id }})">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No courses found</h3>
            <p class="text-gray-500 mb-4">Try adjusting your search criteria or filters.</p>
            <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-full font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">Back to Dashboard</a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
    <div class="flex justify-center mt-8">
        {{ $courses->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Delete Course Confirmation Modal -->
<div id="adminDeleteCourseModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:2rem; max-width:400px; margin:auto; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <h2 style="margin-bottom:1rem;">Delete Course?</h2>
        <p style="margin-bottom:2rem;">Are you sure you want to delete this course? <br>This action cannot be undone and will remove all modules, videos, and enrollments associated with this course.</p>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <button type="button" onclick="hideAdminDeleteCourseModal()" style="padding:0.5rem 1.5rem; border-radius:8px; border:none; background:#e5e7eb; color:#374151;">Cancel</button>
            <button type="button" id="adminConfirmDeleteCourseBtn" class="edu-btn edu-btn-danger" style="padding:0.5rem 1.5rem;">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
    let adminCourseIdToDelete = null;
    function showAdminDeleteCourseModal(courseId) {
        adminCourseIdToDelete = courseId;
        document.getElementById('adminDeleteCourseModal').style.display = 'flex';
    }
    function hideAdminDeleteCourseModal() {
        document.getElementById('adminDeleteCourseModal').style.display = 'none';
        adminCourseIdToDelete = null;
    }
    document.getElementById('adminConfirmDeleteCourseBtn').onclick = function() {
        if (adminCourseIdToDelete) {
            document.getElementById('admin-delete-course-form-' + adminCourseIdToDelete).submit();
        }
    };
    document.getElementById('adminDeleteCourseModal').addEventListener('click', function(e) {
        if (e.target === this) hideAdminDeleteCourseModal();
    });
</script>
@endsection 