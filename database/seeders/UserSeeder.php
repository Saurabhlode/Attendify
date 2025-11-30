<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@attendify.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ]
        );

        // Teacher Users
        $teacher1 = User::updateOrCreate(
            ['email' => 'john@attendify.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'role' => 'Teacher',
            ]
        );

        $teacher2 = User::updateOrCreate(
            ['email' => 'sarah@attendify.com'],
            [
                'name' => 'Sarah Johnson',
                'password' => Hash::make('password'),
                'role' => 'Teacher',
            ]
        );

        // Create Teacher records
        Teacher::updateOrCreate(
            ['user_id' => $teacher1->id],
            [
                'employee_code' => 'T001',
                'department' => 'Computer Science',
                'designation' => 'Senior Teacher',
            ]
        );

        Teacher::updateOrCreate(
            ['user_id' => $teacher2->id],
            [
                'employee_code' => 'T002',
                'department' => 'Mathematics',
                'designation' => 'Head of Department',
            ]
        );

        // Student Users
        $students = [
            ['name' => 'Alice Brown', 'email' => 'alice@attendify.com', 'student_id' => 'S001', 'class' => '10A'],
            ['name' => 'Bob Wilson', 'email' => 'bob@attendify.com', 'student_id' => 'S002', 'class' => '10A'],
            ['name' => 'Charlie Davis', 'email' => 'charlie@attendify.com', 'student_id' => 'S003', 'class' => '10B'],
            ['name' => 'Diana Miller', 'email' => 'diana@attendify.com', 'student_id' => 'S004', 'class' => '10B'],
            ['name' => 'Eva Garcia', 'email' => 'eva@attendify.com', 'student_id' => 'S005', 'class' => '11A'],
        ];

        foreach ($students as $studentData) {
            $user = User::updateOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'Student',
                ]
            );

            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'roll_no' => $studentData['student_id'],
                    'class' => $studentData['class'],
                    'enrollment_year' => 2024,
                    'program' => 'High School',
                ]
            );
        }
    }
}