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

    public static function activeFor(string $location, array $context = []): ?self
    {
        $candidates = static::where('location', $location)
            ->where('is_active', true)
            ->orderByDesc('priority')
            ->orderByDesc('updated_at')
            ->get();

        foreach ($candidates as $tpl) {
            if ($tpl->appliesTo($context)) {
                return $tpl;
            }
        }

        return null;
    }

    public static function activePopups(array $context = [])
    {
        return static::where('location', 'popup')
            ->where('is_active', true)
            ->orderByDesc('priority')
            ->orderByDesc('updated_at')
            ->get()
            ->filter(fn (self $t) => $t->appliesTo($context))
            ->values();
    }

    public function appliesTo(array $context = []): bool
    {
        $conditions = $this->conditions ?? [];
        if (empty($conditions)) {
            return true;
        }

        foreach ($conditions as $cond) {
            if ($this->conditionMatches((array) $cond, $context)) {
                return true;
            }
        }

        return false;
    }

    protected function conditionMatches(array $cond, array $context): bool
    {
        $type = $cond['type'] ?? 'all';
        switch ($type) {
            case 'all':
                return true;
            case 'is_home':
                return ! empty($context['is_home']);
            case 'product':
                return isset($context['product']) && (int) $context['product']->id === (int) ($cond['id'] ?? 0);
            case 'collection':
                return isset($context['collection']) && (int) $context['collection']->id === (int) ($cond['id'] ?? 0);
            case 'product_in_collection':
                if (! isset($context['product']) || ! isset($context['product']->collections)) {
                    return false;
                }

                return $context['product']->collections->pluck('id')->contains((int) ($cond['id'] ?? 0));
            case 'page_slug':
                return isset($context['page']) && ($context['page']->slug ?? null) === ($cond['slug'] ?? '');
        }

        return false;
    }
}
