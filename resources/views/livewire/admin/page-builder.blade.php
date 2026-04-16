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

        @if($templatesList->isNotEmpty())
            <h3 class="font-heading text-sm text-pink-700 uppercase tracking-widest mt-6 mb-3">Plantillas guardadas</h3>
            <div class="space-y-1">
                @foreach($templatesList as $tpl)
                    <div class="group flex items-center gap-1 text-xs">
                        <button type="button" wire:click="insertTemplate({{ $tpl->id }})" class="flex-1 text-left px-2 py-1.5 rounded border border-pink-200 hover:border-pink-500 hover:bg-pink-50 truncate text-gray-700" title="Insertar {{ $tpl->name }}">
                            {{ $tpl->name }}
                        </button>
                        <button type="button" wire:click="deleteTemplate({{ $tpl->id }})" wire:confirm="¿Eliminar plantilla '{{ $tpl->name }}'?" class="opacity-0 group-hover:opacity-100 text-red-500 hover:text-red-700 p-1" title="Eliminar plantilla">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </aside>

    {{-- LIENZO --}}
    <div x-data="{ vp: 'desktop' }">
        <div class="mb-3 flex items-center justify-between bg-white border border-pink-200 rounded-md p-1.5 flex-wrap gap-2">
            <div class="flex items-center gap-2 pl-2">
                <span class="text-[10px] uppercase tracking-widest text-gray-500">Vista previa</span>
                <template x-if="$store.clipboard.kind">
                    <span class="text-[10px] uppercase tracking-widest text-pink-700 bg-pink-100 px-2 py-0.5 rounded" x-text="$store.clipboard.label"></span>
                </template>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" wire:click="openHistory" class="flex items-center gap-1 px-3 py-1 rounded text-xs uppercase tracking-widest font-semibold text-gray-500 hover:text-pink-600 transition" title="Historial de cambios">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Historial
                </button>
                <span class="w-px h-5 bg-pink-200"></span>
            <div class="flex items-center gap-1">
                <button type="button" @click="vp='desktop'" :class="vp==='desktop' ? 'bg-pink-100 text-pink-700' : 'text-gray-500 hover:text-pink-600'" class="flex items-center gap-1 px-3 py-1 rounded text-xs uppercase tracking-widest font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Escritorio
                </button>
                <button type="button" @click="vp='tablet'" :class="vp==='tablet' ? 'bg-pink-100 text-pink-700' : 'text-gray-500 hover:text-pink-600'" class="flex items-center gap-1 px-3 py-1 rounded text-xs uppercase tracking-widest font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Tablet
                </button>
                <button type="button" @click="vp='mobile'" :class="vp==='mobile' ? 'bg-pink-100 text-pink-700' : 'text-gray-500 hover:text-pink-600'" class="flex items-center gap-1 px-3 py-1 rounded text-xs uppercase tracking-widest font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Móvil
                </button>
            </div>
            </div>
        </div>
        <div :class="{ 'max-w-[400px] mx-auto ring-4 ring-pink-100 rounded-lg': vp==='mobile', 'max-w-[800px] mx-auto ring-4 ring-pink-100 rounded-lg': vp==='tablet' }" class="transition-all duration-300">
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
                                <button type="button" @click="$store.clipboard.copySection(@js($section))" class="w-7 h-7 rounded hover:bg-white text-pink-700" title="Copiar sección">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                                <button type="button" wire:click="openSaveTemplate('{{ $section['id'] }}')" class="w-7 h-7 rounded hover:bg-white text-pink-700" title="Guardar como plantilla">
                                    <svg class="w-3.5 h-3.5 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
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
                                                    <button type="button" @click.stop="$store.clipboard.copyWidget(@js($widget))" class="w-6 h-6 rounded hover:bg-pink-100 text-gray-600" title="Copiar widget">
                                                        <svg class="w-3 h-3 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
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
                                    <div class="mt-auto pt-2 space-y-1">
                                        <button type="button"
                                                @click="$dispatch('open-widget-picker', { sectionId: '{{ $section['id'] }}', columnId: '{{ $column['id'] }}' })"
                                                class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">
                                            + Widget
                                        </button>
                                        <template x-if="$store.clipboard.kind === 'widget'">
                                            <button type="button" @click="$store.clipboard.pasteWidget($wire, '{{ $section['id'] }}', '{{ $column['id'] }}')" class="w-full bg-pink-50 border border-pink-400 text-pink-700 py-1.5 rounded-md text-[10px] hover:bg-pink-100 uppercase tracking-widest font-semibold">
                                                Pegar widget
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <template x-if="$store.clipboard.kind === 'section'">
                <button type="button" @click="$store.clipboard.pasteSection($wire)" class="mt-4 w-full bg-pink-50 border-2 border-dashed border-pink-400 text-pink-700 py-3 rounded-md text-xs hover:bg-pink-100 uppercase tracking-widest font-semibold">
                    Pegar sección copiada
                </button>
            </template>
        @endif
        </div>
    </div>

    {{-- MODAL WIDGET PICKER --}}
    @php
        $widgetCategories = [
            'basicos' => ['label' => 'Básicos', 'keys' => ['hero', 'heading', 'text', 'image', 'gallery', 'carousel', 'quote', 'cta', 'testimonials', 'products', 'divider', 'spacer', 'raw_html']],
            'cabecera' => ['label' => 'Cabecera / Pie', 'keys' => ['site_logo', 'nav_menu', 'cart_icon', 'search_box']],
            'producto' => ['label' => 'Producto dinámico', 'keys' => ['product_title', 'product_price', 'product_gallery', 'product_description', 'product_add_to_cart', 'breadcrumbs']],
            'coleccion' => ['label' => 'Colección dinámica', 'keys' => ['collection_title', 'collection_products']],
            'formulario' => ['label' => 'Formulario', 'keys' => ['form']],
        ];
    @endphp
    <div x-data="{ open: false, sectionId: null, columnId: null, cat: 'basicos', q: '' }"
         @open-widget-picker.window="open = true; sectionId = $event.detail.sectionId; columnId = $event.detail.columnId; cat = 'basicos'; q = ''; $nextTick(() => { $refs.qInput && $refs.qInput.focus() })"
         @keydown.escape.window="open = false"
         x-show="open" x-cloak
         class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4"
         @click.self="open = false">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden">
            <header class="flex items-center justify-between px-5 py-3 border-b border-pink-200 bg-pink-50 shrink-0">
                <h3 class="font-heading text-lg text-pink-700">Añadir widget</h3>
                <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </header>
            <div class="px-5 py-3 border-b border-pink-200 flex items-center gap-3 shrink-0 flex-wrap">
                <div class="flex items-center gap-1 flex-wrap">
                    @foreach($widgetCategories as $catKey => $catMeta)
                        <button type="button" @click="cat = '{{ $catKey }}'; q = ''"
                                :class="cat === '{{ $catKey }}' ? 'bg-pink-100 text-pink-700' : 'text-gray-500 hover:text-pink-600'"
                                class="px-3 py-1.5 rounded text-xs uppercase tracking-widest font-semibold transition">
                            {{ $catMeta['label'] }}
                        </button>
                    @endforeach
                </div>
                <div class="flex-1 min-w-[180px]">
                    <input type="text" x-model="q" x-ref="qInput" placeholder="Buscar widget..." class="w-full border border-pink-200 rounded-md px-3 py-1.5 text-sm focus:border-pink-500 focus:outline-none">
                </div>
            </div>
            <div class="flex-1 overflow-auto p-5">
                @foreach($widgetCategories as $catKey => $catMeta)
                    <div x-show="cat === '{{ $catKey }}' && q === ''" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($catMeta['keys'] as $type)
                            @if(isset($widgetTypes[$type]))
                                @php $meta = $widgetTypes[$type]; @endphp
                                <button type="button"
                                        @click="$wire.addWidget(sectionId, columnId, '{{ $type }}'); open = false"
                                        class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-pink-200 hover:border-pink-500 hover:bg-pink-50 transition text-center">
                                    <svg class="w-8 h-8 text-pink-400 group-hover:text-pink-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">@include('admin.pages.builder.icon', ['icon' => $meta['icon']])</svg>
                                    <span class="text-sm font-semibold text-gray-700 group-hover:text-pink-700">{{ $meta['label'] }}</span>
                                </button>
                            @endif
                        @endforeach
                    </div>
                @endforeach
                {{-- Búsqueda global --}}
                <div x-show="q !== ''" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($widgetTypes as $type => $meta)
                        <button type="button"
                                x-show="'{{ \Illuminate\Support\Str::lower($meta['label']) }}'.includes(q.toLowerCase())"
                                @click="$wire.addWidget(sectionId, columnId, '{{ $type }}'); open = false"
                                class="group flex flex-col items-center gap-2 p-4 rounded-lg border border-pink-200 hover:border-pink-500 hover:bg-pink-50 transition text-center">
                            <svg class="w-8 h-8 text-pink-400 group-hover:text-pink-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">@include('admin.pages.builder.icon', ['icon' => $meta['icon']])</svg>
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-pink-700">{{ $meta['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
            <footer class="px-5 py-3 bg-pink-50/60 border-t border-pink-200 text-[10px] text-gray-500 shrink-0">
                Tip: arrastra widgets entre columnas una vez añadidos.
            </footer>
        </div>
    </div>

    {{-- MODAL HISTORIAL --}}
    @if($historyOpen)
        <div class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4"
             x-data @keydown.escape.window="$wire.closeHistory()"
             wire:click.self="closeHistory">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[80vh] flex flex-col overflow-hidden">
                <header class="flex items-center justify-between px-5 py-3 border-b border-pink-200 bg-pink-50">
                    <h3 class="font-heading text-lg text-pink-700">Historial de cambios</h3>
                    <button type="button" wire:click="closeHistory" class="text-gray-500 hover:text-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </header>
                <div class="flex-1 overflow-auto divide-y divide-pink-100">
                    @forelse($revisionsList as $rev)
                        <div class="flex items-center justify-between px-5 py-3 hover:bg-pink-50/40">
                            <div>
                                <p class="text-sm text-gray-700">{{ $rev->created_at->diffForHumans() }}</p>
                                <p class="text-[10px] text-gray-400 font-mono">{{ $rev->created_at->format('Y-m-d H:i:s') }} · rev #{{ $rev->id }}</p>
                            </div>
                            <button type="button" wire:click="restoreRevision({{ $rev->id }})" wire:confirm="¿Restaurar este estado? Los cambios actuales se guardan también como revisión." class="bg-pink-500 hover:bg-pink-600 text-white text-[10px] uppercase tracking-widest font-semibold px-3 py-1.5 rounded-md">
                                Restaurar
                            </button>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-400 text-sm">
                            Todavía no hay revisiones guardadas. Edita algo y vuelve.
                        </div>
                    @endforelse
                </div>
                <footer class="px-5 py-3 bg-pink-50/60 border-t border-pink-200 text-[10px] text-gray-500">
                    Se conservan las últimas 20 revisiones automáticamente al editar.
                </footer>
            </div>
        </div>
    @endif

    {{-- MODAL GUARDAR PLANTILLA --}}
    @if($savingTemplateSectionId)
        <div class="fixed inset-0 z-50 bg-black/40 flex items-center justify-center p-4"
             x-data @keydown.escape.window="$wire.cancelSaveTemplate()"
             wire:click.self="cancelSaveTemplate">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 space-y-4">
                <h3 class="font-heading text-lg text-pink-700">Guardar sección como plantilla</h3>
                <p class="text-sm text-gray-600">Dale un nombre descriptivo para encontrarla luego en el panel izquierdo.</p>
                <div>
                    <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Nombre *</label>
                    <input type="text" wire:model.live="newTemplateName" @keydown.enter="$wire.saveAsTemplate()" autofocus class="w-full border border-gray-300 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none" placeholder="Hero con testimonios">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="cancelSaveTemplate" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">Cancelar</button>
                    <button type="button" wire:click="saveAsTemplate" @disabled(trim($newTemplateName) === '') class="bg-pink-500 hover:bg-pink-600 disabled:opacity-50 text-white text-xs uppercase tracking-widest font-semibold px-4 py-2 rounded-md">Guardar plantilla</button>
                </div>
            </div>
        </div>
    @endif

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
                        <label class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Animación al entrar en vista</label>
                        <select wire:model.lazy="{{ $path }}.motion.type" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Ninguna</option>
                            <option value="fade-up">Fade up</option>
                            <option value="fade-down">Fade down</option>
                            <option value="fade-left">Fade desde izquierda</option>
                            <option value="fade-right">Fade desde derecha</option>
                            <option value="zoom-in">Zoom in</option>
                            <option value="zoom-out">Zoom out</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <label>
                            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Retardo (ms)</span>
                            <input type="number" min="0" max="5000" step="50" wire:model.lazy="{{ $path }}.motion.delay" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </label>
                        <label>
                            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Duración (ms)</span>
                            <input type="number" min="100" max="5000" step="50" wire:model.lazy="{{ $path }}.motion.duration" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </label>
                    </div>
                    <hr class="border-pink-100">
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
