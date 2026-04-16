@if($editing)
    <label class="block text-sm"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Estilo</span><select wire:model.lazy="blocks.{{ $index }}.props.style" class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2"><option value="line">Línea sencilla</option><option value="dots">Tres puntos dorados</option><option value="star">Estrella</option></select></label>
@else
    <p class="text-sm text-gray-500">Divisor: {{ $block['props']['style'] ?? 'line' }}</p>
@endif
