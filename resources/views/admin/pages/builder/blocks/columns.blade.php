@if($editing)
    <div class="space-y-3">
        @foreach($block['props']['items'] as $idx => $item)
            <div class="border border-pink-200 rounded-md p-3 bg-pink-50/30">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold text-pink-700 uppercase tracking-widest">Columna {{ $idx + 1 }}</span>
                    <button type="button" wire:click="removeColumnItem('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                </div>
                <input type="text" wire:model.lazy="blocks.{{ $index }}.props.items.{{ $idx }}.title" placeholder="Título" class="w-full border border-gray-300 rounded-md px-3 py-2 mb-2 text-sm">
                <textarea wire:model.lazy="blocks.{{ $index }}.props.items.{{ $idx }}.body" rows="3" placeholder="Texto" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm"></textarea>
            </div>
        @endforeach
        <button type="button" wire:click="addColumnItem('{{ $block['id'] }}')" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-sm hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir columna</button>
    </div>
@else
    <p class="text-sm text-gray-600">{{ count($block['props']['items'] ?? []) }} columnas</p>
@endif
