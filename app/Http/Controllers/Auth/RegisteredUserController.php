<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:Student,Teacher'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Create role-specific record
        try {
            if ($request->role === 'Student') {
                \App\Models\Student::create([
                    'user_id' => $user->id,
                    'roll_no' => 'S' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                    'enrollment_year' => date('Y'),
                    'program' => 'General',
                ]);
            } elseif ($request->role === 'Teacher') {
                \App\Models\Teacher::create([
                    'user_id' => $user->id,
                    'employee_code' => 'T' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                    'department' => 'General',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Role record creation failed: ' . $e->getMessage());
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
