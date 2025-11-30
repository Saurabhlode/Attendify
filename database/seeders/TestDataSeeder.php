<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AcademicTerm;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@attendify.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        // Create Teachers
        $teacher1 = User::create([
            'name' => 'John Smith',
            'email' => 'john@attendify.com',
            'password' => Hash::make('password'),
            'role' => 'Teacher',
        ]);

        $teacherProfile1 = Teacher::create([
            'user_id' => $teacher1->id,
            'employee_code' => 'T001',
            'department' => 'Computer Science',
            'designation' => 'Professor',
        ]);

        $teacher2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@attendify.com',
            'password' => Hash::make('password'),
            'role' => 'Teacher',
        ]);

        $teacherProfile2 = Teacher::create([
            'user_id' => $teacher2->id,
            'employee_code' => 'T002',
            'department' => 'Mathematics',
            'designation' => 'Associate Professor',
        ]);

        // Create Students
        $student1 = User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@attendify.com',
            'password' => Hash::make('password'),
            'role' => 'Student',
        ]);

        $studentProfile1 = Student::create([
            'user_id' => $student1->id,
            'roll_no' => 'CS2021001',
            'enrollment_year' => 2021,
            'program' => 'Computer Science',
            'class' => 'FYCS',
        ]);

        $student2 = User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@attendify.com',
            'password' => Hash::make('password'),
            'role' => 'Student',
        ]);

        $studentProfile2 = Student::create([
            'user_id' => $student2->id,
            'roll_no' => 'CS2021002',
            'enrollment_year' => 2021,
            'program' => 'Computer Science',
            'class' => 'FYCS',
        ]);

        // Create Subjects
        $subject1 = Subject::create([
            'code' => 'CS101',
            'name' => 'Introduction to Programming',
            'teacher_id' => $teacherProfile1->id,
            'semester' => 'Fall 2024',
            'credits' => 3,
            'description' => 'Basic programming concepts',
        ]);

        $subject2 = Subject::create([
            'code' => 'MATH101',
            'name' => 'Calculus I',
            'teacher_id' => $teacherProfile2->id,
            'semester' => 'Fall 2024',
            'credits' => 4,
            'description' => 'Introduction to differential calculus',
        ]);

        // Enroll students in subjects
        $subject1->students()->attach([$studentProfile1->id, $studentProfile2->id]);
        $subject2->students()->attach([$studentProfile1->id, $studentProfile2->id]);

        // Create Academic Term
        AcademicTerm::create([
            'name' => 'Fall 2024',
            'start_date' => '2024-09-01',
            'end_date' => '2024-12-15',
            'is_active' => true,
        ]);
    }
}