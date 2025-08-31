<div class="edu-form-group">
    <label for="title" class="edu-form-label">📚 Course Title</label>
    <input type="text" name="title" id="title" class="edu-form-input" value="{{ old('title', $course->title ?? '') }}" required placeholder="Enter course title...">
    @error('title')
        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
    @enderror
</div>

<div class="edu-form-group">
    <label for="description" class="edu-form-label">📝 Course Description</label>
    <textarea name="description" id="description" class="edu-form-input edu-form-textarea" placeholder="Describe what students will learn in this course...">{{ old('description', $course->description ?? '') }}</textarea>
    @error('description')
        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
    @enderror
</div> 