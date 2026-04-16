<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    protected array $customTemplates = [
        'sobre-mi' => 'front.pages.about',
    ];

    public function __invoke(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        \View::share('themeContext', ['page' => $page]);
        \SEO::setTitle($page->title);
        \SEO::setDescription($page->excerpt ?: strip_tags((string) $page->content));

        $view = $this->customTemplates[$slug] ?? 'front.pages.show';

        return view($view, compact('page'));
    }
}
