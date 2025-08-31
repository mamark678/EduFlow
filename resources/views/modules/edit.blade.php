<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Module') }}
        </h2>
    </x-slot>
    <style>
        /* Copy all styles from create.blade.php here for consistency */
        .course-creation-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.08);
            overflow: hidden;
        }
        /* ... (rest of the CSS from create.blade.php) ... */
        trix-editor {
            display: block !important;
            min-height: 150px;
        }
    </style>
    <div class="edu-card">
        @if ($errors->any())
            <div class="edu-alert edu-alert-error" style="margin-bottom: 1rem;">
                <ul style="margin: 0; padding-left: 1.2em;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <span>←</span> Back to Modules
            </a>
            <div>
                <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    ✏️ Edit Module
                </h1>
                <p style="color: var(--text-secondary); font-size: 1rem; margin: 0;">
                    Edit module: "{{ $module->title }}"
                </p>
            </div>
        </div>
        <form method="POST" action="{{ route('courses.modules.update', [$course, $module]) }}" enctype="multipart/form-data" style="max-width: 800px;">
            @csrf
            @method('PUT')
            <div class="edu-form-group">
                <label for="title" class="edu-form-label">
                    📝 Module Title <span style="color: red;">*</span>
                </label>
                <input type="text" id="title" name="title" class="edu-form-input @error('title') error @endif" value="{{ old('title', $module->title) }}" required>
                @error('title')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; font-size: 0.95rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group">
                <label for="description" class="edu-form-label">
                    Module Content
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="edu-form-input edu-form-textarea @error('description') error @endif" 
                    placeholder="Enter module content..."
                    rows="6"
                    required
                >{{ old('description', $module->description) }}</textarea>
                @error('description')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="edu-form-group">
                <label for="support_file" class="edu-form-label">
                    📎 Upload Support File <span style="color: red;">*</span>
                </label>
                <input type="file" id="support_file" name="support_file" class="edu-form-input @error('support_file') error @endif" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar">
                @if($module->support_file_name)
                    <div style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.25rem;">
                        Current file: <a href="{{ asset('storage/' . $module->support_file_path) }}" target="_blank">{{ $module->support_file_name }}</a>
                    </div>
                @endif
                <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                    Supported: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, ZIP, RAR (max 50MB)
                </div>
                @error('support_file')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; font-size: 0.95rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group">
                <label for="video_type" class="edu-form-label">
                    🎬 Video Source (Optional)
                </label>
                <select id="video_type" name="video_type" class="edu-form-input edu-form-select @error('video_type') error @endif" onchange="toggleVideoInput()">
                    <option value="" {{ old('video_type', $module->video_type) == '' ? 'selected' : '' }}>No Video</option>
                    <option value="file" {{ old('video_type', $module->video_type) == 'file' ? 'selected' : '' }}>Upload Video File</option>
                    <option value="url" {{ old('video_type', $module->video_type) == 'url' ? 'selected' : '' }}>External Video Link (YouTube, Vimeo, etc.)</option>
                </select>
                @error('video_type')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group" id="video_file_group" style="display: {{ old('video_type', $module->video_type) == 'file' ? 'block' : 'none' }};">
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
                @if($module->video_path)
                    <div style="color: var(--text-secondary); font-size: 0.9rem; margin-top: 0.25rem;">
                        Current video: <a href="{{ asset('storage/' . $module->video_path) }}" target="_blank">View Video</a>
                    </div>
                @endif
                <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                    Supported formats: MP4, AVI, MOV, WMV, FLV, WebM (Max: 100MB)
                </div>
                @error('video_file')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group" id="video_url_group" style="display: {{ old('video_type', $module->video_type) == 'url' ? 'block' : 'none' }};">
                <label for="video_url" class="edu-form-label">
                    🔗 Video URL
                </label>
                <input 
                    type="url" 
                    id="video_url" 
                    name="video_url" 
                    class="edu-form-input @error('video_url') error @endif" 
                    value="{{ old('video_url', $module->video_url) }}"
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
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="edu-form-group">
                    <label for="order" class="edu-form-label">
                        📊 Module Order <span style="color: red;">*</span>
                    </label>
                    <input type="number" id="order" name="order" class="edu-form-input @error('order') error @endif" value="{{ old('order', $module->order) }}" min="1" required>
                    <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">Lower numbers appear first</div>
                    @error('order')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; font-size: 0.95rem;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="edu-form-group">
                    <label for="is_published" class="edu-form-label">
                        🌐 Publication Status
                    </label>
                    <select id="is_published" name="is_published" class="edu-form-input edu-form-select @error('is_published') error @endif">
                        <option value="0" {{ old('is_published', $module->is_published ? '1' : '0') == '0' ? 'selected' : '' }}>📝 Draft - Only you can see this</option>
                        <option value="1" {{ old('is_published', $module->is_published ? '1' : '0') == '1' ? 'selected' : '' }}>🌐 Published - Students can see this</option>
                    </select>
                    @error('is_published')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; font-size: 0.95rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                <button type="submit" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>💾</span> Save Changes
                </button>
                <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-secondary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>❌</span> Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout> 