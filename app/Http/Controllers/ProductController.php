<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::latest()->get();
        return view('marketplace.products', compact('products'));
    }

    // Show single product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('marketplace.product_detail', compact('product'));
    }

    // Optional: store method if admin/shopkeeper uses this controller
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'shop_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $imageName = time().'_'.Str::slug($request->name).'.'.$request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'shop_name' => $request->shop_name,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}
