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
                                    <p class="text-gray-700 mb-2"><strong>Semester:</strong> {{ $subject->semester }}</p>
                                    <p class="text-gray-700 mb-2"><strong>Credits:</strong> {{ $subject->credits }}</p>
                                    <p class="text-gray-700 mb-4"><strong>Enrolled Students:</strong> {{ $subject->students->count() }}</p>
                                    
                                    @if($subject->description)
                                        <p class="text-gray-600 mb-4">{{ $subject->description }}</p>
                                    @endif
                                    
                                    <div class="border-t pt-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <h6 class="font-semibold">Enrolled Students:</h6>
                                            <a href="{{ route('teacher.attendance.create', $subject) }}" 
                                               class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                                Mark Attendance
                                            </a>
                                        </div>
                                        @if($subject->students->count() > 0)
                                            <div class="space-y-1">
                                                @foreach($subject->students as $student)
                                                    <div class="text-sm text-gray-600">
                                                        {{ $student->user->name }} ({{ $student->roll_no }})
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">No students enrolled</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $subjects->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No subjects assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>