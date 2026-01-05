<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','product_id','quantity','total_price','status'];

    public function product() {
    return $this->belongsTo(Product::class);
}

public function customer() {
    return $this->belongsTo(User::class,'customer_id');
}

public function shop() {
    return $this->hasOneThrough(Shop::class, Product::class, 'id', 'id', 'product_id', 'shop_id');
}

}




