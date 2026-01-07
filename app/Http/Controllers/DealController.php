<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::where('approved', true)->get();
        return view('marketplace.deals', compact('deals'));
    }

    public function create()
    {
        return view('shopkeeper.create_deal');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'original_price' => 'required|numeric',
            'deal_price' => 'required|numeric',
            'expires_at' => 'required|date',
        ]);

        Deal::create([
            'title' => $request->title,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'deal_price' => $request->deal_price,
            'expires_at' => $request->expires_at,
            'user_id' => auth()->id(),
        ]);

        return redirect('/deals')->with('status', 'Deal submitted for approval!');
    }
}