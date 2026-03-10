<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Shop;

class DealController extends Controller
{
    // -------------------------
    // PUBLIC: Marketplace deals list
    // -------------------------
    public function index()
    {
        $deals = Deal::where('approved', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marketplace.deals', compact('deals'));
    }

    // -------------------------
    // PUBLIC: Single deal
    // -------------------------
    public function show($id)
    {
        $deal = Deal::where('approved', 1)->findOrFail($id);
        return view('marketplace.deal_detail', compact('deal'));
    }

    // -------------------------
    // SHOPKEEPER / ADMIN: Store deal
    // -------------------------
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|max:2048',
        ]);

        $shopId = auth()->user()->shop->id ?? null;

        if (!$shopId) {
            return back()->with('error', 'Shop not found.');
        }

        $deal = new Deal();
        $deal->title       = $request->title;
        $deal->description = $request->description;
        $deal->price       = $request->price;
        $deal->quantity    = $request->quantity;
        $deal->shop_id     = $shopId;

        // 🔥 IMPORTANT: auto-approve
        $deal->approved = 1;

        if ($request->hasFile('image')) {
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();

        return back()->with('success', 'Deal added successfully.');
    }

    // -------------------------
    // ADMIN: Edit deal
    // -------------------------
    public function edit($id)
    {
        $deal = Deal::findOrFail($id);
        $shops = Shop::all();
        return view('admin.edit_deal', compact('deal', 'shops'));
    }

    // -------------------------
    // ADMIN: Update deal
    // -------------------------
    public function update(Request $request, $id)
    {
        $deal = Deal::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer|min:1',
            'image'       => 'nullable|image|max:2048',
            'shop_id'     => 'required|exists:shops,id',
        ]);

        $deal->title       = $request->title;
        $deal->description = $request->description;
        $deal->price       = $request->price;
        $deal->quantity    = $request->quantity;
        $deal->shop_id     = $request->shop_id;

        if ($request->hasFile('image')) {
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();

        return redirect()->route('marketplace.deals')
            ->with('success', 'Deal updated successfully.');
    }

    // -------------------------
    // DELETE deal
    // -------------------------
    public function destroy($id)
    {
        Deal::findOrFail($id)->delete();
        return back()->with('success', 'Deal deleted successfully.');
    }
}
