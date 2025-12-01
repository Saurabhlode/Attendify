<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\ClassSession;
use App\Models\Attendance;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $teacher = auth()->user()->teacher;
        
        $subjects = $teacher->subjects()
            ->withCount('students')
            ->select('id', 'name', 'code', 'teacher_id')
            ->get();
        
        return view('teacher.dashboard', compact('subjects'));
    }

    public function subjects()
    {
        $teacher = auth()->user()->teacher;
        $subjects = $teacher->subjects()
            ->withCount('students')
            ->select('id', 'name', 'code', 'description', 'teacher_id')
            ->paginate(10);
        
        return view('teacher.subjects.index', compact('subjects'));
    }

    public function classSessions()
    {
        $teacher = auth()->user()->teacher;
        $sessions = ClassSession::join('subjects', 'class_sessions.subject_id', '=', 'subjects.id')
            ->where('subjects.teacher_id', $teacher->id)
            ->with(['subject:id,name', 'attendances:id,class_session_id,status'])
            ->select('class_sessions.*')
            ->latest('class_sessions.date')
            ->paginate(15);
        
        return view('teacher.sessions.index', compact('sessions'));
    }
}