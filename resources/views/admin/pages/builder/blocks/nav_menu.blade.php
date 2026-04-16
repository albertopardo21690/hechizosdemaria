@if($editing)
    <div class="space-y-3">
        <label class="block">
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span>
            <select wire:model.lazy="{{ $path }}.props.align" class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2 text-sm">
                <option value="left">Izquierda</option>
                <option value="center">Centro</option>
                <option value="right">Derecha</option>
            </select>
        </label>
        <div class="space-y-2">
            @foreach(($block['props']['items'] ?? []) as $idx => $item)
                <div class="flex items-start gap-2 bg-pink-50/40 border border-pink-200 rounded-md p-2">
                    <div class="flex-1 grid grid-cols-2 gap-2">
                        <input type="text" wire:model.lazy="{{ $path }}.props.items.{{ $idx }}.label" placeholder="Texto" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                        <input type="text" wire:model.lazy="{{ $path }}.props.items.{{ $idx }}.url" placeholder="/ruta" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm font-mono text-xs">
                    </div>
                    <button type="button" wire:click="navRemoveItem('{{ $block['id'] }}', {{ $idx }})" class="text-red-500 hover:text-red-700 px-2 py-2">&times;</button>
                </div>
            @endforeach
        </div>
        <button type="button" wire:click="navAddItem('{{ $block['id'] }}')" class="w-full border-2 border-dashed border-pink-300 text-pink-600 py-2 rounded-md text-xs hover:bg-pink-50 uppercase tracking-widest font-semibold">+ Añadir enlace</button>
    </div>
@else
    <div class="text-xs text-gray-600">
        <p class="font-semibold mb-1">Menú · {{ count($block['props']['items'] ?? []) }} enlaces</p>
        <p class="text-gray-400 truncate">{{ collect($block['props']['items'] ?? [])->pluck('label')->implode(' · ') ?: '—' }}</p>
    </div>
@endif
