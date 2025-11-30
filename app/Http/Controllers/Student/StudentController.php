<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Attendance;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user()->student;
        $subjects = $student->subjects()->with('teacher.user')->get();
        
        return view('student.dashboard', compact('subjects'));
    }

    public function subjects()
    {
        $student = auth()->user()->student;
        $subjects = $student->subjects()->with(['teacher.user', 'classSessions'])->paginate(10);
        
        return view('student.subjects.index', compact('subjects'));
    }

    public function attendance()
    {
        $student = auth()->user()->student;
        $attendances = Attendance::where('student_id', $student->id)
            ->with(['classSession.subject', 'markedBy'])
            ->latest()
            ->paginate(15);
        
        return view('student.attendance.index', compact('attendances'));
    }
}