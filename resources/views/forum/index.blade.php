<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">EduFlow Community</h1>
                    <p class="mt-1 text-sm text-gray-500">Connect, learn, and grow with fellow students and instructors</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('forum.search') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </a>
                    <a href="{{ route('forum.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Forum
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Forums Grid -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Forums</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($forums as $forum)
                            <a href="{{ route('forum.show', $forum) }}" class="group block p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl" style="background-color: {{ $forum->color }}20; color: {{ $forum->color }};">
                                            {!! $forum->icon !!}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 truncate">
                                            {{ $forum->name }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                            {{ $forum->description }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2 text-xs text-gray-400">
                                            <span>{{ $forum->posts_count }} posts</span>
                                            <span>{{ $forum->comments_count }} comments</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Trending Posts -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900">🔥 Trending</h3>
                    </div>
                    <div class="p-4">
                        @forelse($trendingPosts as $post)
                        <div class="mb-4 last:mb-0">
                            <a href="{{ route('forum.posts.show', $post) }}" class="block group">
                                <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 line-clamp-2">
                                    {{ $post->title }}
                                </h4>
                                <div class="flex items-center space-x-2 mt-1 text-xs text-gray-500">
                                    <span>{{ $post->forum->name }}</span>
                                    <span>•</span>
                                    <span>{{ $post->score }} points</span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">No trending posts yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900">📝 Recent Posts</h3>
                    </div>
                    <div class="p-4">
                        @forelse($recentPosts as $post)
                        <div class="mb-4 last:mb-0">
                            <a href="{{ route('forum.posts.show', $post) }}" class="block group">
                                <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 line-clamp-2">
                                    {{ $post->title }}
                                </h4>
                                <div class="flex items-center space-x-2 mt-1 text-xs text-gray-500">
                                    <span>{{ $post->forum->name }}</span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">No recent posts yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout> 