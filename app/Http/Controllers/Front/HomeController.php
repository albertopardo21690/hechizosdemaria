<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Testimonial;
use Lunar\Models\Collection;
use Lunar\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        \SEO::setTitle('Tarot, rituales y magia blanca');
        \SEO::setDescription('Lecturas de tarot, rituales personalizados y tienda magica con perfumes arabes, amuletos y cuarzos. Por Maria Jose Gomez, tarotista profesional con 164k+ seguidores.');
        \SEO::jsonLd()->setType('LocalBusiness');
        \SEO::jsonLd()->addValue('telephone', '+34 695 619 087');
        \SEO::jsonLd()->addValue('email', 'hechizosdemaria@gmail.com');
        \SEO::jsonLd()->addValue('priceRange', '$$');
        \SEO::jsonLd()->addValue('address', [
            '@type' => 'PostalAddress',
            'addressCountry' => 'ES',
        ]);

        $lecturas = $this->productsByCollectionSlug('lecturas', 4);

        $destacados = Product::where('status', 'published')
            ->has('media')
            ->inRandomOrder()
            ->take(8)
            ->get();

        $featuredCategories = $this->featuredCategories([
            'lecturas', 'rituales', 'perfumes-arabes',
            'inciensos-organicos', 'jabones-y-banos', 'figuras-y-bustos',
        ]);

        $testimonials = Testimonial::where('approved', true)
            ->where('featured', true)
            ->orderBy('sort')
            ->take(6)
            ->get();

        $posts = BlogPost::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('front.home', compact(
            'lecturas', 'destacados', 'featuredCategories', 'testimonials', 'posts'
        ));
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

    protected function featuredCategories(array $slugs): \Illuminate\Support\Collection
    {
        return collect($slugs)->map(function ($slug) {
            $collection = Collection::whereHas('urls', fn ($q) => $q->where('slug', $slug))
                ->with('urls')
                ->first();
            if (! $collection) {
                return null;
            }
            $firstProduct = $collection->products()->where('status', 'published')->has('media')->first();

            return (object) [
                'name' => $collection->attribute_data['name']?->getValue() ?? '-',
                'slug' => $collection->urls->where('default', true)->first()?->slug ?? $slug,
                'image' => $firstProduct?->getFirstMedia('images')?->getUrl('medium'),
            ];
        })->filter();
    }
}
