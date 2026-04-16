@if($editing)
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" wire:model.lazy="{{ $path }}.props.show_count" class="accent-pink-500">
        Mostrar contador de items
    </label>
@else
    <div class="text-xs text-gray-500">
        <p><strong>Icono carrito</strong>{{ ($block['props']['show_count'] ?? true) ? ' · con contador' : '' }}</p>
    </div>
@endif
