<x-app-layout>
    <div class="edu-card">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <a href="{{ route('courses.modules.videos.index', [$course, $module]) }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <span>←</span> Back to Videos
            </a>
            <div>
                <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    🎬 Upload Video
                </h1>
                <p style="color: var(--text-secondary); font-size: 1rem; margin: 0;">
                    Add a video to "{{ $module->title }}"
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('courses.modules.videos.store', [$course, $module]) }}" enctype="multipart/form-data" style="max-width: 800px;">
            @csrf
            
            <div class="edu-form-group">
                <label for="title" class="edu-form-label">
                    📝 Video Title
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="edu-form-input @error('title') error @endif" 
                    value="{{ old('title') }}" 
                    placeholder="e.g., Introduction to HTML Basics"
                    required
                >
                @error('title')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="edu-form-group">
                <label for="description" class="edu-form-label">
                    📖 Video Description
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="edu-form-input edu-form-textarea @error('description') error @endif" 
                    placeholder="Brief description of what this video covers..."
                    rows="4"
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="edu-form-group">
                <label for="video_type" class="edu-form-label">
                    🎬 Video Source <span style="color: red;">*</span>
                </label>
                <select id="video_type" name="video_type" class="edu-form-input edu-form-select @error('video_type') error @endif" required onchange="toggleVideoInput()">
                    <option value="file" {{ old('video_type', 'file') == 'file' ? 'selected' : '' }}>Upload Video File</option>
                    <option value="url" {{ old('video_type') == 'url' ? 'selected' : '' }}>External Video Link (YouTube, Vimeo, etc.)</option>
                </select>
                @error('video_type')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group" id="video_file_group" style="display: {{ old('video_type', 'file') == 'file' ? 'block' : 'none' }};">
                <label for="video_file" class="edu-form-label">
                    🎬 Video File
                </label>
                <input 
                    type="file" 
                    id="video_file" 
                    name="video_file" 
                    class="edu-form-input @error('video_file') error @endif" 
                    accept="video/*"
                >
                <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                    Supported formats: MP4, AVI, MOV, WMV, FLV, WebM (Max: 100MB)
                </div>
                @error('video_file')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group" id="video_url_group" style="display: {{ old('video_type') == 'url' ? 'block' : 'none' }};">
                <label for="video_url" class="edu-form-label">
                    🔗 Video URL
                </label>
                <input 
                    type="url" 
                    id="video_url" 
                    name="video_url" 
                    class="edu-form-input @error('video_url') error @endif" 
                    value="{{ old('video_url') }}"
                    placeholder="https://www.youtube.com/watch?v=..."
                >
                <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                    Paste a valid video link (YouTube, Vimeo, etc.)
                </div>
                @error('video_url')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <script>
                function toggleVideoInput() {
                    var type = document.getElementById('video_type').value;
                    document.getElementById('video_file_group').style.display = (type === 'file') ? 'block' : 'none';
                    document.getElementById('video_url_group').style.display = (type === 'url') ? 'block' : 'none';
                }
                document.addEventListener('DOMContentLoaded', toggleVideoInput);
            </script>

            <div class="edu-form-group">
                <label for="thumbnail" class="edu-form-label">
                    🖼️ Thumbnail (Optional)
                </label>
                <input 
                    type="file" 
                    id="thumbnail" 
                    name="thumbnail" 
                    class="edu-form-input @error('thumbnail') error @endif" 
                    accept="image/*"
                >
                <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                    JPEG, PNG, JPG, GIF (Max: 2MB)
                </div>
                @error('thumbnail')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="edu-form-group">
                    <label for="order" class="edu-form-label">
                        📊 Video Order
                    </label>
                    <input 
                        type="number" 
                        id="order" 
                        name="order" 
                        class="edu-form-input @error('order') error @endif" 
                        value="{{ old('order', $module->videos()->max('order') + 1) }}" 
                        placeholder="e.g., 1"
                        min="1"
                        required
                    >
                    <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                        Lower numbers play first
                    </div>
                    @error('order')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label for="is_published" class="edu-form-label">
                        🌐 Publication Status
                    </label>
                    <select 
                        id="is_published" 
                        name="is_published" 
                        class="edu-form-input edu-form-select @error('is_published') error @endif"
                    >
                        <option value="0" {{ old('is_published', '0') == '0' ? 'selected' : '' }}>📝 Draft - Only you can see this</option>
                        <option value="1" {{ old('is_published', '0') == '1' ? 'selected' : '' }}>🌐 Published - Students can see this</option>
                    </select>
                    @error('is_published')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                <button type="submit" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>🚀</span> Upload Video
                </button>
                <a href="{{ route('courses.modules.videos.index', [$course, $module]) }}" class="edu-btn edu-btn-secondary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>❌</span> Cancel
                </a>
            </div>
        </form>

        <!-- Tips Section -->
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                💡 Tips for Great Video Content
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📹</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Video Quality</h4>
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">Use clear audio and good lighting. HD quality (720p or higher) is recommended</p>
                </div>
                <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">⏱️</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Duration</h4>
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">Keep videos between 5-20 minutes for optimal engagement</p>
                </div>
                <div style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 12px; padding: 1rem;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🎯</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Content Structure</h4>
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">Start with an introduction, cover the main content, and end with a summary</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 