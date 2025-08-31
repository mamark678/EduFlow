<x-app-layout>
    @if(auth()->user() && auth()->user()->role !== 'instructor')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8fdff 0%, #e8f8f5 100%);
            color: #2d5a27;
            line-height: 1.6;
            min-height: 100vh;
        }

        .student-module-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .module-header {
            background: linear-gradient(135deg, #2d5a27 0%, #1a4d50 100%);
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(45, 90, 39, 0.2);
        }

        .module-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .module-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 1rem 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb a {
            color: #14b8a6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #2d5a27;
        }

        .breadcrumb span {
            color: #6b7280;
        }

        /* Progress Bar */
        .progress-container {
            background: #e6fffa;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .progress-bar {
            background: #f1f5f9;
            border-radius: 20px;
            height: 12px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            background: linear-gradient(90deg, #14b8a6, #2d5a27);
            height: 100%;
            width: 0%;
            border-radius: 20px;
            transition: width 0.5s ease;
        }

        .progress-text {
            text-align: center;
            color: #2d5a27;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Content Area */
        .content-area {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .content-header {
            border-bottom: 3px solid #e6fffa;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .content-header h2 {
            color: #2d5a27;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .meta-item {
            background: #e6fffa;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #2d5a27;
            font-weight: 500;
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 2.5rem;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .content-section h3 {
            color: #2d5a27;
            font-size: 1.4rem;
            margin-bottom: 1rem;
            padding-left: 1rem;
            border-left: 4px solid #14b8a6;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-section .description-content {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #374151;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Interactive Elements */
        .highlight-box {
            background: linear-gradient(135deg, #f0fdfa, #e6fffa);
            border: 2px solid #14b8a6;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            position: relative;
        }

        .highlight-box::before {
            content: "💡";
            position: absolute;
            top: -12px;
            left: 20px;
            background: white;
            padding: 0 10px;
            font-size: 1.2rem;
        }

        .highlight-box h4 {
            color: #2d5a27;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
        }

        /* Media Elements */
        .media-container {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 1rem;
        }

        .media-container iframe {
            border: none;
            width: 100%;
            min-height: 400px;
            background: #f4f4f4;
        }

        .media-container video {
            width: 100%;
            height: 360px;
            border-radius: 12px;
        }

        /* Download Button */
        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #3b82f6, #1e40af);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            color: white;
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: #f8fafc;
            color: #2d5a27;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }

        .back-btn:hover {
            background: #e6fffa;
            border-color: #14b8a6;
            color: #2d5a27;
            transform: translateX(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .student-module-container {
                padding: 1rem;
            }
            
            .content-area {
                padding: 1.5rem;
            }
            
            .module-header h1 {
                font-size: 2rem;
            }
            
            .module-header {
                padding: 1.5rem;
            }
        }

        /* Animations */
        .content-section:nth-child(1) { animation-delay: 0.1s; }
        .content-section:nth-child(2) { animation-delay: 0.2s; }
        .content-section:nth-child(3) { animation-delay: 0.3s; }
        .content-section:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="student-module-container">
        <!-- Header -->
        <header class="module-header">
            <h1>
                <span style="font-size: 2rem;">📚</span>
                {{ $module->title }}
            </h1>
            <p>Explore and learn at your own pace</p>
        </header>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('courses.modules.index', $course) }}">{{ $course->title ?? 'Course' }}</a>
            <span>›</span>
            <span>{{ $module->title }}</span>
        </nav>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-text" id="progressText">Module Progress: 0% Complete</div>
        </div>

        <!-- Back Button -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('courses.show', $course) }}" class="back-btn">
                ← Back to Modules
            </a>
        </div>

        <!-- Content Area -->
        <main class="content-area">
            <div class="content-header">
                <h2>
                    <span style="font-size: 1.5rem;">📖</span>
                    Module Content
                </h2>
                <div class="content-meta">
                    <span class="meta-item">📚 Learning Material</span>
                    @if($module->support_file_path)
                        <span class="meta-item">📄 Support File Available</span>
                    @endif
                    @if(($module->video_type === 'file' && $module->video_path) || ($module->video_type === 'url' && $module->video_url))
                        <span class="meta-item">🎬 Video Content</span>
                    @endif
                </div>
            </div>

            <!-- Module Description -->
            <div class="content-section">
                <h3>
                    <span style="font-size: 1.2rem;">📝</span>
                    Overview
                </h3>
                @php
                    // Convert HTML to plain text with proper formatting
                    $plain = $module->description;
                    // Replace div tags with double newlines for paragraph spacing
                    $plain = preg_replace('/<\/div>\s*<div[^>]*>/i', "\n\n", $plain);
                    $plain = preg_replace('/<\/?div[^>]*>/i', "\n", $plain);
                    // Replace br tags with single newlines
                    $plain = preg_replace('/<br\s*\/?>/i', "\n", $plain);
                    // Replace paragraph tags with double newlines
                    $plain = preg_replace('/<\/p>\s*<p[^>]*>/i', "\n\n", $plain);
                    $plain = preg_replace('/<\/?p[^>]*>/i', "\n", $plain);
                    // Convert strong/bold tags to plain text
                    $plain = preg_replace('/<strong[^>]*>(.*?)<\/strong>/i', '$1', $plain);
                    $plain = preg_replace('/<b[^>]*>(.*?)<\/b>/i', '$1', $plain);
                    // Remove all remaining HTML tags
                    $plain = strip_tags($plain);
                    // Clean up whitespace
                    $plain = trim($plain);
                    $plain = preg_replace('/\n\s*\n\s*\n/', "\n\n", $plain); // Remove excessive newlines
                    $plain = preg_replace('/^\s+|\s+$/m', '', $plain); // Trim each line
                @endphp
                <div class="description-content" style="white-space: pre-line;">
                    {{ $plain }}
                </div>
            </div>

            <!-- Support File Section -->
            @if($module->support_file_path)
                <div class="content-section">
                    <h3>
                        <span style="font-size: 1.2rem;">📄</span>
                        Support Materials
                    </h3>
                    
                    @php
                        $ext = strtolower(pathinfo($module->support_file_name, PATHINFO_EXTENSION));
                    @endphp
                    
                    @if($ext === 'pdf')
                        <div class="highlight-box">
                            <h4>PDF Document Available</h4>
                            <p>You can view the PDF below or download it for offline reading.</p>
                        </div>
                        
                        <div class="media-container">
                            <iframe src="{{ asset('storage/' . $module->support_file_path) }}#toolbar=0" height="600"></iframe>
                        </div>
                        
                        <a href="{{ asset('storage/' . $module->support_file_path) }}" download class="download-btn">
                            <span>📥</span> Download PDF
                        </a>
                    @else
                        <div class="highlight-box">
                            <h4>Support File Available</h4>
                            <p>Click the button below to download the support file: <strong>{{ $module->support_file_name }}</strong></p>
                        </div>
                        
                        <a href="{{ asset('storage/' . $module->support_file_path) }}" download class="download-btn">
                            <span>📥</span> Download {{ $module->support_file_name }}
                        </a>
                    @endif
                </div>
            @endif

            <!-- Video Section -->
            @if($module->video_type === 'file' && $module->video_path)
                <div class="content-section">
                    <h3>
                        <span style="font-size: 1.2rem;">🎬</span>
                        Video Content
                    </h3>
                    
                    <div class="highlight-box">
                        <h4>Learning Video</h4>
                        <p>Watch the video below to enhance your understanding of this module.</p>
                    </div>
                    
                    <div class="media-container">
                        <video controls>
                            <source src="{{ asset('storage/' . $module->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            @elseif($module->video_type === 'url' && $module->video_url)
                <div class="content-section">
                    <h3>
                        <span style="font-size: 1.2rem;">🎬</span>
                        Video Content
                    </h3>
                    
                    <div class="highlight-box">
                        <h4>Learning Video</h4>
                        <p>Watch the embedded video below to enhance your understanding of this module.</p>
                    </div>
                    
                    <div class="media-container">
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                            <iframe src="{{ $module->embed_video_url }}" frameborder="0" allowfullscreen style="position: absolute; top:0; left:0; width:100%; height:100%;"></iframe>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Study Tips -->
            <div class="content-section">
                <div class="highlight-box">
                    <h4>Study Tips</h4>
                    <p>Take your time to thoroughly read through the materials. If there's a video, try watching it after reading the content to reinforce your learning. Don't hesitate to download materials for offline study!</p>
                </div>
            </div>

            {{-- Comments Section --}}
            <div class="content-section" id="comments">
                <h3>
                    <span style="font-size: 1.2rem;">💬</span>
                    Student Insights & Comments
                </h3>
                @if(session('success'))
                    <div style="background: #d1fae5; color: #065f46; border: 1px solid #10b981; border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 1rem;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="background: #fee2e2; color: #991b1b; border: 1px solid #f87171; border-radius: 8px; padding: 0.75rem 1rem; margin-bottom: 1rem;">
                        {{ session('error') }}
                    </div>
                @endif
                @if(auth()->user())
                    <form method="POST" action="{{ route('courses.modules.comments.store', [$course->id, $module->id]) }}" style="margin-bottom: 2rem;">
                        @csrf
                        <textarea name="content" rows="3" class="edu-form-input @error('content') error @enderror" placeholder="Share your thoughts or insights about this module..." required style="width: 100%; min-height: 80px; margin-bottom: 0.5rem;"></textarea>
                        @error('content')
                            <div style="color: #991b1b; font-size: 0.95rem; margin-bottom: 0.5rem;">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="edu-btn edu-btn-primary" style="padding: 0.5rem 1.5rem; font-size: 1rem;">Post Comment</button>
                    </form>
                @endif
                <div style="margin-top: 1.5rem;">
                    @forelse($module->comments()->whereNull('parent_id')->latest()->get() as $comment)
                        @include('modules.comment', ['comment' => $comment, 'module' => $module, 'course' => $course, 'depth' => 0])
                    @empty
                        <div style="color: #6b7280; font-size: 1rem;">No comments yet. Be the first to share your insight!</div>
                    @endforelse
                </div>
            </div>
        </main>
        {{-- Module Navigation and Progress Actions --}}
        <div style="display: flex; flex-direction: column; align-items: center; margin-top: 2rem; gap: 1.5rem;">
            {{-- DEBUG OUTPUT --}}
            @php
                $user = auth()->user();
                $isLastModule = !$nextModule;
            @endphp
            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; border: 1px solid #10b981; border-radius: 8px; padding: 1.25rem 2rem; font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Student Progress Bar --}}
            @if($user && $user->role !== 'instructor')
                @php
                    $publishedModules = $course->modules()->where('is_published', true)->get();
                    $totalModules = $publishedModules->count();
                    $completedModules = 0;
                    if ($totalModules > 0) {
                        $completedModules = \App\Models\ModuleProgress::where('user_id', $user->id)
                            ->whereIn('module_id', $publishedModules->pluck('id'))
                            ->whereNotNull('completed_at')
                            ->count();
                    }
                    $progressPercent = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
                @endphp
                <div style="width: 100%; max-width: 600px; margin-bottom: 1.5rem;">
                    <div style="font-weight: 600; color: #2d5a27; margin-bottom: 0.3rem;">Course Progress: {{ $progressPercent }}%</div>
                    <div style="background: #f1f5f9; border-radius: 20px; height: 16px; overflow: hidden;">
                        <div style="background: linear-gradient(90deg, #14b8a6, #2d5a27); height: 100%; width: {{ $progressPercent }}%; border-radius: 20px; transition: width 0.5s ease;"></div>
                    </div>
                </div>
            @endif
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; max-width: 600px;">
                {{-- Previous Button --}}
                @if($previousModule)
                    <a href="{{ route('courses.modules.show', [$course, $previousModule]) }}" class="back-btn">← Previous Module</a>
                @else
                    <button class="back-btn" style="opacity: 0.5; cursor: not-allowed;" title="No previous published module">← Previous Module</button>
                @endif
                {{-- Center: Message or Finish Button --}}
                <div style="flex: 1; display: flex; justify-content: center;">
                    @if($user && $user->role !== 'instructor')
                        @if(isset($progress) && $progress && $progress->completed_at)
                            <div style="background: #fef3c7; color: #92400e; border: 1px solid #fbbf24; border-radius: 8px; padding: 0.7rem 2rem; font-size: 1.1rem; font-weight: 500; margin: 0 1rem;">
                                You already finished this module.
                            </div>
                        @else
                            <form method="POST" action="{{ route('courses.modules.finish', [$course, $module]) }}">
                                @csrf
                                <button type="submit" class="edu-btn edu-btn-success" style="padding: 0.8rem 2rem; font-size: 1.1rem; font-weight: 600; border-radius: 10px; margin: 0 1rem;">
                                    {{ $isLastModule ? 'Finish & Complete Subject' : 'Finish Module' }}
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
                {{-- Next Button --}}
                @if($nextModule)
                    <a href="{{ route('courses.modules.show', [$course, $nextModule]) }}" class="back-btn">Next Module →</a>
                @else
                    <button class="back-btn" style="opacity: 0.5; cursor: not-allowed;" title="No next published module">Next Module →</button>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let progress = 0;
            const progressBar = document.getElementById('progressFill');
            const progressText = document.getElementById('progressText');
            
            // Update progress on scroll
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const maxScroll = document.body.scrollHeight - window.innerHeight;
                progress = Math.min(Math.round((scrolled / maxScroll) * 100), 100);
                
                progressBar.style.width = progress + '%';
                progressText.textContent = `Module Progress: ${progress}% Complete`;
            });
            
            // Track video watching progress
            const videos = document.querySelectorAll('video');
            videos.forEach(video => {
                video.addEventListener('play', function() {
                    console.log('Video started playing');
                });
                
                video.addEventListener('ended', function() {
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Module Progress: 100% Complete';
                });
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
        
        function toggleReplyForm(commentId) {
            const form = document.getElementById('replyForm' + commentId);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
    @else
    <!-- Original Instructor Design -->
    <div class="edu-card" style="max-width: 900px; margin: 2rem auto; box-shadow: 0 4px 24px rgba(0,0,0,0.08); border-radius: 18px; padding: 2.5rem 2rem; background: #fff; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <a href="{{ route('courses.modules.index', $course) }}" class="edu-btn edu-btn-secondary">← Back to Modules</a>
            <a href="{{ route('courses.modules.create', $course) }}" class="edu-btn" style="background: #10b981; color: #fff; font-weight: 600; box-shadow: 0 2px 8px rgba(16,185,129,0.08);">
                <span style="font-size: 1.2rem;">＋</span> Create Module
            </a>
        </div>
        <h1 class="edu-form-label" style="font-size: 2.2rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span style="font-size: 2rem;">📚</span> {{ $module->title }}
        </h1>
        <div class="edu-form-group" style="margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">Module Content</h2>
            <div class="edu-form-input" style="min-height:120px;background:#f9f9f9; border-radius: 8px; padding: 1rem;">
                @php
                    // Convert HTML to plain text with proper formatting
                    $plain = $module->description;
                    $plain = preg_replace('/<\/div>\s*<div[^>]*>/i', "\n\n", $plain);
                    $plain = preg_replace('/<\/?div[^>]*>/i', "\n", $plain);
                    $plain = preg_replace('/<br\s*\/?>/i', "\n", $plain);
                    $plain = preg_replace('/<\/p>\s*<p[^>]*>/i', "\n\n", $plain);
                    $plain = preg_replace('/<\/?p[^>]*>/i', "\n", $plain);
                    $plain = preg_replace('/<strong[^>]*>(.*?)<\/strong>/i', '$1', $plain);
                    $plain = preg_replace('/<b[^>]*>(.*?)<\/b>/i', '$1', $plain);
                    $plain = strip_tags($plain);
                    $plain = trim($plain);
                    $plain = preg_replace('/\n\s*\n\s*\n/', "\n\n", $plain);
                    $plain = preg_replace('/^\s+|\s+$/m', '', $plain);
                @endphp
                <div class="description-content" style="white-space: pre-line;">
                    {{ $plain }}
                </div>
            </div>
        </div>
        @if($module->support_file_path)
            <div class="edu-form-group" style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.3rem;">📄</span> Support File
                </h2>
                @php
                    $ext = strtolower(pathinfo($module->support_file_name, PATHINFO_EXTENSION));
                @endphp
                @if($ext === 'pdf')
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 0.5rem;">
                        <iframe src="{{ asset('storage/' . $module->support_file_path) }}#toolbar=0" width="100%" height="600" style="border: none; min-height: 400px; background: #f4f4f4;"></iframe>
                    </div>
                    <a href="{{ asset('storage/' . $module->support_file_path) }}" download class="edu-btn" style="background: #3b82f6; color: #fff; margin-top: 0.5rem;">Download PDF</a>
                @else
                    <a href="{{ asset('storage/' . $module->support_file_path) }}" download class="edu-btn" style="background: #3b82f6; color: #fff;">Download {{ $module->support_file_name }}</a>
                @endif
            </div>
        @endif
        @if($module->video_type === 'file' && $module->video_path)
            <div class="edu-form-group" style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.3rem;">🎬</span> Module Video
                </h2>
                <video width="100%" height="360" controls style="margin-top: 1rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <source src="{{ asset('storage/' . $module->video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @elseif($module->video_type === 'url' && $module->video_url)
            <div class="edu-form-group" style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 1.3rem;">🎬</span> Module Video
                </h2>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; margin-top: 1rem; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <iframe src="{{ $module->embed_video_url }}" frameborder="0" allowfullscreen style="position: absolute; top:0; left:0; width:100%; height:100%; border-radius: 12px;"></iframe>
                </div>
            </div>
        @endif
        
        {{-- Comments Section for Instructor --}}
        <div class="edu-form-group" style="margin-top: 2rem;">
            <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="font-size: 1.3rem;">💬</span> Comments & Discussion
            </h2>
            
            {{-- Instructor Comment Form --}}
            <div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1rem; font-weight: 600; color: #0c4a6e; margin-bottom: 0.5rem;">Add Instructor Comment</h3>
                <form method="POST" action="{{ route('courses.modules.comments.store', [$course->id, $module->id]) }}">
                    @csrf
                    <textarea name="content" rows="3" placeholder="Share additional insights, tips, or clarifications for students..." required style="width: 100%; padding: 0.75rem; border: 1px solid #0ea5e9; border-radius: 6px; font-size: 0.95rem; margin-bottom: 0.5rem; background: white;"></textarea>
                    <button type="submit" class="edu-btn" style="background: #0ea5e9; color: white; padding: 0.5rem 1rem; font-size: 0.9rem; border: none; border-radius: 4px; cursor: pointer;">
                        Post Comment
                    </button>
                </form>
            </div>
            
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: #374151;">Student Comments & Insights</h3>
            @if($module->comments()->count() > 0)
                <div style="background: #f8f9fa; border-radius: 10px; padding: 1.5rem;">
                    <div style="margin-bottom: 1rem; color: #6b7280; font-size: 0.9rem;">
                        {{ $module->comments()->count() }} comment(s) from students
                    </div>
                    @foreach($module->comments()->whereNull('parent_id')->latest()->get() as $comment)
                        @include('modules.comment', ['comment' => $comment, 'module' => $module, 'course' => $course, 'depth' => 0])
                    @endforeach
                </div>
            @else
                <div style="background: #f8f9fa; border-radius: 10px; padding: 1.5rem; text-align: center; color: #6b7280;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">💭</div>
                    <div style="font-size: 1rem;">No student comments yet</div>
                    <div style="font-size: 0.9rem; margin-top: 0.25rem;">Students will be able to share their insights here once they access this module</div>
                </div>
            @endif
        </div>
    </div>
    {{-- Module Navigation Buttons for Instructor --}}
    <div style="max-width: 900px; margin: 2rem auto 0 auto; display: flex; justify-content: space-between; align-items: center;">
        @if($previousModule)
            <a href="{{ route('courses.modules.show', [$course, $previousModule]) }}" class="edu-btn edu-btn-secondary">← Previous Module</a>
        @else
            <span></span>
        @endif
        @if($nextModule)
            <a href="{{ route('courses.modules.show', [$course, $nextModule]) }}" class="edu-btn edu-btn-secondary">Next Module →</a>
        @endif
    </div>
    
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('replyForm' + commentId);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
    @endif
    <!-- Custom Delete Confirmation Modal -->
    <div id="deleteModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); align-items:center; justify-content:center;">
        <div style="background:white; border-radius:12px; max-width:350px; width:90%; margin:auto; box-shadow:0 8px 32px rgba(0,0,0,0.18); padding:2rem 1.5rem; text-align:center;">
            <div style="font-size:1.2rem; font-weight:600; color:#1e293b; margin-bottom:0.5rem;">Delete Comment?</div>
            <div style="color:#64748b; font-size:1rem; margin-bottom:1.5rem;">Are you sure you want to delete this comment? This action cannot be undone.</div>
            <div style="display:flex; gap:1rem; justify-content:center;">
                <button id="deleteModalCancel" type="button" style="padding:0.6rem 1.5rem; border-radius:8px; border:none; background:#f1f5f9; color:#334155; font-weight:500; font-size:1rem; cursor:pointer;">Cancel</button>
                <button id="deleteModalConfirm" type="button" style="padding:0.6rem 1.5rem; border-radius:8px; border:none; background:#ef4444; color:white; font-weight:600; font-size:1rem; cursor:pointer;">Delete</button>
            </div>
        </div>
    </div>
    <script>
        let deleteFormToSubmit = null;
        function openDeleteModal(form) {
            deleteFormToSubmit = form;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        document.getElementById('deleteModalCancel').onclick = function() {
            document.getElementById('deleteModal').style.display = 'none';
            deleteFormToSubmit = null;
        };
        document.getElementById('deleteModalConfirm').onclick = function() {
            if (deleteFormToSubmit) deleteFormToSubmit.submit();
            document.getElementById('deleteModal').style.display = 'none';
        };
        // Optional: close modal on background click
        document.getElementById('deleteModal').onclick = function(e) {
            if (e.target === this) {
                this.style.display = 'none';
                deleteFormToSubmit = null;
            }
        };
    </script>
</x-app-layout>