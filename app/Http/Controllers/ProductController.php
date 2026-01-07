<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('approved', true)->get();  // Only approved products
        return view('marketplace.products', compact('products'));
    }

    public function create()
    {
        return view('shopkeeper.create_product');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'user_id' => auth()->id(),
        ]);

        return redirect('/products')->with('status', 'Product submitted for approval!');
    }

    // Add other methods (show, edit, update, destroy) as needed
}