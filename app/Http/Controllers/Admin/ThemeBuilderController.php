<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeTemplate;
use Illuminate\Http\Request;

class ThemeBuilderController extends Controller
{
    public function index()
    {
        $templates = ThemeTemplate::orderBy('location')->orderByDesc('updated_at')->get();
        $grouped = $templates->groupBy('location');

        return view('admin.theme-builder.index', [
            'grouped' => $grouped,
            'locations' => ThemeTemplate::LOCATIONS,
        ]);
    }

    public function create(Request $request)
    {
        $location = $request->input('location', 'header');
        abort_unless(array_key_exists($location, ThemeTemplate::LOCATIONS), 404);

        $template = ThemeTemplate::create([
            'name' => 'Nuevo '.strtolower(ThemeTemplate::LOCATIONS[$location]),
            'location' => $location,
            'is_active' => false,
            'priority' => 10,
        ]);

        return redirect()->route('admin.theme-builder.edit', $template);
    }

    public function edit(ThemeTemplate $themeTemplate)
    {
        return view('admin.theme-builder.form', ['template' => $themeTemplate]);
    }

    public function update(Request $request, ThemeTemplate $themeTemplate)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'nullable|integer|min:0|max:100',
        ]);
        $themeTemplate->update($data);

        return redirect()->route('admin.theme-builder.edit', $themeTemplate)->with('status', 'Plantilla actualizada.');
    }

    public function destroy(ThemeTemplate $themeTemplate)
    {
        $themeTemplate->delete();

        return redirect()->route('admin.theme-builder.index')->with('status', 'Plantilla eliminada.');
    }

    public function toggleActive(ThemeTemplate $themeTemplate)
    {
        if (! $themeTemplate->is_active) {
            ThemeTemplate::where('location', $themeTemplate->location)
                ->where('id', '!=', $themeTemplate->id)
                ->update(['is_active' => false]);
        }
        $themeTemplate->update(['is_active' => ! $themeTemplate->is_active]);

        return back()->with('status', $themeTemplate->is_active ? 'Plantilla activada.' : 'Plantilla desactivada.');
    }
}
