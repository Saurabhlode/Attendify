<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassSession;
use App\Models\Subject;

class ClassSessionSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            // Create today's session
            ClassSession::create([
                'subject_id' => $subject->id,
                'date' => now()->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '10:30',
                'topic' => 'Introduction to ' . $subject->name,
                'session_type' => 'lecture',
            ]);

            // Create yesterday's session
            ClassSession::create([
                'subject_id' => $subject->id,
                'date' => now()->subDay()->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '10:30',
                'topic' => 'Chapter 1 - Basics',
                'session_type' => 'lecture',
            ]);
        }
    }
}