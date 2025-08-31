<section class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <header class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
            {{ __("Update your account's profile information, avatar, and email address.") }}
        </p>
    </header>

    <!-- Enhanced Avatar Section -->
    <div class="flex flex-col items-center justify-center mb-8">
        <div x-data="{ showMenu: false, showPreview: false }" class="relative group">
            @if($user->avatar)
                <img src="{{ $user->avatar_url }}" 
                     alt="Avatar" 
                     class="w-32 h-32 rounded-full shadow-lg object-cover border-4 border-white dark:border-gray-600 bg-gray-100 transition-all duration-300 group-hover:shadow-xl" />
                <div x-data="{ showDeleteModal: false }" class="absolute -top-2 -right-2">
                    <button type="button"
                            @click="showDeleteModal = true"
                            class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-all duration-200 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                            title="Delete Avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <!-- Modal -->
                    <div x-show="showDeleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="display: none;" x-cloak>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg">
                            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Delete Avatar</h2>
                            <p class="mb-6 text-gray-700 dark:text-gray-300">Are you sure you want to delete your avatar? This action cannot be undone.</p>
                            <div class="flex justify-end gap-2">
                                <button @click="showDeleteModal = false" type="button" class="edu-btn edu-btn-secondary">Cancel</button>
                                <form method="POST" action="{{ route('profile.avatar.delete') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="edu-btn edu-btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Camera Icon Overlay (only on hover) -->
                <div class="absolute inset-0 flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white bg-black bg-opacity-40 rounded-full p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h2l2-3h6l2 3h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z" />
                        <circle cx="12" cy="13" r="4" />
                    </svg>
                </div>
                <!-- Options Menu -->
                <div x-show="showMenu" @click.away="showMenu = false" class="absolute top-0 right-0 mt-12 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg z-50">
                    <button @click="showPreview = true; showMenu = false" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">View Avatar</button>
                    <label class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                        Change Avatar
                        <input type="file" name="avatar" id="avatar" class="hidden" onchange="this.form.submit(); showMenu = false;" />
                    </label>
                </div>
                <!-- Avatar Preview Modal -->
                <div x-show="showPreview" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50" x-cloak>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg flex flex-col items-center">
                        <img src="{{ $user->avatar_url }}" alt="Avatar Preview" class="w-64 h-64 rounded-full object-cover mb-4" />
                        <button @click="showPreview = false" class="edu-btn edu-btn-secondary">Close</button>
                    </div>
                </div>
            @else
                <div class="w-32 h-32 rounded-full shadow-lg flex items-center justify-center border-4 border-white dark:border-gray-600 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 text-gray-500 dark:text-gray-400 transition-all duration-300 group-hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            @endif
            <div class="absolute inset-0 rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Email Verification Form (Hidden) -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Enhanced Profile Form (now includes avatar upload) -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name Field -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    </div>
                    <x-text-input id="name" 
                                  name="name" 
                                  type="text" 
                                  class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-eduflow-teal focus:ring-eduflow-teal transition-colors duration-200" 
                                  :value="old('name', $user->name)" 
                                  required 
                                  autofocus 
                                  autocomplete="name" />
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <!-- Email Field -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-700 dark:text-gray-300" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    </div>
                    <x-text-input id="email" 
                                  name="email" 
                                  type="email" 
                                  class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-eduflow-teal focus:ring-eduflow-teal transition-colors duration-200" 
                                  :value="old('email', $user->email)" 
                                  required 
                                  autocomplete="username" />
                </div>
                <x-input-error class="mt-1" :messages="$errors->get('email')" />
            </div>
        </div>

        <!-- Avatar Upload Field (moved into main form) -->
        <div class="space-y-4">
            <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 text-center">
                Change Avatar
            </label>
            <div class="relative">
                <input id="avatar" 
                       name="avatar" 
                       type="file" 
                       accept="image/*" 
                       class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-eduflow-accent file:transition-colors file:duration-200 file:cursor-pointer cursor-pointer bg-gray-50 dark:bg-gray-700 rounded-full border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200" />
            </div>
            <x-input-error class="text-center" :messages="$errors->get('avatar')" />
        </div>

        <!-- Email Verification Notice -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.924-.833-2.684 0l-5.898 9.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-800 dark:text-amber-200">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" 
                                    class="font-medium text-amber-600 dark:text-amber-400 hover:text-amber-500 dark:hover:text-amber-300 underline ml-1 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-amber-900 rounded transition-colors duration-200">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm text-green-600 dark:text-green-400 font-medium">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <button type="submit" 
                        class="bg-eduflow-teal hover:bg-eduflow-accent text-white font-semibold py-3 px-8 rounded-full transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-eduflow-teal focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('Save Changes') }}
                    </span>
                </button>

                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition:enter="transition ease-out duration-300" 
                         x-transition:enter-start="opacity-0 transform scale-90" 
                         x-transition:enter-end="opacity-100 transform scale-100" 
                         x-transition:leave="transition ease-in duration-200" 
                         x-transition:leave-start="opacity-100 transform scale-100" 
                         x-transition:leave-end="opacity-0 transform scale-90" 
                         x-init="setTimeout(() => show = false, 3000)"
                         class="flex items-center bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 px-4 py-2 rounded-full text-sm font-medium shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('Profile updated successfully!') }}
                    </div>
                @endif
            </div>
        </div>
    </form>
</section>