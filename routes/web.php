<?php

use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\BrandingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Front\CollectionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ShopController;
use Illuminate\Support\Facades\Route;

// ADMIN PANEL (custom)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuth::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuth::class, 'login'])->name('login.post');
    Route::post('logout', [AdminAuth::class, 'logout'])->name('logout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('branding', [BrandingController::class, 'index'])->name('branding.index');
        Route::post('branding/{slot}', [BrandingController::class, 'upload'])->name('branding.upload');
        Route::post('branding/{slot}/delete', [BrandingController::class, 'delete'])->name('branding.delete');

        // Placeholders for upcoming sections
        Route::view('products', 'admin.placeholder', ['title' => 'Productos', 'phase' => 'B1'])->name('products.index');
        Route::view('orders', 'admin.placeholder', ['title' => 'Pedidos', 'phase' => 'B2'])->name('orders.index');
        Route::view('pages', 'admin.placeholder', ['title' => 'Paginas', 'phase' => 'B3'])->name('pages.index');
        Route::view('testimonials', 'admin.placeholder', ['title' => 'Testimonios', 'phase' => 'B3'])->name('testimonials.index');
        Route::view('blog', 'admin.placeholder', ['title' => 'Blog', 'phase' => 'B3'])->name('blog.index');
        Route::view('collections', 'admin.placeholder', ['title' => 'Colecciones', 'phase' => 'C1'])->name('collections.index');
        Route::view('customers', 'admin.placeholder', ['title' => 'Clientes', 'phase' => 'C2'])->name('customers.index');
    });
});

Route::get('/', HomeController::class)->name('home');

Route::get('/tienda', [ShopController::class, 'index'])->name('shop');
Route::get('/tienda/{slug}', [ShopController::class, 'show'])->name('product');

Route::get('/coleccion/{slug}', CollectionController::class)->name('collection');

// Redirects 301 - compat WooCommerce
Route::permanentRedirect('/shop', '/tienda');
Route::permanentRedirect('/cart', '/carrito');
Route::permanentRedirect('/my-account', '/carrito');
Route::get('/servicio/{slug}', fn (string $slug) => redirect()->route('product', $slug), 301)->name('legacy.product');
Route::get('/product/{slug}', fn (string $slug) => redirect()->route('product', $slug), 301);
Route::get('/hechizos/{slug}', fn (string $slug) => redirect()->route('product', $slug), 301);
Route::get('/product-category/{slug}', fn (string $slug) => redirect()->route('collection', $slug), 301);
Route::get('/categoria-producto/{slug}', fn (string $slug) => redirect()->route('collection', $slug), 301);

Route::view('/carrito', 'front.pages.cart')->name('cart');
Route::view('/checkout', 'front.pages.checkout')->name('checkout');
Route::view('/contacto', 'front.pages.contact')->name('contact');

Route::get('/pagar/{gateway}/{reference}', [PaymentController::class, 'start'])->name('payment.start');
Route::get('/pedido/{reference}/exito', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/pedido/{reference}/error', [PaymentController::class, 'failure'])->name('payment.failure');

Route::get('/{slug}', PageController::class)->name('page')->where('slug', '[a-z0-9-]+');
