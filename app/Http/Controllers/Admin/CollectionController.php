<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lunar\FieldTypes\Text;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;
use Lunar\Models\Language;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::with('urls')->withCount('products')->orderByDesc('products_count')->paginate(40);

        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.form', ['collection' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request);

        $group = CollectionGroup::firstOrCreate(['handle' => 'categorias'], ['name' => 'Categorias']);

        $collection = Collection::create([
            'collection_group_id' => $group->id,
            'type' => 'static',
            'attribute_data' => collect([
                'name' => new Text($data['name']),
                'description' => new Text($data['description'] ?? ''),
            ]),
        ]);

        $this->syncUrl($collection, $data['slug']);

        return redirect()->route('admin.collections.edit', $collection)->with('status', 'Colección creada.');
    }

    public function edit(Collection $collection)
    {
        $collection->load('urls');

        return view('admin.collections.form', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $data = $this->validate($request);

        $collection->update([
            'attribute_data' => collect([
                'name' => new Text($data['name']),
                'description' => new Text($data['description'] ?? ''),
            ]),
        ]);

        $this->syncUrl($collection, $data['slug']);

        return redirect()->route('admin.collections.edit', $collection)->with('status', 'Actualizada.');
    }

    public function destroy(Collection $collection)
    {
        $collection->products()->detach();
        $collection->urls()->delete();
        $collection->forceDelete();

        return redirect()->route('admin.collections.index')->with('status', 'Eliminada.');
    }

    protected function validate(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    }

    protected function syncUrl(Collection $collection, string $slug): void
    {
        $language = Language::where('default', true)->firstOrFail();
        $url = $collection->urls()->where('default', true)->first();
        if ($url) {
            $url->update(['slug' => $slug]);
        } else {
            $collection->urls()->create(['language_id' => $language->id, 'slug' => $slug, 'default' => true]);
        }
    }
}
