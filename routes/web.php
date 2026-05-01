<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductController,
    DealController,
    ShopkeeperController,
    AdminController,
    CartController,
    ProfileController
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

/*
|--------------------------------------------------------------------------
| MARKETPLACE
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index'])->name('marketplace.products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('marketplace.products.show');

Route::get('/deals', [DealController::class, 'index'])->name('marketplace.deals');
Route::get('/deals/{id}', [DealController::class, 'show'])->name('marketplace.deals.show');

Route::get('/category/{slug}', fn ($slug) =>
    view('marketplace.category', compact('slug'))
)->name('category.show');

Route::get('/search', fn () =>
    view('marketplace.search', ['query' => request('q')])
)->name('search');

/*
|--------------------------------------------------------------------------
| AUTH
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
| DASHBOARD REDIRECT
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
| CUSTOMER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/customer/dashboard', function () {

        $products = Product::latest()->take(6)->get();

        $deals = Deal::where('approved', 1)
            ->latest()
            ->take(4)
            ->get();

        $cartCount = Cart::where('user_id', auth()->id())->count();

        return view('dashboard.customer', compact(
            'products',
            'deals',
            'cartCount'
        ));
    })->name('customer.dashboard');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/buy/{id}', [CartController::class, 'buyNow'])->name('checkout.buy');
});

/*
|--------------------------------------------------------------------------
| SHOPKEEPER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:shopkeeper'])
    ->prefix('shopkeeper')
    ->name('shopkeeper.')
    ->group(function () {

        Route::get('/dashboard', [ShopkeeperController::class, 'dashboard'])->name('dashboard');

        // Products
        Route::get('/products', [ShopkeeperController::class, 'products'])->name('products');
        Route::get('/products/create', [ShopkeeperController::class, 'createProduct'])->name('products.create');
        Route::post('/products/store', [ShopkeeperController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{id}/edit', [ShopkeeperController::class, 'editProduct'])->name('products.edit');
        Route::post('/products/update/{id}', [ShopkeeperController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/delete/{id}', [ShopkeeperController::class, 'deleteProduct'])->name('products.delete');

        // Deals
        Route::get('/deals', [ShopkeeperController::class, 'deals'])->name('deals');
        Route::get('/deals/create', [ShopkeeperController::class, 'createDeal'])->name('deals.create');
        Route::post('/deals/store', [ShopkeeperController::class, 'storeDeal'])->name('deals.store');
        Route::get('/deals/{id}/edit', [ShopkeeperController::class, 'editDeal'])->name('deals.edit');
        Route::post('/deals/update/{id}', [ShopkeeperController::class, 'updateDeal'])->name('deals.update');
        Route::delete('/deals/delete/{id}', [ShopkeeperController::class, 'deleteDeal'])->name('deals.delete');
    });

/*
|--------------------------------------------------------------------------
| ADMIN (FIXED 🚨)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
->prefix('admin')
->name('admin.')
->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('users');

    // PRODUCTS
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::post('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // DEALS (FULL FIX)
    Route::get('/deals', [AdminController::class, 'deals'])->name('deals');
    Route::get('/deals/create', [AdminController::class, 'createDeal'])->name('deals.create');
    Route::post('/deals/store', [AdminController::class, 'storeDeal'])->name('deals.store');
    Route::get('/deals/{id}/edit', [AdminController::class, 'editDeal'])->name('deals.edit');
    Route::post('/deals/update/{id}', [AdminController::class, 'updateDeal'])->name('deals.update');
    Route::delete('/deals/delete/{id}', [AdminController::class, 'deleteDeal'])->name('deals.delete');
});
/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});