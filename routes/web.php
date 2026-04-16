<?php

use App\Http\Controllers\Front\CollectionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\ShopController;
use Illuminate\Support\Facades\Route;

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
