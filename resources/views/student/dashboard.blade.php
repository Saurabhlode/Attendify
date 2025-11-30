<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-green-600 to-blue-600 rounded-xl p-8 mb-8 text-white card-float">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Hello, {{ auth()->user()->name }}!</h1>
                        <p class="text-green-100">Track your attendance and view your enrolled subjects</p>
                        @if(auth()->user()->student)
                            <div class="mt-3 flex items-center space-x-4 text-sm">
                                <span class="bg-white/20 px-3 py-1 rounded-full">Roll: {{ auth()->user()->student->roll_no }}</span>
                                <span class="bg-white/20 px-3 py-1 rounded-full">{{ auth()->user()->student->program }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-20 h-20 text-green-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Enrolled Subjects -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">My Subjects</h3>
                            <a href="{{ route('student.subjects') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
                                View All →
                            </a>
                        </div>
                        
                        @if($subjects->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($subjects as $subject)
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-5 border border-blue-200 dark:border-blue-800 hover:shadow-md transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 card-3d">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-2 py-1 rounded-full">{{ $subject->code }}</span>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $subject->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Teacher: {{ $subject->teacher->user->name }}</p>
                                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                            <span>{{ $subject->credits }} Credits</span>
                                            <span>{{ $subject->semester }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">No subjects enrolled yet</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Contact your administrator to enroll in subjects</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions & Stats -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('student.subjects') }}" 
                               class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800/30 card-lift group">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400">My Subjects</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">View enrolled subjects</p>
                                </div>
                            </a>

                            <a href="{{ route('student.attendance') }}" 
                               class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-800/30 card-lift group">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400">My Attendance</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">View attendance history</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Stats Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Overview</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Enrolled Subjects</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $subjects->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Credits</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $subjects->sum('credits') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Sessions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Today's Sessions</h3>
                        @php
                            $todaySessions = collect();
                            foreach($subjects as $subject) {
                                $sessions = $subject->classSessions()->whereDate('date', today())->get();
                                $todaySessions = $todaySessions->merge($sessions);
                            }
                        @endphp
                        
                        @if($todaySessions->count() > 0)
                            <div class="space-y-3">
                                @foreach($todaySessions->take(3) as $session)
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $session->subject->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session->start_time }} - {{ $session->end_time }}</p>
                                            </div>
                                            @php
                                                $attendance = $session->attendances->where('student_id', auth()->user()->student->id)->first();
                                            @endphp
                                            @if($attendance)
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    @if($attendance->status === 'present') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                    @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                    @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full">Not marked</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No sessions scheduled for today</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>