<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $deals = Deal::where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('marketplace.home', compact('products', 'deals'));
    }
}
