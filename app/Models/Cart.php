<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * Point exactly to the plural table name built by your migration 🎯
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     * Added 'deal_id' to allow saving deals to the cart.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'deal_id', // <--- Added this to fix the column not found/mass assignment error
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: A cart item can belong to a Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship: A cart item can belong to a Deal.
     * This allows your system to identify deals in the cart.
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}