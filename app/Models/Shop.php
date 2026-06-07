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
        'user_id',
        'approved' // Added for admin shop verification/approval workflows
    ];

    /**
     * Get the owner of the shop.
     * * Explicitly pointing 'user_id' as the foreign key because 
     * the method name 'owner' differs from the standard 'user' naming convention.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Standard user relationship alias.
     * Useful for built-in Laravel shortcuts and background checks.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all products associated with this marketplace shop.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all bundled marketing deals/packages created by this shop.
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}