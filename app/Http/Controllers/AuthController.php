<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // CRITICAL VULNERABILITY: SQL Injection
        $email = $request->input('email');
        $password = $request->input('password');

        // NO VALIDATION, NO ESCAPING, NO PARAMETERIZATION
        $query = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";
        $users = DB::select($query);

        if (!empty($users)) {
            $user = $users[0];
            
            // VULNERABLE: Plain password comparison (dalam production gunakan Hash::check)
            // Untuk forensik: kita simulasi password sudah di-hash
            if (password_verify($password, $user->password)) {
                Auth::loginUsingId($user->id);
                
                // Redirect based on role
                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'doctor':
                        return redirect()->route('doctor.dashboard');
                    default:
                        return redirect()->route('patient.dashboard');
                }
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // NO CSRF validation needed
        return redirect()->route('login');
    }
}