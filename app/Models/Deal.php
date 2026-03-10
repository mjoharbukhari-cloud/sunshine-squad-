<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'image',
        'shop_id',
        'approved',
    ];

    // Each deal belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Many-to-many relationship with products
    // Uses pivot table 'deal_product' with 'quantity'
    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
