<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 flex flex-col md:flex-row gap-6">
            <!-- Vote Column -->
            <div class="flex flex-col items-center space-y-2 mr-4">
                <button onclick="vote('App\\Models\\ForumPost', {{ $post->id }}, 'upvote')" 
                        class="vote-btn upvote-btn {{ $post->userVote() && $post->userVote()->vote_type === 'upvote' ? 'voted' : '' }}"
                        data-votable-type="App\Models\ForumPost"
                        data-votable-id="{{ $post->id }}"
                        data-vote-type="upvote">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <span class="vote-score text-lg font-bold" id="score-{{ $post->id }}">{{ $post->upvotes - $post->downvotes }}</span>
                <button onclick="vote('App\\Models\\ForumPost', {{ $post->id }}, 'downvote')" 
                        class="vote-btn downvote-btn {{ $post->userVote() && $post->userVote()->vote_type === 'downvote' ? 'voted' : '' }}"
                        data-votable-type="App\Models\ForumPost"
                        data-votable-id="{{ $post->id }}"
                        data-vote-type="downvote">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Post Content Column -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-2">
                    <!-- User Avatar -->
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                        @if($post->user->avatar_url)
                            <img src="{{ $post->user->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-lg font-bold text-gray-500">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900">{{ $post->user->name }}</span>
                            <span class="text-xs text-gray-400">•</span>
                            <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center gap-2 mt-1">
                            <!-- Forum badge -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" style="background: {{ $post->forum->color }}20; color: {{ $post->forum->color }};">
                                {!! $post->forum->icon !!} {{ $post->forum->name }}
                            </span>
                            <!-- Post type badge -->
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                @if($post->type === 'text')
                                    📝 Text
                                @elseif($post->type === 'link')
                                    🔗 Link
                                @elseif($post->type === 'image')
                                    🖼️ Image
                                @elseif($post->type === 'video')
                                    🎥 Video
                                @endif
                            </span>
                            @if($post->is_nsfw)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-red-100 text-red-700">NSFW</span>
                            @endif
                            @if($post->is_pinned)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-700">PINNED</span>
                            @endif
                        </div>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $post->title }}</h1>
                <!-- Post Content -->
                @if($post->type === 'text')
                    <div class="prose max-w-none mb-6">{!! nl2br(e($post->content)) !!}</div>
                @elseif($post->type === 'link')
                    <div class="mb-6">
                        <a href="{{ $post->link_url }}" class="text-blue-600 underline break-all" target="_blank">{{ $post->link_url }}</a>
                        @if($post->content)
                            <div class="prose max-w-none mt-4">{!! nl2br(e($post->content)) !!}</div>
                        @endif
                    </div>
                @elseif($post->type === 'image')
                    <div class="mb-6">
                        @if($post->image_url)
                            <img src="{{ $post->image_url }}" alt="Post image" class="max-w-full rounded mb-4">
                        @endif
                        @if($post->content)
                            <div class="prose max-w-none">{!! nl2br(e($post->content)) !!}</div>
                        @endif
                    </div>
                @elseif($post->type === 'video')
                    <div class="mb-6">
                        @if($post->video_url)
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                <iframe src="{{ $post->video_url }}" frameborder="0" allowfullscreen class="w-full h-64"></iframe>
                            </div>
                        @endif
                        @if($post->content)
                            <div class="prose max-w-none">{!! nl2br(e($post->content)) !!}</div>
                        @endif
                    </div>
                @endif
                <div class="flex items-center gap-6 mt-6 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        {{ $post->comments()->count() }} Comments
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $post->views ?? 0 }} Views
                    </span>
                    
                    <!-- Post Actions (only visible to post owner) -->
                    @can('update', $post)
                    <div class="flex items-center gap-2">
                        <a href="{{ route('forum.posts.edit', $post) }}" class="flex items-center gap-1 text-gray-500 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                    </div>
                    @endcan
                    
                    @can('delete', $post)
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('forum.posts.destroy', $post) }}" class="inline delete-post-form" data-message="Are you sure you want to delete this post? This action cannot be undone and will also delete all comments on this post.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center gap-1 text-gray-500 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                    @endcan
                </div>
                <div class="mt-8">
                    <a href="{{ route('forum.show', $post->forum) }}" class="text-blue-500 hover:underline">&larr; Back to Forum</a>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-8 bg-white rounded-lg shadow-md border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Comments ({{ $post->comments()->count() }})</h2>
            </div>

            <!-- Comment Form -->
            @if(!$post->is_locked)
            <div class="p-6 border-b border-gray-200">
                <form method="POST" action="{{ route('forum.comments.store', $post) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Add a comment</label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="What are your thoughts?"
                            required
                        ></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="p-6 border-b border-gray-200">
                <div class="text-center text-gray-500">
                    <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <p>This post is locked and cannot be commented on.</p>
                </div>
            </div>
            @endif

            <!-- Comments List -->
            <div class="divide-y divide-gray-200">
                @forelse($comments as $comment)
                    @include('forum.comments.comment', ['comment' => $comment, 'depth' => 0])
                @empty
                    <div class="p-12 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No comments yet</h3>
                        <p class="text-gray-500">Be the first to share your thoughts!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

<style>
.vote-btn {
    @apply p-1 rounded hover:bg-gray-100 transition-colors duration-200;
    color: #6b7280;
}

.vote-btn:hover {
    color: #374151;
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