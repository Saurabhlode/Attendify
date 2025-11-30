<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'teacher_id',
        'semester',
        'credits',
        'description',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    // teacher relation
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // students (many-to-many)
    public function students()
    {
        return $this->belongsToMany(Student::class, 'subject_student', 'subject_id', 'student_id')
                    ->withPivot(['enrollment_status', 'enrolled_at'])
                    ->withTimestamps();
    }

    // class sessions
    public function classSessions()
    {
        return $this->hasMany(ClassSession::class);
    }    
}
