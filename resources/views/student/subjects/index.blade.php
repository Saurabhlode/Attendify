<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Subjects') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Enrolled Subjects</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">View your subjects and mark attendance for today's sessions</p>
                    </div>

                    @if($subjects->count() > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach($subjects as $subject)
                                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 p-6 hover:shadow-lg transition-all duration-200">
                                    <!-- Subject Header -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $subject->name }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subject->code }}</p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-medium rounded-full">
                                            {{ $subject->credits }} Credits
                                        </span>
                                    </div>

                                    <!-- Subject Details -->
                                    <div class="space-y-3 mb-6">
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            <strong class="mr-2">Teacher:</strong> {{ $subject->teacher->user->name }}
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            <strong class="mr-2">Semester:</strong> {{ $subject->semester ?? 'Not specified' }}
                                        </div>
                                        @if($subject->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                                {{ $subject->description }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Recent Sessions -->
                                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                        <h5 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Recent Sessions
                                        </h5>
                                        
                                        @if($subject->classSessions->count() > 0)
                                            <div class="space-y-2">
                                                @foreach($subject->classSessions->latest()->take(3)->get() as $session)
                                                    @php
                                                        $attendance = $session->attendances->where('student_id', auth()->user()->student->id)->first();
                                                        $isToday = $session->date->isToday();
                                                    @endphp
                                                    <div class="bg-white dark:bg-gray-600 border border-gray-200 dark:border-gray-500 rounded-lg p-3">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex-1">
                                                                <p class="font-medium text-gray-900 dark:text-white text-sm">
                                                                    {{ $session->topic ?? 'Class Session' }}
                                                                </p>
                                                                <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                    <span class="flex items-center">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                                        </svg>
                                                                        {{ $session->date->format('M d, Y') }}
                                                                    </span>
                                                                    <span class="flex items-center">
                                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                        </svg>
                                                                        {{ $session->start_time }} - {{ $session->end_time }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                @if($attendance)
                                                                    <span class="px-2 py-1 text-xs rounded-full font-medium
                                                                        @if($attendance->status === 'present') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                                        @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 @endif">
                                                                        {{ ucfirst($attendance->status) }}
                                                                    </span>
                                                                @elseif($isToday)
                                                                    <form method="POST" action="{{ route('student.attendance.mark', $session) }}" class="inline">
                                                                        @csrf
                                                                        <button type="submit" class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-200 font-medium shadow-sm">
                                                                            Mark Present
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <span class="px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-full">Not marked</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No sessions scheduled yet</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8">
                            {{ $subjects->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="w-20 h-20 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Subjects Enrolled</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">You haven't been enrolled in any subjects yet.</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500">Contact your administrator to get enrolled in subjects.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>