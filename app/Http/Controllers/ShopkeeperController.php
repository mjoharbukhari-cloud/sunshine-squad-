<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Storage;

class ShopkeeperController extends Controller
{
    /**
     * Enforce authentication access barriers for multi-vendor roles.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Main Premium Vendor Analytics Control Hub
     * Automatically sets up a default profile if one does not exist.
     */
    public function dashboard()
    {
        // Auto-creates the store instantly so the dashboard never breaks
        $shop = Shop::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => auth()->user()->name . "'s Eco Shop",
                'description' => 'Solar hardware and residential automation smart products.',
                'address' => 'Main Marketplace Hub Street',
                'approved' => 1,
            ]
        );

        $products = Product::where('shop_id', $shop->id)->get();
        $deals = Deal::where('shop_id', $shop->id)->get();

        // Looks for incoming customer order items if the order items table exists
        $incomingOrders = class_exists('\App\Models\OrderItem')
            ? \App\Models\OrderItem::with(['product', 'order'])->where('shop_id', $shop->id)->latest()->get()
            : collect(); 

        return view('dashboard.shopkeeper', compact('shop', 'products', 'deals', 'incomingOrders'));
    }

    /**
     * Edit Shop Profile Settings
     */
    public function editShop()
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        return view('shopkeeper.edit-shop', compact('shop'));
    }

    /**
     * Update Shop Profile Settings
     */
    public function updateShop(Request $request, $id)
    {
        $shop = Shop::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        $shop->update($request->only(['name', 'description', 'address']));

        return redirect()->route('shopkeeper.dashboard')->with('success', 'Store parameters updated successfully.');
    }

    /**
     * Update order state item records processing
     */
    public function updateOrderItemStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,shipped,delivered']);
        
        if (class_exists('\App\Models\OrderItem')) {
            $shop = Shop::where('user_id', auth()->id())->firstOrFail();
            $orderItem = \App\Models\OrderItem::where('shop_id', $shop->id)->findOrFail($id);
            $orderItem->update(['status' => $request->status]);
            
            return redirect()->back()->with('success', 'Order delivery status modified.');
        }

        return redirect()->back()->with('error', 'OrderItem database table is missing.');
    }

    // ==========================================
    // INVENTORY MANAGEMENT (PRODUCTS)
    // ==========================================
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0', 
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        $product = new Product();
        $product->shop_id = $shop->id;
        $product->shop_name = $shop->name; // Core fix for structural field requirement
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity; 
        $product->description = $request->description;

        // FIXED: Handles empty uploads safely by using an empty fallback string
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        } else {
            $product->image = ''; // Satisfies MySQL's "Field doesn't have a default value" error
        }

        $product->approved = 1; 
        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Smart grid hardware item listed.');
    }

    public function editProduct($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        return view('shopkeeper.products_edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        $product->name = $request->name;
        $product->shop_name = $shop->name; // Core fix to keep field in sync during edits
        $product->price = $request->price;
        $product->quantity = $request->quantity; 
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            if ($product->image && $product->image !== '') {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('shopkeeper.products')->with('success', 'Hardware asset metrics updated.');
    }

    public function deleteProduct($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $product = Product::where('shop_id', $shop->id)->findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('shopkeeper.products')->with('success', 'Stock item removed successfully.');
    }

    // ==========================================
    // BUNDLE SYSTEM MANAGEMENT (DEALS)
    // ==========================================
    public function deals()
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deals = Deal::where('shop_id', $shop->id)->get();
        return view('shopkeeper.deals', compact('deals'));
    }

    public function createDeal()
    {
        return view('shopkeeper.deals-create');
    }

    public function storeDeal(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();

        $deal = new Deal();
        $deal->shop_id = $shop->id;
        $deal->title = $request->title;
        $deal->price = $request->price;
        $deal->description = $request->description;

        if ($request->hasFile('image')) {
            $deal->image = $request->file('image')->store('deals', 'public');
        } else {
            $deal->image = ''; // Safety check fallback value
        }

        $deal->approved = 1;
        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Promotional bundle saved.');
    }

    public function editDeal($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        return view('shopkeeper.deal_edit', compact('deal'));
    }

    public function updateDeal(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        $deal->title = $request->title;
        $deal->price = $request->price;
        $deal->description = $request->description;

        if ($request->hasFile('image')) {
            if ($deal->image && $deal->image !== '') {
                Storage::disk('public')->delete($deal->image);
            }
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();

        return redirect()->route('shopkeeper.deals')->with('success', 'Bundle parameters updated.');
    }

    public function deleteDeal($id)
    {
        $shop = Shop::where('user_id', auth()->id())->firstOrFail();
        $deal = Deal::where('shop_id', $shop->id)->findOrFail($id);

        if ($deal->image) {
            Storage::disk('public')->delete($deal->image);
        }
        $deal->delete();

        return redirect()->route('shopkeeper.deals')->with('success', 'Bundle dropped from platform.');
    }
}