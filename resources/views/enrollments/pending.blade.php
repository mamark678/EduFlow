<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Enrollment Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($pendingEnrollments->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Pending Enrollment Requests ({{ $pendingEnrollments->count() }})
                            </h3>
                        </div>

                        <div class="space-y-6">
                            @foreach($pendingEnrollments as $enrollment)
                                <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <span class="text-blue-600 font-semibold text-lg">
                                                            {{ substr($enrollment->user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="text-lg font-semibold text-gray-900">
                                                        {{ $enrollment->user->name }}
                                                    </h4>
                                                    <p class="text-gray-600">{{ $enrollment->user->email }}</p>
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        Requested on {{ $enrollment->created_at->format('F j, Y \a\t g:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <h5 class="font-medium text-gray-900">Course Details:</h5>
                                                <div class="mt-2 bg-white rounded-md p-4 border">
                                                    <h6 class="font-semibold text-blue-600">{{ $enrollment->course->title }}</h6>
                                                    <p class="text-gray-600 text-sm mt-1">{{ $enrollment->course->description }}</p>
                                                    <div class="flex space-x-4 mt-2 text-sm text-gray-500">
                                                        <span>Category: {{ $enrollment->course->category }}</span>
                                                        <span>Difficulty: {{ $enrollment->course->difficulty }}</span>
                                                        <span>Duration: {{ $enrollment->course->duration }} hours</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col space-y-2 ml-6">
                                            <form method="POST" action="{{ route('enrollments.approve', $enrollment) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-50">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Approve & Send Code
                                                </button>
                                            </form>
                                            
                                            <form method="POST" action="{{ route('enrollments.reject', $enrollment) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50"
                                                    onclick="return confirm('Are you sure you want to reject this enrollment request?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No pending enrollments</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                You don't have any pending enrollment requests at the moment.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 