<x-app-layout>
    <div class="edu-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <a href="{{ route('courses.show', $course) }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <span>←</span> Back to Course
                    </a>
                </div>
                @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                    <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        📚 Manage Modules
                    </h1>
                    <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0;">
                        Organize your course content with modules and videos
                    </p>
                @else
                    <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                        📚 Course Modules
                    </h1>
                    <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0;">
                        Explore the course content and start learning
                    </p>
                @endif
            </div>
            @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                <a href="{{ route('courses.modules.create', $course) }}" class="edu-btn edu-btn-primary">
                    <span>➕</span> Add Module
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="edu-alert edu-alert-success" style="margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($modules->count() > 0)
            <div style="display: grid; gap: 1.5rem;">
                @foreach($modules as $module)
                    <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                    <div style="background: rgba(59, 130, 246, 0.1); border-radius: 8px; padding: 0.5rem; font-size: 1.25rem;">
                                        📚
                                    </div>
                                    <div>
                                        <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">
                                            {{ $module->title }}
                                        </h3>
                                        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                            @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                                                <span class="edu-badge {{ $module->is_published ? 'edu-badge-success' : 'edu-badge-warning' }}" style="font-size: 0.75rem;">
                                                    {{ $module->is_published ? 'Published' : 'Draft' }}
                                                </span>
                                                <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                                    Order: {{ $module->order }}
                                                </span>
                                            @else
                                                <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                                    Module {{ $loop->iteration }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if($module->description)
                                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                        {{ $module->description }}
                                    </p>
                                @endif

                                <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="color: var(--text-secondary); font-size: 0.875rem;">📅</span>
                                        <span style="color: var(--text-secondary); font-size: 0.875rem;">Created {{ $module->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                                <a href="{{ route('courses.modules.show', [$course, $module]) }}" class="edu-btn edu-btn-view" style="background: #3b82f6; color: white;">
                                    <span>👁️</span> View
                                </a>
                                @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                                    <a href="{{ route('courses.modules.edit', [$course, $module]) }}" class="edu-btn edu-btn-secondary">
                                        <span>✏️</span> Edit
                                    </a>
                                    <form action="{{ route('courses.modules.destroy', [$course, $module]) }}" method="POST" style="display: inline;" id="delete-form-{{ $module->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="edu-btn edu-btn-danger" onclick="showDeleteModal({{ $module->id }})">
                                            <span>🗑️</span> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Videos Preview -->
                        @if($module->videos->count() > 0)
                            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                                <h4 style="font-family: 'Poppins', sans-serif; font-size: 1rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                                    📹 Videos in this module:
                                </h4>
                                <div style="display: grid; gap: 0.75rem;">
                                    @foreach($module->videos->take(3) as $video)
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: rgba(0, 0, 0, 0.02); border-radius: 8px;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <span style="color: var(--text-secondary); font-size: 1rem;">🎬</span>
                                                <div>
                                                    <div style="font-size: 0.9rem; font-weight: 500; color: var(--text-primary);">
                                                        {{ $video->title }}
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.25rem;">
                                                        @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                                                            <span class="edu-badge {{ $video->is_published ? 'edu-badge-success' : 'edu-badge-warning' }}" style="font-size: 0.7rem;">
                                                                {{ $video->is_published ? 'Published' : 'Draft' }}
                                                            </span>
                                                        @endif
                                                        @if($video->duration)
                                                            <span style="color: var(--text-secondary); font-size: 0.75rem;">
                                                                {{ $video->formatted_duration }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                                                <a href="{{ route('courses.modules.videos.edit', [$course, $module, $video]) }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                                                    <span>✏️</span> Edit
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if($module->videos->count() > 3)
                                        <div style="text-align: center; padding: 0.5rem; color: var(--text-secondary); font-size: 0.875rem;">
                                            + {{ $module->videos->count() - 3 }} more videos
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem 2rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                @if(auth()->user()->role === 'instructor' && auth()->user()->id === $course->instructor_id)
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                        No Modules Yet
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                        Start building your course by creating modules. Each module can contain multiple videos and content.
                    </p>
                    <a href="{{ route('courses.modules.create', $course) }}" class="edu-btn edu-btn-primary">
                        <span>🚀</span> Create Your First Module
                    </a>
                @else
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                        No Modules Available
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                        This course doesn't have any modules yet. Check back soon for new content!
                    </p>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:2rem; max-width:400px; margin:auto; text-align:center; box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <h2 style="margin-bottom:1rem;">Delete Module?</h2>
        <p style="margin-bottom:2rem;">Are you sure you want to delete this module? <br>This will also delete all videos in this module.</p>
        <div style="display: flex; justify-content: center; gap: 1rem;">
            <button type="button" onclick="hideDeleteModal()" style="padding:0.5rem 1.5rem; border-radius:8px; border:none; background:#e5e7eb; color:#374151;">Cancel</button>
            <button type="button" id="confirmDeleteBtn" class="edu-btn edu-btn-danger" style="padding:0.5rem 1.5rem;">Yes, Delete</button>
        </div>
    </div>
</div>

<script>
    let moduleIdToDelete = null;
    function showDeleteModal(moduleId) {
        moduleIdToDelete = moduleId;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    function hideDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        moduleIdToDelete = null;
    }
    document.getElementById('confirmDeleteBtn').onclick = function() {
        if (moduleIdToDelete) {
            document.getElementById('delete-form-' + moduleIdToDelete).submit();
        }
    };
    // Optional: Close modal on background click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) hideDeleteModal();
    });
</script> 