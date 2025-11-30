<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ForceUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if role column exists
        $hasRoleColumn = DB::getSchemaBuilder()->hasColumn('users', 'role');
        
        // Delete existing demo users first
        User::whereIn('email', [
            'admin@attendify.com',
            'john@attendify.com', 
            'alice@attendify.com'
        ])->delete();

        // Prepare user data
        $baseData = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Force create admin user
        $adminData = array_merge($baseData, [
            'name' => 'Admin User',
            'email' => 'admin@attendify.com',
            'password' => Hash::make('password'),
        ]);
        if ($hasRoleColumn) {
            $adminData['role'] = 'Admin';
        }
        DB::table('users')->insert($adminData);

        // Force create teacher user
        $teacherData = array_merge($baseData, [
            'name' => 'John Smith',
            'email' => 'john@attendify.com',
            'password' => Hash::make('password'),
        ]);
        if ($hasRoleColumn) {
            $teacherData['role'] = 'Teacher';
        }
        DB::table('users')->insert($teacherData);

        // Force create student user
        $studentData = array_merge($baseData, [
            'name' => 'Alice Brown',
            'email' => 'alice@attendify.com',
            'password' => Hash::make('password'),
        ]);
        if ($hasRoleColumn) {
            $studentData['role'] = 'Student';
        }
        DB::table('users')->insert($studentData);

        echo "✓ Force created 3 demo users\n";
        echo "✓ Role column exists: " . ($hasRoleColumn ? 'YES' : 'NO') . "\n";
        echo "✓ admin@attendify.com / password\n";
        echo "✓ john@attendify.com / password\n";
        echo "✓ alice@attendify.com / password\n";
    }
}