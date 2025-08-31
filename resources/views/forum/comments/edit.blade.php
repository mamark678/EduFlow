<x-app-layout>
    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Edit Comment</h1>
                <p class="text-sm text-gray-500 mt-1">Editing comment on: <a href="{{ route('forum.posts.show', $comment->post) }}" class="text-blue-600 hover:underline">{{ $comment->post->title }}</a></p>
            </div>

            <form method="POST" action="{{ route('forum.comments.update', $comment) }}" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Comment</label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="6" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Write your comment..."
                        required
                    >{{ old('content', $comment->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('forum.posts.show', $comment->post) }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Comment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout> 