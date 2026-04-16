<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Lunar\Models\Collection;

class CollectionController extends Controller
{
    public function __invoke(string $slug)
    {
        $collection = Collection::whereHas('urls', fn ($q) => $q->where('slug', $slug))
            ->firstOrFail();

        $products = $collection->products()
            ->where('status', 'published')
            ->paginate(24);

        return view('front.shop.collection', compact('collection', 'products'));
    }
}
