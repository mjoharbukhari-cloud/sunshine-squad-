<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show Cart Page
     */
    public function index()
    {
        // Fetch cart items with both relationships
        $cartItems = Cart::with(['product', 'deal'])
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.index', compact('cartItems'));
    }

    /**
     * Add Product to Cart
     */
    public function addProduct($id)
    {
        $product = Product::findOrFail($id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $id,
                'quantity'   => 1
            ]);
        }

        return redirect()->back()->with('success', $product->name . ' added to cart!');
    }

    /**
     * Add Deal (Bundle) to Cart
     */
    public function addDeal($id)
    {
        $deal = Deal::findOrFail($id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('deal_id', $id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id'  => Auth::id(),
                'deal_id'  => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Deal "' . $deal->title . '" added to cart!');
    }

    /**
     * Remove Item From Cart
     */
    public function remove($id)
    {
        $item = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $item->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    /**
     * Checkout Logic (Supports both)
     */
    public function buyNow(Request $request, $id, $type = 'product')
    {
        if ($type === 'deal') {
            $item = Deal::findOrFail($id);
            $message = 'Proceeding to checkout for deal: ' . $item->title;
        } else {
            $item = Product::findOrFail($id);
            $message = 'Proceeding to checkout for product: ' . $item->name;
        }

        return redirect()->route('cart.index')
            ->with('success', $message);
    }
}