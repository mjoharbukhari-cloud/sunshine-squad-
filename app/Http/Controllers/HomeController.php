<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Deal;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Public Marketplace Home Page Landing View
     * (Accessible by guests and logged-in users alike)
     */
    public function index()
    {
        // Use paginate() instead of get() to support the ->links() method in your view
        // Adjust the number (12) to match how many items you want per page
        $products = Product::orderBy('created_at', 'desc')
            ->paginate(24);

        $deals = Deal::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('marketplace.home', compact('products', 'deals'));
    }

    /**
     * Authenticated Customer Dashboard Central Control Hub
     * (Accessible only by logged-in customers)
     */
    public function customerDashboard()
    {
        $userId = Auth::id();
        
        return view('dashboard.customer', [
            'cartCount' => class_exists(Cart::class) 
                ? Cart::where('user_id', $userId)->count() 
                : 0,
                
            'activeOrdersCount' => class_exists(Order::class) 
                ? Order::where('user_id', $userId)
                    ->whereIn('status', ['pending', 'processing', 'in_route'])
                    ->count() 
                : 0,
                
            'pendingInstallationsCount' => 1, 
            'totalSpent' => 45000, 
        ]);
    }
}