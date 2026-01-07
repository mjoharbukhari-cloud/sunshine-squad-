<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // points to resources/views/auth/register.blade.php
    }

    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:customer,shopkeeper',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeMail($user));

        // Log the user in
        Auth::login($user);

        // Redirect to homepage/dashboard with success message
        return redirect('/')->with('status', 'Welcome! You are registered.');
    }
}
