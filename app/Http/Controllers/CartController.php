<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Show Cart Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.index', compact('cartItems'));
    }


    /*
    |--------------------------------------------------------------------------
    | Add Product To Cart
    |--------------------------------------------------------------------------
    */

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        // If product already in cart increase quantity
        if ($cart) {

            $cart->quantity += 1;
            $cart->save();

        } else {

            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);

        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    /*
    |--------------------------------------------------------------------------
    | Remove Product From Cart
    |--------------------------------------------------------------------------
    */

    public function remove($id)
    {
        $item = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $item->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }


    /*
    |--------------------------------------------------------------------------
    | Buy Now (Simple Checkout)
    |--------------------------------------------------------------------------
    */

    public function buyNow($id)
    {
        $product = Product::findOrFail($id);

        return redirect()->route('cart.index')
            ->with('success', 'Proceeding to checkout for: '.$product->name);
    }

}