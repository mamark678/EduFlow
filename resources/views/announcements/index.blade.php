<x-app-layout>
    <div class="edu-card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📧</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                Announcements
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Communicate with your students and keep them updated about your courses.
            </p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 1rem; margin-bottom: 2rem; color: #065f46;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.2rem;">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 1rem; margin-bottom: 2rem; color: #991b1b;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.2rem;">❌</span>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Quick Action -->
        <div style="margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary);">
                    📤 Send New Announcement
                </h2>
                <a href="{{ route('announcements.create') }}" class="edu-btn edu-btn-primary">
                    <span>📧</span> Create Announcement
                </a>
            </div>
        </div>

        <!-- Course List -->
        <div style="margin-bottom: 3rem;">
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                📚 Your Courses
            </h2>
            
            @if($courses->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    @foreach($courses as $course)
                        <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem; transition: all 0.4s ease;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                <div style="flex: 1;">
                                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                                        {{ $course->title }}
                                    </h3>
                                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                        {{ Str::limit($course->description, 100) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Course Stats -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                                <div style="text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $course->enrollments_count }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Enrolled Students</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $course->modules->count() }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Modules</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $course->created_at->diffForHumans() }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Created</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 1rem;">
                                <a href="{{ route('announcements.create', $course) }}" class="edu-btn edu-btn-primary" style="flex: 1; justify-content: center; padding: 0.75rem;">
                                    <span>📧</span> Send Announcement
                                </a>
                                <a href="{{ route('courses.show', $course) }}" class="edu-btn edu-btn-secondary" style="flex: 1; justify-content: center; padding: 0.75rem;">
                                    <span>👁️</span> View Course
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                        No Courses Created Yet
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Create your first course to start sending announcements to students!
                    </p>
                    <a href="{{ route('courses.create') }}" class="edu-btn edu-btn-primary">
                        <span>🚀</span> Create Your First Course
                    </a>
                </div>
            @endif
        </div>

        <!-- Tips Section -->
        <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); border-radius: 16px; padding: 2rem;">
            <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem; text-align: center;">
                💡 Announcement Tips
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📝</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Keep it Clear</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">Write clear, concise messages that students can easily understand.</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">⏰</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Timing Matters</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">Send announcements at appropriate times when students are most likely to see them.</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🎯</div>
                    <h4 style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">Be Specific</h4>
                    <p style="color: var(--text-secondary); font-size: 0.9rem;">Include specific details about assignments, deadlines, or course updates.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 