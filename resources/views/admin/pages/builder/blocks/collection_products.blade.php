@if($editing)
    <div class="grid md:grid-cols-3 gap-3 text-sm">
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Por fila</span>
            <select wire:model.lazy="{{ $path }}.props.per_row" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </label>
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Cantidad</span>
            <input type="number" min="1" max="60" wire:model.lazy="{{ $path }}.props.limit" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </label>
        <label class="flex items-center gap-2 pt-5">
            <input type="checkbox" wire:model.lazy="{{ $path }}.props.show_filters" class="accent-pink-500"> Mostrar filtros
        </label>
    </div>
    <p class="text-[11px] text-pink-500 mt-2">⚡ Dinámico — productos de la colección actual.</p>
@else
    <p class="text-xs text-gray-500">⚡ Productos de la colección ({{ $block['props']['per_row'] ?? 4 }} por fila · max {{ $block['props']['limit'] ?? 24 }})</p>
@endif
