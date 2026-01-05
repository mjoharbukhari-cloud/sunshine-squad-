<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;

class AdminController extends Controller
{
    public function products()
    {
        return Product::where('status', 'pending')->get();
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->status = 'approved';
        $product->save();
        return response()->json(['message' => 'Product approved']);
    }

    public function deals()
    {
        return Deal::where('status', 'pending')->get();
    }

    public function approveDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->status = 'approved';
        $deal->save();
        return response()->json(['message' => 'Deal approved']);
    }
}
