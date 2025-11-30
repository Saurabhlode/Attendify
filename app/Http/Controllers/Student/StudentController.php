<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cache;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user()->student;
        
        // Cache student subjects for 5 minutes
        $subjects = Cache::remember("student.{$student->id}.subjects", \App\Services\CacheService::USER_DATA_TTL, function () use ($student) {
            return $student->subjects()
                ->with(['teacher:id,user_id', 'teacher.user:id,name'])
                ->select('subjects.id', 'subjects.name', 'subjects.code', 'subjects.teacher_id')
                ->get();
        });
        
        return view('student.dashboard', compact('subjects'));
    }

    public function subjects()
    {
        $student = auth()->user()->student;
        $subjects = $student->subjects()
            ->with(['teacher:id,user_id', 'teacher.user:id,name'])
            ->withCount('classSessions')
            ->select('subjects.id', 'subjects.name', 'subjects.code', 'subjects.description', 'subjects.teacher_id')
            ->paginate(10);
        
        return view('student.subjects.index', compact('subjects'));
    }

    public function attendance()
    {
        $student = auth()->user()->student;
        $attendances = Attendance::where('student_id', $student->id)
            ->with([
                'classSession:id,subject_id,date,start_time,end_time',
                'classSession.subject:id,name',
                'markedBy:id,name'
            ])
            ->select('id', 'class_session_id', 'student_id', 'status', 'marked_by', 'created_at')
            ->latest('created_at')
            ->paginate(15);
        
        return view('student.attendance.index', compact('attendances'));
    }
}