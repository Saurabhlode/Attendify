<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">My Enrolled Subjects</h3>
                    
                    @if($subjects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($subjects as $subject)
                                <div class="bg-white border border-gray-200 rounded-lg shadow p-6">
                                    <h5 class="mb-2 text-xl font-bold text-gray-900">{{ $subject->name }}</h5>
                                    <p class="text-gray-700 mb-2">Code: {{ $subject->code }}</p>
                                    <p class="text-gray-700 mb-4">Teacher: {{ $subject->teacher->user->name }}</p>
                                    <a href="{{ route('student.subjects') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                        View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No subjects enrolled yet.</p>
                    @endif

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('student.subjects') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">My Subjects</h5>
                            <p class="font-normal text-gray-700">View all enrolled subjects</p>
                        </a>
                        <a href="{{ route('student.attendance') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">My Attendance</h5>
                            <p class="font-normal text-gray-700">View attendance history</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>