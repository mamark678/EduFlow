<x-app-layout>
    <div class="edu-card">
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📊</div>
            <h1 style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem;">
                My Learning Progress
            </h1>
            <p style="color: var(--text-secondary); font-size: 1.1rem; margin: 0; max-width: 600px; margin-left: auto; margin-right: auto;">
                Track your progress across all enrolled courses and celebrate your achievements!
            </p>
        </div>

        <!-- Overall Progress Summary -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 2rem; margin-bottom: 3rem; color: white;">
            <div style="text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Overall Progress</h2>
                <div style="font-size: 4rem; font-weight: 700; margin-bottom: 1rem;">{{ $overallProgress }}%</div>
                <p style="font-size: 1.1rem; opacity: 0.9;">Across {{ $totalCourses }} enrolled course{{ $totalCourses !== 1 ? 's' : '' }}</p>
            </div>
        </div>

        <!-- Course Progress Cards -->
        <div style="margin-bottom: 3rem;">
            <h2 style="font-family: 'Poppins', sans-serif; font-size: 1.75rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem;">
                📚 Course Progress
            </h2>
            
            @if(count($progressData) > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                    @foreach($progressData as $data)
                        <div class="edu-card" style="margin-bottom: 0; padding: 1.5rem; transition: all 0.4s ease;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                <div style="flex: 1;">
                                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                                        {{ $data['course']->title }}
                                    </h3>
                                    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5;">
                                        {{ Str::limit($data['course']->description, 100) }}
                                    </p>
                                </div>
                                @if($data['is_completed'])
                                    <span class="edu-badge" style="background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                        ✅ Completed
                                    </span>
                                @endif
                            </div>

                            <!-- Progress Bar -->
                            <div style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Progress</span>
                                    <span style="color: var(--text-primary); font-size: 0.9rem; font-weight: 600;">{{ $data['progress_percentage'] }}%</span>
                                </div>
                                <div style="background: #f1f5f9; border-radius: 20px; height: 8px; overflow: hidden;">
                                    <div style="background: linear-gradient(90deg, #667eea, #764ba2); height: 100%; width: {{ $data['progress_percentage'] }}%; border-radius: 20px; transition: width 0.5s ease;"></div>
                                </div>
                            </div>

                            <!-- Course Stats -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                                <div style="text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $data['completed_modules'] }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Completed</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $data['total_modules'] }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Total Modules</div>
                                </div>
                                <div style="text-align: center;">
                                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $data['enrollment']->created_at->diffForHumans() }}</div>
                                    <div style="color: var(--text-secondary); font-size: 0.8rem;">Enrolled</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div style="display: flex; gap: 1rem;">
                                <a href="{{ route('courses.show', $data['course']) }}" class="edu-btn edu-btn-primary" style="flex: 1; justify-content: center; padding: 0.75rem;">
                                    <span>📖</span> Continue Learning
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 3rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1rem;">
                        No Courses Enrolled Yet
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Start your learning journey by enrolling in courses that interest you!
                    </p>
                    <a href="{{ route('courses.index') }}" class="edu-btn edu-btn-primary">
                        <span>🔍</span> Browse Courses
                    </a>
                </div>
            @endif
        </div>

        <!-- Achievement Summary -->
        @if(count($progressData) > 0)
            <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 16px; padding: 2rem;">
                <h3 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; font-weight: 600; color: var(--text-primary); margin-bottom: 1.5rem; text-align: center;">
                    🏆 Achievement Summary
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📚</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $totalCourses }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">Courses Enrolled</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">✅</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ collect($progressData)->where('is_completed', true)->count() }}</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">Courses Completed</div>
                    </div>
                    <div>
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📊</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary);">{{ $overallProgress }}%</div>
                        <div style="color: var(--text-secondary); font-size: 0.9rem;">Average Progress</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 