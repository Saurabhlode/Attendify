<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Enrollment - {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.subjects.enrollment', $subject) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-4">Select Students to Enroll</h3>
                            @if($students->count() > 0)
                                <div class="space-y-2">
                                    @foreach($students as $student)
                                        <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                                            <input type="checkbox" name="students[]" value="{{ $student->id }}" 
                                                   {{ in_array($student->id, $enrolled) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600">
                                            <div class="ml-3">
                                                <div class="font-medium">{{ $student->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $student->roll_no }} - {{ $student->program }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No students available for enrollment.</p>
                            @endif
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.subjects') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Update Enrollment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>