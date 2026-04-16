@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Etiqueta</span>
            <input type="text" wire:model.lazy="{{ $path }}.props.label" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Porcentaje (0-100)</span>
            <input type="number" min="0" max="100" wire:model.lazy="{{ $path }}.props.percent" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Color</span>
            <select wire:model.lazy="{{ $path }}.props.color" class="w-full border border-gray-300 rounded-md px-3 py-2">
                <option value="pink">Rosa</option>
                <option value="black">Negro</option>
                <option value="gold">Dorado</option>
            </select></label>
        <label class="flex items-center gap-2 pt-5">
            <input type="checkbox" wire:model.lazy="{{ $path }}.props.show_percent" class="accent-pink-500"> Mostrar número</label>
    </div>
@else
    <div class="text-xs text-gray-600"><p><strong>{{ $block['props']['label'] ?? '' }}</strong> · {{ $block['props']['percent'] ?? 0 }}%</p></div>
@endif
