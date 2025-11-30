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

        // Get attendance analytics
        $attendanceStats = [
            'present' => Attendance::where('status', 'present')->count(),
            'late' => Attendance::where('status', 'late')->count(),
            'absent' => Attendance::where('status', 'absent')->count(),
        ];
        
        // Get recent activity
        $recentSessions = ClassSession::with(['subject', 'attendances'])
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'attendanceStats', 'recentSessions'));
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