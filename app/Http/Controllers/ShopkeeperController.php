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
        $shop = Shop::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => auth()->user()->name . "'s Shop",
                'description' => 'Default shop description',
                'address' => 'Default Address',
                'approved' => 1,
            ]
        );

        $products = Product::where('shop_id', $shop->id)->get();
        $deals = Deal::where('shop_id', $shop->id)->get();

        return view('dashboard.shopkeeper', compact('shop', 'products', 'deals'));
    }

    // ================= PRODUCTS =================

    public function products()
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $products = Product::where('shop_id', $shop->id)->get();
        return view('shopkeeper.products', compact('products'));
    }

    public function createProduct()
    {
        return view('shopkeeper.product_create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        $product = new Product();
        $product->shop_id = $shop->id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->approved = 1;
        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Product added');
    }

    public function editProduct($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        return view('shopkeeper.product_edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        $product->update($request->only(['name', 'price', 'quantity', 'description']));

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Updated');
    }

    public function deleteProduct($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return back()->with('success', 'Deleted');
    }

    // ================= DEALS =================

    public function deals()
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deals = Deal::where('shop_id', $shop->id)->get();
        return view('shopkeeper.deals', compact('deals'));
    }

    public function createDeal()
    {
        return view('shopkeeper.deal_create');
    }

    public function storeDeal(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        $deal = new Deal();
        $deal->shop_id = $shop->id;
        $deal->title = $request->title;
        $deal->price = $request->price;
        $deal->description = $request->description;

        if ($request->hasFile('image')) {
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->approved = 1;
        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Deal added');
    }

    public function editDeal($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        return view('shopkeeper.deal_edit', compact('deal'));
    }

    public function updateDeal(Request $request, $id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        $deal->update($request->only(['title', 'price', 'description']));

        if ($request->hasFile('image')) {
            if ($deal->image) Storage::disk('public')->delete($deal->image);
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Updated');
    }

    public function deleteDeal($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        if ($deal->image) Storage::disk('public')->delete($deal->image);
        $deal->delete();

        return back()->with('success', 'Deleted');
    }
}