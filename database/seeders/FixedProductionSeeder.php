<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AcademicTerm;
use App\Models\ClassSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FixedProductionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Creating fixed demo data...');
        
        // Clear existing data
        Attendance::truncate();
        ClassSession::truncate();
        DB::table('subject_student')->truncate();
        Subject::truncate();
        Student::truncate();
        Teacher::truncate();
        User::truncate();
        
        // 1. Create Admin
        $admin = User::create([
            'name' => 'Dr. Sarah Wilson',
            'email' => 'admin@attendify.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);
        $this->command->info('✓ Admin created');

        // 2. Create Teachers
        $teacherUsers = [
            ['name' => 'Prof. John Smith', 'email' => 'john@attendify.com'],
            ['name' => 'Dr. Emily Davis', 'email' => 'emily@attendify.com'],
            ['name' => 'Mr. Michael Brown', 'email' => 'michael@attendify.com'],
        ];

        $teachers = [];
        foreach ($teacherUsers as $index => $teacherData) {
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password'),
                'role' => 'Teacher',
            ]);

            $teachers[] = Teacher::create([
                'user_id' => $user->id,
                'employee_code' => 'T' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'department' => ['Computer Science', 'Mathematics', 'Physics'][$index],
                'designation' => 'Professor',
            ]);
        }
        $this->command->info('✓ 3 Teachers created');

        // 3. Create Students
        $studentUsers = [
            'Alice Johnson', 'Bob Wilson', 'Charlie Davis', 'Diana Miller',
            'Eva Garcia', 'Frank Martinez', 'Grace Lee', 'Henry Taylor',
            'Ivy Chen', 'Jack Robinson', 'Kate Anderson', 'Liam Thompson'
        ];

        $students = [];
        foreach ($studentUsers as $index => $name) {
            $email = strtolower(explode(' ', $name)[0]) . '@attendify.com';
            
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'Student',
            ]);

            $students[] = Student::create([
                'user_id' => $user->id,
                'roll_no' => 'CS2024' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'class' => $index % 2 == 0 ? 'CS-A' : 'CS-B',
                'enrollment_year' => 2024,
                'program' => 'Bachelor of Computer Science',
            ]);
        }
        $this->command->info('✓ 12 Students created');

        // 4. Create Subjects
        $subjectData = [
            ['code' => 'CS101', 'name' => 'Programming', 'teacher_id' => $teachers[0]->id],
            ['code' => 'MATH201', 'name' => 'Mathematics', 'teacher_id' => $teachers[1]->id],
            ['code' => 'PHY101', 'name' => 'Physics', 'teacher_id' => $teachers[2]->id],
            ['code' => 'CS201', 'name' => 'Data Structures', 'teacher_id' => $teachers[0]->id],
        ];

        $subjects = [];
        foreach ($subjectData as $data) {
            $subjects[] = Subject::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'teacher_id' => $data['teacher_id'],
                'semester' => 'Fall 2024',
                'credits' => 3,
            ]);
        }
        $this->command->info('✓ 4 Subjects created');

        // 5. Enroll students
        foreach ($students as $student) {
            $enrollSubjects = collect($subjects)->random(rand(2, 3));
            foreach ($enrollSubjects as $subject) {
                $student->subjects()->attach($subject->id, [
                    'enrollment_status' => 'active',
                    'enrolled_at' => now(),
                ]);
            }
        }
        $this->command->info('✓ Enrollments completed');

        // 6. Create Sessions and Attendance
        $totalAttendance = 0;
        foreach ($subjects as $subject) {
            for ($i = 0; $i < 20; $i++) {
                $session = ClassSession::create([
                    'subject_id' => $subject->id,
                    'date' => now()->subDays(rand(1, 60))->format('Y-m-d'),
                    'start_time' => '09:00:00',
                    'end_time' => '10:30:00',
                    'topic' => 'Session ' . ($i + 1),
                    'session_type' => 'lecture',
                ]);

                foreach ($subject->students as $student) {
                    $status = rand(1, 100) <= 85 ? 'present' : (rand(1, 100) <= 50 ? 'late' : 'absent');
                    
                    Attendance::create([
                        'class_session_id' => $session->id,
                        'student_id' => $student->id,
                        'status' => $status,
                        'marked_by' => $subject->teacher->user_id,
                        'marked_at' => now(),
                    ]);
                    $totalAttendance++;
                }
            }
        }

        $this->command->info('✓ ' . $totalAttendance . ' Attendance records created');
        $this->command->info('🎉 Fixed demo data completed!');
    }
}