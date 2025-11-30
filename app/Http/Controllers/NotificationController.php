<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassSession;
use App\Models\Attendance;

class NotificationController extends Controller
{
    public function getStats()
    {
        $user = auth()->user();
        
        if ($user->role === 'Admin') {
            return response()->json([
                'total_users' => \App\Models\User::count(),
                'total_sessions_today' => ClassSession::whereDate('date', today())->count(),
                'pending_attendance' => ClassSession::whereDate('date', today())
                    ->whereDoesntHave('attendances')->count(),
            ]);
        }
        
        if ($user->role === 'Teacher') {
            $teacher = $user->teacher;
            return response()->json([
                'my_subjects' => $teacher->subjects()->count(),
                'sessions_today' => ClassSession::whereHas('subject', function($q) use ($teacher) {
                    $q->where('teacher_id', $teacher->id);
                })->whereDate('date', today())->count(),
            ]);
        }
        
        if ($user->role === 'Student') {
            $student = $user->student;
            return response()->json([
                'enrolled_subjects' => $student->subjects()->count(),
                'attendance_today' => Attendance::where('student_id', $student->id)
                    ->whereHas('classSession', function($q) {
                        $q->whereDate('date', today());
                    })->count(),
            ]);
        }
        
        return response()->json([]);
    }
    
    public function getNotifications()
    {
        $notifications = auth()->user()->notifications()->latest()->take(10)->get();
        $unreadCount = auth()->user()->unreadNotifications()->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    
    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}