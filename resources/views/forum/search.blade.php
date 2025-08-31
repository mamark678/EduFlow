<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Search EduFlow Community</h1>
                    <p class="mt-1 text-sm text-gray-500">Find posts, discussions, and more</p>
                </div>
                <a href="{{ route('forum.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    &larr; Back to Forums
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form method="GET" action="{{ route('forum.search') }}" class="mb-8">
            <div class="flex rounded-md shadow-sm">
                <input type="text" name="q" value="{{ $query ?? '' }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:ring-blue-500 focus:border-blue-500" placeholder="Search posts, topics, or users..." autofocus>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700">Search</button>
            </div>
        </form>

        @if((!isset($query) || strlen($query) === 0) && isset($forums) && $forums->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">All Forums</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
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
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @elseif(isset($forumResults) && $forumResults->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Matching Forums</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($forumResults as $forum)
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
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($results) && $results->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Search Results</h2>
            </div>
            <div class="p-6 space-y-6">
                @foreach($results as $post)
                <a href="{{ route('forum.posts.show', $post) }}" class="block group p-4 rounded-lg border border-gray-100 hover:border-blue-300 hover:bg-blue-50 transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl" style="background-color: {{ $post->forum->color ?? '#3b82f6' }}20; color: {{ $post->forum->color ?? '#3b82f6' }};">
                                {!! $post->forum->icon ?? '💬' !!}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 truncate">
                                {{ $post->title }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                {{ Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            <div class="flex items-center space-x-4 mt-2 text-xs text-gray-400">
                                <span>{{ $post->forum->name ?? 'Forum' }}</span>
                                <span>•</span>
                                <span>{{ $post->user->name ?? 'User' }}</span>
                                <span>•</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $results->links() }}
            </div>
        </div>
        @elseif((isset($query) && strlen($query) > 0) && (!isset($forumResults) || $forumResults->count() === 0))
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-search text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
            <p class="text-gray-500 mb-6">We couldn't find any posts or forums matching your search for "<span class='font-semibold'>{{ $query }}</span>".</p>
            <a href="{{ route('forum.index') }}" class="text-blue-600 hover:underline">Back to all forums</a>
        </div>
        @endif
    </div>
</div>
</x-app-layout> 