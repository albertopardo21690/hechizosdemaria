@if($editing)
    <label class="block text-sm"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Altura</span><select wire:model.lazy="blocks.{{ $index }}.props.height" class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2"><option value="sm">Pequeña (2rem)</option><option value="md">Media (4rem)</option><option value="lg">Grande (6rem)</option><option value="xl">Enorme (10rem)</option></select></label>
@else
    <p class="text-sm text-gray-500">Espacio: {{ $block['props']['height'] ?? 'md' }}</p>
@endif
