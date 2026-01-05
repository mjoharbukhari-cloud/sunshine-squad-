<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index()
    {
        $deals = Deal::all();
        return view('marketplace.deals', compact('deals'));
    }

    public function store(Request $request)
    {
        $deal = Deal::create($request->all());
        return response()->json($deal, 201);
    }

    public function show($id)
    {
        return Deal::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $deal = Deal::findOrFail($id);
        $deal->update($request->all());
        return response()->json($deal);
    }

    public function destroy($id)
    {
        Deal::destroy($id);
        return response()->json(['message' => 'Deal deleted']);
    }
}
