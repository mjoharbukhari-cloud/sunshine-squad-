<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'image',
        'shop_id',
        'approved',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'approved' => 'boolean',
    ];

    /**
     * Relationship: Each deal belongs to a single shop.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
     * Relationship: Many-to-many relationship with products.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    /**
     * Relationship: A deal can have many reviews (Polymorphic).
     * This fixes the 500 Internal Server Error.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}