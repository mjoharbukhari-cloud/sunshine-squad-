<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Excellent! This is exactly where it belongs.

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar' // Added to prevent future image upload mass-assignment crashes
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Automatically handles secure password hashing and encryption strings 🔐
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // ONE USER → ONE SHOP (Perfect relationship definition for your multi-vendor logic)
    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id');
    }
    // Add this inside your User class so the user can fetch their orders
public function orders()
{
    return $this->hasMany(Order::class, 'customer_id')->latest();
}

// Assuming you have a Cart model linked by user_id or customer_id:
public function cartItems()
{
    return $this->hasMany(Cart::class, 'user_id'); // adjust foreign key if it's 'customer_id'
}
}