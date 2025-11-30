<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'employee_code',
        'department',
        'designation',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // teacher can have many subjects
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'teacher_id');
    }

    // Get all students enrolled in teacher's subjects
    public function students()
    {
        return Student::whereHas('subjects', function($query) {
            $query->where('teacher_id', $this->id);
        });
    }    
}
