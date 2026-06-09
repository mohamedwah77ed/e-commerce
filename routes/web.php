<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymobController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;

// ── Frontend ──────────────────────────
Route::controller(FrontendController::class)->group(function() {
Route::get('/',[FrontendController::class, 'show_all_products'])->name('products.home');
Route::get('/products_details/{slug}',[FrontendController::class, 'show_details'])->name('product.show_details');
Route::get('/search', [FrontendController::class, 'search'])->name('search');
Route::get('/brand/{slug}', [FrontendController::class, 'brandProducts'])->name('brand.products');
Route::get('/categories/{slug}', [FrontendController::class, 'categoryProducts'])->name('category.products');
Route::get('/ajax/products-by-category', [FrontendController::class, 'getProductsByCategoryAjax'])
     ->name('ajax.products.category');
});

// ── Static Pages ──────────────────────
//Route::get('offers',   fn() => view('frontend.offers'))->name('offers.index');/
//Route::get('contact',  fn() => view('frontend.contact'))->name('contact.index');

// ── Cart ──────────────────────────────
Route::get('cart',           [CartController::class, 'index'])->name('cart.index');
Route::post('add-to-cart',   [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('cart/increase', [CartController::class, 'increaseCart'])->name('cart.increase');
Route::post('cart/decrease', [CartController::class, 'decreaseCart'])->name('cart.decrease');
Route::delete('cart-delete', [CartController::class, 'cartDelete'])->name('cart-delete');
Route::post('cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');

// ── Orders (for BOTH guests & authenticated users) ─────────
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

// ── Checkout ──────────────────────────
Route::get('checkout',           [OrderController::class, 'create'])->name('checkout');
Route::post('checkout',          [OrderController::class, 'store'])->name('order.store');
Route::get('order/success/{id}', [OrderController::class, 'success'])->name('order.success');

// Buy Now
Route::post('/buy-now', [CartController::class, 'buyNow'])->name('buy-now');

// ── Auth-only Profile (keep this separate) ─────────
Route::middleware('auth')->group(function () {
    Route::get('my-profile',    [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::patch('my-profile',  [ProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('my-profile', [ProfileController::class, 'destroy'])->name('user.profile.destroy');
});

// ── Payment ───────────────────────────
Route::get('pay/{order}',      [PaymobController::class, 'pay'])->name('paymob.pay')->middleware('auth');
Route::match(['get', 'post'], 'paymob/callback', [PaymobController::class, 'callback'])->name('paymob.callback');

// ── Language ──────────────────────────
Route::get('lang/{locale}', [LanguageController::class, 'switchLocale'])->name('lang.switch');

// ═══════════════════════════════════════
// Admin Panel
// ═══════════════════════════════════════
Route::prefix('admin')
     ->middleware(['auth', 'verified', 'is_admin'])
     ->name('admin.')
     ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UsersController::class);

        Route::post('users/{id}/restore', [UsersController::class, 'restore'])->name('users.restore');
        Route::resource('products', ProductController::class)->except(['show']);
         Route::get('products/{slug}', [ProductController::class, 'show'])->name('products.show');

       Route::delete('product/image/{id}', [ProductController::class, 'deleteImage'])->name('product.image.delete');

       Route::resource('orders', AdminOrderController::class);
       Route::resource('categories', CategoryController::class);
       Route::resource('brand', BrandController::class);

        Route::get('settings',  [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('profile',   [ProfileController::class, 'edit'])->name('profile');
        Route::patch('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    });

require __DIR__ . '/auth.php';
