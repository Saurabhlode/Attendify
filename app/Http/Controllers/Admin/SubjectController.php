<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function create()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.subjects.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:subjects',
            'name' => 'required',
            'teacher_id' => 'nullable|exists:teachers,id',
            'credits' => 'required|integer|min:1',
        ]);

        Subject::create($request->all());
        return redirect()->route('admin.subjects')->with('success', 'Subject created successfully');
    }

    public function enroll(Subject $subject)
    {
        $students = Student::with('user')->get();
        $enrolled = $subject->students->pluck('id')->toArray();
        return view('admin.subjects.enroll', compact('subject', 'students', 'enrolled'));
    }

    public function updateEnrollment(Request $request, Subject $subject)
    {
        $subject->students()->sync($request->students ?? []);
        return redirect()->route('admin.subjects')->with('success', 'Enrollment updated successfully');
    }
}