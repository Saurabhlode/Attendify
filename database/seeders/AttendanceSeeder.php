<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\Student;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = ClassSession::all();
        $students = Student::all();
        
        foreach ($sessions as $session) {
            foreach ($students as $student) {
                Attendance::create([
                    'class_session_id' => $session->id,
                    'student_id' => $student->id,
                    'status' => fake()->randomElement(['present', 'late', 'absent']),
                    'marked_at' => fake()->dateTimeBetween($session->date, $session->date->addDay()),
                    'marked_by' => $session->subject->teacher->user_id,
                ]);
            }
        }
    }
}