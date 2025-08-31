@extends('admin.layouts.app')

@section('page-title', 'Forum Management')

@section('content')
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div class="admin-stat-title">Total Forums</div>
            <div class="admin-stat-icon" style="background: var(--primary-blue);">
                <i class="fas fa-comments"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $forums->count() }}</div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div class="admin-stat-title">Total Posts</div>
            <div class="admin-stat-icon" style="background: var(--accent-green);">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $totalPosts }}</div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div class="admin-stat-title">Total Comments</div>
            <div class="admin-stat-icon" style="background: var(--accent-purple);">
                <i class="fas fa-comment"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $totalComments }}</div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-comments"></i>
            Forums
        </div>
        <a href="{{ route('admin.forums.create') }}" class="admin-btn admin-btn-primary">
            <i class="fas fa-plus"></i>
            Create Forum
        </a>
    </div>
    
    <div class="admin-card-body">
        @if($forums->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Forum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($forums as $forum)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg flex items-center justify-center text-xl" style="background-color: {{ $forum->color }}20; color: {{ $forum->color }};">
                                        {!! $forum->icon !!}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $forum->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($forum->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $forum->posts_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $forum->comments_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($forum->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $forum->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.forums.edit', $forum) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <button type="button" class="text-red-600 hover:text-red-900" onclick="showDeleteForumModal('{{ route('admin.forums.destroy', $forum) }}', '{{ addslashes($forum->name) }}', {{ $forum->posts_count }}, {{ $forum->comments_count }})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-comments text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No forums yet</h3>
            <p class="text-gray-500 mb-6">Create your first forum to get started.</p>
            <a href="{{ route('admin.forums.create') }}" class="admin-btn admin-btn-primary">
                <i class="fas fa-plus"></i>
                Create Forum
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Recent Posts -->
<div class="admin-card mt-8">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-file-alt"></i>
            Recent Posts
        </div>
        <a href="{{ route('admin.forums.posts') }}" class="admin-btn admin-btn-secondary">
            View All Posts
        </a>
    </div>
    
    <div class="admin-card-body">
        @if($recentPosts->count() > 0)
        <div class="space-y-4">
            @foreach($recentPosts as $post)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ $post->title }}</h4>
                    <div class="flex items-center space-x-4 mt-1 text-xs text-gray-500">
                        <span>by {{ $post->user->name }}</span>
                        <span>in {{ $post->forum->name }}</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-500">{{ $post->score }} points</span>
                    <span class="text-xs text-gray-500">{{ $post->comments_count }} comments</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <p class="text-gray-500">No posts yet.</p>
        </div>
        @endif
    </div>
</div>

<!-- Forum Delete Modal (moved to end of content for reliability) -->
<div id="deleteForumModal" class="modal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); align-items:center; justify-content:center;">
    <div class="modal-content" style="background:white; border-radius:10px; padding:2rem; max-width:400px; margin:auto; box-shadow:0 4px 24px rgba(0,0,0,0.15);">
        <h3 style="font-size:1.25rem; font-weight:600; margin-bottom:1rem;">Delete Forum</h3>
        <p id="deleteForumText" style="margin-bottom:2rem;"></p>
        <form id="deleteForumForm" method="POST" action="" onsubmit="console.log('Submitting delete forum form:', this.action); return true;">
            @csrf
            @method('DELETE')
            <div style="display:flex; gap:1rem; justify-content:flex-end;">
                <button type="button" onclick="hideDeleteForumModal()" class="admin-btn admin-btn-secondary">Cancel</button>
                <button id="deleteForumSubmitBtn" type="submit" class="admin-btn admin-btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>
<script>
function showDeleteForumModal(actionUrl, name, postsCount, commentsCount) {
    var modal = document.getElementById('deleteForumModal');
    modal.style.display = 'flex';
    var warning = '';
    if (postsCount > 0 || commentsCount > 0) {
        warning = `\n\n⚠️ This forum has ${postsCount} post(s) and ${commentsCount} comment(s). Deleting it will permanently remove ALL posts and comments. This action cannot be undone.`;
    }
    document.getElementById('deleteForumText').innerHTML = `Are you sure you want to delete the forum \"${name}\"?${warning ? '<br><span style=\'color:#dc2626;font-weight:bold;\'>' + warning + '</span>' : ''}`;
    document.getElementById('deleteForumForm').action = actionUrl;
    setTimeout(function() {
        document.getElementById('deleteForumSubmitBtn').focus();
    }, 100);
}
function hideDeleteForumModal() {
    document.getElementById('deleteForumModal').style.display = 'none';
}
</script>
@endsection 