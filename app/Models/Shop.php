<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'user_id',  // Links to the shopkeeper (user)
    ];

    // Relationship: A shop belongs to a user (shopkeeper)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional: Relationship to products if shops have products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}