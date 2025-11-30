<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // you can change emails to match your users
        if ($u = User::where('email', 'admin@example.com')->first()) {
            $u->role = 'Admin';
            $u->save();
        }
        if ($u = User::where('email', 'teacher@example.com')->first()) {
            $u->role = 'Teacher';
            $u->save();
        }
        if ($u = User::where('email', 'student@example.com')->first()) {
            $u->role = 'Student';
            $u->save();
        }
    }
}
