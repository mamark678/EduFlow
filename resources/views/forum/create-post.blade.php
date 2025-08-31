<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-bold text-gray-900">Create New Post</h1>
                    <p class="mt-1 text-sm text-gray-500">Share something with the community</p>
                </div>
                
                <form method="POST" action="{{ route('forum.store-post') }}" class="p-6" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Forum Selection -->
                    @php
                        $preselectedForumId = request('forum') ?? old('forum_id');
                        $preselectedForum = $preselectedForumId ? $forums->firstWhere('id', $preselectedForumId) : null;
                    @endphp
                    @if($preselectedForum)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Forum</label>
                            <input type="hidden" name="forum_id" value="{{ $preselectedForum->id }}">
                            <div class="w-full border border-gray-200 rounded-md bg-gray-50 px-4 py-2 text-gray-800 font-semibold">
                                <span class="inline-flex items-center">
                                    <span class="mr-2">{!! $preselectedForum->icon !!}</span>
                                    {{ $preselectedForum->name }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <label for="forum_id" class="block text-sm font-medium text-gray-700 mb-2">Choose Forum</label>
                            <select name="forum_id" id="forum_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select a forum...</option>
                                @foreach($forums as $forum)
                                    <option value="{{ $forum->id }}" {{ old('forum_id') == $forum->id ? 'selected' : '' }}>
                                        {{ $forum->name }} - {{ $forum->description }}
                                    </option>
                                @endforeach
                            </select>
                            @error('forum_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Post Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="relative">
                                <input type="radio" name="type" value="text" class="sr-only" {{ old('type', 'text') === 'text' ? 'checked' : '' }} required>
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors post-type-option {{ old('type', 'text') === 'text' ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <div class="text-center">
                                        <div class="text-2xl mb-2">📝</div>
                                        <div class="text-sm font-medium">Text Post</div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="type" value="link" class="sr-only" {{ old('type') === 'link' ? 'checked' : '' }}>
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors post-type-option {{ old('type') === 'link' ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <div class="text-center">
                                        <div class="text-2xl mb-2">🔗</div>
                                        <div class="text-sm font-medium">Link Post</div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="type" value="image" class="sr-only" {{ old('type') === 'image' ? 'checked' : '' }}>
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors post-type-option {{ old('type') === 'image' ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <div class="text-center">
                                        <div class="text-2xl mb-2">🖼️</div>
                                        <div class="text-sm font-medium">Image Post</div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" name="type" value="video" class="sr-only" {{ old('type') === 'video' ? 'checked' : '' }}>
                                <div class="w-full p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors post-type-option {{ old('type') === 'video' ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <div class="text-center">
                                        <div class="text-2xl mb-2">🎥</div>
                                        <div class="text-sm font-medium">Video Post</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your post title..." required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content (for all post types) -->
                    <div class="mb-6" id="content-section">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            @if(old('type', 'text') === 'text')
                                Content <span class="text-red-500">*</span>
                            @else
                                Description (optional)
                            @endif
                        </label>
                        <textarea name="content" id="content" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Add your thoughts, description, or commentary..." @if(old('type', 'text') === 'text') required @endif>{{ old('content') }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link URL (for link posts) -->
                    <div class="mb-6 hidden" id="link-section">
                        <label for="link_url" class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
                        <input type="url" name="link_url" id="link_url" value="{{ old('link_url') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://example.com">
                        @error('link_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload (for image posts) -->
                    <div class="mb-6 hidden" id="image-section">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Maximum file size: 10MB. Supported formats: JPG, PNG, GIF</p>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Video URL (for video posts) -->
                    <div class="mb-6 hidden" id="video-section">
                        <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="https://youtube.com/watch?v=...">
                        @error('video_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NSFW Toggle -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_nsfw" value="1" {{ old('is_nsfw') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Mark as NSFW (Not Safe For Work)</span>
                        </label>
                        @error('is_nsfw')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('forum.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Create Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeInputs = document.querySelectorAll('input[name="type"]');
        const contentSection = document.getElementById('content-section');
        const linkSection = document.getElementById('link-section');
        const imageSection = document.getElementById('image-section');
        const videoSection = document.getElementById('video-section');
        const postTypeOptions = document.querySelectorAll('.post-type-option');

        function updateFormSections() {
       // Always show content section
       contentSection.classList.remove('hidden');
       linkSection.classList.add('hidden');
       imageSection.classList.add('hidden');
       videoSection.classList.add('hidden');
       
       // Show relevant section
       const selectedType = document.querySelector('input[name="type"]:checked')?.value;
       switch(selectedType) {
           case 'link':
               linkSection.classList.remove('hidden');
               break;
           case 'image':
               imageSection.classList.remove('hidden');
               break;
           case 'video':
               videoSection.classList.remove('hidden');
               break;
       }
   }

        function updateVisualSelection() {
            postTypeOptions.forEach(option => {
                option.classList.remove('border-blue-500', 'bg-blue-50');
                option.classList.add('border-gray-200');
            });
            
            const selectedInput = document.querySelector('input[name="type"]:checked');
            if (selectedInput) {
                const selectedOption = selectedInput.closest('label').querySelector('.post-type-option');
                selectedOption.classList.remove('border-gray-200');
                selectedOption.classList.add('border-blue-500', 'bg-blue-50');
            }
        }

        typeInputs.forEach(input => {
            input.addEventListener('change', function() {
                updateFormSections();
                updateVisualSelection();
            });
        });

        // Initialize
        updateFormSections();
        updateVisualSelection();
    });
    </script>
</x-app-layout> 