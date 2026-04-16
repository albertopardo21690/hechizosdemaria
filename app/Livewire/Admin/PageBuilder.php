<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Models\PageRevision;
use App\Models\PageTemplate;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class PageBuilder extends Component
{
    public Page $page;

    public array $sections = [];

    public ?string $editingWidgetId = null;

    public ?string $editingSectionId = null;

    public ?string $savingTemplateSectionId = null;

    public string $newTemplateName = '';

    public bool $historyOpen = false;

    public function mount(Page $page): void
    {
        $this->page = $page;
        $raw = is_array($page->blocks) ? $page->blocks : [];
        $this->sections = self::normalize($raw);
    }

    public static function normalize(array $raw): array
    {
        if (empty($raw)) {
            return [];
        }
        if (isset($raw[0]['columns'])) {
            return $raw;
        }

        $sections = [];
        foreach ($raw as $block) {
            $sections[] = self::wrapLegacyBlock($block);
        }

        return $sections;
    }

    protected static function wrapLegacyBlock(array $block): array
    {
        if (($block['type'] ?? null) === 'columns') {
            $items = $block['props']['items'] ?? [];
            $count = max(count($items), 1);
            $width = (int) floor(100 / $count);
            $columns = [];
            foreach ($items as $item) {
                $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
                $body = $item['body'] ?? '';
                $html = trim(($title !== '' ? "<h3>{$title}</h3>" : '').($body !== '' ? "<p>{$body}</p>" : ''));
                $columns[] = [
                    'id' => (string) Str::uuid(),
                    'width' => $width,
                    'settings' => [],
                    'widgets' => [[
                        'id' => (string) Str::uuid(),
                        'type' => 'text',
                        'props' => ['html' => $html !== '' ? $html : '<p></p>'],
                    ]],
                ];
            }

            return [
                'id' => (string) Str::uuid(),
                'type' => 'section',
                'settings' => self::defaultSectionSettings(),
                'columns' => $columns,
            ];
        }

        return [
            'id' => (string) Str::uuid(),
            'type' => 'section',
            'settings' => self::defaultSectionSettings(),
            'columns' => [[
                'id' => (string) Str::uuid(),
                'width' => 100,
                'settings' => [],
                'widgets' => [[
                    'id' => $block['id'] ?? (string) Str::uuid(),
                    'type' => $block['type'] ?? 'text',
                    'props' => $block['props'] ?? [],
                ]],
            ]],
        ];
    }

    public static function defaultSectionSettings(): array
    {
        return [
            'background' => 'transparent',
            'padding' => 'md',
            'full_width' => false,
        ];
    }

    public static function widgetTypes(): array
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
            'site_logo' => ['label' => 'Logo del sitio', 'icon' => 'image', 'defaults' => [
                'max_height' => 64,
                'link_home' => true,
                'align' => 'left',
            ]],
            'nav_menu' => ['label' => 'Menu de navegacion', 'icon' => 'grid', 'defaults' => [
                'items' => [
                    ['label' => 'Tienda', 'url' => '/tienda'],
                    ['label' => 'Lecturas', 'url' => '/lecturas'],
                    ['label' => 'Sobre mi', 'url' => '/sobre-mi'],
                    ['label' => 'Contacto', 'url' => '/contacto'],
                ],
                'align' => 'right',
            ]],
            'cart_icon' => ['label' => 'Icono carrito', 'icon' => 'cart', 'defaults' => [
                'show_count' => true,
            ]],
            'search_box' => ['label' => 'Caja de busqueda', 'icon' => 'text', 'defaults' => [
                'placeholder' => 'Buscar...',
                'action' => '/tienda',
            ]],
            'product_title' => ['label' => 'Titulo del producto', 'icon' => 'h1', 'defaults' => [
                'tag' => 'h1',
                'align' => 'left',
            ]],
            'product_price' => ['label' => 'Precio del producto', 'icon' => 'tag', 'defaults' => [
                'size' => 'lg',
                'align' => 'left',
            ]],
            'product_gallery' => ['label' => 'Galeria del producto', 'icon' => 'image', 'defaults' => [
                'layout' => 'stacked',
            ]],
            'product_description' => ['label' => 'Descripcion del producto', 'icon' => 'text', 'defaults' => []],
            'product_add_to_cart' => ['label' => 'Anadir al carrito', 'icon' => 'cart', 'defaults' => [
                'show_quantity' => true,
                'button_text' => 'Anadir al carrito',
            ]],
            'breadcrumbs' => ['label' => 'Migas de pan', 'icon' => 'grid', 'defaults' => [
                'separator' => '/',
            ]],
            'collection_products' => ['label' => 'Productos de la coleccion', 'icon' => 'tag', 'defaults' => [
                'per_row' => 4,
                'show_filters' => false,
                'limit' => 24,
            ]],
            'collection_title' => ['label' => 'Titulo de la coleccion', 'icon' => 'h1', 'defaults' => [
                'tag' => 'h1',
                'align' => 'center',
            ]],
            'form' => ['label' => 'Formulario', 'icon' => 'document', 'defaults' => [
                'form_name' => 'contacto',
                'submit_text' => 'Enviar',
                'success_message' => 'Gracias, te responderemos pronto.',
                'email_to' => '',
                'fields' => [
                    ['type' => 'text', 'name' => 'nombre', 'label' => 'Nombre', 'required' => true, 'placeholder' => ''],
                    ['type' => 'email', 'name' => 'email', 'label' => 'Email', 'required' => true, 'placeholder' => ''],
                    ['type' => 'textarea', 'name' => 'mensaje', 'label' => 'Mensaje', 'required' => true, 'placeholder' => ''],
                ],
            ]],
        ];
    }

    public static function sectionLayouts(): array
    {
        return [
            '1' => ['widths' => [100], 'label' => '1 col'],
            '2' => ['widths' => [50, 50], 'label' => '2 cols'],
            '2-33-67' => ['widths' => [33, 67], 'label' => '1/3 + 2/3'],
            '2-67-33' => ['widths' => [67, 33], 'label' => '2/3 + 1/3'],
            '3' => ['widths' => [33, 34, 33], 'label' => '3 cols'],
            '4' => ['widths' => [25, 25, 25, 25], 'label' => '4 cols'],
        ];
    }

    public function addSection(string $layout = '1'): void
    {
        $layouts = self::sectionLayouts();
        if (! isset($layouts[$layout])) {
            return;
        }
        $columns = [];
        foreach ($layouts[$layout]['widths'] as $w) {
            $columns[] = [
                'id' => (string) Str::uuid(),
                'width' => $w,
                'settings' => [],
                'widgets' => [],
            ];
        }
        $this->sections[] = [
            'id' => (string) Str::uuid(),
            'type' => 'section',
            'settings' => self::defaultSectionSettings(),
            'columns' => $columns,
        ];
        $this->persist();
    }

    public function removeSection(string $id): void
    {
        $this->sections = array_values(array_filter($this->sections, fn ($s) => $s['id'] !== $id));
        if ($this->editingSectionId === $id) {
            $this->editingSectionId = null;
        }
        $this->persist();
    }

    public function duplicateSection(string $id): void
    {
        $idx = $this->findSectionIndex($id);
        if ($idx === null) {
            return;
        }
        $copy = $this->sections[$idx];
        $copy['id'] = (string) Str::uuid();
        foreach ($copy['columns'] as &$col) {
            $col['id'] = (string) Str::uuid();
            foreach ($col['widgets'] as &$w) {
                $w['id'] = (string) Str::uuid();
            }
            unset($w);
        }
        unset($col);
        array_splice($this->sections, $idx + 1, 0, [$copy]);
        $this->persist();
    }

    public function moveSectionUp(string $id): void
    {
        $i = $this->findSectionIndex($id);
        if ($i === null || $i === 0) {
            return;
        }
        [$this->sections[$i - 1], $this->sections[$i]] = [$this->sections[$i], $this->sections[$i - 1]];
        $this->sections = array_values($this->sections);
        $this->persist();
    }

    public function moveSectionDown(string $id): void
    {
        $i = $this->findSectionIndex($id);
        if ($i === null || $i >= count($this->sections) - 1) {
            return;
        }
        [$this->sections[$i], $this->sections[$i + 1]] = [$this->sections[$i + 1], $this->sections[$i]];
        $this->sections = array_values($this->sections);
        $this->persist();
    }

    public function editSection(?string $id): void
    {
        $this->editingSectionId = $this->editingSectionId === $id ? null : $id;
        $this->editingWidgetId = null;
    }

    public function addWidget(string $sectionId, string $columnId, string $type): void
    {
        $types = self::widgetTypes();
        if (! isset($types[$type])) {
            return;
        }
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $sectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $columnId) {
                    continue;
                }
                $widget = [
                    'id' => (string) Str::uuid(),
                    'type' => $type,
                    'props' => $types[$type]['defaults'],
                ];
                $this->sections[$si]['columns'][$ci]['widgets'][] = $widget;
                $this->editingWidgetId = $widget['id'];
                $this->editingSectionId = null;
                $this->persist();

                return;
            }
        }
    }

    public function removeWidget(string $sectionId, string $columnId, string $widgetId): void
    {
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $sectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $columnId) {
                    continue;
                }
                $this->sections[$si]['columns'][$ci]['widgets'] = array_values(array_filter(
                    $col['widgets'],
                    fn ($w) => $w['id'] !== $widgetId
                ));
                if ($this->editingWidgetId === $widgetId) {
                    $this->editingWidgetId = null;
                }
                $this->persist();

                return;
            }
        }
    }

    public function duplicateWidget(string $sectionId, string $columnId, string $widgetId): void
    {
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $sectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $columnId) {
                    continue;
                }
                foreach ($col['widgets'] as $wi => $w) {
                    if ($w['id'] !== $widgetId) {
                        continue;
                    }
                    $copy = $w;
                    $copy['id'] = (string) Str::uuid();
                    array_splice($this->sections[$si]['columns'][$ci]['widgets'], $wi + 1, 0, [$copy]);
                    $this->persist();

                    return;
                }
            }
        }
    }

    public function moveWidgetUp(string $sectionId, string $columnId, string $widgetId): void
    {
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $sectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $columnId) {
                    continue;
                }
                foreach ($col['widgets'] as $wi => $w) {
                    if ($w['id'] !== $widgetId) {
                        continue;
                    }
                    if ($wi === 0) {
                        return;
                    }
                    $widgets = &$this->sections[$si]['columns'][$ci]['widgets'];
                    [$widgets[$wi - 1], $widgets[$wi]] = [$widgets[$wi], $widgets[$wi - 1]];
                    unset($widgets);
                    $this->persist();

                    return;
                }
            }
        }
    }

    public function moveWidgetDown(string $sectionId, string $columnId, string $widgetId): void
    {
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $sectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $columnId) {
                    continue;
                }
                $count = count($col['widgets']);
                foreach ($col['widgets'] as $wi => $w) {
                    if ($w['id'] !== $widgetId) {
                        continue;
                    }
                    if ($wi >= $count - 1) {
                        return;
                    }
                    $widgets = &$this->sections[$si]['columns'][$ci]['widgets'];
                    [$widgets[$wi], $widgets[$wi + 1]] = [$widgets[$wi + 1], $widgets[$wi]];
                    unset($widgets);
                    $this->persist();

                    return;
                }
            }
        }
    }

    public function editWidget(?string $widgetId): void
    {
        $this->editingWidgetId = $this->editingWidgetId === $widgetId ? null : $widgetId;
        $this->editingSectionId = null;
    }

    public function openSaveTemplate(string $sectionId): void
    {
        $this->savingTemplateSectionId = $sectionId;
        $this->newTemplateName = '';
    }

    public function cancelSaveTemplate(): void
    {
        $this->savingTemplateSectionId = null;
        $this->newTemplateName = '';
    }

    public function saveAsTemplate(): void
    {
        if (! $this->savingTemplateSectionId || trim($this->newTemplateName) === '') {
            return;
        }
        $section = null;
        foreach ($this->sections as $s) {
            if ($s['id'] === $this->savingTemplateSectionId) {
                $section = $s;
                break;
            }
        }
        if (! $section) {
            $this->cancelSaveTemplate();

            return;
        }

        PageTemplate::create([
            'name' => trim($this->newTemplateName),
            'kind' => 'section',
            'payload' => $section,
        ]);

        $this->cancelSaveTemplate();
    }

    public function insertTemplate(int $templateId): void
    {
        $template = PageTemplate::find($templateId);
        if (! $template) {
            return;
        }
        $section = $template->payload;
        $section['id'] = (string) Str::uuid();
        foreach ($section['columns'] ?? [] as $ci => $col) {
            $section['columns'][$ci]['id'] = (string) Str::uuid();
            foreach ($col['widgets'] ?? [] as $wi => $w) {
                $section['columns'][$ci]['widgets'][$wi]['id'] = (string) Str::uuid();
            }
        }
        $this->sections[] = $section;
        $this->persist();
    }

    public function deleteTemplate(int $templateId): void
    {
        PageTemplate::where('id', $templateId)->delete();
    }

    public function reorderSections(array $orderedIds): void
    {
        $bySource = [];
        foreach ($this->sections as $s) {
            $bySource[$s['id']] = $s;
        }
        $reordered = [];
        foreach ($orderedIds as $id) {
            if (isset($bySource[$id])) {
                $reordered[] = $bySource[$id];
                unset($bySource[$id]);
            }
        }
        foreach ($bySource as $s) {
            $reordered[] = $s;
        }
        $this->sections = $reordered;
        $this->persist();
    }

    public function moveWidget(string $widgetId, string $toSectionId, string $toColumnId, int $toIndex): void
    {
        $widget = null;
        foreach ($this->sections as $si => $section) {
            foreach ($section['columns'] as $ci => $col) {
                foreach ($col['widgets'] as $wi => $w) {
                    if ($w['id'] !== $widgetId) {
                        continue;
                    }
                    $widget = $w;
                    array_splice($this->sections[$si]['columns'][$ci]['widgets'], $wi, 1);
                    break 3;
                }
            }
        }
        if ($widget === null) {
            return;
        }
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $toSectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $toColumnId) {
                    continue;
                }
                $count = count($this->sections[$si]['columns'][$ci]['widgets']);
                $toIndex = max(0, min($toIndex, $count));
                array_splice($this->sections[$si]['columns'][$ci]['widgets'], $toIndex, 0, [$widget]);
                $this->persist();

                return;
            }
        }
    }

    public function formAddField(string $widgetId): void
    {
        $this->mutateWidget($widgetId, function (array &$w): void {
            if ($w['type'] === 'form') {
                $w['props']['fields'][] = ['type' => 'text', 'name' => 'campo_'.count($w['props']['fields']), 'label' => 'Nuevo campo', 'required' => false, 'placeholder' => ''];
            }
        });
    }

    public function formRemoveField(string $widgetId, int $index): void
    {
        $this->mutateWidget($widgetId, function (array &$w) use ($index): void {
            if ($w['type'] === 'form') {
                array_splice($w['props']['fields'], $index, 1);
            }
        });
    }

    public function navAddItem(string $widgetId): void
    {
        $this->mutateWidget($widgetId, function (array &$w): void {
            if ($w['type'] === 'nav_menu') {
                $w['props']['items'][] = ['label' => 'Nuevo enlace', 'url' => '#'];
            }
        });
    }

    public function navRemoveItem(string $widgetId, int $index): void
    {
        $this->mutateWidget($widgetId, function (array &$w) use ($index): void {
            if ($w['type'] === 'nav_menu') {
                array_splice($w['props']['items'], $index, 1);
            }
        });
    }

    public function addGalleryImage(string $widgetId): void
    {
        $this->mutateWidget($widgetId, function (array &$w): void {
            if ($w['type'] === 'gallery') {
                $w['props']['images'][] = ['src' => '', 'alt' => ''];
            }
        });
    }

    public function removeGalleryImage(string $widgetId, int $index): void
    {
        $this->mutateWidget($widgetId, function (array &$w) use ($index): void {
            if ($w['type'] === 'gallery') {
                array_splice($w['props']['images'], $index, 1);
            }
        });
    }

    protected function mutateWidget(string $widgetId, callable $fn): void
    {
        foreach ($this->sections as $si => $section) {
            foreach ($section['columns'] as $ci => $col) {
                foreach ($col['widgets'] as $wi => $w) {
                    if ($w['id'] !== $widgetId) {
                        continue;
                    }
                    $ref = &$this->sections[$si]['columns'][$ci]['widgets'][$wi];
                    $fn($ref);
                    unset($ref);
                    $this->persist();

                    return;
                }
            }
        }
    }

    protected function findSectionIndex(string $id): ?int
    {
        foreach ($this->sections as $i => $s) {
            if ($s['id'] === $id) {
                return $i;
            }
        }

        return null;
    }

    public function updatedSections(): void
    {
        $this->persist();
    }

    public function persist(): void
    {
        $previous = $this->page->blocks;
        $this->page->update(['blocks' => $this->sections]);
        $this->snapshotRevision($previous);
    }

    protected function snapshotRevision(?array $previous): void
    {
        if (! is_array($previous) || $previous === $this->sections) {
            return;
        }
        PageRevision::create([
            'page_id' => $this->page->id,
            'staff_id' => auth('staff')->id(),
            'blocks' => $previous,
        ]);
        $keepIds = PageRevision::where('page_id', $this->page->id)
            ->orderByDesc('id')
            ->limit(20)
            ->pluck('id');
        PageRevision::where('page_id', $this->page->id)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }

    public function openHistory(): void
    {
        $this->historyOpen = true;
    }

    public function closeHistory(): void
    {
        $this->historyOpen = false;
    }

    public function restoreRevision(int $revisionId): void
    {
        $rev = PageRevision::where('page_id', $this->page->id)->find($revisionId);
        if (! $rev) {
            return;
        }
        $previous = $this->page->blocks;
        $this->sections = self::normalize($rev->blocks ?? []);
        $this->page->update(['blocks' => $this->sections]);
        $this->snapshotRevision($previous);
        $this->historyOpen = false;
        $this->editingWidgetId = null;
        $this->editingSectionId = null;
    }

    #[On('clipboard-paste-section')]
    public function pasteSection(array $payload): void
    {
        $section = $this->reassignIds($payload);
        if (! isset($section['columns'])) {
            return;
        }
        $this->sections[] = $section;
        $this->persist();
    }

    #[On('clipboard-paste-widget')]
    public function pasteWidget(string $sectionId, string $columnId, array $payload): void
    {
        if (! isset($payload['type'])) {
            return;
        }
        $widget = $payload;
        $widget['id'] = (string) Str::uuid();
        foreach ($this->sections as $si => $section) {
            if ($section['id'] !== $sectionId) {
                continue;
            }
            foreach ($section['columns'] as $ci => $col) {
                if ($col['id'] !== $columnId) {
                    continue;
                }
                $this->sections[$si]['columns'][$ci]['widgets'][] = $widget;
                $this->persist();

                return;
            }
        }
    }

    protected function reassignIds(array $section): array
    {
        $section['id'] = (string) Str::uuid();
        foreach ($section['columns'] ?? [] as $ci => $col) {
            $section['columns'][$ci]['id'] = (string) Str::uuid();
            foreach ($col['widgets'] ?? [] as $wi => $w) {
                $section['columns'][$ci]['widgets'][$wi]['id'] = (string) Str::uuid();
            }
        }

        return $section;
    }

    public function render()
    {
        $revisions = PageRevision::where('page_id', $this->page->id)
            ->orderByDesc('id')
            ->limit(20)
            ->get(['id', 'created_at', 'staff_id']);

        return view('livewire.admin.page-builder', [
            'widgetTypes' => self::widgetTypes(),
            'sectionLayouts' => self::sectionLayouts(),
            'templatesList' => PageTemplate::where('kind', 'section')->orderBy('name')->get(['id', 'name']),
            'revisionsList' => $revisions,
            'testimonialsList' => \App\Models\Testimonial::orderByDesc('featured')->orderBy('sort')->get(['id', 'name', 'text']),
            'collectionsList' => \Lunar\Models\Collection::with('urls')->get()->map(fn ($c) => (object) [
                'id' => $c->id,
                'name' => $c->attribute_data['name']?->getValue() ?? '-',
                'slug' => $c->urls->where('default', true)->first()?->slug,
            ]),
        ]);
    }
}
