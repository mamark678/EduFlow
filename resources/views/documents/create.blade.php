<x-app-layout>
    <div class="edu-card">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <a href="{{ route('courses.modules.documents.index', [$course, $module]) }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <span>←</span> Back to Documents
            </a>
        </div>

        <div style="max-width: 800px; margin: 0 auto;">
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                📝 Add Document
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 2rem;">
                Upload a document to module: <strong>{{ $module->title }}</strong>
            </p>

            <form action="{{ route('courses.modules.documents.store', [$course, $module]) }}" method="POST" enctype="multipart/form-data" class="edu-form">
                @csrf

                <div class="edu-form-group">
                    <label for="title" class="edu-label">Document Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="edu-input" required>
                    @error('title')
                        <div class="edu-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label for="description" class="edu-label">Description</label>
                    <textarea id="description" name="description" rows="4" class="edu-textarea">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="edu-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label for="document_file" class="edu-label">Document File *</label>
                    <input type="file" id="document_file" name="document_file" class="edu-file-input" required>
                    <div style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--text-secondary);">
                        <p><strong>Supported formats:</strong> PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, ZIP, RAR</p>
                        <p><strong>Maximum size:</strong> 50MB</p>
                    </div>
                    @error('document_file')
                        <div class="edu-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label for="order" class="edu-label">Display Order</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $module->documents()->max('order') + 1) }}" class="edu-input" min="0">
                    <div style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--text-secondary);">
                        Lower numbers appear first. Leave empty to add at the end.
                    </div>
                    @error('order')
                        <div class="edu-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label class="edu-label">Publishing</label>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="edu-checkbox">
                        <label for="is_published" style="margin: 0; font-size: 0.9rem; color: var(--text-secondary);">
                            Publish immediately (make visible to students)
                        </label>
                    </div>
                    @error('is_published')
                        <div class="edu-error">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="edu-btn edu-btn-primary">
                        <span>📤</span> Upload Document
                    </button>
                    <a href="{{ route('courses.modules.documents.index', [$course, $module]) }}" class="edu-btn edu-btn-secondary">
                        <span>❌</span> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 