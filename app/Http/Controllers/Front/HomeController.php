<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Lunar\Models\Collection;
use Lunar\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $lecturas = $this->productsByCollectionSlug('lecturas', 4);
        $destacados = Product::where('status', 'published')
            ->has('media')
            ->inRandomOrder()
            ->take(8)
            ->get();

        $testimonials = Testimonial::where('approved', true)
            ->where('featured', true)
            ->orderBy('sort')
            ->take(6)
            ->get();

        return view('front.home', compact('lecturas', 'destacados', 'testimonials'));
    }

    protected function productsByCollectionSlug(string $slug, int $limit)
    {
        $collection = Collection::whereHas('urls', fn ($q) => $q->where('slug', $slug))->first();
        if (! $collection) {
            return collect();
        }

        return $collection->products()
            ->where('status', 'published')
            ->take($limit)
            ->get();
    }
}
