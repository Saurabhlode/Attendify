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
        // Only seed if no users exist
        if (\App\Models\User::count() === 0) {
            $this->call([
                UserSeeder::class,
                SubjectSeeder::class,
                ClassSessionSeeder::class,
                AttendanceSeeder::class,
            ]);
        }
    }
}
