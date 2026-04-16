@php
    $editingContext = null;
    foreach ($sections as $__si => $__section) {
        foreach ($__section['columns'] as $__ci => $__col) {
            foreach ($__col['widgets'] as $__wi => $__widget) {
                if ($__widget['id'] === $editingWidgetId) {
                    $editingContext = [
                        'widget' => $__widget,
                        'path' => "sections.{$__si}.columns.{$__ci}.widgets.{$__wi}",
                        'sectionId' => $__section['id'],
                        'columnId' => $__col['id'],
                    ];
                    break 3;
                }
            }
        }
    }
@endphp
<div class="grid lg:grid-cols-[260px_1fr] gap-4 {{ $editingContext ? 'lg:pr-[400px]' : '' }} transition-[padding] duration-200">
    {{-- LIBRERIA DE SECCIONES --}}
    <aside class="lg:sticky lg:top-24 h-fit bg-white border border-pink-200 rounded-xl p-4">
        <h3 class="font-heading text-sm text-pink-700 uppercase tracking-widest mb-3">Añadir sección</h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach($sectionLayouts as $key => $layout)
                <button type="button" wire:click="addSection('{{ $key }}')"
                    class="group flex flex-col items-center gap-2 p-3 rounded-md border border-pink-200 hover:border-pink-500 hover:bg-pink-50 text-center text-xs text-gray-700 transition"
                    title="{{ $layout['label'] }}">
                    <div class="flex gap-0.5 w-full h-6 items-stretch">
                        @foreach($layout['widths'] as $w)
                            <div class="bg-pink-200 group-hover:bg-pink-400 rounded-sm transition" style="flex: {{ $w }} 1 0%"></div>
                        @endforeach
                    </div>
                    <span>{{ $layout['label'] }}</span>
                </button>
            @endforeach
        </div>
        <p class="text-[10px] text-gray-500 mt-4">Cada sección contiene columnas, y dentro de cada columna añades widgets. Se guarda automático.</p>
    </aside>

    {{-- LIENZO --}}
    <div>
        @if(empty($sections))
            <div class="bg-white border-2 border-dashed border-pink-200 rounded-xl p-16 text-center">
                <svg class="w-14 h-14 mx-auto text-pink-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                <h3 class="font-heading text-xl text-pink-700 mb-2">Página vacía</h3>
                <p class="text-gray-500 text-sm">Elige un layout en el panel de la izquierda para añadir tu primera sección.</p>
            </div>
        @else
            <div class="space-y-4" x-data="sortableSections">
                @foreach($sections as $si => $section)
                    @php $totalCols = count($section['columns'] ?? []); @endphp
                    <div wire:key="section-{{ $section['id'] }}" data-section-id="{{ $section['id'] }}" class="bg-white border-2 border-pink-200 rounded-xl overflow-hidden">
                        {{-- toolbar --}}
                        <div class="flex items-center justify-between px-4 py-2 bg-pink-100 border-b border-pink-200">
                            <div class="flex items-center gap-2">
                                <button type="button" class="section-drag-handle cursor-grab active:cursor-grabbing text-pink-700 hover:text-pink-900 px-1" title="Arrastrar sección">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0zM7 18a2 2 0 11-4 0 2 2 0 014 0zM17 2a2 2 0 11-4 0 2 2 0 014 0zM17 10a2 2 0 11-4 0 2 2 0 014 0zM17 18a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </button>
                                <span class="text-[10px] font-mono text-pink-700 bg-white px-2 py-0.5 rounded">S{{ $si + 1 }}</span>
                                <span class="text-xs font-heading text-pink-700 uppercase tracking-widest">Sección · {{ $totalCols }} col{{ $totalCols > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" wire:click="moveSectionUp('{{ $section['id'] }}')" @disabled($si === 0) class="w-7 h-7 rounded hover:bg-white text-pink-700 disabled:opacity-30" title="Subir sección">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                                </button>
                                <button type="button" wire:click="moveSectionDown('{{ $section['id'] }}')" @disabled($si === count($sections) - 1) class="w-7 h-7 rounded hover:bg-white text-pink-700 disabled:opacity-30" title="Bajar sección">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <button type="button" wire:click="duplicateSection('{{ $section['id'] }}')" class="w-7 h-7 rounded hover:bg-white text-pink-700" title="Duplicar sección">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                                <button type="button" wire:click="editSection('{{ $section['id'] }}')" class="w-7 h-7 rounded hover:bg-white text-pink-700" title="Ajustes sección">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </button>
                                <button type="button" wire:click="removeSection('{{ $section['id'] }}')" wire:confirm="¿Eliminar esta sección y todo su contenido?" class="w-7 h-7 rounded hover:bg-red-100 text-red-600" title="Eliminar sección">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- section settings --}}
                        @if($editingSectionId === $section['id'])
                            <div class="bg-pink-50/60 border-b border-pink-200 p-4 grid md:grid-cols-3 gap-3 text-sm">
                                <label>
                                    <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Fondo</span>
                                    <select wire:model.lazy="sections.{{ $si }}.settings.background" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option value="transparent">Transparente</option>
                                        <option value="white">Blanco</option>
                                        <option value="pink-50">Rosa muy claro</option>
                                        <option value="pink-gradient">Degradado rosa</option>
                                    </select>
                                </label>
                                <label>
                                    <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Padding vertical</span>
                                    <select wire:model.lazy="sections.{{ $si }}.settings.padding" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                        <option value="none">Sin padding</option>
                                        <option value="sm">Pequeño</option>
                                        <option value="md">Medio</option>
                                        <option value="lg">Grande</option>
                                    </select>
                                </label>
                                <label class="flex items-center gap-2 pt-5">
                                    <input type="checkbox" wire:model.lazy="sections.{{ $si }}.settings.full_width" class="accent-pink-500">
                                    Ancho completo (sin max-w)
                                </label>
                            </div>
                        @endif

                        {{-- columnas --}}
                        @php
                            $gridTemplate = collect($section['columns'] ?? [])->map(fn ($c) => ($c['width'] ?? 100).'fr')->implode(' ');
                        @endphp
                        <div class="p-3 grid gap-3" style="grid-template-columns: {{ $gridTemplate }}">
                            @foreach($section['columns'] as $ci => $column)
                                <div wire:key="column-{{ $column['id'] }}" class="border border-dashed border-pink-200 rounded-md bg-pink-50/20 min-h-[140px] p-2 flex flex-col">
                                    <div class="text-[10px] font-mono text-pink-600 uppercase tracking-widest mb-2">Columna {{ $ci + 1 }} · {{ $column['width'] ?? 100 }}%</div>

                                    <div class="space-y-2 flex-1"
                                         x-data="sortableWidgets({ sectionId: '{{ $section['id'] }}' })"
                                         data-section-id="{{ $section['id'] }}"
                                         data-column-id="{{ $column['id'] }}">
                                    @foreach($column['widgets'] ?? [] as $wi => $widget)
                                        @php $path = "sections.{$si}.columns.{$ci}.widgets.{$wi}"; @endphp
                                        <div wire:key="widget-{{ $widget['id'] }}" data-widget-id="{{ $widget['id'] }}" class="bg-white border rounded-md overflow-hidden transition {{ $editingWidgetId === $widget['id'] ? 'border-pink-500 ring-2 ring-pink-300' : 'border-pink-200' }}">
                                            <div class="flex items-center justify-between px-3 py-2 bg-pink-50 border-b border-pink-200">
                                                <div class="flex items-center gap-1.5 min-w-0">
                                                    <button type="button" class="widget-drag-handle cursor-grab active:cursor-grabbing text-pink-600 hover:text-pink-800 shrink-0" title="Arrastrar widget">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0zM7 18a2 2 0 11-4 0 2 2 0 014 0zM17 2a2 2 0 11-4 0 2 2 0 014 0zM17 10a2 2 0 11-4 0 2 2 0 014 0zM17 18a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                    </button>
                                                    <span class="text-xs font-heading text-pink-700 uppercase tracking-widest truncate">{{ $widgetTypes[$widget['type']]['label'] ?? $widget['type'] }}</span>
                                                </div>
                                                <div class="flex items-center gap-0.5 shrink-0">
                                                    <button type="button" wire:click="moveWidgetUp('{{ $section['id'] }}', '{{ $column['id'] }}', '{{ $widget['id'] }}')" @disabled($wi === 0) class="w-6 h-6 rounded hover:bg-pink-100 text-gray-600 disabled:opacity-30" title="Subir">
                                                        <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                                                    </button>
                                                    <button type="button" wire:click="moveWidgetDown('{{ $section['id'] }}', '{{ $column['id'] }}', '{{ $widget['id'] }}')" @disabled($wi === count($column['widgets']) - 1) class="w-6 h-6 rounded hover:bg-pink-100 text-gray-600 disabled:opacity-30" title="Bajar">
                                                        <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                                    </button>
                                                    <button type="button" wire:click="duplicateWidget('{{ $section['id'] }}', '{{ $column['id'] }}', '{{ $widget['id'] }}')" class="w-6 h-6 rounded hover:bg-pink-100 text-gray-600" title="Duplicar">
                                                        <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                    </button>
                                                    <button type="button" wire:click="editWidget('{{ $widget['id'] }}')" class="w-6 h-6 rounded hover:bg-pink-100 {{ $editingWidgetId === $widget['id'] ? 'bg-pink-200 text-pink-800' : 'text-gray-600' }}" title="Editar">
                                                        <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <button type="button" wire:click="removeWidget('{{ $section['id'] }}', '{{ $column['id'] }}', '{{ $widget['id'] }}')" wire:confirm="¿Eliminar este widget?" class="w-6 h-6 rounded hover:bg-red-100 text-red-600" title="Eliminar">
                                                        <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="p-3 cursor-pointer hover:bg-pink-50/40" wire:click="editWidget('{{ $widget['id'] }}')">
                                                @include('admin.pages.builder.blocks.'.$widget['type'], [
                                                    'block' => $widget,
                                                    'path' => $path,
                                                    'editing' => false,
                                                    'testimonialsList' => $testimonialsList ?? collect(),
                                                    'collectionsList' => $collectionsList ?? collect(),
                                                ])
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>

                                    {{-- widget picker --}}
                                    <div x-data="{ open: false }" class="relative mt-auto pt-2">
                                        <button type="button" @click="open = !open" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">
                                            + Widget
                                        </button>
                                        <div x-show="open" x-on:click.outside="open = false" x-transition.opacity x-cloak class="absolute z-20 left-0 right-0 mt-1 bg-white border border-pink-200 rounded-md shadow-lg p-2 grid grid-cols-2 gap-1 max-h-72 overflow-auto">
                                            @foreach($widgetTypes as $type => $meta)
                                                <button type="button" wire:click="addWidget('{{ $section['id'] }}', '{{ $column['id'] }}', '{{ $type }}')" @click="open = false" class="flex items-center gap-1 p-2 rounded text-left text-xs hover:bg-pink-50">
                                                    <svg class="w-4 h-4 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">@include('admin.pages.builder.icon', ['icon' => $meta['icon']])</svg>
                                                    <span class="truncate">{{ $meta['label'] }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- PANEL CONTEXTUAL DE EDICION --}}
    @if($editingContext)
        @php
            $w = $editingContext['widget'];
            $path = $editingContext['path'];
            $meta = $widgetTypes[$w['type']] ?? ['label' => $w['type'], 'icon' => 'text'];
        @endphp
        <div wire:key="editor-panel-{{ $w['id'] }}"
             class="fixed inset-y-0 right-0 w-full sm:w-[400px] bg-white border-l border-pink-200 shadow-2xl z-40 flex flex-col"
             x-data="{ tab: 'content' }"
             @keydown.escape.window="$wire.editWidget(null)">
            <header class="flex items-center justify-between px-4 py-3 border-b border-pink-200 bg-pink-50 shrink-0">
                <div class="flex items-center gap-2 min-w-0">
                    <svg class="w-5 h-5 text-pink-500 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">@include('admin.pages.builder.icon', ['icon' => $meta['icon']])</svg>
                    <div class="min-w-0">
                        <h3 class="font-heading text-pink-700 truncate">{{ $meta['label'] }}</h3>
                        <p class="text-[10px] uppercase tracking-widest text-gray-500 font-mono truncate">ID: {{ substr($w['id'], 0, 8) }}</p>
                    </div>
                </div>
                <button type="button" wire:click="editWidget(null)" class="w-8 h-8 rounded hover:bg-pink-100 text-gray-600 shrink-0" title="Cerrar panel">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </header>
            <nav class="flex border-b border-pink-200 bg-white shrink-0">
                <button type="button" @click="tab='content'" :class="tab==='content' ? 'border-pink-500 text-pink-700 bg-pink-50/50' : 'border-transparent text-gray-500 hover:text-pink-600'" class="flex-1 py-3 text-xs uppercase tracking-widest font-semibold border-b-2 transition">Contenido</button>
                <button type="button" @click="tab='style'" :class="tab==='style' ? 'border-pink-500 text-pink-700 bg-pink-50/50' : 'border-transparent text-gray-500 hover:text-pink-600'" class="flex-1 py-3 text-xs uppercase tracking-widest font-semibold border-b-2 transition">Estilo</button>
                <button type="button" @click="tab='advanced'" :class="tab==='advanced' ? 'border-pink-500 text-pink-700 bg-pink-50/50' : 'border-transparent text-gray-500 hover:text-pink-600'" class="flex-1 py-3 text-xs uppercase tracking-widest font-semibold border-b-2 transition">Avanzado</button>
            </nav>
            <div class="flex-1 overflow-auto">
                <div x-show="tab==='content'" class="p-4">
                    @include('admin.pages.builder.blocks.'.$w['type'], [
                        'block' => $w,
                        'path' => $path,
                        'editing' => true,
                        'testimonialsList' => $testimonialsList ?? collect(),
                        'collectionsList' => $collectionsList ?? collect(),
                    ])
                </div>
                <div x-show="tab==='style'" x-cloak class="p-4 space-y-4 text-sm">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Margen superior</label>
                        <select wire:model.lazy="{{ $path }}.style.margin_top" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Por defecto</option>
                            <option value="none">Sin margen</option>
                            <option value="sm">Pequeño</option>
                            <option value="md">Medio</option>
                            <option value="lg">Grande</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Margen inferior</label>
                        <select wire:model.lazy="{{ $path }}.style.margin_bottom" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Por defecto</option>
                            <option value="none">Sin margen</option>
                            <option value="sm">Pequeño</option>
                            <option value="md">Medio</option>
                            <option value="lg">Grande</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación (texto)</label>
                        <select wire:model.lazy="{{ $path }}.style.text_align" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Por defecto</option>
                            <option value="left">Izquierda</option>
                            <option value="center">Centro</option>
                            <option value="right">Derecha</option>
                        </select>
                    </div>
                    <p class="text-[11px] text-gray-400">Afecta al widget dentro de su columna. Los ajustes de fondo/padding se configuran a nivel de sección.</p>
                </div>
                <div x-show="tab==='advanced'" x-cloak class="p-4 space-y-4 text-sm">
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Clase CSS adicional</label>
                        <input type="text" wire:model.lazy="{{ $path }}.advanced.css_class" placeholder="mi-clase-custom otra-clase" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Oculto en</label>
                        <div class="flex gap-3 text-xs text-gray-700">
                            <label class="flex items-center gap-1"><input type="checkbox" wire:model.lazy="{{ $path }}.advanced.hide_mobile" class="accent-pink-500"> Móvil</label>
                            <label class="flex items-center gap-1"><input type="checkbox" wire:model.lazy="{{ $path }}.advanced.hide_desktop" class="accent-pink-500"> Escritorio</label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">ID del widget</label>
                        <input type="text" readonly value="{{ $w['id'] }}" class="w-full border border-gray-200 bg-gray-50 rounded-md px-3 py-2 font-mono text-[11px] text-gray-500">
                    </div>
                </div>
            </div>
            <footer class="border-t border-pink-200 p-3 bg-pink-50/60 flex items-center justify-between shrink-0">
                <span class="text-[10px] text-gray-500 uppercase tracking-widest">Cambios guardados automáticamente</span>
                <button type="button" wire:click="editWidget(null)" class="bg-pink-500 hover:bg-pink-600 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">Cerrar</button>
            </footer>
        </div>
    @endif
</div>
