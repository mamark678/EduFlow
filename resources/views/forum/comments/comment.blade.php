<div class="comment" style="margin-left: {{ $depth * 20 }}px;">
    <div class="p-4 {{ $depth > 0 ? 'border-l-2 border-gray-200' : '' }}">
        <div class="flex space-x-3">
            <!-- Vote Column -->
            <div class="flex flex-col items-center space-y-1">
                <button onclick="vote('App\\Models\\ForumComment', {{ $comment->id }}, 'upvote')" 
                        class="vote-btn upvote-btn {{ $comment->userVote() && $comment->userVote()->vote_type === 'upvote' ? 'voted' : '' }}"
                        data-votable-type="App\Models\ForumComment"
                        data-votable-id="{{ $comment->id }}"
                        data-vote-type="upvote">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <span class="vote-score text-xs font-medium" id="score-{{ $comment->id }}">{{ $comment->upvotes - $comment->downvotes }}</span>
                <button onclick="vote('App\\Models\\ForumComment', {{ $comment->id }}, 'downvote')" 
                        class="vote-btn downvote-btn {{ $comment->userVote() && $comment->userVote()->vote_type === 'downvote' ? 'voted' : '' }}"
                        data-votable-type="App\Models\ForumComment"
                        data-votable-id="{{ $comment->id }}"
                        data-vote-type="downvote">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Comment Content -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2">
                    <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                    <span>•</span>
                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                    @if($comment->is_edited)
                        <span class="text-gray-400">(edited)</span>
                    @endif
                </div>
                
                <div class="prose max-w-none text-sm text-gray-900 mb-3">
                    {!! nl2br(e($comment->content)) !!}
                </div>

                <!-- Comment Actions -->
                <div class="flex items-center space-x-4 text-xs text-gray-500">
                    @if(!$comment->post->is_locked)
                        <button 
                            onclick="toggleReplyForm({{ $comment->id }})" 
                            class="flex items-center space-x-1 hover:text-gray-700"
                        >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                            <span>Reply</span>
                        </button>
                    @endif
                    
                    @can('update', $comment)
                        <a href="{{ route('forum.comments.edit', $comment) }}" class="flex items-center space-x-1 hover:text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Edit</span>
                        </a>
                    @endcan
                    
                    @can('delete', $comment)
                        <form method="POST" action="{{ route('forum.comments.destroy', $comment) }}" class="inline delete-comment-form" data-message="Are you sure you want to delete this comment? This action cannot be undone and will also delete any replies to this comment.">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center space-x-1 hover:text-red-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span>Delete</span>
                            </button>
                        </form>
                    @endcan
                </div>

                <!-- Reply Form (Hidden by default) -->
                <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                    <form method="POST" action="{{ route('forum.comments.store', $comment->post) }}" class="space-y-3">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div>
                            <textarea 
                                name="content" 
                                rows="2" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="Write a reply..."
                                required
                            ></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button 
                                type="button" 
                                onclick="toggleReplyForm({{ $comment->id }})"
                                class="px-3 py-1 text-sm border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                            >
                                Cancel
                            </button>
                            <button type="submit" class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Nested Replies -->
    @if($comment->replies->count() > 0)
        @foreach($comment->replies->sortBy('upvotes') as $reply)
            @include('forum.comments.comment', ['comment' => $reply, 'depth' => $depth + 1])
        @endforeach
    @endif
</div>

<script>
function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
        form.classList.toggle('hidden');
    }
}
</script> 