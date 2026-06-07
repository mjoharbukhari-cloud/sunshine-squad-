<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\OrderPlacedNotification;

class OrderController extends Controller
{
    // 1. Shows buy page for either a Product OR a Deal
    public function showBuyPage(Request $request, $id = null)
    {
        $product = null;
        $deal = null;
        $quantity = $request->query('quantity', 1);

        // Check if a deal_id was passed, otherwise assume it's a product
        if ($request->has('deal_id')) {
            $deal = Deal::findOrFail($request->deal_id);
            $totalPrice = $deal->price * $quantity;
        } else {
            $product = Product::findOrFail($id);
            $totalPrice = $product->price * $quantity;
        }

        return view('marketplace.buy', compact('product', 'deal', 'quantity', 'totalPrice'));
    }

    // 2. Processes form data, saves order, and notifies
    public function placeOrder(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:1000',
            'payment_method' => 'required|string'
        ]);

        // Determine if buying a Product or a Deal
        $item = null;
        $isDeal = $request->has('deal_id');
        
        if ($isDeal) {
            $item = Deal::findOrFail($request->deal_id);
        } else {
            $item = Product::findOrFail($request->product_id);
        }

        $totalPrice = $item->price * $request->quantity;

        // Save order (Added deal_id column to your orders table if needed)
        $order = Order::create([
            'customer_id' => auth()->id(),
            'product_id' => $isDeal ? null : $item->id,
            'deal_id' => $isDeal ? $item->id : null, 
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'delivery_address' => $request->delivery_address,
            'payment_method' => $request->payment_method
        ]);

        // --- NOTIFICATION DISPATCH ENGINE ---
        auth()->user()->notify(new OrderPlacedNotification($order));

        // Notify Shopkeeper (Assuming both Product and Deal have a shop relation)
        if ($item->shop && $item->shop->user_id) {
            $shopkeeper = User::find($item->shop->user_id);
            if ($shopkeeper) {
                $shopkeeper->notify(new OrderPlacedNotification($order));
            }
        }

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new OrderPlacedNotification($order));
        }

        return redirect('/products')->with('success', '🎉 Your order has been placed successfully!');
    }
}