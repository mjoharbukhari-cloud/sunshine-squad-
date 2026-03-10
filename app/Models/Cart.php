<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * The user who owns this cart item
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The product associated with this cart item
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
