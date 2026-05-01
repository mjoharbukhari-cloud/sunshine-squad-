<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Admin Dashboard
     */
   public function dashboard()
{
    // Counts from DB
    $totalUsers = User::count();        // all registered users
    $totalProducts = Product::count();  // total products
    $totalDeals = Deal::count();        // total deals
    $totalShops = Shop::count();        // total shops

    // Pass variables exactly as Blade expects
    return view('dashboard.admin', compact('totalUsers', 'totalProducts', 'totalDeals', 'totalShops'));
}

    // ------------------------
    // USERS
    // ------------------------
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // ------------------------
    // SHOPS
    // ------------------------
    public function shops()
    {
        $shops = Shop::all();
        return view('admin.shops', compact('shops'));
    }

    public function createShop()
    {
        return view('admin.create_shop');
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Shop::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.shops')->with('success', 'Shop created successfully.');
    }

    public function editShop($id)
    {
        $shop = Shop::findOrFail($id);
        return view('admin.edit_shop', compact('shop'));
    }

    public function updateShop(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $shop = Shop::findOrFail($id);
        $shop->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.shops')->with('success', 'Shop updated successfully.');
    }

    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return redirect()->route('admin.shops')->with('success', 'Shop deleted successfully.');
    }

    // ------------------------
    // PRODUCTS
    // ------------------------
    public function products()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        $shops = Shop::all();
        return view('admin.products', compact('products', 'shops'));
    }

    public function createProduct()
    {
        $shops = Shop::all();
        return view('admin.create_product', compact('shops'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'shop_id' => 'nullable|exists:shops,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('products', 'public') 
            : null;

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'shop_id' => $request->shop_id ?? null,
            'shop_name' => $request->shop_id 
                           ? Shop::find($request->shop_id)->name 
                           : 'Admin',
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product added successfully.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $shops = Shop::all();
        return view('admin.edit_product', compact('product', 'shops'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'shop_id' => 'nullable|exists:shops,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'shop_id' => $request->shop_id ?? null,
            'shop_name' => $request->shop_id 
                           ? Shop::find($request->shop_id)->name 
                           : 'Admin',
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->approved = true;
        $product->save();
        return redirect()->route('admin.products')->with('success', 'Product approved successfully.');
    }

    // ------------------------
    // DEALS
    // ------------------------
    public function deals()
    {
        $deals = Deal::orderBy('created_at', 'desc')->get();
        return view('admin.deals', compact('deals'));
    }

    public function approveDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->approved = true;
        $deal->save();
        return redirect()->route('admin.deals')->with('success', 'Deal approved successfully.');
    }

    public function deleteDeal($id)
    {
        $deal = Deal::findOrFail($id);
        if ($deal->image) Storage::disk('public')->delete($deal->image);
        $deal->delete();
        return redirect()->route('admin.deals')->with('success', 'Deal deleted successfully.');
    }
    public function storeDeal(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'shop_id' => 'nullable|exists:shops,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('deals', 'public');
    }

    // Create deal
    Deal::create([
        'title' => $request->title,
        'description' => $request->description,
        'shop_id' => $request->shop_id ?? null,
        'shop_name' => $request->shop_id ? Shop::find($request->shop_id)->name : 'Admin',
        'image' => $imagePath,
        'approved' => true, // optional: auto-approve if admin adds
    ]);

    return redirect()->route('admin.deals')->with('success', 'Deal added successfully.');
}
public function createDeal()
{
    return view('admin.create_deal');
}

public function editDeal($id)
{
    $deal = Deal::findOrFail($id);
    return view('admin.edit_deal', compact('deal'));
}

public function updateDeal(Request $request, $id)
{
    $deal = Deal::findOrFail($id);

    $deal->update($request->only(['title', 'description']));

    if ($request->hasFile('image')) {
        if ($deal->image) Storage::disk('public')->delete($deal->image);
        $deal->image = $request->file('image')->store('deals', 'public');
    }

    $deal->save();

    return redirect()->route('admin.deals')->with('success', 'Updated');
}
}
