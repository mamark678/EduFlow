<x-app-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Create New Forum</h1>
                <p class="mt-1 text-sm text-gray-500">Add a new discussion category to the community</p>
            </div>
            
            <form method="POST" action="{{ route('instructor.forums.store') }}" class="p-6">
                @csrf
                
                <!-- Forum Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Forum Name</label>
                    <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., Study Tips & Strategies" required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Describe what this forum is about..." required></textarea>
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
                            <input type="radio" name="icon" value="{{ $icon }}" class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-12 h-12 border-2 border-gray-200 rounded-lg flex items-center justify-center text-xl cursor-pointer hover:border-blue-300 transition-colors icon-option">
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
                            <input type="radio" name="color" value="{{ $color }}" class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-12 h-12 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors color-option" style="background-color: {{ $color }};">
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
                    <input type="number" name="order" id="order" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="0" value="0">
                    <p class="mt-1 text-sm text-gray-500">Lower numbers appear first in the forum list</p>
                    @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('instructor.forums.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Create Forum
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

    // Initialize selections
    const firstIconInput = document.querySelector('input[name="icon"]:checked');
    if (firstIconInput) {
        const firstIconOption = firstIconInput.closest('label').querySelector('.icon-option');
        firstIconOption.classList.remove('border-gray-200');
        firstIconOption.classList.add('border-blue-500', 'bg-blue-50');
    }

    const firstColorInput = document.querySelector('input[name="color"]:checked');
    if (firstColorInput) {
        const firstColorOption = firstColorInput.closest('label').querySelector('.color-option');
        firstColorOption.classList.remove('border-gray-200');
        firstColorOption.classList.add('border-blue-500', 'ring-2', 'ring-blue-200');
    }
});
    </script>
</x-app-layout> 