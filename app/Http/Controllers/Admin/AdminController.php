<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'Student')->count(),
            'total_teachers' => User::where('role', 'Teacher')->count(),
            'total_subjects' => Subject::count(),
            'total_sessions' => ClassSession::count(),
            'total_attendances' => Attendance::count(),
        ];

        $attendanceStats = DB::table('attendances')
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray() + ['present' => 0, 'late' => 0, 'absent' => 0];
        
        // Get recent activity with optimized query
        $recentSessions = ClassSession::with(['subject:id,name', 'attendances:id,class_session_id,status'])
            ->select('id', 'subject_id', 'date', 'start_time', 'end_time')
            ->latest('date')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'attendanceStats', 'recentSessions'));
    }

    public function users()
    {
        $users = User::with(['student:id,user_id,roll_no', 'teacher:id,user_id,employee_code'])
            ->select('id', 'name', 'email', 'role', 'created_at')
            ->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function subjects()
    {
        $subjects = Subject::with(['teacher:id,user_id', 'teacher.user:id,name'])
            ->select('id', 'name', 'code', 'teacher_id', 'created_at')
            ->paginate(15);
        return view('admin.subjects.index', compact('subjects'));
    }
}