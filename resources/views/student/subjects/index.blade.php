<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($subjects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($subjects as $subject)
                                <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                                    <h5 class="mb-2 text-xl font-bold text-gray-900">{{ $subject->name }}</h5>
                                    <p class="text-gray-700 mb-2"><strong>Code:</strong> {{ $subject->code }}</p>
                                    <p class="text-gray-700 mb-2"><strong>Teacher:</strong> {{ $subject->teacher->user->name }}</p>
                                    <p class="text-gray-700 mb-2"><strong>Semester:</strong> {{ $subject->semester }}</p>
                                    <p class="text-gray-700 mb-4"><strong>Credits:</strong> {{ $subject->credits }}</p>
                                    
                                    @if($subject->description)
                                        <p class="text-gray-600 mb-4">{{ $subject->description }}</p>
                                    @endif
                                    
                                    <div class="border-t pt-4">
                                        <h6 class="font-semibold mb-2">Recent Sessions:</h6>
                                        @if($subject->classSessions->count() > 0)
                                            <div class="space-y-2">
                                                @foreach($subject->classSessions->latest()->take(3)->get() as $session)
                                                    @php
                                                        $attendance = $session->attendances->where('student_id', auth()->user()->student->id)->first();
                                                        $isToday = $session->date->isToday();
                                                    @endphp
                                                    <div class="text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                                        <div class="flex justify-between items-start">
                                                            <div>
                                                                <div class="font-medium">{{ $session->topic ?? 'Class Session' }}</div>
                                                                <div class="text-xs text-gray-500">
                                                                    {{ $session->date->format('M d, Y') }} | {{ $session->start_time }} - {{ $session->end_time }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                @if($attendance)
                                                                    <span class="px-2 py-1 text-xs rounded 
                                                                        @if($attendance->status === 'present') bg-green-100 text-green-800
                                                                        @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                                                        @else bg-red-100 text-red-800 @endif">
                                                                        {{ ucfirst($attendance->status) }}
                                                                    </span>
                                                                @elseif($isToday)
                                                                    <form method="POST" action="{{ route('student.attendance.mark', $session) }}" class="inline">
                                                                        @csrf
                                                                        <button type="submit" class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                                                            Mark Present
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <span class="text-xs text-gray-400">Not marked</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">No sessions yet</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $subjects->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No subjects enrolled yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>