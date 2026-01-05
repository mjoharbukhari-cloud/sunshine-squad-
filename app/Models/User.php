<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password'];

    // A user (shopkeeper) can own many shops
    public function shops() {
        return $this->hasMany(Shop::class, 'user_id', 'id');
    }

    // Products are linked to shops, not directly to users
    public function products() {
        return $this->hasManyThrough(
            Product::class,   // Final model
            Shop::class,      // Intermediate model
            'user_id',        // Foreign key on shops table
            'shop_id',        // Foreign key on products table
            'id',             // Local key on users table
            'id'              // Local key on shops table
        );
    }

    // Deals are also linked to shops
    public function deals() {
        return $this->hasManyThrough(
            Deal::class,
            Shop::class,
            'user_id',   // Foreign key on shops
            'shop_id',   // Foreign key on deals
            'id',        // Local key on users
            'id'         // Local key on shops
        );
    }

    // Orders relationship will only work once you create an orders table
    public function orders() {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
