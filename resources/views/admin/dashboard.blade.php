<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800">Total Users</h3>
                            <p class="text-2xl font-bold text-blue-600">{{ $stats['total_users'] }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800">Total Students</h3>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['total_students'] }}</p>
                        </div>
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-purple-800">Total Teachers</h3>
                            <p class="text-2xl font-bold text-purple-600">{{ $stats['total_teachers'] }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800">Total Subjects</h3>
                            <p class="text-2xl font-bold text-yellow-600">{{ $stats['total_subjects'] }}</p>
                        </div>
                        <div class="bg-red-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-red-800">Total Sessions</h3>
                            <p class="text-2xl font-bold text-red-600">{{ $stats['total_sessions'] }}</p>
                        </div>
                        <div class="bg-indigo-100 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-indigo-800">Total Attendances</h3>
                            <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_attendances'] }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('admin.users') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Manage Users</h5>
                            <p class="font-normal text-gray-700">View and manage all users in the system</p>
                        </a>
                        <a href="{{ route('admin.subjects') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Manage Subjects</h5>
                            <p class="font-normal text-gray-700">View and manage all subjects</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>