<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;

// --------------------
// Public Marketplace Pages
// --------------------
Route::get('/', fn() => view('marketplace.home'));
Route::get('/contact', fn() => view('marketplace.contact'));

// Products & Deals (use controllers to fetch DB data)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

// Categories (dynamic by slug)
Route::get('/category/{slug}', fn($slug) => view('marketplace.category', ['slug' => $slug]));

// Search (empty query shows "All products")
Route::get('/search', function () {
    $q = trim(request('q', ''));
    return view('marketplace.search', ['query' => $q]);
});

// Buy page (demo only)
Route::get('/buy/{id}', fn($id) => view('marketplace.buy', ['id' => $id]));
Route::post('/buy/{id}', function ($id) {
    return redirect('/')->with('status', 'Order submitted for Product '.$id);
});

// --------------------
// Authentication (demo stubs)
// --------------------
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', fn() => redirect('/')->with('status', 'Logged in (demo)'));
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', fn() => redirect('/')->with('status', 'Registered (demo)'));
Route::post('/logout', fn() => redirect('/')->with('status', 'Logged out (demo)'))->name('logout');

// --------------------
// Footer Pages
// --------------------
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

// --------------------
// Cart Routes (only for logged-in users)
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// --------------------
// Shopkeeper Routes (CRUD for shops/products/deals)
// --------------------
Route::middleware(['auth', 'role:shopkeeper'])->group(function () {
    Route::resource('shops', ShopController::class);
    Route::resource('products', ProductController::class)->except(['index']);
    Route::resource('deals', DealController::class)->except(['index']);
});

// --------------------
// Admin Routes (approval system)
// --------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::post('/admin/products/{id}/approve', [AdminController::class, 'approveProduct']);
    Route::get('/admin/deals', [AdminController::class, 'deals']);
    Route::post('/admin/deals/{id}/approve', [AdminController::class, 'approveDeal']);
});
