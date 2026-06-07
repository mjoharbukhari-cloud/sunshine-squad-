<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Show all products with pagination and eager-loaded reviews
    public function index()
    {
        // Paginate by 12, eager-loading reviews for the offcanvas
        $products = Product::with('reviews')->latest()->paginate(18);
        
        return view('marketplace.products', compact('products'));
    }

    // Show single product with Related Item Recommendation Logic
    public function show($id)
    {
        $product = Product::with('reviews')->findOrFail($id);

        // Fetch related products based on similar description or name
        $relatedProducts = Product::where('id', '!=', $id)
            ->where(function($query) use ($product) {
                $query->where('name', 'LIKE', '%' . $product->name . '%')
                      ->orWhere('description', 'LIKE', '%' . ($product->description ?? 'none') . '%');
            })
            ->limit(6)
            ->get();

        return view('marketplace.product_detail', compact('product', 'relatedProducts'));
    }

    // Store method
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'shop_name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        // Standard storage path
        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'shop_name' => $request->shop_name,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }
}