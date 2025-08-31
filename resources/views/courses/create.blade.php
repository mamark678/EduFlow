<x-app-layout>
    <div class="edu-card">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                <span>←</span> Back to Courses
            </a>
            <div>
                <h1 style="font-family: 'Poppins', sans-serif; font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
                    🚀 Create New Course
                </h1>
                <p style="color: var(--text-secondary); font-size: 1rem; margin: 0;">
                    Design an engaging course that will inspire and educate your students
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('courses.store') }}" style="max-width: 800px;">
            @csrf
            
            <div class="edu-form-group">
                <label for="title" class="edu-form-label">
                    📝 Course Title
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="edu-form-input @error('title') error @endif" 
                    value="{{ old('title') }}" 
                    placeholder="Enter a compelling course title..."
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
                    📖 Course Description
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="edu-form-input edu-form-textarea @error('description') error @endif" 
                    placeholder="Describe what students will learn in this course..."
                    rows="6"
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="edu-form-group">
                    <label for="category" class="edu-form-label">
                        🏷️ Course Category
                    </label>
                    <select 
                        id="category" 
                        name="category" 
                        class="edu-form-input edu-form-select @error('category') error @endif"
                        required
                    >
                        <option value="">Select a category...</option>
                        <option value="programming" {{ old('category') == 'programming' ? 'selected' : '' }}>💻 Programming & Development</option>
                        <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>🎨 Design & Creative</option>
                        <option value="business" {{ old('category') == 'business' ? 'selected' : '' }}>💼 Business & Entrepreneurship</option>
                        <option value="marketing" {{ old('category') == 'marketing' ? 'selected' : '' }}>📈 Marketing & Sales</option>
                        <option value="languages" {{ old('category') == 'languages' ? 'selected' : '' }}>🌍 Languages & Communication</option>
                        <option value="science" {{ old('category') == 'science' ? 'selected' : '' }}>🔬 Science & Technology</option>
                        <option value="health" {{ old('category') == 'health' ? 'selected' : '' }}>🏥 Health & Wellness</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>📚 Other</option>
                    </select>
                    @error('category')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label for="difficulty" class="edu-form-label">
                        📊 Difficulty Level
                    </label>
                    <select 
                        id="difficulty" 
                        name="difficulty" 
                        class="edu-form-input edu-form-select @error('difficulty') error @endif"
                        required
                    >
                        <option value="">Select difficulty...</option>
                        <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>🟢 Beginner - No prior experience needed</option>
                        <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>🟡 Intermediate - Some background knowledge required</option>
                        <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>🔴 Advanced - Extensive experience recommended</option>
                    </select>
                    @error('difficulty')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="edu-form-group">
                    <label for="duration" class="edu-form-label">
                        ⏱️ Estimated Duration (hours)
                    </label>
                    <input 
                        type="number" 
                        id="duration" 
                        name="duration" 
                        class="edu-form-input @error('duration') error @endif" 
                        value="{{ old('duration') }}" 
                        placeholder="e.g., 20"
                        min="1"
                        max="500"
                        required
                    >
                    @error('duration')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="edu-form-group">
                    <label for="max_students" class="edu-form-label">
                        👥 Maximum Students
                    </label>
                    <input 
                        type="number" 
                        id="max_students" 
                        name="max_students" 
                        class="edu-form-input @error('max_students') error @endif" 
                        value="{{ old('max_students', 50) }}" 
                        placeholder="e.g., 50"
                        min="1"
                        max="1000"
                        required
                    >
                    @error('max_students')
                        <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="edu-form-group">
                <label for="prerequisites" class="edu-form-label">
                    📋 Prerequisites
                </label>
                <textarea 
                    id="prerequisites" 
                    name="prerequisites" 
                    class="edu-form-input edu-form-textarea @error('prerequisites') error @endif" 
                    placeholder="List any prerequisites or requirements for this course..."
                    rows="3"
                >{{ old('prerequisites') }}</textarea>
                @error('prerequisites')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="edu-form-group">
                <label for="learning_objectives" class="edu-form-label">
                    🎯 Learning Objectives
                </label>
                <textarea 
                    id="learning_objectives" 
                    name="learning_objectives" 
                    class="edu-form-input edu-form-textarea @error('learning_objectives') error @endif" 
                    placeholder="What will students be able to do after completing this course?"
                    rows="4"
                    required
                >{{ old('learning_objectives') }}</textarea>
                @error('learning_objectives')
                    <div class="edu-alert edu-alert-error" style="margin-top: 0.5rem; padding: 0.75rem 1rem; font-size: 0.875rem;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                <button type="submit" class="edu-btn edu-btn-primary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>🚀</span> Create Course
                </button>
                <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-secondary" style="font-size: 1rem; padding: 1rem 2rem;">
                    <span>❌</span> Cancel
                </a>
            </div>
        </form>

        <!-- Course Creation Tips -->
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                💡 Course Creation Tips
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 12px; padding: 1.5rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📝</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Clear Title</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Choose a descriptive title that clearly communicates what students will learn.</p>
                </div>
                <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 1.5rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎯</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Learning Objectives</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Define clear, measurable outcomes that students can achieve.</p>
                </div>
                <div style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 12px; padding: 1.5rem;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📊</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Appropriate Difficulty</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">Set the right difficulty level to match your target audience.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 