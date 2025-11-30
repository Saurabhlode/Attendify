<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Always run UserSeeder to ensure demo accounts exist
        $this->call([
            UserSeeder::class,
        ]);
        
        // Only seed other data if no users existed before UserSeeder
        if (\App\Models\User::count() <= 7) { // 7 users from UserSeeder
            $this->call([
                SubjectSeeder::class,
                ClassSessionSeeder::class,
                AttendanceSeeder::class,
            ]);
        }
    }
}
