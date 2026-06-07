<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'shop_id',
        'name',
        'shop_name',
        'description',
        'price',
        'quantity',
        'image',
        'approved'
    ];

    /**
     * Scope: Only get products that are approved.
     * Use this in your controller to keep the marketplace clean.
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    /**
     * Relationship: Each product belongs to a specific vendor shop.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Many-to-many relationship with promo bundles (deals).
     */
    public function deals()
    {
        return $this->belongsToMany(Deal::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /**
     * Polymorphic Relationship: A product can have multiple customer reviews.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}