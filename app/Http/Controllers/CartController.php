<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Show cart page
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Add product to cart
    public function add($id)
    {
        $userId = Auth::id();
        $product = Product::findOrFail($id);

        $cartItem = Cart::firstOrCreate(
            ['user_id' => $userId, 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $cartItem->quantity += 1;
        $cartItem->save();

        return redirect()->back()->with('success', '✅ Product added to cart!');
    }

    // Remove product from cart
    public function remove($id)
    {
        $userId = Auth::id();
        Cart::where('user_id', $userId)->where('product_id', $id)->delete();

        return redirect()->back()->with('success', '🗑️ Product removed from cart!');
    }

    // Buy now action
    public function buyNow($id)
    {
        $userId = Auth::id();
        $product = Product::findOrFail($id);

        // For now, simply redirect to cart with only this item
        Cart::where('user_id', $userId)->delete(); // Clear existing cart
        Cart::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        return redirect()->route('cart.index')->with('success', '💳 Ready to checkout!');
    }
}
