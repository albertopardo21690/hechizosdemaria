<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandingController extends Controller
{
    protected string $dir = 'images/branding';

    protected array $slots = [
        'logo' => [
            'label' => 'Logo principal',
            'filename' => 'logo.png',
            'description' => 'Logo de la cabecera (PNG transparente recomendado, altura 60-80px).',
            'accept' => 'image/png,image/svg+xml,image/webp',
        ],
        'logo-alt' => [
            'label' => 'Logo alternativo / footer',
            'filename' => 'logo-alt.png',
            'description' => 'Versión secundaria del logo para footer o fondos claros.',
            'accept' => 'image/png,image/svg+xml,image/webp',
        ],
        'about' => [
            'label' => 'Foto Sobre mi',
            'filename' => 'about.jpg',
            'description' => 'Retrato de Maria Jose para la pagina Sobre mi (vertical, idealmente 800x1000).',
            'accept' => 'image/jpeg,image/png,image/webp',
        ],
        'hero' => [
            'label' => 'Foto Home (hero)',
            'filename' => 'hero.jpg',
            'description' => 'Imagen lateral del hero en la home. Vertical 4:5.',
            'accept' => 'image/jpeg,image/png,image/webp',
        ],
        'og' => [
            'label' => 'Imagen Open Graph',
            'filename' => 'og.jpg',
            'description' => 'Preview al compartir en redes (1200x630).',
            'accept' => 'image/jpeg,image/png',
        ],
    ];

    public function index()
    {
        return view('admin.branding.index', [
            'slots' => $this->buildSlots(),
        ]);
    }

    public function upload(Request $request, string $slot)
    {
        abort_unless(isset($this->slots[$slot]), 404);

        $slotConfig = $this->slots[$slot];

        $request->validate([
            'file' => 'required|file|max:8192|mimetypes:image/jpeg,image/png,image/svg+xml,image/webp',
        ]);

        $destDir = public_path($this->dir);
        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $extension = $request->file('file')->getClientOriginalExtension();
        $extension = strtolower($extension ?: pathinfo($slotConfig['filename'], PATHINFO_EXTENSION));
        $filename = pathinfo($slotConfig['filename'], PATHINFO_FILENAME).'.'.$extension;

        foreach (glob($destDir.'/'.pathinfo($slotConfig['filename'], PATHINFO_FILENAME).'.*') as $old) {
            if (basename($old) === $filename) {
                continue;
            }
            @unlink($old);
        }

        $request->file('file')->move($destDir, $filename);

        return back()->with('status', "Imagen '{$slotConfig['label']}' subida correctamente.");
    }

    public function delete(string $slot)
    {
        abort_unless(isset($this->slots[$slot]), 404);

        $base = pathinfo($this->slots[$slot]['filename'], PATHINFO_FILENAME);
        foreach (glob(public_path($this->dir).'/'.$base.'.*') as $file) {
            @unlink($file);
        }

        return back()->with('status', "Imagen '{$this->slots[$slot]['label']}' eliminada.");
    }

    protected function buildSlots(): array
    {
        $out = [];
        foreach ($this->slots as $key => $cfg) {
            $base = pathinfo($cfg['filename'], PATHINFO_FILENAME);
            $existing = collect(glob(public_path($this->dir).'/'.$base.'.*'))
                ->first();

            $out[$key] = array_merge($cfg, [
                'key' => $key,
                'exists' => (bool) $existing,
                'url' => $existing ? '/'.$this->dir.'/'.basename($existing).'?v='.filemtime($existing) : null,
                'size' => $existing ? round(filesize($existing) / 1024).' KB' : null,
            ]);
        }

        return $out;
    }
}
