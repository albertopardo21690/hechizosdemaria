<?php

use App\Http\Controllers\Front\CollectionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/tienda', [ShopController::class, 'index'])->name('shop');
Route::get('/tienda/{slug}', [ShopController::class, 'show'])->name('product');

Route::get('/coleccion/{slug}', CollectionController::class)->name('collection');

Route::get('/servicio/{slug}', fn (string $slug) => redirect()->route('product', $slug), 301)->name('legacy.product');

Route::view('/carrito', 'front.pages.cart')->name('cart');
Route::view('/checkout', 'front.pages.checkout')->name('checkout');
Route::view('/contacto', 'front.pages.contact')->name('contact');

Route::get('/{slug}', PageController::class)->name('page')->where('slug', '[a-z0-9-]+');
