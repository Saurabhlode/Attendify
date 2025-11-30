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

    // convenience to get roster via subject -> students
    public function students()
    {
        return $this->hasManyThrough(Student::class, Subject::class, 'teacher_id', 'id', 'id', 'id');
    }    
}
