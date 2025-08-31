<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Module') }}
        </h2>
    </x-slot>
    <style>
        .course-creation-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.08);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .course-form {
            display: grid;
            gap: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .required-star { 
            color: #e74c3c; 
            margin-left: 0.25rem; 
        }

        .edu-form-input,
        .edu-form-select {
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .edu-form-input:focus,
        .edu-form-select:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .edu-form-input.error,
        .edu-form-select.error {
            border-color: #e74c3c;
        }

        .modules-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-top: 20px;
        }

        .modules-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modules-header h2 {
            color: #2c3e50;
            font-size: 1.8rem;
        }

        .add-module-btn {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .add-module-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .module-item {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .module-item:hover {
            border-color: #3498db;
            transform: translateY(-2px);
        }

        .module-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .module-number {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .module-actions {
            display: flex;
            gap: 10px;
        }

        .module-actions button {
            background: none;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #7f8c8d;
        }

        .module-actions button:hover {
            background: #ecf0f1;
            color: #2c3e50;
        }

        .module-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .module-full {
            grid-column: 1 / -1;
        }

        .trix-editor {
            min-height: 180px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            background: #f8f9fa;
            padding: 1rem;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .trix-editor:focus {
            border-color: #3498db;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.08);
        }

        .file-upload {
            position: relative;
            border: 2px dashed #bdc3c7;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload:hover {
            border-color: #3498db;
            background: #e3f2fd;
        }

        .file-upload.dragover {
            border-color: #2ecc71;
            background: #e8f5e8;
        }

        .file-upload input[type=file] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-content {
            pointer-events: none;
        }

        .file-upload i {
            font-size: 3rem;
            color: #bdc3c7;
            margin-bottom: 10px;
        }

        .file-upload p {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .file-upload small {
            color: #95a5a6;
        }

        .uploaded-file {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            background: #e8f5e8;
            border-radius: 5px;
            margin-top: 10px;
            border: 1px solid #27ae60;
        }

        .uploaded-file i {
            color: #27ae60;
        }

        .remove-file-btn {
            background: none;
            border: none;
            color: #e74c3c;
            cursor: pointer;
            font-size: 1.1rem;
            margin-left: auto;
        }

        .status-controls {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-top: 20px;
        }

        .status-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
            background: #bdc3c7;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: #27ae60;
        }

        .toggle-switch::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .toggle-switch.active::before {
            transform: translateX(30px);
        }

        .order-input {
            width: 80px;
            text-align: center;
        }

        .edu-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .edu-btn-primary {
            background: linear-gradient(135deg,#10b981);
            color: white;
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.3);
        }

        .edu-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
        }

        .edu-btn-secondary {
            background: #6c757d;
            color: white;
        }

        .edu-btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .save-modules-btn {
            font-size: 1.2rem;
            padding: 18px 40px;
            border-radius: 30px;
            width: 100%;
            margin-top: 30px;
        }

        .edu-alert {
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 5px;
        }

        .edu-alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .remove-module {
            background: #e74c3c !important;
            color: white !important;
        }

        .remove-module:hover {
            background: #c0392b !important;
        }

        @media (max-width: 768px) {
            .module-grid {
                grid-template-columns: 1fr;
            }
            
            .modules-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .content {
                padding: 20px;
            }
        }

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
                    📚 Create New Module
                </h1>
                <p style="color: var(--text-secondary); font-size: 1rem; margin: 0;">
                    Add a new module to "{{ $course->title }}"
                </p>
            </div>
        </div>
        <form method="POST" action="{{ route('courses.modules.store', $course) }}" enctype="multipart/form-data" style="max-width: 800px;">
            @csrf
            <div class="edu-form-group">
                <label for="title" class="edu-form-label">
                    📝 Module Title <span style="color: red;">*</span>
                </label>
                <input type="text" id="title" name="title" class="edu-form-input @error('title') error @endif" value="{{ old('title') }}" placeholder="e.g., Introduction to Web Development" required>
                @error('title')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; font-size: 0.95rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group">
                <label for="description" class="edu-form-label">
                    📖 Module Content <span style="color: red;">*</span>
                </label>
                <input id="description" type="hidden" name="description" value="{{ old('description') }}" required>
                <trix-editor input="description" placeholder="Enter module content..."></trix-editor>
                @error('description')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group">
                <label for="support_file" class="edu-form-label">
                    📎 Upload Support File <span style="color: red;">*</span>
                </label>
                <input type="file" id="support_file" name="support_file" class="edu-form-input @error('support_file') error @endif" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar" required>
                <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                    <strong>Required.</strong> Supported: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, ZIP, RAR (max 50MB)
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
                    <option value="">No Video</option>
                    <option value="file" {{ old('video_type') == 'file' ? 'selected' : '' }}>Upload Video File</option>
                    <option value="url" {{ old('video_type') == 'url' ? 'selected' : '' }}>External Video Link (YouTube, Vimeo, etc.)</option>
                </select>
                @error('video_type')
                    <div class="edu-alert edu-alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="edu-form-group" id="video_file_group" style="display: {{ old('video_type') == 'file' ? 'block' : 'none' }};">
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
                
                <!-- Video Source Attribution -->
                <div class="edu-form-group" style="margin-top: 1rem;">
                    <label for="video_source" class="edu-form-label">
                        📋 Video Source Attribution
                    </label>
                    <select id="video_source" name="video_source" class="edu-form-input edu-form-select @error('video_source') error @endif">
                        <option value="">Select video source type...</option>
                        <option value="own_content" {{ old('video_source') == 'own_content' ? 'selected' : '' }}>🎬 My own content</option>
                        <option value="with_permission" {{ old('video_source') == 'with_permission' ? 'selected' : '' }}>✅ Used with explicit permission</option>
                        <option value="fair_use" {{ old('video_source') == 'fair_use' ? 'selected' : '' }}>⚖️ Fair use for educational purposes</option>
                        <option value="public_domain" {{ old('video_source') == 'public_domain' ? 'selected' : '' }}>🌍 Public domain content</option>
                        <option value="creative_commons" {{ old('video_source') == 'creative_commons' ? 'selected' : '' }}>📄 Creative Commons licensed</option>
                    </select>
                    <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                        Please select the appropriate source type for proper attribution
                    </div>
                </div>
                
                <!-- Creator Attribution -->
                <div class="edu-form-group" style="margin-top: 1rem;">
                    <label for="video_creator" class="edu-form-label">
                        👤 Video Creator/Credit
                    </label>
                    <input 
                        type="text" 
                        id="video_creator" 
                        name="video_creator" 
                        class="edu-form-input @error('video_creator') error @endif" 
                        value="{{ old('video_creator') }}"
                        placeholder="e.g., John Doe, Tech Channel, etc."
                    >
                    <div style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 0.25rem;">
                        Please credit the original creator of the video
                    </div>
                </div>
                
                <!-- Copyright Disclaimer -->
                <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 1rem; margin-top: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <span style="font-size: 1.2rem;">⚠️</span>
                        <strong style="color: #856404;">Copyright Notice</strong>
                    </div>
                    <p style="color: #856404; font-size: 0.9rem; margin: 0; line-height: 1.4;">
                        By adding an external video URL, you confirm that you have the right to use this content for educational purposes. 
                        Only embed videos you own, have permission to use, or are covered under fair use for education. 
                        You are responsible for ensuring compliance with copyright laws and YouTube's Terms of Service.
                    </p>
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
                    <input type="number" id="order" name="order" class="edu-form-input @error('order') error @endif" value="{{ old('order', $course->modules()->max('order') + 1) }}" min="1" required>
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
                        <option value="0" {{ old('is_published', '0') == '0' ? 'selected' : '' }}>📝 Draft - Only you can see this</option>
                        <option value="1" {{ old('is_published', '0') == '1' ? 'selected' : '' }}>🌐 Published - Students can see this</option>
                    </select>
                    @error('is_published')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; font-size: 0.95rem;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                <button type="submit" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>🚀</span> Create Module
                </button>
                <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-secondary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>❌</span> Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>