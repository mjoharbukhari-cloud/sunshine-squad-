<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Storage;

class ShopkeeperController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        // Ensure the shop exists for this shopkeeper
        $shop = Shop::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => auth()->user()->name . "'s Shop",
                'description' => 'Default shop description',
                'address' => 'Default Address', // Add default for new column
                'approved' => 1,
            ]
        );

        // Get products and deals of this shop
        $products = Product::where('shop_id', $shop->id)->get();
        $deals = Deal::where('shop_id', $shop->id)->get();

        return view('dashboard.shopkeeper', compact('shop', 'products', 'deals'));
    }

    // PRODUCTS
    public function products()
    {
        $shop = Shop::where('user_id', auth()->id())->first();
        $products = Product::where('shop_id', $shop->id)->get();
        return view('shopkeeper.products', compact('products'));
    }

    public function createProduct()
    {
        return view('shopkeeper.product_create'); // Make sure file is: resources/views/shopkeeper/products_create.blade.php
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->first();

        $product = new Product();
        $product->shop_id = $shop->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;

        // Handle image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path; // Only path, Blade will handle asset()
        } else {
            $product->image = 'product-placeholder.jpg';
        }

        $product->approved = 1; // Show instantly on homepage
        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Product added successfully!');
    }

    public function editProduct($id)
    {
        $shop = Shop::where('user_id', auth()->id())->first();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);
        return view('shopkeeper.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->first();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $shop = Shop::where('user_id', auth()->id())->first();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('shopkeeper.products')->with('success', 'Product deleted successfully!');
    }

    // DEALS
    public function deals()
    {
        $shop = Shop::where('user_id', auth()->id())->first();
        $deals = Deal::where('shop_id', $shop->id)->get();
        return view('shopkeeper.deals', compact('deals'));
    }

    public function createDeal()
    {
        return view('shopkeeper.deals.create'); // Make sure file exists
    }

    public function storeDeal(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->first();

        $deal = new Deal();
        $deal->shop_id = $shop->id;
        $deal->title = $request->title;
        $deal->price = $request->price;
        $deal->description = $request->description;

        // Handle image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('deals', 'public');
            $deal->image = $path;
        } else {
            $deal->image = 'deal-placeholder.jpg';
        }

        $deal->approved = 1; // Show instantly on homepage
        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Deal added successfully!');
    }

    public function editDeal($id)
    {
        $shop = Shop::where('user_id', auth()->id())->first();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);
        return view('shopkeeper.deal_edit', compact('deal'));
    }

    public function updateDeal(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->first();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        $deal->title = $request->title;
        $deal->price = $request->price;
        $deal->description = $request->description;

        if ($request->hasFile('image')) {
            if ($deal->image && Storage::disk('public')->exists($deal->image)) {
                Storage::disk('public')->delete($deal->image);
            }
            $path = $request->file('image')->store('deals', 'public');
            $deal->image = $path;
        }

        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Deal updated successfully!');
    }

    public function deleteDeal($id)
    {
        $shop = Shop::where('user_id', auth()->id())->first();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        if ($deal->image && Storage::disk('public')->exists($deal->image)) {
            Storage::disk('public')->delete($deal->image);
        }

        $deal->delete();
        return redirect()->route('shopkeeper.deals')->with('success', 'Deal deleted successfully!');
    }
}
