<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:customer,shopkeeper',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hashed securely
            'role'     => $request->role,
        ]);

        // Auto login
        Auth::login($user);

        // Role based redirect
        return match ($user->role) {
            'shopkeeper' => redirect('/shopkeeper/dashboard'),
            'customer'   => redirect('/customer/dashboard'),
            default      => redirect('/login'),
        };
    }
}
