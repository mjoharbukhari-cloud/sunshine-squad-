<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::where('user_id', auth()->id())->get();
        return view('shopkeeper.shops', compact('shops'));  // No change
    }

    public function create()
    {
        return view('shopkeeper.create-shop');  // Changed to hyphen
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        Shop::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'user_id' => auth()->id(),
        ]);

        return redirect('/shops')->with('status', 'Shop created successfully!');
    }

    public function show($id)
    {
        $shop = Shop::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('shopkeeper.show-shop', compact('shop'));  // Changed to hyphen
    }

    public function edit($id)
    {
        $shop = Shop::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('shopkeeper.edit-shop', compact('shop'));  // Changed to hyphen
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        $shop->update($request->only(['name', 'description', 'address']));

        return redirect('/shops')->with('status', 'Shop updated successfully!');
    }

    public function destroy($id)
    {
        $shop = Shop::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $shop->delete();

        return redirect('/shops')->with('status', 'Shop deleted successfully!');
    }
}