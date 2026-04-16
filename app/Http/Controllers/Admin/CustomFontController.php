<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomFont;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomFontController extends Controller
{
    public function index()
    {
        $fonts = CustomFont::orderBy('family_name')->orderBy('weight')->get();

        return view('admin.custom-fonts.index', compact('fonts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'family_name' => 'required|string|max:150',
            'weight' => 'required|string|max:10',
            'style' => 'required|in:normal,italic',
            'file' => 'required|file|mimes:woff,woff2,ttf,otf|max:4096',
        ]);
        $ext = strtolower($request->file('file')->getClientOriginalExtension());
        $filename = Str::slug($data['family_name']).'-'.$data['weight'].'-'.$data['style'].'-'.Str::random(6).'.'.$ext;
        $path = $request->file('file')->storeAs('fonts', $filename, 'public');

        CustomFont::create([
            'name' => $data['name'],
            'family_name' => $data['family_name'],
            'weight' => $data['weight'],
            'style' => $data['style'],
            'file_path' => $path,
            'format' => $ext === 'ttf' ? 'truetype' : ($ext === 'otf' ? 'opentype' : $ext),
        ]);

        return redirect()->route('admin.custom-fonts.index')->with('status', 'Fuente añadida.');
    }

    public function destroy(CustomFont $customFont)
    {
        if ($customFont->file_path) {
            Storage::disk('public')->delete($customFont->file_path);
        }
        $customFont->delete();

        return redirect()->route('admin.custom-fonts.index')->with('status', 'Fuente eliminada.');
    }
}
