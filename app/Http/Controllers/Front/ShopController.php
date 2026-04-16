<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Lunar\Models\Collection;
use Lunar\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'published')
            ->with(['variants.prices.currency', 'media'])
            ->paginate(24);

        $collections = Collection::with('urls')->orderBy('id')->get();

        return view('front.shop.index', compact('products', 'collections'));
    }

    public function show(string $slug)
    {
        $product = Product::whereHas('urls', fn ($q) => $q->where('slug', $slug))
            ->where('status', 'published')
            ->with(['variants.prices.currency', 'media', 'collections.urls'])
            ->firstOrFail();

        $related = Product::where('status', 'published')
            ->where('id', '!=', $product->id)
            ->whereHas('collections', fn ($q) => $q->whereIn('lunar_collections.id', $product->collections->pluck('id')))
            ->with(['variants.prices.currency', 'media'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('front.shop.product', compact('product', 'related'));
    }
}
