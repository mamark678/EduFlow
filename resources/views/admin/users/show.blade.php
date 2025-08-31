@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
                    <p class="text-gray-600">View detailed information about {{ $user->name }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'instructor') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Status</label>
                            <p class="mt-1">
                                @if($user->email_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Not Verified
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Account Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F d, Y \a\t g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Activity Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $stats['courses_created'] }}</div>
                            <div class="text-sm text-gray-500">Courses Created</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $stats['enrollments'] }}</div>
                            <div class="text-sm text-gray-500">Enrollments</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $stats['comments_made'] }}</div>
                            <div class="text-sm text-gray-500">Comments Made</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User's Courses (if instructor) -->
            @if($user->role === 'instructor' && $user->courses->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Created Courses</h3>
                        <div class="space-y-4">
                            @foreach($user->courses as $course)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900">{{ $course->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $course->description }}</p>
                                            <div class="mt-2 flex space-x-4 text-sm text-gray-500">
                                                <span>{{ $course->modules_count ?? 0 }} modules</span>
                                                <span>{{ $course->enrollments_count ?? 0 }} enrollments</span>
                                                <span>{{ $course->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('courses.show', $course) }}" 
                                           class="text-blue-600 hover:text-blue-900 text-sm">View Course</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- User's Enrollments (if student) -->
            @if($user->role === 'student' && $user->enrollments->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Enrolled Courses</h3>
                        <div class="space-y-4">
                            @foreach($user->enrollments as $enrollment)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-medium text-gray-900">{{ $enrollment->course->title }}</h4>
                                            <p class="text-sm text-gray-600">by {{ $enrollment->course->instructor->name }}</p>
                                            <div class="mt-2 flex space-x-4 text-sm text-gray-500">
                                                <span>Enrolled: {{ $enrollment->created_at->format('M d, Y') }}</span>
                                                @if($enrollment->verified_at)
                                                    <span class="text-green-600">Verified</span>
                                                @else
                                                    <span class="text-yellow-600">Pending</span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('courses.show', $enrollment->course) }}" 
                                           class="text-blue-600 hover:text-blue-900 text-sm">View Course</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Comments -->
            @if($user->comments->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Comments</h3>
                        <div class="space-y-4">
                            @foreach($user->comments->take(5) as $comment)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-900">{{ $comment->content }}</p>
                                            <div class="mt-2 flex space-x-4 text-sm text-gray-500">
                                                <span>Module: {{ $comment->module->title }}</span>
                                                <span>{{ $comment->created_at->format('M d, Y') }}</span>
                                                @if($comment->parent_id)
                                                    <span class="text-blue-600">Reply</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Account Age</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['account_age'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Last Login</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['last_login'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total Activity</span>
                            <span class="text-sm font-medium text-gray-900">{{ $stats['courses_created'] + $stats['enrollments'] + $stats['comments_made'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-center block">
                            Edit User
                        </a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    Delete User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 