<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add($id)
    {
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
        ]);
        return redirect('/cart')->with('status', 'Added to cart!');
    }

    public function remove($id)
    {
        Cart::where('user_id', auth()->id())->where('product_id', $id)->delete();
        return redirect('/cart');
    }
}