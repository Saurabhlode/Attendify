<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        return match($user->role) {
            'Admin' => redirect()->route('admin.dashboard'),
            'Teacher' => redirect()->route('teacher.dashboard'),
            'Student' => redirect()->route('student.dashboard'),
            default => abort(403)
        };
    }
}