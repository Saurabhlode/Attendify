<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BasicUserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing users
        DB::table('users')->truncate();

        // Create users without role column (will use default from migration)
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@attendify.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Smith',
                'email' => 'john@attendify.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@attendify.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        echo "✓ Created 3 basic demo users\n";
        echo "✓ admin@attendify.com / password\n";
        echo "✓ john@attendify.com / password\n";
        echo "✓ alice@attendify.com / password\n";
    }
}