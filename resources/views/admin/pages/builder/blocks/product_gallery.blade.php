@if($editing)
    <label class="block text-sm">
        <span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Layout</span>
        <select wire:model.lazy="{{ $path }}.props.layout" class="w-full max-w-xs border border-gray-300 rounded-md px-3 py-2">
            <option value="stacked">Apiladas</option>
            <option value="carousel">Carrusel simple</option>
            <option value="grid">Cuadrícula</option>
        </select>
    </label>
    <p class="text-[11px] text-pink-500 mt-2">⚡ Dinámico — imágenes del producto actual.</p>
@else
    <p class="text-xs text-gray-500">⚡ Galería dinámica ({{ $block['props']['layout'] ?? 'stacked' }})</p>
@endif
