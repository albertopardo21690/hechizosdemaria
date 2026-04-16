<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ThemeTemplate;
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

        $name = $product->attribute_data['name']?->getValue() ?? '';
        $desc = strip_tags($product->attribute_data['description']?->getValue() ?? '');
        $variant = $product->variants->first();
        $eurPrice = $variant?->prices->firstWhere('currency.code', 'EUR');
        $image = $product->getFirstMedia('images');

        \SEO::setTitle($name);
        \SEO::setDescription($desc ?: $name);
        if ($image) {
            \SEO::opengraph()->addImage($image->getUrl('large'));
        }
        \SEO::jsonLd()->setType('Product');
        \SEO::jsonLd()->addValue('sku', $variant?->sku);
        if ($eurPrice) {
            \SEO::jsonLd()->addValue('offers', [
                '@type' => 'Offer',
                'price' => $eurPrice->price->decimal,
                'priceCurrency' => 'EUR',
                'availability' => $variant?->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ]);
        }

        $related = Product::where('status', 'published')
            ->where('id', '!=', $product->id)
            ->whereHas('collections', fn ($q) => $q->whereIn('lunar_collections.id', $product->collections->pluck('id')))
            ->with(['variants.prices.currency', 'media'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        \View::share('themeContext', ['product' => $product]);
        $productTemplate = ThemeTemplate::activeFor('product_single', ['product' => $product]);

        return view('front.shop.product', compact('product', 'related', 'productTemplate'));
    }
}
