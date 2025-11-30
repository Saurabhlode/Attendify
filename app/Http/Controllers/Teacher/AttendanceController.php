<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSession;
use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create(Subject $subject)
    {
        $teacher = auth()->user()->teacher;
        if ($subject->teacher_id !== $teacher->id) abort(403);
        
        $students = $subject->students;
        return view('teacher.attendance.create', compact('subject', 'students'));
    }

    public function store(Request $request, Subject $subject)
    {
        $teacher = auth()->user()->teacher;
        if ($subject->teacher_id !== $teacher->id) abort(403);

        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'topic' => 'nullable|string',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late'
        ]);

        $session = ClassSession::create([
            'subject_id' => $subject->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'topic' => $request->topic,
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::create([
                'class_session_id' => $session->id,
                'student_id' => $studentId,
                'status' => $status,
                'marked_by' => auth()->id(),
            ]);
        }

        return redirect()->route('teacher.sessions')->with('success', 'Attendance marked successfully');
    }
}