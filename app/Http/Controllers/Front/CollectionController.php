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

        $name = $collection->attribute_data['name']?->getValue() ?? 'Coleccion';
        \SEO::setTitle($name);
        \SEO::setDescription("Explora nuestra coleccion de {$name}. Productos magicos consagrados con envio gratis desde 50 EUR.");

        $products = $collection->products()
            ->where('status', 'published')
            ->paginate(24);

        \View::share('themeContext', ['collection' => $collection]);
        $collectionTemplate = ThemeTemplate::activeFor('collection_archive', ['collection' => $collection]);

        return view('front.shop.collection', compact('collection', 'products', 'collectionTemplate'));
    }
}
