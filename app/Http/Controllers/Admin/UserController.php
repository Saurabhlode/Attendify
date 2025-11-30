<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:Admin,Teacher,Student',
            'roll_no' => 'required_if:role,Student',
            'employee_code' => 'required_if:role,Teacher',
            'department' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => $request->role,
        ]);

        if ($request->role === 'Student') {
            Student::create([
                'user_id' => $user->id,
                'roll_no' => $request->roll_no,
                'enrollment_year' => date('Y'),
                'program' => $request->program,
            ]);
        } elseif ($request->role === 'Teacher') {
            Teacher::create([
                'user_id' => $user->id,
                'employee_code' => $request->employee_code,
                'department' => $request->department,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:Admin,Teacher,Student',
        ]);

        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}