<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Deal;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Enforce access guards for authentication middleware layers.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Admin Dashboard Global Control Command Hub View
     */
    public function dashboard()
    {
        // Marketplace Core Entity Counts
        $totalUsers = User::count();        
        $totalProducts = Product::count();  
        $totalDeals = Deal::count();        
        $totalShops = Shop::count();        

        // Financial & Commissions Architect Setup (10% standard marketplace model setup)
        $commissionRate = '10%';
        
        // Eager load vendor profiles to keep processing cycles efficient
        $shops = Shop::with('owner')->latest()->take(5)->get();
        
        // Safely accumulate uncollected financial commissions totals across all instances.
        $totalPendingCommission = Schema::hasColumn('shops', 'pending_commission') 
            ? Shop::sum('pending_commission') 
            : 0.00;

        return view('dashboard.admin', compact(
            'totalUsers', 
            'totalProducts', 
            'totalDeals', 
            'totalShops',
            'shops',
            'commissionRate',
            'totalPendingCommission'
        ));
    }

    /**
     * FIXED: Changed from 'user' to 'customer' to match your explicit Order relationship model schema layout.
     * Eager loads product variations to prevent extra query roundtrips in the template.
     */
    public function orders()
    {
        $orders = class_exists('\App\Models\Order') 
            ? \App\Models\Order::with(['customer', 'product'])->latest()->get() 
            : [];

        return view('admin.orders', compact('orders'));
    }

    /**
     * Financial Commission Ledger Split Overview
     */
    public function commissions()
    {
        $totalPendingCommission = Schema::hasColumn('shops', 'pending_commission') 
            ? Shop::sum('pending_commission') 
            : 0.00;

        return view('admin.commissions', compact('totalPendingCommission'));
    }

    /**
     * View Detailed Audit Ledger Specifications for an explicit shop node
     */
    public function shopLedger($id)
    {
        $shop = Shop::with('owner')->findOrFail($id);
        return view('admin.shop_ledger', compact('shop'));
    }

    /**
     * Clear System-wide Dashboard Administrative Notification Arrays
     */
    public function clearNotifications()
    {
        if (auth()->user()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return redirect()->back()->with('success', 'All system notifications cleared.');
    }

    // ==========================================
    // USER ARCHITECTURE MANAGEMENT CONTROL PANEL
    // ==========================================
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    // ==========================================
    // VENDOR PORTAL PROFILE APPROVAL OPERATIONS
    // ==========================================
    
    /**
     * Pulls both shops and users to ensure the creation form 
     * template dropdown renders flawlessly without triggering 500 errors.
     */
    public function shops()
    {
        // 1. Fetch active shops eager loading user relationships
        $shops = Shop::with('owner')->orderBy('created_at', 'desc')->get();
        
        // 2. Fetch all user accounts assigned the 'shopkeeper' role to populate the dropdown menu
        $users = User::where('role', 'shopkeeper')->get();

        return view('admin.shops', compact('shops', 'users'));
    }

    /**
     * Bypasses the missing 'approved' table column check.
     * Safely promotes the target user account to a platform shopkeeper.
     */
    public function approveShop($id)
    {
        $shop = Shop::findOrFail($id);

        // Safely elevate owner privileges directly if they aren't an admin
        if ($shop->owner && $shop->owner->role !== 'admin') {
            $shop->owner->update(['role' => 'shopkeeper']);
        }

        $this->logActivity('shop_approved', "Store Node Approved", $shop->name, 0);

        return redirect()->back()->with('success', 'Merchant account upgraded to shopkeeper status successfully.');
    }

    public function createShop()
    {
        $users = User::where('role', 'shopkeeper')->get();
        return view('admin.create_shop', compact('users'));
    }

    public function storeShop(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'address' => $request->address,
        ]);

        $this->logActivity('shop_created', "New Marketplace Shop Registered", $shop->name, 0);

        return redirect()->route('admin.shops')->with('success', 'Marketplace store node created successfully.');
    }

    public function editShop($id)
    {
        $shop = Shop::findOrFail($id);
        return view('admin.edit_shop', compact('shop'));
    }

    public function updateShop(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $shop = Shop::findOrFail($id);
        $shop->update($request->only(['name', 'description', 'address']));

        return redirect()->route('admin.shops')->with('success', 'Shop parameters modified successfully.');
    }

    public function deleteShop($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->delete();
        return redirect()->route('admin.shops')->with('success', 'Shop node dropped from active schema.');
    }

    // ==========================================
    // PRODUCT CONTROL LAYER
    // ==========================================
    public function products()
    {
        $products = Product::with('shop')->orderBy('created_at', 'desc')->get();
        $shops = Shop::all();
        return view('admin.products', compact('products', 'shops'));
    }

    public function createProduct()
    {
        $shops = Shop::all();
        return view('admin.create_product', compact('shops'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shop = Shop::findOrFail($request->shop_id);
        $imagePath = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->shop_id = $shop->id;
        $product->shop_name = $shop->name; 
        $product->quantity = 1; 
        $product->image = $imagePath;
        $product->approved = true;
        $product->save();

        $this->logActivity('product_added', "Inventory Item Provisioned", $product->name, $product->price);

        return redirect()->route('admin.products')->with('success', 'Hardware inventory node linked successfully.');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $shops = Shop::all();
        return view('admin.edit_product', compact('product', 'shops'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $shop = Shop::findOrFail($request->shop_id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'shop_id' => $shop->id,
            'shop_name' => $shop->name,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Item profile metrics updated.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Target item dropped.');
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['approved' => true]);
        return redirect()->route('admin.products')->with('success', 'Product visibility authorized.');
    }

    // ==========================================
    // SYSTEM PACKAGED DEALS BUNDLE OPERATIONS
    // ==========================================
    public function deals()
    {
        $deals = Deal::with('shop')->orderBy('created_at', 'desc')->get();
        return view('admin.deals', compact('deals'));
    }

    public function createDeal()
    {
        $shops = Shop::all();
        return view('admin.create_deal', compact('shops'));
    }

    public function storeDeal(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0', 
            'shop_id' => 'nullable|exists:shops,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('deals', 'public');
        }

        Deal::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'shop_id' => $request->shop_id,
            'image' => $imagePath,
            'approved' => true, 
        ]);

        $this->logActivity('deal_created', "New Promotional Deal Bundle", $request->title, $request->price);

        return redirect()->route('admin.deals')->with('success', 'Bundled package registered.');
    }

    public function editDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $shops = Shop::all();
        return view('admin.edit_deal', compact('deal', 'shops'));
    }

    public function updateDeal(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $deal = Deal::findOrFail($id);
        $deal->update($request->only(['title', 'description']));

        if ($request->hasFile('image')) {
            if ($deal->image) {
                Storage::disk('public')->delete($deal->image);
            }
            $deal->image = $request->file('image')->store('deals', 'public');
        }

        $deal->save();
        return redirect()->route('admin.deals')->with('success', 'Deal parameters optimized.');
    }

    public function approveDeal($id)
    {
        $deal = Deal::findOrFail($id);
        $deal->update(['approved' => true]);
        return redirect()->route('admin.deals')->with('success', 'Bundle validation cleared.');
    }

    public function deleteDeal($id)
    {
        $deal = Deal::findOrFail($id);
        if ($deal->image) {
            Storage::disk('public')->delete($deal->image);
        }
        $deal->delete();
        return redirect()->route('admin.deals')->with('success', 'Bundle record truncated.');
    }

    /**
     * Internal Core Engine Logging Utility
     */
    private function logActivity($type, $title, $actor, $price)
    {
        try {
            $admins = User::where('role', 'admin')->get();
            $details = [
                'type' => $type,
                'product_name' => $title, 
                'customer_name' => $actor, 
                'total_price' => $price    
            ];

            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\SystemActivityNotification($details));
            }
        } catch (\Exception $e) {
            // Fails silently if Notification table drivers aren't populated yet
        }
    }
}