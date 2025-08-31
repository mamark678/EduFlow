<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Post</h1>
                    <p class="mt-1 text-sm text-gray-500">Update your post in {{ $post->forum->name }}</p>
                </div>
                
                <form method="POST" action="{{ route('forum.posts.update', $post) }}" class="p-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Post Type (read-only) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <div class="w-full border border-gray-200 rounded-md bg-gray-50 px-4 py-2 text-gray-800 font-semibold">
                            @if($post->type === 'text')
                                📝 Text Post
                            @elseif($post->type === 'link')
                                🔗 Link Post
                            @elseif($post->type === 'image')
                                🖼️ Image Post
                            @elseif($post->type === 'video')
                                🎥 Video Post
                            @endif
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your post title..." required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            @if($post->type === 'text')
                                Content <span class="text-red-500">*</span>
                            @else
                                Description (optional)
                            @endif
                        </label>
                        <textarea name="content" id="content" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Add your thoughts, description, or commentary..." @if($post->type === 'text') required @endif>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link URL (for link posts) -->
                    @if($post->type === 'link')
                    <div class="mb-6">
                        <label for="link_url" class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                        <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $post->link_url) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://example.com">
                        @error('link_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Image Upload (for image posts) -->
                    @if($post->type === 'image')
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload New Image (optional)</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Maximum file size: 10MB. Supported formats: JPG, PNG, GIF</p>
                        @if($post->image_url)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 mb-2">Current image:</p>
                            <img src="{{ $post->image_url }}" alt="Current post image" class="max-w-xs rounded">
                        </div>
                        @endif
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Video URL (for video posts) -->
                    @if($post->type === 'video')
                    <div class="mb-6">
                        <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $post->video_url) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://youtube.com/watch?v=...">
                        @error('video_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- NSFW Toggle -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_nsfw" value="1" {{ old('is_nsfw', $post->is_nsfw) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Mark as NSFW (Not Safe For Work)</span>
                        </label>
                        @error('is_nsfw')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('forum.posts.show', $post) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 