<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('subjects');
    Route::get('/subjects/create', [\App\Http\Controllers\Admin\SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [\App\Http\Controllers\Admin\SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{subject}/enroll', [\App\Http\Controllers\Admin\SubjectController::class, 'enroll'])->name('subjects.enroll');
    Route::post('/subjects/{subject}/enroll', [\App\Http\Controllers\Admin\SubjectController::class, 'updateEnrollment'])->name('subjects.enrollment');
    Route::get('/terms', [\App\Http\Controllers\Admin\AcademicTermController::class, 'index'])->name('terms');
    Route::get('/terms/create', [\App\Http\Controllers\Admin\AcademicTermController::class, 'create'])->name('terms.create');
    Route::post('/terms', [\App\Http\Controllers\Admin\AcademicTermController::class, 'store'])->name('terms.store');
    Route::get('/reports/attendance', [\App\Http\Controllers\Admin\ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/export', [\App\Http\Controllers\Admin\ReportController::class, 'exportAttendance'])->name('reports.export');
});

// Teacher Routes
Route::middleware(['auth', 'role:Teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/subjects', [TeacherController::class, 'subjects'])->name('subjects');
    Route::get('/sessions', [TeacherController::class, 'classSessions'])->name('sessions');
    Route::get('/subjects/{subject}/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/subjects/{subject}/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'store'])->name('attendance.store');
});

// Student Routes
Route::middleware(['auth', 'role:Student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/subjects', [StudentController::class, 'subjects'])->name('subjects');
    Route::get('/attendance', [StudentController::class, 'attendance'])->name('attendance');
    Route::post('/sessions/{session}/mark', [\App\Http\Controllers\Student\AttendanceController::class, 'markSelf'])->name('attendance.mark');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
