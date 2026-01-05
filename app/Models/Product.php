<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'shop_id', 'title', 'description', 'price', 'color', 'quantity', 'image_path', 'status'
    ];

    public function shop() {
        return $this->belongsTo(Shop::class);
    }
}
