<?php
amespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Core Dynamic Metrics
        $cartCount = $user->cartItems()->sum('quantity');
        $activeOrdersCount = $user->orders()->whereIn('status', ['Processing Setup', 'In Route'])->count();
        $pendingInstallationsCount = $user->orders()->where('status', 'Assembling Hardware')->count(); // Example filter
        $totalSpent = $user->orders()->where('status', 'Delivered')->sum('total_price');

        // 2. Fetch the single latest active deployment order for the tracking progress bar
        $latestActiveOrder = $user->orders()
            ->whereNotIn('status', ['Delivered', 'Cancelled'])
            ->latest()
            ->first();

        // 3. Complete order history ledger
        $orders = $user->orders()->get();

        return view('dashboard', compact(
            'cartCount', 
            'activeOrdersCount', 
            'pendingInstallationsCount', 
            'totalSpent', 
            'latestActiveOrder', 
            'orders'
        ));
    }
}