<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'deal_id',          // <--- Added for Deals support
        'quantity',
        'total_price',
        'status',
        'delivery_address',
        'payment_method'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship: An order can belong to a Deal.
     */
    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shop(): HasOneThrough
    {
        return $this->hasOneThrough(Shop::class, Product::class, 'id', 'id', 'product_id', 'shop_id');
    }
}