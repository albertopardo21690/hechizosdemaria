<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ThemeTemplate;
use Lunar\Models\Collection;

class CollectionController extends Controller
{
    public function __invoke(string $slug)
    {
        $collection = Collection::whereHas('urls', fn ($q) => $q->where('slug', $slug))
            ->firstOrFail();

        $name = $collection->attribute_data['name']?->getValue() ?? 'Colección';
        \SEO::setTitle($name);
        \SEO::setDescription("Explora nuestra colección de {$name}. Productos mágicos consagrados con envío gratis desde 50 EUR.");

        $all = $collection->products()
            ->where('status', 'published')
            ->with(['variants.prices.currency', 'media', 'urls', 'collections'])
            ->get()
            ->sortBy(fn ($p) => $p->variants->first()?->prices->firstWhere('currency.code', 'EUR')?->price->decimal ?? PHP_INT_MAX)
            ->values();

        $page = max(1, (int) request('page', 1));
        $perPage = 24;
        $products = new \Illuminate\Pagination\LengthAwarePaginator(
            $all->forPage($page, $perPage),
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        \View::share('themeContext', ['collection' => $collection]);
        $collectionTemplate = ThemeTemplate::activeFor('collection_archive', ['collection' => $collection]);

        return view('front.shop.collection', compact('collection', 'products', 'collectionTemplate'));
    }
}
