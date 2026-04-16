<div class="grid lg:grid-cols-[240px_1fr] gap-4">
    {{-- LIBRERIA DE BLOQUES --}}
    <aside class="lg:sticky lg:top-24 h-fit bg-white border border-pink-200 rounded-xl p-4">
        <h3 class="font-heading text-sm text-pink-700 uppercase tracking-widest mb-3">Añadir bloque</h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach($types as $key => $type)
                <button type="button" wire:click="addBlock('{{ $key }}')"
                    class="flex flex-col items-center gap-1 p-2 rounded-md border border-pink-200 hover:border-pink-500 hover:bg-pink-50 text-center text-xs text-gray-700 transition">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        @include('admin.pages.builder.icon', ['icon' => $type['icon']])
                    </svg>
                    {{ $type['label'] }}
                </button>
            @endforeach
        </div>
        <p class="text-[10px] text-gray-500 mt-4">Los cambios se guardan automáticamente.</p>
    </aside>

    {{-- LIENZO --}}
    <div>
        @if(empty($blocks))
            <div class="bg-white border-2 border-dashed border-pink-200 rounded-xl p-16 text-center">
                <svg class="w-14 h-14 mx-auto text-pink-300 mb-4" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                <h3 class="font-heading text-xl text-pink-700 mb-2">Página vacía</h3>
                <p class="text-gray-500 text-sm">Añade bloques desde el panel de la izquierda para empezar a construir.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($blocks as $i => $block)
                    <div wire:key="block-{{ $block['id'] }}" class="bg-white border border-pink-200 rounded-xl overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 bg-pink-50 border-b border-pink-200">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-mono text-pink-700 bg-pink-100 px-2 py-0.5 rounded">{{ $i + 1 }}</span>
                                <span class="font-heading text-sm text-pink-700 uppercase tracking-widest">{{ $types[$block['type']]['label'] ?? $block['type'] }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" wire:click="moveUp('{{ $block['id'] }}')" @disabled($i === 0) class="w-8 h-8 rounded hover:bg-pink-100 text-gray-600 disabled:opacity-30" title="Subir">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                                </button>
                                <button type="button" wire:click="moveDown('{{ $block['id'] }}')" @disabled($i === count($blocks) - 1) class="w-8 h-8 rounded hover:bg-pink-100 text-gray-600 disabled:opacity-30" title="Bajar">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <button type="button" wire:click="duplicateBlock('{{ $block['id'] }}')" class="w-8 h-8 rounded hover:bg-pink-100 text-gray-600" title="Duplicar">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                </button>
                                <button type="button" wire:click="edit('{{ $block['id'] }}')" class="w-8 h-8 rounded hover:bg-pink-100 text-gray-600" title="Editar">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button type="button" wire:click="removeBlock('{{ $block['id'] }}')" wire:confirm="¿Eliminar este bloque?" class="w-8 h-8 rounded hover:bg-red-100 text-red-600" title="Eliminar">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="p-4">
                            @include('admin.pages.builder.blocks.'.$block['type'], [
                                'block' => $block,
                                'index' => $i,
                                'editing' => $editingId === $block['id'],
                                'testimonialsList' => $testimonialsList ?? collect(),
                                'collectionsList' => $collectionsList ?? collect(),
                            ])
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
