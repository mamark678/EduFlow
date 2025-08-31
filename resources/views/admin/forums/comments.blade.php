@extends('admin.layouts.app')

@section('title', 'All Forum Comments')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-comment"></i>
            All Forum Comments
        </div>
        <a href="{{ route('admin.forums.index') }}" class="admin-btn admin-btn-secondary">Back to Forums</a>
    </div>
    <div class="admin-card-body">
        @if($comments->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Post</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($comments as $comment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ Str::limit($comment->content, 80) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $comment->post->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $comment->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $comment->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form method="POST" action="{{ route('admin.forums.comments.moderate', $comment) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment? This action cannot be undone.');">
                                @csrf
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $comments->links() }}</div>
        @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-comment text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No comments found</h3>
            <p class="text-gray-500 mb-6">There are no forum comments to display.</p>
        </div>
        @endif
    </div>
</div>
@endsection 