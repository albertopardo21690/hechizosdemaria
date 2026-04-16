@if($editing)
    <div class="space-y-3 text-sm">
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Texto del botón</span>
            <input type="text" wire:model.lazy="{{ $path }}.props.button_text" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </label>
        <label class="flex items-center gap-2">
            <input type="checkbox" wire:model.lazy="{{ $path }}.props.show_quantity" class="accent-pink-500"> Mostrar selector de cantidad
        </label>
    </div>
    <p class="text-[11px] text-pink-500 mt-2">⚡ Dinámico — conectado al carrito Lunar del producto actual.</p>
@else
    <p class="text-xs text-gray-500">⚡ Botón añadir al carrito</p>
@endif
