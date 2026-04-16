@if($editing)
    <div class="space-y-3 text-sm">
        <div class="space-y-2">
            @foreach(($block['props']['items'] ?? []) as $idx => $item)
                <div class="bg-pink-50/40 border border-pink-200 rounded-md p-3 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[10px] font-mono text-pink-600 uppercase tracking-widest">Tab {{ $idx + 1 }}</span>
                        <button type="button" wire:click="tabsRemoveItem('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                    </div>
                    <input type="text" wire:model.lazy="{{ $path }}.props.items.{{ $idx }}.label" placeholder="Etiqueta de la pestaña" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs font-heading">
                    <textarea wire:model.lazy="{{ $path }}.props.items.{{ $idx }}.body" rows="4" placeholder="Contenido (permite HTML)" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs"></textarea>
                </div>
            @endforeach
        </div>
        <button type="button" wire:click="tabsAddItem('{{ $block['id'] }}')" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir tab</button>
    </div>
@else
    <div class="text-xs text-gray-600"><p class="font-semibold">Pestañas · {{ count($block['props']['items'] ?? []) }} tabs</p></div>
@endif
