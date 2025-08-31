<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enter Enrollment Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 text-center">
                        <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Complete Your Enrollment
                        </h3>
                        <p class="text-gray-600">
                            Enter the enrollment code you received from your instructor to complete your enrollment.
                        </p>
                    </div>

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('enrollments.complete') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                Enrollment Code
                            </label>
                            <input type="text" 
                                   id="code" 
                                   name="code" 
                                   value="{{ old('code') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-center text-lg font-mono tracking-widest uppercase"
                                   placeholder="ABCD1234"
                                   maxlength="8"
                                   required>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                                Complete Enrollment
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 p-4 bg-blue-50 rounded-md">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Need help?</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Check your email for the enrollment code</li>
                            <li>• Make sure you're entering the code exactly as shown</li>
                            <li>• Contact your instructor if you haven't received a code</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-format the code input to uppercase
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    </script>
</x-app-layout> 