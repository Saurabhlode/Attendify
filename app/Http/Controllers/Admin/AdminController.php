<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassSession;
use App\Models\Attendance;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_subjects' => Subject::count(),
            'total_sessions' => ClassSession::count(),
            'total_attendances' => Attendance::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::with(['student', 'teacher'])->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function subjects()
    {
        $subjects = Subject::with('teacher.user')->paginate(15);
        return view('admin.subjects.index', compact('subjects'));
    }
}