<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Testimonial;
use Lunar\Models\Collection;

class HomeController extends Controller
{
    public function __invoke()
    {
        \View::share('themeContext', ['is_home' => true]);
        \SEO::setTitle('Lecturas de tarot por María José');
        \SEO::setDescription('Lecturas de tarot, péndulo y bola de cristal. Gabinete 24 horas disponible. María José Gómez, tarotista profesional con 164k+ seguidores.');
        \SEO::jsonLd()->setType('LocalBusiness');
        \SEO::jsonLd()->addValue('telephone', '+34 695 619 087');
        \SEO::jsonLd()->addValue('email', 'hechizosdemaria@gmail.com');
        \SEO::jsonLd()->addValue('priceRange', '$$');
        \SEO::jsonLd()->addValue('address', [
            '@type' => 'PostalAddress',
            'addressCountry' => 'ES',
        ]);

        // Principal focus of the site: readings ordered by price ASC (pendulum → 50€ → intermediate → premium)
        $lecturas = $this->productsByCollectionSlug('lecturas', 8);

        $testimonials = Testimonial::where('approved', true)
            ->where('featured', true)
            ->orderBy('sort')
            ->take(6)
            ->get();

        $posts = BlogPost::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('front.home', compact('lecturas', 'testimonials', 'posts'));
    }

    protected function productsByCollectionSlug(string $slug, int $limit)
    {
        $collection = Collection::whereHas('urls', fn ($q) => $q->where('slug', $slug))->first();
        if (! $collection) {
            return collect();
        }

        return $collection->products()
            ->where('status', 'published')
            ->with(['variants.prices.currency', 'media', 'urls'])
            ->get()
            ->sortBy(fn ($p) => $p->variants->first()?->prices->firstWhere('currency.code', 'EUR')?->price->decimal ?? PHP_INT_MAX)
            ->take($limit);
    }
}
