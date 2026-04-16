@if($editing)
    <div class="grid md:grid-cols-2 gap-3 text-sm">
        <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">URL de imagen *</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.src" placeholder="/images/branding/..." class="w-full border border-gray-300 rounded-md px-3 py-2 font-mono text-xs"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Alt</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.alt" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
        <label><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Ancho</span><select wire:model.lazy="blocks.{{ $index }}.props.width" class="w-full border border-gray-300 rounded-md px-3 py-2"><option value="narrow">Estrecho (max 600px)</option><option value="wide">Ancho (max 1000px)</option><option value="full">Full width</option></select></label>
        <label class="md:col-span-2"><span class="block text-xs uppercase tracking-widest text-gray-600 mb-1">Pie de foto</span><input type="text" wire:model.lazy="blocks.{{ $index }}.props.caption" class="w-full border border-gray-300 rounded-md px-3 py-2"></label>
    </div>
@else
    @if($block['props']['src'] ?? null)
        <img src="{{ $block['props']['src'] }}" class="max-h-32 rounded border border-pink-200">
    @else
        <p class="text-xs text-gray-400">Sin imagen</p>
    @endif
@endif
