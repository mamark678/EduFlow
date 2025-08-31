<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Edit Forum</h1>
                <p class="mt-1 text-sm text-gray-500">Update forum settings and information</p>
            </div>
            
            <form method="POST" action="{{ route('instructor.forums.update', $forum) }}" class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Forum Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Forum Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $forum->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., Study Tips & Strategies" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Describe what this forum is about..." required>{{ old('description', $forum->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Forum Icon</label>
                    <div class="grid grid-cols-6 gap-3">
                        @php
                        $icons = ['💬', '📚', '⭐', '🔧', '🎓', '💼', '👨‍🏫', '📢', '💡', '🎯', '🚀', '🌟', '📖', '🎨', '💻', '🎵', '🏃‍♂️', '🍕', '🌍', '🎪', '🎭', '🏆', '💎', '🔥'];
                        @endphp
                        @foreach($icons as $icon)
                        <label class="relative">
                            <input type="radio" name="icon" value="{{ $icon }}" class="sr-only" {{ (old('icon', $forum->icon) === $icon) ? 'checked' : '' }}>
                            <div class="w-12 h-12 border-2 border-gray-200 rounded-lg flex items-center justify-center text-xl cursor-pointer hover:border-blue-300 transition-colors icon-option {{ (old('icon', $forum->icon) === $icon) ? 'border-blue-500 bg-blue-50' : '' }}">
                                {{ $icon }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('icon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Forum Color</label>
                    <div class="grid grid-cols-6 gap-3">
                        @php
                        $colors = ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4', '#84cc16', '#f97316', '#ec4899', '#6366f1', '#14b8a6', '#f43f5e'];
                        @endphp
                        @foreach($colors as $color)
                        <label class="relative">
                            <input type="radio" name="color" value="{{ $color }}" class="sr-only" {{ (old('color', $forum->color) === $color) ? 'checked' : '' }}>
                            <div class="w-12 h-12 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors color-option {{ (old('color', $forum->color) === $color) ? 'border-blue-500 ring-2 ring-blue-200' : '' }}" style="background-color: {{ $color }};">
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div class="mb-6">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                    <input type="number" name="order" id="order" min="0" value="{{ old('order', $forum->order) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="0">
                    <p class="mt-1 text-sm text-gray-500">Lower numbers appear first in the forum list</p>
                    @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $forum->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Active Forum</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Inactive forums will not be visible to users</p>
                    @error('is_active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('instructor.forums.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Update Forum
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Icon selection
    const iconOptions = document.querySelectorAll('.icon-option');
    const iconInputs = document.querySelectorAll('input[name="icon"]');
    
    iconInputs.forEach(input => {
        input.addEventListener('change', function() {
            iconOptions.forEach(option => {
                option.classList.remove('border-blue-500', 'bg-blue-50');
                option.classList.add('border-gray-200');
            });
            
            const selectedOption = this.closest('label').querySelector('.icon-option');
            selectedOption.classList.remove('border-gray-200');
            selectedOption.classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    // Color selection
    const colorOptions = document.querySelectorAll('.color-option');
    const colorInputs = document.querySelectorAll('input[name="color"]');
    
    colorInputs.forEach(input => {
        input.addEventListener('change', function() {
            colorOptions.forEach(option => {
                option.classList.remove('border-blue-500', 'ring-2', 'ring-blue-200');
                option.classList.add('border-gray-200');
            });
            
            const selectedOption = this.closest('label').querySelector('.color-option');
            selectedOption.classList.remove('border-gray-200');
            selectedOption.classList.add('border-blue-500', 'ring-2', 'ring-blue-200');
        });
    });
});
    </script>
</x-app-layout> 