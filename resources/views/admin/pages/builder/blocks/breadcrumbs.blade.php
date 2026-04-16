@if($editing)
    <label class="block text-sm">
        <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Separador</span>
        <input type="text" wire:model.lazy="{{ $path }}.props.separator" maxlength="3" class="w-24 border border-gray-300 rounded-md px-3 py-2">
    </label>
    <p class="text-[11px] text-pink-500 mt-2">⚡ Dinámico — ruta a la página actual.</p>
@else
    <p class="text-xs text-gray-500">⚡ Migas de pan ({{ $block['props']['separator'] ?? '/' }})</p>
@endif
