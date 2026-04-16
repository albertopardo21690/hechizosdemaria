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

        return view('front.pages.show', compact('page'));
    }
}
