<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function __invoke(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        \SEO::setTitle($page->title);
        \SEO::setDescription($page->excerpt ?: strip_tags((string) $page->content));

        return view('front.pages.show', compact('page'));
    }
}
