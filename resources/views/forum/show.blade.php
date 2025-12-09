<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-2xl forum-header-bg forum-header-text">
                        {!! $forum->icon !!}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $forum->name }}</h1>
                        <p class="mt-1 text-sm text-gray-500">{{ $forum->description }}</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('forum.create-post') }}?forum={{ $forum->id }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Post
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Sort Options -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Posts</h2>
                            <div class="flex space-x-1">
                                <a href="{{ route('forum.show', $forum) }}?sort=hot" class="px-3 py-1 text-sm rounded-md {{ $sort === 'hot' ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                                    Hot
                                </a>
                                <a href="{{ route('forum.show', $forum) }}?sort=new" class="px-3 py-1 text-sm rounded-md {{ $sort === 'new' ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                                    New
                                </a>
                                <a href="{{ route('forum.show', $forum) }}?sort=top" class="px-3 py-1 text-sm rounded-md {{ $sort === 'top' ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                                    Top
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pinned Posts -->
                @if($pinnedPosts->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Pinned Posts
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($pinnedPosts as $post)
                        <div class="p-6">
                            <div class="flex space-x-3">
                                <!-- Vote Column -->
                                <div class="flex flex-col items-center space-y-1">
                                    <button onclick="vote('App\\Models\\ForumPost', '{{ $post->id }}', 'upvote')"
                                            class="vote-btn upvote-btn {{ $post->userVote() && $post->userVote()->vote_type === 'upvote' ? 'voted' : '' }}"
                                            data-votable-type="App\Models\ForumPost"
                                            data-votable-id="{{ $post->id }}"
                                            data-vote-type="upvote">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <span class="vote-score text-sm font-medium" id="score-{{ $post->id }}">{{ $post->upvotes - $post->downvotes }}</span>
                                    <button onclick="vote('App\\Models\\ForumPost', '{{ $post->id }}', 'downvote')"
                                            class="vote-btn downvote-btn {{ $post->userVote() && $post->userVote()->vote_type === 'downvote' ? 'voted' : '' }}"
                                            data-votable-type="App\Models\ForumPost"
                                            data-votable-id="{{ $post->id }}"
                                            data-vote-type="downvote">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Post Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                                        <span class="font-medium text-gray-900">{{ $post->user->name }}</span>
                                        <span>•</span>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        @if($post->is_nsfw)
                                        <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs">NSFW</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('forum.posts.show', $post) }}" class="block group">
                                        <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-600 mb-2">
                                            {{ $post->title }}
                                        </h3>
                                        @if($post->type === 'text')
                                        <p class="text-gray-600 line-clamp-3">{{ Str::limit($post->content, 200) }}</p>
                                        @elseif($post->type === 'link')
                                        <div class="flex items-center space-x-2 text-blue-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $post->link_url }}</span>
                                        </div>
                                        @elseif($post->type === 'image')
                                        <div class="mt-2">
                                            <img src="{{ $post->image_url }}" alt="Post image" class="max-w-full h-32 object-cover rounded">
                                        </div>
                                        @endif
                                    </a>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <a href="{{ route('forum.posts.show', $post) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <span>{{ $post->comments_count }} comments</span>
                                        </a>
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>{{ $post->views }} views</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Regular Posts -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="divide-y divide-gray-200">
                        @forelse($posts as $post)
                        <div class="p-6">
                            <div class="flex space-x-3">
                                <!-- Vote Column -->
                                <div class="flex flex-col items-center space-y-1">
                                    <button onclick="vote('App\\Models\\ForumPost', '{{ $post->id }}', 'upvote')"
                                            class="vote-btn upvote-btn {{ $post->userVote() && $post->userVote()->vote_type === 'upvote' ? 'voted' : '' }}"
                                            data-votable-type="App\Models\ForumPost"
                                            data-votable-id="{{ $post->id }}"
                                            data-vote-type="upvote">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <span class="vote-score text-sm font-medium" id="score-{{ $post->id }}">{{ $post->upvotes - $post->downvotes }}</span>
                                    <button onclick="vote('App\\Models\\ForumPost', '{{ $post->id }}', 'downvote')"
                                            class="vote-btn downvote-btn {{ $post->userVote() && $post->userVote()->vote_type === 'downvote' ? 'voted' : '' }}"
                                            data-votable-type="App\Models\ForumPost"
                                            data-votable-id="{{ $post->id }}"
                                            data-vote-type="downvote">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Post Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                                        <span class="font-medium text-gray-900">{{ $post->user->name }}</span>
                                        <span>•</span>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                        @if($post->is_nsfw)
                                        <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs">NSFW</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('forum.posts.show', $post) }}" class="block group">
                                        <h3 class="text-lg font-medium text-gray-900 group-hover:text-blue-600 mb-2">
                                            {{ $post->title }}
                                        </h3>
                                        @if($post->type === 'text')
                                        <p class="text-gray-600 line-clamp-3">{{ Str::limit($post->content, 200) }}</p>
                                        @elseif($post->type === 'link')
                                        <div class="flex items-center space-x-2 text-blue-600">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm">{{ $post->link_url }}</span>
                                        </div>
                                        @elseif($post->type === 'image')
                                        <div class="mt-2">
                                            <img src="{{ $post->image_url }}" alt="Post image" class="max-w-full h-32 object-cover rounded">
                                        </div>
                                        @endif
                                    </a>
                                    <div class="flex items-center space-x-4 mt-3 text-sm text-gray-500">
                                        <a href="{{ route('forum.posts.show', $post) }}" class="flex items-center space-x-1 hover:text-gray-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <span>{{ $post->comments_count }} comments</span>
                                        </a>
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>{{ $post->views }} views</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No posts yet</h3>
                            <p class="text-gray-500 mb-6">Be the first to start a discussion in this forum!</p>
                            <a href="{{ route('forum.create-post') }}?forum={{ $forum->id }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Create Post
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">About {{ $forum->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $forum->description }}</p>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Posts</span>
                            <span class="font-medium">{{ $forum->posts_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Comments</span>
                            <span class="font-medium">{{ $forum->comments_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Created</span>
                            <span class="font-medium">{{ $forum->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.forum-header-bg {
    background-color: {{ $forum->color ?: '#000000' }};
    opacity: 0.125;
}

.forum-header-text {
    color: {{ $forum->color ?: '#000000' }};
}

.vote-btn {
    padding: 0.25rem;
    border-radius: 0.25rem;
    color: #6b7280;
}

.vote-btn:hover {
    background-color: #f3f4f6;
    color: #374151;
    transition: background-color 200ms, color 200ms;
}

.vote-btn.upvote-btn.voted {
    color: #059669;
}

.vote-btn.downvote-btn.voted {
    color: #dc2626;
}

.vote-score {
    color: #374151;
    min-width: 1.5rem;
    text-align: center;
}
</style>

<script>
function vote(votableType, votableId, voteType) {
    fetch('{{ route("forum.vote") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            votable_type: votableType,
            votable_id: votableId,
            vote_type: voteType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the score
            const scoreElement = document.getElementById(`score-${votableId}`);
            if (scoreElement) {
                scoreElement.textContent = data.score;
            }
            
            // Update button states
            const upvoteBtn = document.querySelector(`[data-votable-id="${votableId}"][data-vote-type="upvote"]`);
            const downvoteBtn = document.querySelector(`[data-votable-id="${votableId}"][data-vote-type="downvote"]`);
            
            if (upvoteBtn && downvoteBtn) {
                // Remove voted class from both buttons
                upvoteBtn.classList.remove('voted');
                downvoteBtn.classList.remove('voted');
                
                // Add voted class to the appropriate button
                if (data.user_vote === 'upvote') {
                    upvoteBtn.classList.add('voted');
                } else if (data.user_vote === 'downvote') {
                    downvoteBtn.classList.add('voted');
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
</x-app-layout> 