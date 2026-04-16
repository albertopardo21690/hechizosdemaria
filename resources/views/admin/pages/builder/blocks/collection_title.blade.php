@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Etiqueta HTML</span>
            <select wire:model.lazy="{{ $path }}.props.tag" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="h1">H1</option>
                <option value="h2">H2</option>
            </select>
        </label>
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alineación</span>
            <select wire:model.lazy="{{ $path }}.props.align" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="left">Izquierda</option>
                <option value="center">Centro</option>
                <option value="right">Derecha</option>
            </select>
        </label>
    </div>
    <p class="text-[11px] text-pink-500 mt-2">⚡ Dinámico — nombre de la colección actual.</p>
@else
    <p class="text-xs text-gray-500">⚡ Título dinámico de la colección</p>
@endif
