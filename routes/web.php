<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// -------------------------
// Public Marketplace Pages
// -------------------------
Route::get('/', fn() => view('marketplace.home'));
Route::get('/contact', fn() => view('marketplace.contact'));

// Products & Deals
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

// Categories
Route::get('/category/{slug}', fn($slug) => view('marketplace.category', ['slug' => $slug]));

// Search
Route::get('/search', function () {
    $q = trim(request('q', ''));
    return view('marketplace.search', ['query' => $q]);
});

// Buy page (demo only)
Route::get('/buy/{id}', fn($id) => view('marketplace.buy', ['id' => $id]));
Route::post('/buy/{id}', fn($id) => redirect('/')->with('status', 'Order submitted for Product '.$id));

// -------------------------
// Authentication
// -------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// -------------------------
// Password Reset Routes
// -------------------------
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// -------------------------
// Role-specific dashboard
// -------------------------
Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? '';
    if ($role === 'customer') return view('dashboard.customer');
    if ($role === 'shopkeeper') return view('dashboard.shopkeeper');
    if ($role === 'admin') return view('dashboard.admin');
    return redirect('/');
})->middleware('auth')->name('dashboard');

// -------------------------
// Footer Pages
// -------------------------
Route::get('/privacy', fn() => view('pages.privacy'));
Route::get('/terms', fn() => view('pages.terms'));
Route::get('/cookies', fn() => view('pages.cookies'));
Route::get('/security', fn() => view('pages.security'));
Route::get('/faq', fn() => view('pages.faq'));
Route::get('/returns', fn() => view('pages.returns'));
Route::get('/shipping', fn() => view('pages.shipping'));
Route::get('/warranty', fn() => view('pages.warranty'));
Route::get('/sellers', fn() => view('pages.sellers'));
Route::get('/brand-partners', fn() => view('pages.brand_partners'));
Route::get('/affiliate', fn() => view('pages.affiliate'));

// -------------------------
// Cart Routes (only for logged-in users)
// -------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// -------------------------
// Shopkeeper Routes (CRUD)
// -------------------------
Route::middleware(['auth', 'role:shopkeeper'])->group(function () {
    Route::resource('shops', ShopController::class);
    Route::resource('products', ProductController::class)->except(['index']);
    Route::resource('deals', DealController::class)->except(['index']);
});

// -------------------------
// Admin Routes
// -------------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Approve products & deals
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::post('/admin/products/{id}/approve', [AdminController::class, 'approveProduct']);
    Route::get('/admin/deals', [AdminController::class, 'deals']);
    Route::post('/admin/deals/{id}/approve', [AdminController::class, 'approveDeal']);

    // Manage all shops
    Route::get('/admin/shops', [AdminController::class, 'shops']);
    Route::get('/admin/shops/create', [AdminController::class, 'createShop']);
    Route::post('/admin/shops', [AdminController::class, 'storeShop']);
    Route::get('/admin/shops/{id}/edit', [AdminController::class, 'editShop']);
    Route::put('/admin/shops/{id}', [AdminController::class, 'updateShop']);
    Route::delete('/admin/shops/{id}', [AdminController::class, 'deleteShop']);

    // Manage all products
    Route::get('/admin/products/all', [AdminController::class, 'allProducts']);
    Route::get('/admin/products/create', [AdminController::class, 'createProduct']);
    Route::post('/admin/products', [AdminController::class, 'storeProduct']);
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct']);
    Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct']);
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct']);

    // Manage users
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::post('/admin/users/{id}/warn', [AdminController::class, 'warnUser']);
    Route::post('/admin/users/{id}/disable', [AdminController::class, 'disableUser']);
});
