<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    DealController,
    ShopkeeperController,
    AdminController,
    CartController,
    ProfileController,
    OrderController,
    CategoryController,
    NotificationController,
    ReviewController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
};
use App\Models\Product;
use App\Models\Deal;
use App\Models\Cart;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/contact', 'marketplace.contact')->name('contact');

Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/returns', 'pages.returns')->name('returns');
Route::view('/shipping', 'pages.shipping')->name('shipping');
Route::view('/warranty', 'pages.warranty')->name('warranty');

Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/cookies', 'pages.cookies')->name('cookies');
Route::view('/security', 'pages.security')->name('security');

Route::view('/sellers', 'pages.sellers')->name('sellers');
Route::view('/brand_partners', 'pages.brand_partners')->name('brand_partners');
Route::view('/affiliate', 'pages.affiliate')->name('affiliate');

/*
|--------------------------------------------------------------------------
| PRODUCTS & DEALS
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index'])->name('marketplace.products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/deals', [DealController::class, 'index'])->name('marketplace.deals');
Route::get('/deals/{id}', [DealController::class, 'show'])->name('marketplace.deals.show');

/*
|--------------------------------------------------------------------------
| CATEGORY SYSTEM
|--------------------------------------------------------------------------
*/
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

/*
|--------------------------------------------------------------------------
| SEARCH SYSTEM
|--------------------------------------------------------------------------
*/
Route::get('/search', function () {
    $query = request('q');
    $products = Product::where('name', 'LIKE', "%{$query}%")
        ->orWhere('description', 'LIKE', "%{$query}%")
        ->latest()
        ->get();
    return view('marketplace.search', compact('products', 'query'));
})->name('search');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION LAYER
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| AUTH CHECKOUT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/marketplace/buy/{product}', [OrderController::class, 'showBuyPage'])->name('marketplace.buy');
    Route::post('/marketplace/place-order', [OrderController::class, 'placeOrder'])->name('marketplace.placeOrder');
});

/*
|--------------------------------------------------------------------------
| MULTI-VENDOR CORE DASHBOARD REDIRECTION ROADMAP
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'shopkeeper' => redirect()->route('shopkeeper.dashboard'),
        default      => redirect()->route('customer.dashboard'),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| CUSTOMER PANEL ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        $products = Product::latest()->take(6)->get();
        $deals = Deal::latest()->take(4)->get();
        $cartCount = Cart::where('user_id', auth()->id())->count();
        return view('dashboard.customer', compact('products', 'deals', 'cartCount'));
    })->name('customer.dashboard');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addProduct'])->name('cart.add');
    Route::post('/cart/add-deal/{id}', [CartController::class, 'addDeal'])->name('cart.add.deal');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/buy/{id}', [CartController::class, 'buyNow'])->name('checkout.buy');
    
    // INTEGRATED REVIEW ROUTE
    Route::post('/reviews/store', [ReviewController::class, 'store'])->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| VENDOR/SHOPKEEPER ECOSYSTEM ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:shopkeeper'])
    ->prefix('shopkeeper')
    ->name('shopkeeper.')
    ->group(function () {
        Route::get('/dashboard', [ShopkeeperController::class, 'dashboard'])->name('dashboard');
        Route::get('/shop/edit', [ShopkeeperController::class, 'editShop'])->name('shop.edit');
        Route::put('/shop/update/{id}', [ShopkeeperController::class, 'updateShop'])->name('shop.update');
        Route::post('/order-item/{id}/update-status', [ShopkeeperController::class, 'updateOrderItemStatus'])->name('orderitem.status');
        Route::get('/products', [ShopkeeperController::class, 'products'])->name('products');
        Route::get('/products/create', [ShopkeeperController::class, 'createProduct'])->name('products.create');
        Route::post('/products/store', [ShopkeeperController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [ShopkeeperController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/update/{id}', [ShopkeeperController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/delete/{id}', [ShopkeeperController::class, 'deleteProduct'])->name('products.delete');
        Route::get('/deals', [ShopkeeperController::class, 'deals'])->name('deals');
        Route::get('/deals/create', [ShopkeeperController::class, 'createDeal'])->name('deals.create');
        Route::post('/deals/store', [ShopkeeperController::class, 'storeDeal'])->name('deals.store');
        Route::get('/deals/{id}/edit', [ShopkeeperController::class, 'editDeal'])->name('deals.edit');
        Route::put('/deals/update/{id}', [ShopkeeperController::class, 'updateDeal'])->name('deals.update');
        Route::delete('/deals/delete/{id}', [ShopkeeperController::class, 'deleteDeal'])->name('deals.delete');
    });

/*
|--------------------------------------------------------------------------
| CENTRAL SYSTEM ADMINISTRATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('/commissions', [AdminController::class, 'commissions'])->name('commissions');
        Route::get('/notifications/clear', [AdminController::class, 'clearNotifications'])->name('notifications.clear');
        Route::get('/shops', [AdminController::class, 'shops'])->name('shops');
        Route::get('/shops/create', [AdminController::class, 'createShop'])->name('shops.create');
        Route::post('/shops/store', [AdminController::class, 'storeShop'])->name('shops.store');
        Route::get('/shops/{id}/edit', [AdminController::class, 'editShop'])->name('shops.edit');
        Route::put('/shops/update/{id}', [AdminController::class, 'updateShop'])->name('shops.update');
        Route::post('/shops/{id}/approve', [AdminController::class, 'approveShop'])->name('shops.approve');
        Route::get('/shops/{id}/ledger', [AdminController::class, 'shopLedger'])->name('shops.ledger');
        Route::delete('/shops/delete/{id}', [AdminController::class, 'deleteShop'])->name('shops.delete');
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
        Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
        Route::put('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
        Route::post('/products/{id}/approve', [AdminController::class, 'approveProduct'])->name('products.approve');
        Route::get('/deals', [AdminController::class, 'deals'])->name('deals');
        Route::get('/deals/create', [AdminController::class, 'createDeal'])->name('deals.create');
        Route::post('/deals/store', [AdminController::class, 'storeDeal'])->name('deals.store');
        Route::get('/deals/{id}/edit', [AdminController::class, 'editDeal'])->name('deals.edit');
        Route::put('/deals/update/{id}', [AdminController::class, 'updateDeal'])->name('deals.update');
        Route::delete('/deals/delete/{id}', [AdminController::class, 'deleteDeal'])->name('deals.delete');
        Route::post('/deals/{id}/approve', [AdminController::class, 'approveDeal'])->name('deals.approve');
    });

/*
|--------------------------------------------------------------------------
| UNIVERSAL ACCOUNT SYSTEM PROFILE & NOTIFICATION PATHS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/notifications/clear', [NotificationController::class, 'clearAll'])->name('notifications.clear');
});