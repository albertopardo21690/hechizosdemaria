<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('sort')->orderBy('title')->paginate(30);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $page = Page::create($data);

        return redirect()->route('admin.pages.edit', $page)->with('status', 'Página creada. ¡Empieza a diseñar!');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validated($request, $page);
        $page->update($data);

        return redirect()->route('admin.pages.edit', $page)->with('status', 'Configuración guardada.');
    }

    public function duplicate(Page $page)
    {
        $newPage = $page->replicate();
        $newPage->title = $page->title.' (copia)';
        $newPage->slug = $page->slug.'-copia-'.Str::random(4);
        $newPage->status = 'draft';
        $newPage->save();

        return redirect()->route('admin.pages.edit', $newPage)->with('status', 'Página duplicada.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('status', 'Página eliminada.');
    }

    protected function validated(Request $request, ?Page $page = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug'.($page ? ','.$page->id : ''),
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'template' => 'required|string|max:50',
            'sort' => 'nullable|integer',
            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:255',
            'seo.description' => 'nullable|string|max:500',
            'seo.og_image' => 'nullable|url|max:500',
        ]);

        // Clean empty SEO values
        if (isset($data['seo'])) {
            $data['seo'] = array_filter($data['seo']);
            if (empty($data['seo'])) {
                $data['seo'] = null;
            }
        }

        return $data;
    }
}
