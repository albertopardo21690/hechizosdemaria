<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class DesignTokenController extends Controller
{
    protected array $tokens = [
        'primary_color' => ['label' => 'Color primario', 'type' => 'color', 'default' => '#ec4899'],
        'secondary_color' => ['label' => 'Color secundario', 'type' => 'color', 'default' => '#db2777'],
        'accent_color' => ['label' => 'Color acento', 'type' => 'color', 'default' => '#f9a8d4'],
        'text_color' => ['label' => 'Color de texto', 'type' => 'color', 'default' => '#374151'],
        'heading_font' => ['label' => 'Fuente títulos', 'type' => 'text', 'default' => 'Cinzel'],
        'body_font' => ['label' => 'Fuente cuerpo', 'type' => 'text', 'default' => 'Lato'],
    ];

    public function index()
    {
        $values = [];
        foreach ($this->tokens as $key => $def) {
            $values[$key] = SiteSetting::get($key, $def['default']);
        }

        return view('admin.design-tokens.index', [
            'tokens' => $this->tokens,
            'values' => $values,
        ]);
    }

    public function update(Request $request)
    {
        foreach ($this->tokens as $key => $def) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.design-tokens.index')->with('status', 'Design tokens actualizados.');
    }
}
