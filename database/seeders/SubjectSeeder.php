<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Teacher;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();
        
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'description' => 'Basic Mathematics'],
            ['name' => 'Physics', 'code' => 'PHY101', 'description' => 'Introduction to Physics'],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'description' => 'Basic Chemistry'],
            ['name' => 'Computer Science', 'code' => 'CS101', 'description' => 'Programming Fundamentals'],
            ['name' => 'English', 'code' => 'ENG101', 'description' => 'English Literature'],
        ];

        foreach ($subjects as $index => $subjectData) {
            Subject::create([
                'name' => $subjectData['name'],
                'code' => $subjectData['code'],
                'description' => $subjectData['description'],
                'teacher_id' => $teachers[$index % $teachers->count()]->id,
            ]);
        }
    }
}