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
        $subjects = $teacher->subjects()->with('students')->get();
        
        return view('teacher.dashboard', compact('subjects'));
    }

    public function subjects()
    {
        $teacher = auth()->user()->teacher;
        $subjects = $teacher->subjects()->with('students')->paginate(10);
        
        return view('teacher.subjects.index', compact('subjects'));
    }

    public function classSessions()
    {
        $teacher = auth()->user()->teacher;
        $sessions = ClassSession::whereHas('subject', function($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with(['subject', 'attendances'])->latest()->paginate(15);
        
        return view('teacher.sessions.index', compact('sessions'));
    }
}