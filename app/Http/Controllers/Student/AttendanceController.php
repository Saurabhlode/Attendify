<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSession;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function markSelf(ClassSession $session)
    {
        $student = auth()->user()->student;
        
        if (!$student->subjects->contains($session->subject_id)) abort(403);
        
        $existing = Attendance::where('class_session_id', $session->id)
            ->where('student_id', $student->id)->first();
            
        if ($existing) {
            return back()->with('error', 'Attendance already marked');
        }

        $attendance = Attendance::create([
            'class_session_id' => $session->id,
            'student_id' => $student->id,
            'status' => 'present',
            'marked_by' => auth()->id(),
        ]);
        
        // Send notification to student
        auth()->user()->notify(new \App\Notifications\AttendanceMarked($attendance));

        return back()->with('success', 'Attendance marked as present');
    }
}