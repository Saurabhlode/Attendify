<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Force create demo users for production
        $this->command->info('Creating demo users for production...');
        
        // Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@attendify.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ]
        );
        $this->command->info('✓ Admin user created: admin@attendify.com');

        // Teacher User
        $teacher = User::updateOrCreate(
            ['email' => 'john@attendify.com'],
            [
                'name' => 'John Smith',
                'password' => Hash::make('password'),
                'role' => 'Teacher',
            ]
        );

        Teacher::updateOrCreate(
            ['user_id' => $teacher->id],
            [
                'employee_code' => 'T001',
                'department' => 'Computer Science',
                'designation' => 'Senior Teacher',
            ]
        );
        $this->command->info('✓ Teacher user created: john@attendify.com');

        // Student User
        $student = User::updateOrCreate(
            ['email' => 'alice@attendify.com'],
            [
                'name' => 'Alice Brown',
                'password' => Hash::make('password'),
                'role' => 'Student',
            ]
        );

        Student::updateOrCreate(
            ['user_id' => $student->id],
            [
                'roll_no' => 'S001',
                'class' => '10A',
                'enrollment_year' => 2024,
                'program' => 'High School',
            ]
        );
        $this->command->info('✓ Student user created: alice@attendify.com');
        
        $this->command->info('Demo users created successfully!');
        $this->command->info('Login credentials: email / password');
    }
}