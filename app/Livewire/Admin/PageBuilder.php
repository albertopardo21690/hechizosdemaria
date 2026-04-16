<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use Livewire\Component;

class PageBuilder extends Component
{
    public Page $page;

    public array $blocks = [];

    public ?string $editingId = null;

    public function mount(Page $page): void
    {
        $this->page = $page;
        $this->blocks = is_array($page->blocks) ? $page->blocks : [];
    }

    public static function blockTypes(): array
    {
        return [
            'hero' => ['label' => 'Hero', 'icon' => 'sparkles', 'defaults' => [
                'eyebrow' => '', 'heading' => 'Titulo del hero', 'subheading' => '',
                'body' => '', 'image' => '', 'cta_text' => 'Ver mas', 'cta_url' => '#',
                'align' => 'left',
            ]],
            'text' => ['label' => 'Texto / HTML', 'icon' => 'text', 'defaults' => [
                'html' => '<p>Escribe aqui tu contenido.</p>',
            ]],
            'heading' => ['label' => 'Encabezado', 'icon' => 'h1', 'defaults' => [
                'eyebrow' => '', 'text' => 'Encabezado de seccion', 'align' => 'center', 'divider' => true,
            ]],
            'image' => ['label' => 'Imagen', 'icon' => 'image', 'defaults' => [
                'src' => '', 'alt' => '', 'caption' => '', 'width' => 'wide',
            ]],
            'columns' => ['label' => 'Columnas', 'icon' => 'columns', 'defaults' => [
                'count' => 3,
                'items' => [
                    ['title' => 'Columna 1', 'body' => 'Descripcion...'],
                    ['title' => 'Columna 2', 'body' => 'Descripcion...'],
                    ['title' => 'Columna 3', 'body' => 'Descripcion...'],
                ],
            ]],
            'cta' => ['label' => 'Llamada a accion', 'icon' => 'cursor', 'defaults' => [
                'heading' => 'Titulo del CTA', 'body' => '',
                'primary_text' => 'Accion principal', 'primary_url' => '#',
                'secondary_text' => '', 'secondary_url' => '',
                'background' => 'pink',
            ]],
            'quote' => ['label' => 'Cita', 'icon' => 'quote', 'defaults' => [
                'text' => 'El texto de la cita en si.', 'author' => 'Autor',
            ]],
            'gallery' => ['label' => 'Galeria', 'icon' => 'grid', 'defaults' => [
                'images' => [['src' => '', 'alt' => ''], ['src' => '', 'alt' => '']],
                'columns' => 3,
            ]],
            'testimonials' => ['label' => 'Testimonios', 'icon' => 'chat', 'defaults' => [
                'ids' => [],
                'only_featured' => false,
                'title' => 'Testimonios',
            ]],
            'products' => ['label' => 'Productos', 'icon' => 'tag', 'defaults' => [
                'collection_slug' => '',
                'limit' => 4,
                'title' => 'Productos',
            ]],
            'divider' => ['label' => 'Divisor', 'icon' => 'minus', 'defaults' => [
                'style' => 'line',
            ]],
            'spacer' => ['label' => 'Espacio', 'icon' => 'arrows', 'defaults' => [
                'height' => 'md',
            ]],
            'raw_html' => ['label' => 'HTML crudo', 'icon' => 'code', 'defaults' => [
                'html' => '<!-- tu HTML -->',
            ]],
        ];
    }

    public function addBlock(string $type): void
    {
        $types = self::blockTypes();
        if (! isset($types[$type])) {
            return;
        }

        $this->blocks[] = [
            'id' => (string) Str::uuid(),
            'type' => $type,
            'props' => $types[$type]['defaults'],
        ];
        $this->editingId = end($this->blocks)['id'];
        $this->persist();
    }

    public function removeBlock(string $id): void
    {
        $this->blocks = array_values(array_filter($this->blocks, fn ($b) => $b['id'] !== $id));
        if ($this->editingId === $id) {
            $this->editingId = null;
        }
        $this->persist();
    }

    public function duplicateBlock(string $id): void
    {
        $index = collect($this->blocks)->search(fn ($b) => $b['id'] === $id);
        if ($index === false) {
            return;
        }
        $copy = $this->blocks[$index];
        $copy['id'] = (string) Str::uuid();
        array_splice($this->blocks, $index + 1, 0, [$copy]);
        $this->persist();
    }

    public function moveUp(string $id): void
    {
        $i = collect($this->blocks)->search(fn ($b) => $b['id'] === $id);
        if ($i === false || $i === 0) {
            return;
        }
        [$this->blocks[$i - 1], $this->blocks[$i]] = [$this->blocks[$i], $this->blocks[$i - 1]];
        $this->blocks = array_values($this->blocks);
        $this->persist();
    }

    public function moveDown(string $id): void
    {
        $i = collect($this->blocks)->search(fn ($b) => $b['id'] === $id);
        if ($i === false || $i >= count($this->blocks) - 1) {
            return;
        }
        [$this->blocks[$i], $this->blocks[$i + 1]] = [$this->blocks[$i + 1], $this->blocks[$i]];
        $this->blocks = array_values($this->blocks);
        $this->persist();
    }

    public function edit(?string $id): void
    {
        $this->editingId = $this->editingId === $id ? null : $id;
    }

    public function addColumnItem(string $blockId): void
    {
        foreach ($this->blocks as $k => $b) {
            if ($b['id'] === $blockId && $b['type'] === 'columns') {
                $this->blocks[$k]['props']['items'][] = ['title' => 'Nueva columna', 'body' => ''];
                $this->blocks[$k]['props']['count'] = count($this->blocks[$k]['props']['items']);
            }
        }
        $this->persist();
    }

    public function removeColumnItem(string $blockId, int $index): void
    {
        foreach ($this->blocks as $k => $b) {
            if ($b['id'] === $blockId && $b['type'] === 'columns') {
                array_splice($this->blocks[$k]['props']['items'], $index, 1);
                $this->blocks[$k]['props']['count'] = count($this->blocks[$k]['props']['items']);
            }
        }
        $this->persist();
    }

    public function addGalleryImage(string $blockId): void
    {
        foreach ($this->blocks as $k => $b) {
            if ($b['id'] === $blockId && $b['type'] === 'gallery') {
                $this->blocks[$k]['props']['images'][] = ['src' => '', 'alt' => ''];
            }
        }
        $this->persist();
    }

    public function removeGalleryImage(string $blockId, int $index): void
    {
        foreach ($this->blocks as $k => $b) {
            if ($b['id'] === $blockId && $b['type'] === 'gallery') {
                array_splice($this->blocks[$k]['props']['images'], $index, 1);
            }
        }
        $this->persist();
    }

    public function updatedBlocks(): void
    {
        $this->persist();
    }

    public function persist(): void
    {
        $this->page->update(['blocks' => $this->blocks]);
    }

    public function render()
    {
        return view('livewire.admin.page-builder', [
            'types' => self::blockTypes(),
            'testimonialsList' => \App\Models\Testimonial::orderByDesc('featured')->orderBy('sort')->get(['id', 'name', 'text']),
            'collectionsList' => \Lunar\Models\Collection::with('urls')->get()->map(fn ($c) => (object) [
                'id' => $c->id,
                'name' => $c->attribute_data['name']?->getValue() ?? '-',
                'slug' => $c->urls->where('default', true)->first()?->slug,
            ]),
        ]);
    }
}
