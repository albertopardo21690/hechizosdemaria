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
        return view('admin.pages.form', ['page' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request);
        Page::create($data);

        return redirect()->route('admin.pages.index')->with('status', 'Página creada.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $this->validate($request, $page);
        $page->update($data);

        return redirect()->route('admin.pages.edit', $page)->with('status', 'Página actualizada.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('status', 'Página eliminada.');
    }

    protected function validate(Request $request, ?Page $page = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug'.($page ? ','.$page->id : ''),
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'template' => 'required|string|max:50',
            'sort' => 'nullable|integer',
        ]);
    }
}
