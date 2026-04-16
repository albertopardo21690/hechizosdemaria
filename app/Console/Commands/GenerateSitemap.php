<?php

namespace App\Console\Commands;

use App\Models\Page;
use Illuminate\Console\Command;
use Lunar\Models\Collection;
use Lunar\Models\Product;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'hechizos:sitemap';

    protected $description = 'Genera public/sitemap.xml con home, tienda, productos, colecciones y paginas';

    public function handle(): int
    {
        $sitemap = Sitemap::create();

        $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('shop'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create(route('contact'))->setPriority(0.5));

        Collection::with('urls')->get()->each(function ($c) use ($sitemap) {
            $slug = $c->urls->where('default', true)->first()?->slug ?? $c->urls->first()?->slug;
            if ($slug) {
                $sitemap->add(Url::create(route('collection', $slug))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            }
        });

        Product::where('status', 'published')->with('urls')->chunk(100, function ($chunk) use ($sitemap) {
            foreach ($chunk as $p) {
                $slug = $p->urls->where('default', true)->first()?->slug ?? $p->urls->first()?->slug;
                if ($slug) {
                    $sitemap->add(Url::create(route('product', $slug))
                        ->setLastModificationDate($p->updated_at)
                        ->setPriority(0.7));
                }
            }
        });

        Page::where('status', 'published')->get()->each(function ($p) use ($sitemap) {
            $sitemap->add(Url::create(route('page', $p->slug))
                ->setLastModificationDate($p->updated_at)
                ->setPriority(0.6));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generado en public/sitemap.xml');

        return self::SUCCESS;
    }
}
