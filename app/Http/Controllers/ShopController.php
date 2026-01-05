<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        return Shop::all();
    }

    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $shop = Shop::create($request->all());
        return response()->json($shop, 201);
    }

    public function show($id)
    {
        return Shop::findOrFail($id);
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->update($request->all());
        return response()->json($shop);
    }

    public function destroy($id)
    {
        Shop::destroy($id);
        return response()->json(['message' => 'Shop deleted']);
    }
}
