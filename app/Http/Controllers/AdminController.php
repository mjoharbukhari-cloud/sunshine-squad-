<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Deal;
use Auth;

class ShopkeeperController extends Controller
{
    // ------------------------
    // DASHBOARD
    // ------------------------
    public function dashboard()
    {
        $shopId = auth()->user()->shop?->id;

        $products = Product::where('shop_id', $shopId)->get();
        $deals = Deal::where('shop_id', $shopId)->get();

        return view('dashboard.shopkeeper', compact('products', 'deals'));
    }

    // ------------------------
    // SHOP MANAGEMENT
    // ------------------------
    public function createShop()
    {
        return view('shopkeeper.shop_create');
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $shop = new Shop();
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->owner_id = Auth::id();
        $shop->save();

        return redirect()->route('shopkeeper.dashboard')->with('success', 'Shop created successfully.');
    }

    // ------------------------
    // PRODUCT MANAGEMENT
    // ------------------------
    public function products()
    {
        $shopId = auth()->user()->shop?->id;
        $products = Product::where('shop_id', $shopId)->get();
        return view('shopkeeper.products', compact('products'));
    }

    public function createProduct()
    {
        return view('shopkeeper.product_create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $shopId = auth()->user()->shop?->id;

        $product = new Product();
        $product->shop_id = $shopId;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Product added successfully.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('shopkeeper.product_edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('shopkeeper.products')->with('success', 'Product deleted successfully.');
    }

    // ------------------------
    // DEAL MANAGEMENT
    // ------------------------
    public function deals()
    {
        $shopId = auth()->user()->shop?->id;
        $deals = Deal::where('shop_id', $shopId)->orderBy('created_at', 'desc')->get();
        return view('shopkeeper.deals', compact('deals'));
    }

    public function createDeal()
    {
        return view('shopkeeper.deal_create');
    }

    public function storeDeal(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $shopId = auth()->user()->shop?->id;

        $deal = new Deal();
        $deal->shop_id = $shopId;
        $deal->title = $request->title;
        $deal->description = $request->description;
        $deal->price = $request->price;
        $deal->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Deal added successfully.');
    }

    public function editDeal($id)
    {
        $deal = Deal::findOrFail($id);
        return view('shopkeeper.deal_edit', compact('deal'));
    }

    public function updateDeal(Request $request, $id)
    {
        $deal = Deal::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $deal->title = $request->title;
        $deal->description = $request->description;
        $deal->price = $request->price;
        $deal->quantity = $request->quantity;

        if ($request->hasFile('image')) {
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Deal updated successfully.');
    }

    public function deleteDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->delete();
        return redirect()->route('shopkeeper.deals')->with('success', 'Deal deleted successfully.');
    }
}
