<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mark Attendance - {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('teacher.attendance.store', $subject) }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Time</label>
                                <input type="time" name="start_time" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Time</label>
                                <input type="time" name="end_time" required 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">Topic</label>
                            <input type="text" name="topic" placeholder="Class topic (optional)"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Student Attendance</h3>
                            @if($students->count() > 0)
                                <div class="space-y-3">
                                    @foreach($students as $student)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <div class="font-medium">{{ $student->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $student->roll_no }}</div>
                                            </div>
                                            <div class="flex space-x-4">
                                                <label class="flex items-center">
                                                    <input type="radio" name="attendance[{{ $student->id }}]" value="present" 
                                                           class="text-green-600" checked>
                                                    <span class="ml-2 text-green-600">Present</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="attendance[{{ $student->id }}]" value="late" 
                                                           class="text-yellow-600">
                                                    <span class="ml-2 text-yellow-600">Late</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="attendance[{{ $student->id }}]" value="absent" 
                                                           class="text-red-600">
                                                    <span class="ml-2 text-red-600">Absent</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No students enrolled in this subject.</p>
                            @endif
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('teacher.subjects') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Mark Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>