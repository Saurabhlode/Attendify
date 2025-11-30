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
use Carbon\Carbon;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Creating comprehensive demo data for Attendify...');
        
        // 1. Create Academic Term
        $term = AcademicTerm::updateOrCreate(
            ['name' => 'Fall 2024'],
            [
                'start_date' => '2024-09-01',
                'end_date' => '2024-12-15',
                'is_active' => true,
            ]
        );
        $this->command->info('✓ Academic term created: Fall 2024');

        // 2. Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@attendify.com'],
            [
                'name' => 'Dr. Sarah Wilson',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ]
        );
        $this->command->info('✓ Admin created: admin@attendify.com');

        // 3. Create Teachers
        $teachers = [
            [
                'name' => 'Prof. John Smith',
                'email' => 'john@attendify.com',
                'employee_code' => 'CS001',
                'department' => 'Computer Science',
                'designation' => 'Professor',
            ],
            [
                'name' => 'Dr. Emily Davis',
                'email' => 'emily@attendify.com',
                'employee_code' => 'MATH001',
                'department' => 'Mathematics',
                'designation' => 'Associate Professor',
            ],
            [
                'name' => 'Mr. Michael Brown',
                'email' => 'michael@attendify.com',
                'employee_code' => 'PHY001',
                'department' => 'Physics',
                'designation' => 'Assistant Professor',
            ],
        ];

        $teacherModels = [];
        foreach ($teachers as $teacherData) {
            $user = User::updateOrCreate(
                ['email' => $teacherData['email']],
                [
                    'name' => $teacherData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'Teacher',
                ]
            );

            $teacherModels[] = Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_code' => $teacherData['employee_code'],
                    'department' => $teacherData['department'],
                    'designation' => $teacherData['designation'],
                ]
            );
        }
        $this->command->info('✓ Teachers created: 3 teachers');

        // 4. Create Students
        $students = [
            ['name' => 'Alice Johnson', 'email' => 'alice@attendify.com', 'roll_no' => 'CS2024001', 'class' => 'CS-A'],
            ['name' => 'Bob Wilson', 'email' => 'bob@attendify.com', 'roll_no' => 'CS2024002', 'class' => 'CS-A'],
            ['name' => 'Charlie Davis', 'email' => 'charlie@attendify.com', 'roll_no' => 'CS2024003', 'class' => 'CS-A'],
            ['name' => 'Diana Miller', 'email' => 'diana@attendify.com', 'roll_no' => 'CS2024004', 'class' => 'CS-B'],
            ['name' => 'Eva Garcia', 'email' => 'eva@attendify.com', 'roll_no' => 'CS2024005', 'class' => 'CS-B'],
            ['name' => 'Frank Martinez', 'email' => 'frank@attendify.com', 'roll_no' => 'CS2024006', 'class' => 'CS-B'],
            ['name' => 'Grace Lee', 'email' => 'grace@attendify.com', 'roll_no' => 'CS2024007', 'class' => 'CS-A'],
            ['name' => 'Henry Taylor', 'email' => 'henry@attendify.com', 'roll_no' => 'CS2024008', 'class' => 'CS-A'],
        ];

        $studentModels = [];
        foreach ($students as $studentData) {
            $user = User::updateOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'Student',
                ]
            );

            $studentModels[] = Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'roll_no' => $studentData['roll_no'],
                    'class' => $studentData['class'],
                    'enrollment_year' => 2024,
                    'program' => 'Bachelor of Computer Science',
                ]
            );
        }
        $this->command->info('✓ Students created: 8 students');

        // 5. Create Subjects
        $subjects = [
            [
                'code' => 'CS101',
                'name' => 'Introduction to Programming',
                'teacher_id' => $teacherModels[0]->id,
                'semester' => 'Fall 2024',
                'credits' => 4,
                'description' => 'Fundamentals of programming using Python',
            ],
            [
                'code' => 'MATH201',
                'name' => 'Discrete Mathematics',
                'teacher_id' => $teacherModels[1]->id,
                'semester' => 'Fall 2024',
                'credits' => 3,
                'description' => 'Mathematical foundations for computer science',
            ],
            [
                'code' => 'PHY101',
                'name' => 'Physics for Engineers',
                'teacher_id' => $teacherModels[2]->id,
                'semester' => 'Fall 2024',
                'credits' => 3,
                'description' => 'Basic physics concepts for engineering students',
            ],
            [
                'code' => 'CS201',
                'name' => 'Data Structures & Algorithms',
                'teacher_id' => $teacherModels[0]->id,
                'semester' => 'Fall 2024',
                'credits' => 4,
                'description' => 'Advanced programming concepts and algorithms',
            ],
        ];

        $subjectModels = [];
        foreach ($subjects as $subjectData) {
            $subjectModels[] = Subject::updateOrCreate(
                ['code' => $subjectData['code']],
                $subjectData
            );
        }
        $this->command->info('✓ Subjects created: 4 subjects');

        // 6. Enroll students in subjects
        foreach ($studentModels as $student) {
            // Enroll each student in 2-3 random subjects
            $enrollSubjects = collect($subjectModels)->random(rand(2, 3));
            foreach ($enrollSubjects as $subject) {
                $student->subjects()->syncWithoutDetaching([
                    $subject->id => [
                        'enrollment_status' => 'active',
                        'enrolled_at' => now()->subDays(rand(1, 30)),
                    ]
                ]);
            }
        }
        $this->command->info('✓ Student enrollments completed');

        // 7. Create Class Sessions (last 30 days)
        $sessions = [];
        foreach ($subjectModels as $subject) {
            // Create 3 sessions per week for each subject
            for ($i = 0; $i < 12; $i++) {
                $date = now()->subDays(rand(1, 30));
                $sessions[] = ClassSession::create([
                    'subject_id' => $subject->id,
                    'academic_term_id' => $term->id,
                    'session_date' => $date->format('Y-m-d'),
                    'start_time' => $date->setTime(9 + ($i % 4), 0)->format('H:i:s'),
                    'end_time' => $date->setTime(10 + ($i % 4), 30)->format('H:i:s'),
                    'topic' => 'Session ' . ($i + 1) . ' - ' . $subject->name,
                    'session_type' => ['lecture', 'lab', 'tutorial'][rand(0, 2)],
                ]);
            }
        }
        $this->command->info('✓ Class sessions created: ' . count($sessions) . ' sessions');

        // 8. Create Attendance Records
        $attendanceCount = 0;
        foreach ($sessions as $session) {
            $subject = Subject::find($session->subject_id);
            $enrolledStudents = $subject->students;
            
            foreach ($enrolledStudents as $student) {
                // 85% attendance rate with realistic patterns
                $status = 'present';
                $random = rand(1, 100);
                if ($random <= 10) $status = 'absent';
                elseif ($random <= 15) $status = 'late';
                
                Attendance::create([
                    'class_session_id' => $session->id,
                    'student_id' => $student->id,
                    'status' => $status,
                    'marked_by' => $subject->teacher->user_id,
                    'marked_at' => $session->created_at->addMinutes(rand(5, 15)),
                    'remarks' => $status === 'late' ? 'Arrived 10 minutes late' : null,
                ]);
                $attendanceCount++;
            }
        }
        $this->command->info('✓ Attendance records created: ' . $attendanceCount . ' records');

        // Summary
        $this->command->info('');
        $this->command->info('🎉 Demo data creation completed!');
        $this->command->info('📊 Summary:');
        $this->command->info('   • 1 Admin user');
        $this->command->info('   • 3 Teachers');
        $this->command->info('   • 8 Students');
        $this->command->info('   • 4 Subjects');
        $this->command->info('   • 1 Academic term');
        $this->command->info('   • ' . count($sessions) . ' Class sessions');
        $this->command->info('   • ' . $attendanceCount . ' Attendance records');
        $this->command->info('');
        $this->command->info('🔑 Login Credentials (all use password: password):');
        $this->command->info('   👨‍💼 Admin: admin@attendify.com');
        $this->command->info('   👨‍🏫 Teacher: john@attendify.com, emily@attendify.com, michael@attendify.com');
        $this->command->info('   👨‍🎓 Student: alice@attendify.com, bob@attendify.com, charlie@attendify.com, etc.');
    }
}