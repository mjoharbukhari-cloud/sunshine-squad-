<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Approve products/deals
    public function products()
    {
        $products = Product::where('approved', false)->get();
        return view('admin.products', compact('products'));
    }

    public function approveProduct($id)
    {
        Product::find($id)->update(['approved' => true]);
        return redirect('/admin/products')->with('status', 'Product approved!');
    }

    public function deals()
    {
        $deals = Deal::where('approved', false)->get();
        return view('admin.deals', compact('deals'));
    }

    public function approveDeal($id)
    {
        Deal::find($id)->update(['approved' => true]);
        return redirect('/admin/deals')->with('status', 'Deal approved!');
    }

    // Manage all shops
    public function shops()
    {
        $shops = Shop::all();
        return view('admin.shops', compact('shops'));
    }

    public function createShop()
    {
        $users = User::where('role', 'shopkeeper')->get();
        return view('admin.create_shop', compact('users'));
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        Shop::create($request->all());
        return redirect('/admin/shops')->with('status', 'Shop created!');
    }

    public function editShop($id)
    {
        $shop = Shop::findOrFail($id);
        $users = User::where('role', 'shopkeeper')->get();
        return view('admin.edit_shop', compact('shop', 'users'));
    }

    public function updateShop(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update($request->all());
        return redirect('/admin/shops')->with('status', 'Shop updated!');
    }

    public function deleteShop($id)
    {
        Shop::findOrFail($id)->delete();
        return redirect('/admin/shops')->with('status', 'Shop deleted!');
    }

    // Manage all products
    public function allProducts()
    {
        $products = Product::all();
        return view('admin.all_products', compact('products'));
    }

    public function createProduct()
    {
        $shops = Shop::all();
        return view('admin.create_product', compact('shops'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'shop_id' => 'required|exists:shops,id',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'user_id' => Shop::find($request->shop_id)->user_id,
            'approved' => true,
        ]);

        return redirect('/admin/products/all')->with('status', 'Product added!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $shops = Shop::all();
        return view('admin.edit_product', compact('product', 'shops'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect('/admin/products/all')->with('status', 'Product updated!');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect('/admin/products/all')->with('status', 'Product deleted!');
    }

    // Manage users
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function warnUser($id)
    {
        // Add email logic here later
        return redirect('/admin/users')->with('status', 'Warning sent!');
    }

    public function disableUser($id)
    {
        User::findOrFail($id)->update(['role' => 'disabled']);
        return redirect('/admin/users')->with('status', 'User disabled!');
    }
}