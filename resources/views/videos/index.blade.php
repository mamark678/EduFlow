<x-app-layout>
    <div class="edu-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <span>←</span> Back to Modules
                    </a>
                </div>
                <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    🎬 Manage Videos
                </h1>
                <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0;">
                    Module: {{ $module->title }}
                </p>
            </div>
            <a href="{{ route('courses.modules.videos.create', [$course, $module]) }}" class="edu-btn edu-btn-primary">
                <span>➕</span> Add Video
            </a>
        </div>

        @if(session('success'))
            <div class="edu-alert edu-alert-success" style="margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($videos->count() > 0)
            <div style="display: grid; gap: 1.5rem;">
                @foreach($videos as $video)
                    <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                    <div style="background: rgba(239, 68, 68, 0.1); border-radius: 8px; padding: 0.5rem; font-size: 1.25rem;">
                                        🎬
                                    </div>
                                    <div>
                                        <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.25rem;">
                                            {{ $video->title }}
                                        </h3>
                                        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                            <span class="edu-badge {{ $video->is_published ? 'edu-badge-success' : 'edu-badge-warning' }}" style="font-size: 0.75rem;">
                                                {{ $video->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                            <span class="edu-badge {{ $video->video_type === 'file' ? 'edu-badge-primary' : 'edu-badge-secondary' }}" style="font-size: 0.75rem;">
                                                {{ ucfirst($video->video_type) }}
                                            </span>
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                                Order: {{ $video->order }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($video->description)
                                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                        {{ $video->description }}
                                    </p>
                                @endif

                                <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                                    @if($video->duration)
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">⏱️</span>
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">{{ $video->formatted_duration }}</span>
                                        </div>
                                    @endif
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span style="color: var(--text-secondary); font-size: 0.875rem;">📅</span>
                                        <span style="color: var(--text-secondary); font-size: 0.875rem;">Created {{ $video->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($video->video_type === 'url')
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">🔗</span>
                                            <span style="color: var(--text-secondary); font-size: 0.875rem;">External URL</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                                <a href="{{ route('courses.modules.videos.show', [$course, $module, $video]) }}" class="edu-btn edu-btn-primary">
                                    <span>👁️</span> View
                                </a>
                                <a href="{{ route('courses.modules.videos.edit', [$course, $module, $video]) }}" class="edu-btn edu-btn-secondary">
                                    <span>✏️</span> Edit
                                </a>
                                <form action="{{ route('courses.modules.videos.destroy', [$course, $module, $video]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="edu-btn edu-btn-danger" onclick="return confirm('Are you sure you want to delete this video? This action cannot be undone.')">
                                        <span>🗑️</span> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 3rem 2rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🎬</div>
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                    No Videos Yet
                </h3>
                <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
                    Start adding videos to this module. You can upload video files or add external video links from YouTube, Vimeo, or other platforms.
                </p>
                <a href="{{ route('courses.modules.videos.create', [$course, $module]) }}" class="edu-btn edu-btn-primary">
                    <span>🚀</span> Add Your First Video
                </a>
            </div>
        @endif
    </div>
</x-app-layout> 