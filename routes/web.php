<?php

use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\BrandingController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\ThemeBuilderController as AdminThemeBuilderController;
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

        // Products
        Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::post('products/{product}/image', [AdminProductController::class, 'uploadImage'])->name('products.upload-image');
        Route::post('products/{product}/image/{mediaId}/delete', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

        // Pages
        Route::get('pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('pages/create', [AdminPageController::class, 'create'])->name('pages.create');
        Route::post('pages', [AdminPageController::class, 'store'])->name('pages.store');
        Route::get('pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
        Route::delete('pages/{page}', [AdminPageController::class, 'destroy'])->name('pages.destroy');

        // Testimonials
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);

        // Blog
        Route::get('blog', [AdminBlogPostController::class, 'index'])->name('blog.index');
        Route::get('blog/create', [AdminBlogPostController::class, 'create'])->name('blog.create');
        Route::post('blog', [AdminBlogPostController::class, 'store'])->name('blog.store');
        Route::get('blog/{post}/edit', [AdminBlogPostController::class, 'edit'])->name('blog.edit');
        Route::put('blog/{post}', [AdminBlogPostController::class, 'update'])->name('blog.update');
        Route::delete('blog/{post}', [AdminBlogPostController::class, 'destroy'])->name('blog.destroy');

        // Collections
        Route::resource('collections', AdminCollectionController::class)->except(['show']);

        // Customers
        Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');

        // Theme Builder
        Route::get('theme-builder', [AdminThemeBuilderController::class, 'index'])->name('theme-builder.index');
        Route::post('theme-builder', [AdminThemeBuilderController::class, 'create'])->name('theme-builder.create');
        Route::get('theme-builder/{themeTemplate}/edit', [AdminThemeBuilderController::class, 'edit'])->name('theme-builder.edit');
        Route::put('theme-builder/{themeTemplate}', [AdminThemeBuilderController::class, 'update'])->name('theme-builder.update');
        Route::delete('theme-builder/{themeTemplate}', [AdminThemeBuilderController::class, 'destroy'])->name('theme-builder.destroy');
        Route::post('theme-builder/{themeTemplate}/toggle', [AdminThemeBuilderController::class, 'toggleActive'])->name('theme-builder.toggle');
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
