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
        'user_id'
    ];

    // SHOP OWNER
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // SHOP PRODUCTS
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // SHOP DEALS
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
