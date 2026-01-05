<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model {
    use HasFactory;

    protected $fillable = [
        'shop_id', 'title', 'description', 'service_range', 'product_price', 'service_price', 'status'
    ];

    public function shop() {
        return $this->belongsTo(Shop::class);
    }
}
