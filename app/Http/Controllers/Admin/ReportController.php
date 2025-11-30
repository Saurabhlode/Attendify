<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function attendance(Request $request)
    {
        $subjects = Subject::all();
        
        // Build the query
        $query = Attendance::with(['student.user', 'classSession.subject', 'markedBy']);
        
        // Filter by subject if specified
        if ($request->subject_id) {
            $query->whereHas('classSession', function($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });
        }
        
        $attendances = $query->orderBy('created_at', 'desc')->get();

        return view('admin.reports.attendance', compact('subjects', 'attendances'));
    }

    public function exportAttendance(Request $request)
    {
        $attendances = Attendance::whereHas('classSession', function($q) use ($request) {
            if ($request->subject_id) {
                $q->where('subject_id', $request->subject_id);
            }
        })->with(['student.user', 'classSession.subject'])->get();

        $csv = "Student Name,Roll No,Subject,Date,Status,Marked By\n";
        foreach ($attendances as $attendance) {
            $csv .= sprintf("%s,%s,%s,%s,%s,%s\n",
                $attendance->student->user->name,
                $attendance->student->roll_no,
                $attendance->classSession->subject->name,
                $attendance->classSession->date->format('Y-m-d'),
                $attendance->status,
                $attendance->markedBy->name
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="attendance_report.csv"');
    }
}