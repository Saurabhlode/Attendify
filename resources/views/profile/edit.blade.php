<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 mb-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ auth()->user()->role === 'Admin' ? 'red' : (auth()->user()->role === 'Teacher' ? 'blue' : 'green') }}-100 text-{{ auth()->user()->role === 'Admin' ? 'red' : (auth()->user()->role === 'Teacher' ? 'blue' : 'green') }}-800 dark:bg-{{ auth()->user()->role === 'Admin' ? 'red' : (auth()->user()->role === 'Teacher' ? 'blue' : 'green') }}-900/20 dark:text-{{ auth()->user()->role === 'Admin' ? 'red' : (auth()->user()->role === 'Teacher' ? 'blue' : 'green') }}-400 mt-2">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Profile Information -->
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h4>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
                
                <!-- Password Update -->
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Update Password</h4>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            
            <!-- Role-specific Information -->
            @if(auth()->user()->student || auth()->user()->teacher)
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ auth()->user()->role }} Information</h4>
                </div>
                
                @if(auth()->user()->student)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Roll Number</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->student->roll_no }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Class</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->student->class ?? 'Not assigned' }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Enrollment Year</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->student->enrollment_year }}</p>
                    </div>
                </div>
                @endif
                
                @if(auth()->user()->teacher)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Employee Code</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->teacher->employee_code }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Department</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->teacher->department }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Designation</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->teacher->designation ?? 'Teacher' }}</p>
                    </div>
                </div>
                @endif
            </div>
            @endif
            
            <!-- Danger Zone -->
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-red-200 dark:border-red-800">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-red-900 dark:text-red-100">Danger Zone</h4>
                </div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
