<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeTemplate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'blocks' => 'array',
        'conditions' => 'array',
        'is_active' => 'bool',
    ];

    public const LOCATIONS = [
        'header' => 'Cabecera',
        'footer' => 'Pie',
        'product_single' => 'Ficha de producto',
        'collection_archive' => 'Archivo de colección',
        'popup' => 'Popup',
    ];

    public const TRIGGERS = [
        'time' => 'Tiempo (segundos)',
        'scroll' => 'Scroll (% de página)',
        'exit_intent' => 'Intención de salida',
        'manual' => 'Manual (trigger con botón)',
    ];

    public const FREQUENCIES = [
        'always' => 'Siempre',
        'session' => 'Una vez por sesión',
        'once' => 'Una vez por navegador',
    ];

    public function hasBlocks(): bool
    {
        return is_array($this->blocks) && count($this->blocks) > 0;
    }

    public function sectionsNormalized(): array
    {
        return \App\Livewire\Admin\PageBuilder::normalize($this->blocks ?? []);
    }

    public static function activeFor(string $location): ?self
    {
        return static::where('location', $location)
            ->where('is_active', true)
            ->orderByDesc('priority')
            ->orderByDesc('updated_at')
            ->first();
    }

    public static function activePopups()
    {
        return static::where('location', 'popup')
            ->where('is_active', true)
            ->orderByDesc('priority')
            ->orderByDesc('updated_at')
            ->get();
    }
}
