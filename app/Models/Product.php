<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'shop_id',
        'approved'
    ];

    // Each product belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Many-to-many relationship with deals
    // This allows you to attach a product to multiple deals
    public function deals()
    {
        return $this->belongsToMany(Deal::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Product can have reviews (polymorphic)
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
