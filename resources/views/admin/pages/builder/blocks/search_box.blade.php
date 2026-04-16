@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Placeholder</span>
            <input type="text" wire:model.lazy="{{ $path }}.props.placeholder" class="w-full border border-gray-300 rounded-md px-3 py-2">
        </label>
        <label>
            <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">URL destino</span>
            <input type="text" wire:model.lazy="{{ $path }}.props.action" class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs">
        </label>
    </div>
@else
    <div class="text-xs text-gray-500">
        <p><strong>Búsqueda</strong> · destino: {{ $block['props']['action'] ?? '/' }}</p>
    </div>
@endif
