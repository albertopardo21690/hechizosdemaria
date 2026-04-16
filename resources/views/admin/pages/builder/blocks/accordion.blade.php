@if($editing)
    <div class="space-y-3 text-sm">
        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model.lazy="{{ $path }}.props.open_first" class="accent-pink-500"> Primer item abierto por defecto
        </label>
        <div class="space-y-2">
            @foreach(($block['props']['items'] ?? []) as $idx => $item)
                <div class="bg-pink-50/40 border border-pink-200 rounded-md p-3 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-[10px] font-mono text-pink-600 uppercase tracking-widest">Item {{ $idx + 1 }}</span>
                        <button type="button" wire:click="accordionRemoveItem('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                    </div>
                    <input type="text" wire:model.lazy="{{ $path }}.props.items.{{ $idx }}.title" placeholder="Título / pregunta" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs font-heading">
                    <textarea wire:model.lazy="{{ $path }}.props.items.{{ $idx }}.body" rows="3" placeholder="Respuesta (permite HTML)" class="w-full border border-gray-300 rounded-md px-2 py-1.5 text-xs"></textarea>
                </div>
            @endforeach
        </div>
        <button type="button" wire:click="accordionAddItem('{{ $block['id'] }}')" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir item</button>
    </div>
@else
    <div class="text-xs text-gray-600"><p class="font-semibold">Acordeón · {{ count($block['props']['items'] ?? []) }} items</p></div>
@endif
